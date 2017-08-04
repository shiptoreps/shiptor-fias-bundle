<?php
namespace Shiptor\Bundle\FiasBundle\Serializer\Converters;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

/**
 * Class AttributeConverter
 */
class AttributeConverter implements NameConverterInterface
{
    const ADDRESS_OBJECT_TYPE__KOD_T_ST = '@KOD_T_ST';

    public static $dataExeptions = [
        'kodTsT' => self::ADDRESS_OBJECT_TYPE__KOD_T_ST
    ];

    /** @var object */
    public $class;

    /**
     * AttributeConverter constructor.
     * @param object $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param string $propertyName
     * @return string
     */
    public function normalize($propertyName)
    {
        return '@'.strtoupper($propertyName);
    }

    /**
     * @param string $propertyName
     * @return string
     */
    public function denormalize($propertyName)
    {
        $reflect = new \ReflectionClass($this->class);
        $properties = $reflect->getProperties(\ReflectionProperty::IS_PRIVATE);

        $attributes = [];

        foreach ($properties as $property) {
            $attributeName = $property->getName();
            $attributes['@'.strtoupper($attributeName)] = $attributeName;
        }

        if (array_key_exists(strtoupper($propertyName), $attributes)) {
            return $attributes[$propertyName];
        }

        if ($this->class instanceof \Shiptor\Bundle\FiasBundle\Entity\AddressObjectType) {
            return array_search($propertyName, self::$dataExeptions) ?: '#';
        }

        return $propertyName;
    }
}
