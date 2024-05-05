<?php

namespace Products;

use Products\Product;

class Book extends Product
{
    protected $weight;


    function __construct($properties)
    {
        parent::__construct($properties);
        $this->weight = $properties['weight'];
    }

    function getNewProductParams()
    {
        return [$this->sku, $this->name, $this->price, $this->type, null, $this->weight, null, null, null];
    }

    public function validate(bool $isSkuExist)
    {
        $messages = $this->validateProduct($isSkuExist);
        if (!$this->validateFloatProperty('weight')) {
            $messages['weight'] = INVALID_WEIGHT . " -> " . $this->weight;
        }
        return $messages;
    }
}
