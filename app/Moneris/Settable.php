<?php

namespace App\Moneris;

trait Settable
{
    /**
     * Set a property that exists on the class.
     *
     * @param string $property
     *
     * @throws \InvalidArgumentException
     * @return void
     */
    public function __set(string $property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new \InvalidArgumentException('['.get_class($this).'] does not contain a property named ['.$property.']');
        }
    }
}
