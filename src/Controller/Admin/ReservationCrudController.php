<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            
            AssociationField::new('User_id', 'User')
            ->formatValue(function ($value) {
                return $value ? $value->getName() : 'No User'; 
            }),
            AssociationField::new('Ticket', 'Ticket')
            ->formatValue(function ($value) {
                return $value ? $value->getName() : 'No Ticket'; 
            }),
            IntegerField::new('quantity', 'quantity'),
            DateTimeField::new('created_at', 'created_at'),
           
           

            
            
            
        ];
    }
}
