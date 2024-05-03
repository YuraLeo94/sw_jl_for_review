<?php

class ProductsController
{

    public function add()
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $types = [
            1 => 'DVD',
            2 => 'Book',
            3 => 'Furniture'
        ];

        // return response(['status' => 'test', 'message' => 'check parsed data', 'data' => $data]);
        try {
            $productType = $data['type'] ?? null;
            if (!isset($types[$productType])) {
                return response(['status' => 'failed', 'message' => INVALID_TYPE, 'data' => $data]);
                throw new Exception('Invalid product type');
            }

            $productClass = $types[$productType];
            $newProduct = new $productClass($data);
            $productsModel = new ProductsModel("products");

            $itemBySku = $productsModel->takeEntryBySKU($data['sku']);
            if ($itemBySku['execResInfo']['status'] === 'failed') {
                return response($itemBySku['execResInfo']);
            }

            $errors = $newProduct->validate(count($itemBySku['item']) > 0);
            if (count($errors) > 0) {
                return response(['status' => 'failed', 'errors' => $errors, 'test' => 'test']);
            }

            return response($productsModel->add($newProduct->getNewProductParams()));
            // return response(['status' => 'test', 'message' => 'check parsed data', 'data' => $data, 'data2' => $newProduct->getNewProductParams()]);
            // return response($productsModel->add($data));
        } catch (Exception $e) {
            return response(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function get()
    {
        try {
            return response((new ProductsModel("products"))->getAll());
        } catch (Exception $e) {
            return response(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function deleteListOfProducts()
    {
        $jsonData = file_get_contents('php://input');
        $primaryKeys = json_decode($jsonData, true);
        // return response(['status' => 'test', 'message' => 'check parsed data', 'primaryKeys' => $primaryKeys]);
        try {
            return response((new ProductsModel("products"))->deleteListOfProducts($primaryKeys));
        } catch (Exception $e) {
            return response(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}
