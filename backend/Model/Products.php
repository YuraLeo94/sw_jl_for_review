<?php

// namespace Model;

// use Database\Database;
// use PDOException;
// use Exception;
interface IProductsModel
{
    public function getAll();
}


class ProductsModel implements IProductsModel
{

    private $table_name;

    function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    public function add1(array $data): array
    {
        $con = (new Database())->get();
        $execResInfo = array('status' => 'success', 'message' => 'Product added to the database');
        try {
            // Prepare the query
            $query = 'INSERT INTO ' . $this->table_name . ' VALUES (' . implode(',', array_fill(0, count($data), '?')) . ')';
            $stmt = $con->prepare($query);

            // Detect bind types dynamically
            $types = $this->detectBindTypes($data); // Assuming detectBindTypes function is defined

            // Bind parameters
            $params = [];
            foreach ($data as &$value) {
                $params[] = &$value;
            }
            array_unshift($params, $types);
            call_user_func_array(array($stmt, 'bind_param'), $params);

            // Execute the statement
            $success = $stmt->execute();

            if (!$success) {
                $execResInfo = array('status' => 'failed', 'message' => 'Failed to add product.');
            }
        } catch (PDOException $e) {
            $execResInfo = array('status' => 'failed', 'message' => $e->getMessage());
        } finally {
            // Close the statement and the database connection
            if ($stmt) {
                $stmt->close();
            }
            if ($con) {
                $con->close();
            }
        }

        return $execResInfo;
    }

    public function add(array $data): array
    {
        // return ['status' => 'test', 'message' => 'check parsed data', 'data' => $data];
        $execResInfo = array('status' => 'success', 'message' => 'Product added to the database');
        try {

            $con = (new Database())->get();
            $placeholders = implode(',', array_fill(0, count($data), '?'));
            // Prepare the query
            $query = 'INSERT INTO ' . $this->table_name . " VALUES ($placeholders)";
            $stmt = $con->prepare($query);

            // Check if the statement was prepared successfully
            if (!$stmt) {
                return array('status' => 'failed', 'message' => 'Failed to prepare statement', 'db' => $con);
                throw new Exception('Failed to prepare statement');
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
                return array('status' => 'failed', 'message' => 'bind_param method not found on statement object');
                throw new Exception('bind_param method not found on statement object');
            }

            // Call bind_param method using call_user_func_array
            call_user_func_array(array($stmt, 'bind_param'), $params);

            // Execute the statement
            $success = $stmt->execute();

            if (!$success) {
                $execResInfo = array('status' => 'failed', 'message' => 'Failed to add product.');
            }
        } catch (PDOException $e) {
            $execResInfo = array('status' => 'failed', 'message' => $e->getMessage());
        } catch (Exception $e) {
            $execResInfo = array('status' => 'failed', 'message' => $e->getMessage());
        } finally {
            // Close the statement and the database connection
            if ($stmt) {
                $stmt->close();
            }
            if ($con) {
                $con->close();
            }
        }

        return $execResInfo;
    }






    // need fix saving data to the object;
    public function getAll(): array
    {
        $execResInfo = array('status' => 'success', 'message' => 'Products received successfully.');
        $con = (new Database())->get();
        $query = "SELECT * FROM " . $this->table_name;
        $result = mysqli_query($con, $query);
        $products = [];

        // Check if the query was successful
        if (!$result) {
            $execResInfo = array('status' => 'failed', 'message' => mysqli_error($con));
            return array('execResInfo' => $execResInfo, 'products' => $products);
            throw new Exception("Query failed: " . mysqli_error($con));
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
            $execResInfo = array('status' => 'failed', 'message' => $e->getMessage());
        } finally {
            // Close the database connection
            if ($con) {
                mysqli_close($con);
            }
        }
        return array('execResInfo' => $execResInfo, 'products' => $products);
    }

    public function deleteListOfProducts(array $primaryKeys): array
    {
        $execResInfo = array('status' => 'success', 'message' => 'Products deleted successfully.');
        try {
            // Get the database connection
            $con = (new Database())->get();

            // Generate the placeholders for the primary keys
            $placeholders = implode(',', array_fill(0, count($primaryKeys), '?'));

            // Construct the query with the placeholders
            $query = "DELETE FROM " . $this->table_name . " WHERE sku IN ($placeholders)";

            // Prepare the statement
            $statement = $con->prepare($query);

            // Check if the number of placeholders matches the number of primary keys
            if ($statement && $statement->param_count != count($primaryKeys)) {
                return array('status' => 'failed', 'message' => 'Number of placeholders does not match number of primary keys.');
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
                $execResInfo = array('status' => 'failed', 'message' => 'Failed to delete products.');
            }
        } catch (PDOException $e) {
            $execResInfo = array('status' => 'failed', 'message' => $e->getMessage());
        } finally {
            // Close the database connection
            if ($con) {
                $con->close(); // Close the connection properly
            }
        }
        return $execResInfo;
    }

    public function takeEntryBySKU($sku)
    {
        $con = (new Database())->get();
        $query = "SELECT * FROM " . $this->table_name . " WHERE sku = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $sku);

        $execResInfo = ['status' => 'success', 'message' => 'No errors.'];
        $item = [];

        if (!$stmt) {
            return ['execResInfo' => ['status' => 'failed', 'message' => 'DB error', 'sku' => $sku], 'item' => $item];
            throw new Exception("Query preparation failed: " . mysqli_error($con));
        }

        try {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                $item = mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
        } catch (Exception $e) {
            $execResInfo = ['status' => 'failed', 'message' => $e->getMessage()];
        } finally {
            // Close the statement
            mysqli_stmt_close($stmt);
            // Close the database connection
            if ($con) {
                mysqli_close($con);
            }
        }

        return ['execResInfo' => $execResInfo, 'item' => $item];
    }

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
