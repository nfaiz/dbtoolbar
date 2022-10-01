<?php

declare(strict_types=1);

namespace Nfaiz\DbToolbar\Config;

Use Nfaiz\DbToolbar\Collectors\Database;

class Registrar
{
    public static function Toolbar(): array
    {
        return [
            'collectors' => [
                Database::class,
            ],
        ];
    }
}