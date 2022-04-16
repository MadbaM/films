<?php

namespace App\Controller\Admin;

use App\Entity\Actor;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ActorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actor::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        // Configuramos los campos a visualizar y el formato en el cual queremos que se muestren
        return [
            TextField::new('name')
                ->setLabel('Nombre'),
            DateField::new('birthDate')
                ->setLabel('Fecha de nacimiento'),
            DateField::new('deathDate')
                ->setLabel('Fecha de fallecimiento'),
            TextField::new('birthPlace')
                ->setLabel('Lugar de nacimiento'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        // Seteamos los campos en los que queremos que sea efectiva la busqueda y los nombres de las paginas mostradas
        return $crud->setSearchFields(['name', 'birthPlace'])
        ->setPageTitle(Crud::PAGE_INDEX, 'Actores')
        ->setPageTitle(Crud::PAGE_NEW, 'Añadir actor')
        ->setPageTitle(Crud::PAGE_EDIT, 'Editar actor');
    }
    
}
