<?php

namespace Controllers;

use Controllers\ResponseController;
use Exception;
use Model\ProductsModel;

class ProductsController
{

    public function create(array $data)
    {
        // var_dump($inputs); 
        // var_dump($inputs['sku']); 
        // var_dump(json_decode($inputs[0], true));
        // return ResponseController::response(['status' => 'test', 'message' => 'check inputs', 'inputs' => $inputs]);
        // return response(['status' => 'test', 'message' => 'check inputs', 'inputs' => $inputs]);
        // $jsonData = file_get_contents('php://input');
        // $data = json_decode($jsonData, true);
        $data = $this->getInputs();
        $types = [
            1 => 'Products\DVD',
            2 => 'Products\Book',
            3 => 'Products\Furniture'
        ];


        try {
            $productType = $data['type'] ?? null;
            if (!isset($types[$productType])) {
                return ResponseController::response(ResponseController::getPreparedDataResponseFailed(INVALID_TYPE));

                throw new Exception(INVALID_TYPE);
            }

            $productClass = $types[$productType];
            $newProduct = new $productClass($data);
            $productsModel = new ProductsModel(DB_PODUCTS_TABLE_NAME);

            $itemBySku = $productsModel->takeEntryBySKU($data['sku']);
            if ($itemBySku[EXEC_RES_INFO_KEY_NAME][RESPONSE_NAMES['statusKeyName']] === RESPONSE_NAMES['failed']) {
                return ResponseController::response($itemBySku[EXEC_RES_INFO_KEY_NAME]);
            }

            $errors = $newProduct->validate(count($itemBySku['item']) > 0);
            if (count($errors) > 0) {
                return ResponseController::response([
                    RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['failed'],
                    RESPONSE_NAMES['errorsKeyName'] => $errors
                ]);
            }

            return ResponseController::response($productsModel->add($newProduct->getNewProductParams()));
            // return response(['status' => 'test', 'message' => 'check parsed data', 'data' => $data, 'data2' => $newProduct->getNewProductParams()]);
            // return response($productsModel->add($data));
        } catch (Exception $e) {
            return ResponseController::response(ResponseController::getPreparedDataResponseFailed($e->getMessage()));
        }
    }

    public function get()
    {
        // return ResponseController::response(['status' => 'test', 'message' => 'check inputs', 'inputs' => $_GET]);
        try {
            return ResponseController::response(
                (new ProductsModel(DB_PODUCTS_TABLE_NAME))->getAll()
            );
        } catch (Exception $e) {
            return ResponseController::response(ResponseController::getPreparedDataResponseFailed($e->getMessage()));
        }
    }

    public function deleteListOfProducts(array $primaryKeys)
    {
        // $jsonData = file_get_contents('php://input');
        // $primaryKeys = $this->getInputs();
        try {
            return ResponseController::response((new ProductsModel(DB_PODUCTS_TABLE_NAME))->deleteListOfProducts($primaryKeys));
        } catch (Exception $e) {
            return ResponseController::response(ResponseController::getPreparedDataResponseFailed($e->getMessage()));
        }
    }

    public function getInputs()
    {
        // $_POST
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        return $data;
    }
}
