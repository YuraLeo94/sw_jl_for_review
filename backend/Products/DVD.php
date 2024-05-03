<?php

// namespace Products;
// use Product;

class DVD extends Product {
    private $size;


    function __construct($properties)
    {
        parent::__construct($properties);
        $this->size = $properties['size'];
    }

    // function addNew()
    // {
    //     try {
    //         $con = (new Database())->get();
    //         $query = "INSERT INTO Product (sku, name, price, type, size) VALUES (?, ?, ?, 'DVD', ?)";
    //         $statement = $con->prepare($query);
    
    //         // Execute the statement
    //         $success = $statement->execute([$this->sku, $this->name, $this->price, $this->size]);
    //         if ($success) {
    //             echo "Product added successfully.";
    //         } else {
    //             echo "Failed to add product.";
    //         }
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //     }
    // }

    function getNewProductParams() {
        return [$this->sku, $this->name, $this->price, $this->type, $this->size, null, null, null, null];
    }

    public function validateSize()
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