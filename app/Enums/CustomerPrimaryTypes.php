<?php

namespace App\Enums;

enum CustomerPrimaryTypes: string
{
    case Main_Company = "main_company";
    case Child_Company = "child_company";

    public function toString(): string {
        return $this->value;
    }
    
    public static function toName(string $value): string
    {
        return match ($value) {
            self::Main_Company->toString() => 'Main Company',
            self::Child_Company->toString() => 'Child Company',
        };
    }    

}
