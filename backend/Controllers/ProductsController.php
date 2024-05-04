<?php

class ProductsController
{

    public static function add()
    {
        // return response(['status' => 'test', 'message' => 'check inputs', 'inputs' => $inputs]);
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $types = [
            1 => 'DVD',
            2 => 'Book',
            3 => 'Furniture'
        ];

        
        try {
            $productType = $data['type'] ?? null;
            if (!isset($types[$productType])) {
                return ResponseController::response(ResponseController::getPreparedDataResponseFailed(INVALID_TYPE));
                // return response([
                //     RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['failed'],
                //     RESPONSE_NAMES['messagesKeyName'] => INVALID_TYPE
                // ]);
                throw new Exception(INVALID_TYPE);
            }

            $productClass = $types[$productType];
            $newProduct = new $productClass($data);
            $productsModel = new ProductsModel(DB_PODUCTS_TABLE_NAME);

            $itemBySku = $productsModel->takeEntryBySKU($data['sku']);
            if ($itemBySku[EXEC_RES_INFO_KEY_NAME][RESPONSE_NAMES['statusKeyName']] === RESPONSE_NAMES['failed']) {
                return response($itemBySku[EXEC_RES_INFO_KEY_NAME]);
            }

            $errors = $newProduct->validate(count($itemBySku['item']) > 0);
            if (count($errors) > 0) {
                return ResponseController::response([
                    RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['failed'],
                    RESPONSE_NAMES['errorsKeyName'] => $errors
                ]);
            }

            return response($productsModel->add($newProduct->getNewProductParams()));
            // return response(['status' => 'test', 'message' => 'check parsed data', 'data' => $data, 'data2' => $newProduct->getNewProductParams()]);
            // return response($productsModel->add($data));
        } catch (Exception $e) {
            return ResponseController::response(ResponseController::getPreparedDataResponseFailed($e->getMessage()));
            // return response([
            //     RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['failed'],
            //     RESPONSE_NAMES['messagesKeyName'] => $e->getMessage()
            // ]);
        }
    }

    public static function get()
    {
        try {
            return response((new ProductsModel(DB_PODUCTS_TABLE_NAME))->getAll());
        } catch (Exception $e) {
            return ResponseController::response(ResponseController::getPreparedDataResponseFailed($e->getMessage()));
            // return response([
            //     RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['failed'],
            //     RESPONSE_NAMES['messagesKeyName'] => $e->getMessage()
            // ]);
        }
    }

    public static function deleteListOfProducts()
    {
        $jsonData = file_get_contents('php://input');
        $primaryKeys = json_decode($jsonData, true);
        // return response(['status' => 'test', 'message' => 'check parsed data', 'primaryKeys' => $primaryKeys]);
        try {
            return response((new ProductsModel(DB_PODUCTS_TABLE_NAME))->deleteListOfProducts($primaryKeys));
        } catch (Exception $e) {
            return ResponseController::response(ResponseController::getPreparedDataResponseFailed($e->getMessage()));
            // return response([
            //     RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['failed'],
            //     RESPONSE_NAMES['messagesKeyName'] => $e->getMessage()
            // ]);
        }
    }
}
