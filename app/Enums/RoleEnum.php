<?php

namespace App\Enums;

enum RoleEnum : string
{
    case User = 'user';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::User => 'Utilisateur',
            self::Admin => 'Administrateur',
        };
    }
}
