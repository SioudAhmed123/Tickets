<?php

namespace App\Controller\Admin;

use App\Entity\Tickets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class TicketsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tickets::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('name', 'name'),
            AssociationField::new('event_id', 'event_id'),
            integerField::new('price', 'price'),
            IntegerField::new('quantity', 'quantity'),
            DateTimeField::new('created_at', 'created_at'),

            
            
            
        ];
    }
}
