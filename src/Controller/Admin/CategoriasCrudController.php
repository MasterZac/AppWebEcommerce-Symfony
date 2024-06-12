<?php

namespace App\Controller\Admin;

use App\Entity\Categorias;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoriasCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorias::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre'),
            TextEditorField::new('descripcion'),
        ];
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        // dd($entityInstance);
        if(!$entityInstance instanceof Categorias) return;
        parent::persistEntity($em, $entityInstance);

    }
}
