<?php

namespace Model;

use Controllers\ResponseController;

use Database\Database;
use PDOException;
use Exception;
// easy to read update
interface IProductsModel
{
    public function add(array $data);
    public function getAll();
}

// Rename to repositories and create repor services ProductsModel -> ProductsServiece
// example here -> https://github.com/Dmitrijs1710/Crypto_market/blob/main/app/Repositories/CoinsFromApiRepository.php
// ask naming chat gtp!!
// Products move to model;
class ProductsModel implements IProductsModel
{

    private $table_name;

    function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    public function add(array $data): array
    {
        // return ['status' => 'test', 'message' => 'check parsed data', 'data' => $data];
        $execResInfo = ResponseController::getPreparedDataResponseSuccess(RESPONSE_NAMES['productAddOkMessage']);

        try {

            $con = Database::get();
            $placeholders = implode(',', array_fill(0, count($data), '?'));
            // Prepare the query
            $query = 'INSERT INTO ' . $this->table_name . " VALUES ($placeholders)";
            $stmt = $con->prepare($query);

            // Check if the statement was prepared successfully
            if (!$stmt) {
                return ResponseController::getPreparedDataResponseFailed(RESPONSE_NAMES['prepareStatementFailedMessage']);

                throw new Exception(RESPONSE_NAMES['prepareStatementFailedMessage']);
            }

            // Detect bind types dynamically
            $types = $this->detectBindTypes($data); // Assuming detectBindTypes function is defined

            // Bind parameters
            $params = [];
            foreach ($data as &$value) {
                $params[] = &$value;
            }
            array_unshift($params, $types);

            // Check if bind_param method exists on the statement object
            if (!method_exists($stmt, 'bind_param')) {
                return ResponseController::getPreparedDataResponseFailed(RESPONSE_NAMES['bindParamIssueMessage']);

                throw new Exception(RESPONSE_NAMES['bindParamIssueMessage']);
            }

            // Call bind_param method using call_user_func_array
            call_user_func_array(array($stmt, 'bind_param'), $params);

            // Execute the statement
            $success = $stmt->execute();

            if (!$success) {
                $execResInfo = ResponseController::getPreparedDataResponseFailed(RESPONSE_NAMES['productAddFailedMessage']);
            }
        } catch (PDOException $e) {
            $execResInfo = ResponseController::getPreparedDataResponseFailed($e->getMessage());
        } catch (Exception $e) {
            $execResInfo = ResponseController::getPreparedDataResponseFailed($e->getMessage());
        } finally {
            // Close the statement and the database connection
            if ($stmt) {
                $stmt->close();
            }
            // if ($con) {
            //     $con->close();
            // }

            // static one instance example ->
            // https://github.com/Dmitrijs1710/Crypto_market/blob/main/app/Database.php
        }

        return $execResInfo;
    }

    // need fix saving data to the object;
    public function getAll(): array
    {
        $execResInfo = ResponseController::getPreparedDataResponseSuccess(RESPONSE_NAMES['productRecivedSuccessMessage']);

        $con = Database::get();
        $query = "SELECT * FROM " . $this->table_name;
        $result = mysqli_query($con, $query);
        $products = [];

        // Check if the query was successful
        if (!$result) {
            $execResInfo = ResponseController::getPreparedDataResponseFailed(mysqli_error($con));
            // $execResInfo = array(
            //     RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['failed'],
            //     RESPONSE_NAMES['messagesKeyName'] => mysqli_error($con)
            // );
            return array(
                EXEC_RES_INFO_KEY_NAME => $execResInfo,
                RESPONSE_NAMES['productsKeyName'] => $products
            );
            throw new Exception(DB_QUERY_FAILED . mysqli_error($con));
        }
        try {
            // $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

            while ($row = mysqli_fetch_assoc($result)) {
                // Convert types as needed
                $row['price'] = $row['price'] !== null ? (float)$row['price'] : null;
                $row['size'] = $row['size'] !== null ? (int)$row['size'] : null;
                $row['weight'] = $row['weight'] !== null ? (float)$row['weight'] : null;
                $row['width'] = $row['width'] !== null ? (float)$row['width'] : null;
                $row['height'] = $row['height'] !== null ? (float)$row['height'] : null;
                $row['length'] = $row['length'] !== null ? (float)$row['length'] : null;
                $products[] = $row;
            }


            // Free the result set
            mysqli_free_result($result);
        } catch (Exception $e) {
            $execResInfo = ResponseController::getPreparedDataResponseFailed($e->getMessage());
            // $execResInfo = array(
            //     RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['failed'],
            //     RESPONSE_NAMES['messagesKeyName'] => $e->getMessage()
            // );
        } finally {
            // Close the database connection
            // if ($con) {
            //     mysqli_close($con);
            // }
        }
        return array(EXEC_RES_INFO_KEY_NAME => $execResInfo, PRODUCTS_KEY_NAME => $products);
    }

