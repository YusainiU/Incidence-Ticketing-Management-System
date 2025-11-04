<?php

namespace App\Enums;

enum CustomerContactRoles:string
{
    //
    case Sales_Contact = 'sales_contact';
    case Primary_Service_Contact = 'primary_service_contact';
    case Billing_Contact = 'billing_contact';
    case General_Contact = 'general_contact';

    public function toString(): string {
        return $this->value;
    }

    public static function toName(string $value): string
    {
        return match ($value) {
            self::Sales_Contact->toString() => 'Sales Contact',
            self::Primary_Service_Contact->toString() => 'Primary Service Contact',
            self::Billing_Contact->toString() => 'Billing Contact',
            self::General_Contact->toString() => 'General Contact',
        };
    }     


}
