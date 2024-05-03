<?php

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    function __construct($properties)
    {
        $this->sku = $properties['sku'];
        $this->name = $properties['name'];
        $this->price = $properties['price'];
        $this->type = $properties['type'];
    }


    abstract function getNewProductParams();

    public function validateSKU(bool $isExist)
    {
        $isValid = !empty($this->sku) && !preg_match('/\s/', $this->sku);

        return $isValid && !$isExist;
    }

    public function validateName()
    {
        return (strlen($this->name) > 0);
    }

    public function validatePrice()
    {
        return !(filter_var($this->price, FILTER_VALIDATE_FLOAT) && (strlen($this->price) > 0) && floatval($this->price >= 0));
    }

    // public function validatePrice()
    // {
    //     return !(filter_var($this->price, FILTER_VALIDATE_FLOAT) === false && strlen($this->price) > 0 && $this->price >= 0);
    // }

    public function validateType()
    {
        // Check if $this->type is an integer between 1 and 3
        return (is_int($this->type) && $this->type >= 1 && $this->type <= 3);
    }

    protected function validateFloatProperty(string $propertyName)
    {
        // Check if the property exists and is not empty
        if (!property_exists($this, $propertyName) || empty($this->$propertyName)) {
            return false; // or whatever behavior you want for empty properties
        }

        // Remove any thousand separators and trim whitespace
        $propertyValue = str_replace(',', '', trim($this->$propertyName));

        // Validate if it's a valid float and greater than 0
        if (!filter_var($propertyValue, FILTER_VALIDATE_FLOAT) || floatval($propertyValue) <= 0) {
            return false;
        }

        return true;
    }

    public function validateProduct(bool $isSkuExist): array
    {
        $messages = array();
        if (!$this->validateSKU($isSkuExist)) {
            $messages['sku'] = INVALID_SKU . "->" . $this->sku;
        }
        if (!$this->validateName()) {
            $messages['name'] = INVALID_NAME . "->" . $this->name;
        }
        if (!$this->validateFloatProperty('price')) {
            $messages['price'] = INVALID_PRICE . "->" . $this->price;
        }
        if (!$this->validateType()) {
            $messages['type'] = INVALID_TYPE . "->" . $this->type;
        }
        return $messages;
    }
}
