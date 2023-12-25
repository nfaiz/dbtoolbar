<?php

namespace Nfaiz\DbToolbar\Config;

Use Nfaiz\DbToolbar\Collectors\DbCollector;

class Registrar
{
    public static function Toolbar(): array
    {
        return [
            'collectors' => [
                DbCollector::class,
            ],
        ];
    }
}