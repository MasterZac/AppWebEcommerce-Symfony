<?php

namespace App\Controller;

use App\Entity\CarroCompra;
use App\Entity\Productos;
use App\Repository\CarroCompraRepository;
use App\Repository\ProductosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarritoController extends AbstractController
{

    private $carroCompraRepository;
    private $productosRepository;
    private $entityManager;
    private $security;

    public function __construct(CarroCompraRepository $carroCompraRepository, ProductosRepository $productosRepository, EntityManagerInterface $entityManager, Security $security)
    {
        $this->carroCompraRepository = $carroCompraRepository;
        $this->productosRepository = $productosRepository;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/carrito', name: 'carro_compra')]
    public function indexCarrito(): Response
    {
        $user = $this->security->getUser();
        $items = $this->carroCompraRepository->findBy(['usuario' => $user]);

        return $this->render('carrito/index.html.twig', [
            'items' => $items
        ]);
    }
    
    // #[Route('/producto', name: 'ver_producto', methods: ['GET'])]
    // public function verProducto(ProductosRepository $productosRepository)
    // {
    //     $producto = $productosRepository->findAll();

    //     return $this->render('tienda/index.html.twig', [
    //         'product' => $producto,
    //     ]);
    // }

    #[Route('/add-to-cart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(Request $request, EntityManagerInterface $em, ProductosRepository $productosRepository, Security $security)
    {

        $productId = $request->request->get('product_id');
        // $productoId = 2;
        $cantidad = $request->request->get('cantidad');

        $user = $security->getUser();
        $producto = $productosRepository->find($productId);

        // if (!$producto) {
        //     $this->addFlash('error', 'Producto no encontrado');
        //     return $this->redirectToRoute('#'); // Ajusta la ruta de redirección según sea necesario
        // }

        $carroCompra = new CarroCompra();
        $carroCompra->setUsuario($user);
        $carroCompra->setProducto($producto);
        $carroCompra->setCantidad($cantidad);

        $em->persist($carroCompra);
        $em->flush();

        $this->addFlash('success', 'Producto agregado al carrito');
        return $this->redirectToRoute('app_tienda'); // Ajusta la ruta de redirección según sea necesario
    }

    #[Route('/remove-from-cart/{id}', name: 'remove_from_cart', methods: ['POST'])]
    public function removeFromCart(CarroCompra $carroCompra)
    {
        $user = $this->security->getUser();

        if ($carroCompra->getUsuario() !== $user) {
            $this->addFlash('error', 'No tienes permiso para eliminar este artículo');
            return $this->redirectToRoute('tienda');
        }
        
        $this->entityManager->remove($carroCompra);
        $this->entityManager->flush();

        $this->addFlash('success', 'Producto eliminado del carrito');
        return $this->redirectToRoute('carro_compra');
    }

    #[Route('/product/{id}', name: 'producto_venta', methods: ['GET'])]
    public function detail(Productos $producto): Response
    {
        return $this->render('tienda/index.html.twig', [
            'producto' => $producto,
        ]);
    }

    #[Route('/carrito/total', name: 'carro_total', methods: ['GET'])]
    public function getTotalCarrito(): JsonResponse
    {
        $user = $this->security->getUser();
        $items = $this->carroCompraRepository->findBy(['usuario' => $user]);
        
        $total = 0;
        foreach ($items as $item) {
            $total += $item->getProducto()->getPrecio() * $item->getCantidad();
        }

        return new JsonResponse(['total' => $total]);
    }

    #[Route('/cancel-cart', name: 'cancel_cart', methods: ['POST'])]
    public function cancelCart()
    {
        $user = $this->security->getUser();
        $items = $this->carroCompraRepository->findBy(['usuario' => $user]);

        foreach ($items as $item) {
            $this->entityManager->remove($item);
        }
        $this->entityManager->flush();

        $this->addFlash('success', 'Todos los productos han sido eliminados del carrito');
        return $this->redirectToRoute('app_tienda');
    }
    
}

