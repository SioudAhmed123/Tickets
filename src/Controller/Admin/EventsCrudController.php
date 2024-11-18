<?php

namespace App\Controller\Admin;

use App\Entity\Events;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class EventsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Events::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('name', 'name'),
            TextField::new('description', 'description'),
            TextField::new('Location', 'Location'),
            DateTimeField::new('date', 'date'),
            DateTimeField::new('created_at', 'created_at'),
            AssociationField::new('Category', 'Category'),
            TextField::new('image', 'image'),

            
            
            
        ];
    }
}