    public function deleteListOfProducts(array $primaryKeys): array
    {
        $execResInfo = ResponseController::getPreparedDataResponseSuccess(RESPONSE_NAMES['productDeltedSuccessMessage']);
        // $execResInfo = array(
        //     RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['success'],
        //     RESPONSE_NAMES['messagesKeyName'] => RESPONSE_NAMES['productDeltedSuccessMessage']
        // );
        try {
            // Get the database connection
            $con = Database::get();

            // Generate the placeholders for the primary keys
            $placeholders = implode(',', array_fill(0, count($primaryKeys), '?'));

            // Construct the query with the placeholders
            $query = "DELETE FROM " . $this->table_name . " WHERE sku IN ($placeholders)";

            // Prepare the statement
            $statement = $con->prepare($query);

            // Check if the number of placeholders matches the number of primary keys
            if ($statement && $statement->param_count != count($primaryKeys)) {
                return ResponseController::getPreparedDataResponseFailed(RESPONSE_NAMES['bindParamMatchIssueMessage']);
            }

            $types = $this->detectBindTypes($primaryKeys); // Assuming detectBindTypes function is defined

            // Bind parameters
            $params = [];
            foreach ($primaryKeys as &$value) {
                $params[] = &$value;
            }
            array_unshift($params, $types);
            // return array('status' => 'check', 'data' => array('params' => $params, 'placeholders' => $placeholders));
            call_user_func_array(array($statement, 'bind_param'), $params);

            // Execute the statement
            $success = $statement->execute();

            // Check if the execution was successful
            if (!$success) {
                $execResInfo = ResponseController::getPreparedDataResponseFailed(RESPONSE_NAMES['productDeltedFailedMessage']);
            }
        } catch (PDOException $e) {
            $execResInfo = ResponseController::getPreparedDataResponseFailed($e->getMessage());
            // $execResInfo = array(
            //     RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['failed'],
            //     RESPONSE_NAMES['messagesKeyName'] => $e->getMessage()
            // );
        } finally {
            // Close the database connection
            // if ($con) {
            //     $con->close(); // Close the connection properly
            // }
        }
        return $execResInfo;
    }

    public function takeEntryBySKU($sku)
    {
        $con = Database::get();
        $query = "SELECT * FROM " . $this->table_name . " WHERE sku = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $sku);
        $execResInfo = ResponseController::getPreparedDataResponseSuccess(RESPONSE_NAMES['noErrorsMessage']);

        $item = [];

        if (!$stmt) {
            return [
                EXEC_RES_INFO_KEY_NAME => [
                    ResponseController::getPreparedDataResponseFailed(RESPONSE_NAMES['dbErrorMEssage']),
                ],
                'item' => $item
            ];
            throw new Exception(DB_PREP_QUERY_FAILED . mysqli_error($con));
        }

        try {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                $item = mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
        } catch (Exception $e) {
            $execResInfo = ResponseController::getPreparedDataResponseFailed($e->getMessage());
            // $execResInfo = [
            //     RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['failed'],
            //     RESPONSE_NAMES['messagesKeyName'] => $e->getMessage()
            // ];
        } finally {
            // Close the statement
            mysqli_stmt_close($stmt);
            // Close the database connection
            // if ($con) {
            //     mysqli_close($con);
            // }
        }

        return [EXEC_RES_INFO_KEY_NAME => $execResInfo, 'item' => $item];
    }

    // TODO move to helper
    function detectBindTypes(array $data): string
    {
        $types = '';
        foreach ($data as $value) {
            // Determine the type of each value
            $type = gettype($value);

            // Map PHP types to MySQLi types
            switch ($type) {
                case 'boolean':
                    $types .= 'i'; // Boolean values are mapped to integers (0 or 1)
                    break;
                case 'integer':
                    $types .= 'i'; // Integer values
                    break;
                case 'double':
                    $types .= 'd'; // Double (float) values
                    break;
                case 'string':
                default:
                    $types .= 's'; // Default to string for other types
                    break;
            }
        }
        return $types;
    }
}
