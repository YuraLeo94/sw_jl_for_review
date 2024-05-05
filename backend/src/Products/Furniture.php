<?php

namespace Products;

use Products\Product;

class Furniture extends Product
{
    protected $width;
    protected $height;
    protected $length;


    function __construct($properties)
    {
        parent::__construct($properties);
        $this->width = $properties['width'];
        $this->height = $properties['height'];
        $this->length = $properties['length'];
    }

    public function getNewProductParams()
    {
        return [$this->sku, $this->name, $this->price, $this->type, null, null, $this->width, $this->height, $this->length];
    }

    public function validate(bool $isSkuExist)
    {
        $messages = $this->validateProduct($isSkuExist);
        if (!$this->validateFloatProperty('height')) {
            $messages['height'] = INVALID_HEIGHT . " -> " . $this->height;
        }
        if (!$this->validateFloatProperty('width')) {
            $messages['width'] = INVALID_WIDTH . " -> " . $this->width;
        }
        if (!$this->validateFloatProperty('length')) {
            $messages['length'] = INVALID_LENGTH . " -> " . $this->length;
        }
        return $messages;
    }
}
