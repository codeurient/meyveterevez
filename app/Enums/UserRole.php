<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case User  = 'user';
    case Admin = 'admin';

    public function label(): string
    {
        return match($this) {
            self::User  => __t('enum.role.user'),
            self::Admin => __t('enum.role.admin'),
        };
    }

    public function color(): string
    {
        return match($this) {
            self::User  => 'gray',
            self::Admin => 'green',
        };
    }
}
