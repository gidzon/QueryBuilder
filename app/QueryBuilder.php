<?php
namespace app;

use app\Database;




class QueryBuilder
{
    

    public function insert($table, array $data, Database $database)
    {
        $pdo = $database->conect();
        $placeholder = $this->createParametrsOfPlaceholder($data);
        $arrayValues = $this->getArrayValues($data);
        $arrayColumn = $this->getArrayColumns($data);
        $column = $this->getSrtingColumns($arrayColumn);
        
        try {
            $sql = "INSERT INTO $table ({$column}) VALUES({$placeholder})";
            $stn = $pdo->prepare($sql);
            $stn->execute($arrayValues);
        } catch (PDOEexeption $e) {
            echo $e->getMessage();
        }
        
    }

    public  function createParametrsOfPlaceholder(array $data)
    {


        $countPlaceholder = count($data);
        
        $placeholder = (!empty($placeholder)) ? $placeholder = '?,' : str_repeat('?,', $countPlaceholder);
        return rtrim($placeholder, ',');

    }

    public function getArrayValues(array $data): array
    {
        return array_values($data);
    }

    public function getArrayColumns(array $data): array
    {
        return array_keys($data);
    }

    public function getSrtingColumns(array $arrayKeysColumn): string
    {
        return implode(",", $arrayKeysColumn);
        
    }
}
