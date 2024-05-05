<?php

namespace Products;

use Products\Product;

class DVD extends Product {
    private $size;


    function __construct($properties)
    {
        parent::__construct($properties);
        $this->size = $properties['size'];
    }

    public function getNewProductParams() {
        return [$this->sku, $this->name, $this->price, $this->type, $this->size, null, null, null, null];
    }

    private function validateSize()
    {
        if(is_numeric($this->size))
        {
            return true;
        }

        return false;
    }

    public function validate(bool $isSkuExist)
    {
        $messages = $this->validateProduct($isSkuExist);
        if (!$this->validateSize()) {
            $messages['size'] = INVALID_SIZE;
        }
        return $messages;
    }
}