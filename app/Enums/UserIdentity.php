<?php

namespace App\Enums;

enum UserIdentity: string
{
    case Internal = 'internal';
    case Customer = 'customer';
    case Supplier = 'supplier';
    case Guest = 'guest';


    public static function toDisplayName($value): string
    {
        return match ($value) {
            self::Internal->value => 'Internal User',
            self::Customer->value => 'Customer Contact',
            self::Supplier->value => 'Supplier',
            self::Guest->value => 'External Contractor',
        };
    }
    
    public function toString(): string {
        return $this->value;
    }    
}
