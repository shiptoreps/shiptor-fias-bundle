<?php

namespace Shiptor\Bundle\FiasBundle\Exception;

/**
 * Class ObjectDeletedException
 */
class ObjectDeletedException extends \Exception
{
    protected $message = 'Searchable subject is deleted.';
}
