<?php

// namespace Products;

// use Product;

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

    // function addNew()
    // {
    //     try {
    //         $con = (new Database())->get();
    //         $query = "INSERT INTO Product (sku, name, price, type, width, height, length ) VALUES (?, ?, ?, 'DVD', ?, ?, ?)";
    //         $statement = $con->prepare($query);

    //         // Execute the statement
    //         $success = $statement->execute([$this->sku, $this->name, $this->price, $this->width, $this->height, $this->length]);
    //         if ($success) {
    //             echo "Product added successfully.";
    //         } else {
    //             echo "Failed to add product.";
    //         }
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //     } finally {
    //         // Close the database connection
    //         if ($con) {
    //             $con = null;
    //         }
    //     }
    // }

    function getNewProductParams()
    {
        return [$this->sku, $this->name, $this->price, $this->type, null, null, $this->width, $this->height, $this->length];
    }

    private function validateProperty(string $propertyName)
    {
        if (is_numeric($this->$propertyName) && floatval($this->$propertyName >= 0)) {
            return true;
        }

        return false;
    }

    private function validateHeight()
    {
        if (is_numeric($this->height) && floatval($this->height >= 0)) {
            return true;
        }

        return false;
    }

    private function validateWidth()
    {
        if (is_numeric($this->width) && floatval($this->width >= 0)) {
            return true;
        }

        return false;
    }

    private function validateLength()
    {
        if (is_numeric($this->length) && floatval($this->length >= 0)) {
            return true;
        }

        return false;
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
