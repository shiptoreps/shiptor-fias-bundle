<?php

namespace Shiptor\Bundle\FiasBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ShiptorFiasBundle extends Bundle
{
    public function boot()
    {
        parent::boot();

        \Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
    }
}
