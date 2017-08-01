<?php

namespace Shiptor\Bundle\FiasBundle\DataTransformer;

/**
 * Interface DataTransformerInterface
 * @package Shiptor\Bundle\FiasBundle\DataTransformer
 */
interface DataTransformerInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function transform($value);

    /**
     * @param mixed $value
     * @return mixed
     */
    public function reverseTransform($value);
}
