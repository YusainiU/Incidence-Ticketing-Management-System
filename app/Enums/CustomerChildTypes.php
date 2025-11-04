<?php

namespace App\Enums;

enum CustomerChildTypes:string
{
    //child_type --> warehouse|branch|shop|outlet
    case Warehouse = 'warehouse';
    case Branch = 'branch';
    case Shop = 'shop';
    case Outlet = 'outlet';

    public function toString(): string {
        return $this->value;
    }

    public static function toName(string $value): string
    {
        return match ($value) {
            self::Warehouse->toString() => 'Warehouse',
            self::Branch->toString() => 'Branch',
            self::Shop->toString() => 'Shop',
            self::Outlet->toString() => 'Outlet',
        };
    } 


}
