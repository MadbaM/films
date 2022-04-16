<?php

namespace App\Controller\Admin;

use App\Entity\Director;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


class DirectorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Director::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Configuramos los campos a visualizar y el formato en el cual queremos que se muestren
        return [
            TextField::new('name')
                ->setLabel('Nombre'),
            DateField::new('birthDate')
                ->setLabel('Fecha de nacimiento'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        // Seteamos los campos en los que queremos que sea efectiva la busqueda y los nombres de las paginas mostradas
        return $crud->setSearchFields(['name'])
        ->setPageTitle(Crud::PAGE_INDEX, 'Directores')
        ->setPageTitle(Crud::PAGE_NEW, 'Añadir director')
        ->setPageTitle(Crud::PAGE_EDIT, 'Editar director');;
    }
}
