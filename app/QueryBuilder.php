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

    public function select($table, array $where,  Database $database): array
    {
        $pdo = $database->conect();
        $placeholder = $this->createParametrsOfPlaceholder($where);
        $arrayColumn = $this->getArrayColumns($where);
        $arrayValues = $this->getArrayValues($where);
        
        if (count($arrayColumn) === 1 && !empty($where)) {
            $whereString = "WHERE {$arrayColumn['0']} = {$arrayValues['0']}";
            $sql = "SELECT * FROM {$table}" .' ' . $whereString;
            
        } elseif(count($arrayColumn) > 1 && !empty($where)) {
            
            $i = 1;
            $sql = "SELECT * FROM {$table} WHERE";
            foreach ($where as $key => $value) {
                
                
                if($i === 1) {
                    
                    $whereString = " {$key} = {$value}";
                    
                } elseif($i > 1) {
                    $whereString .= " ". "AND $key = $value";
                } 
                
                $i++;
                
                
            }
            $sql .=  $whereString;
            
        } else {
            $sql = "SELECT * FROM {$table}";
            
        }
        
        try {
            $stn = $pdo->prepare($sql);
            $stn->execute($where);
            return $stn->fetchAll();
        } catch (PDOExeption $e) {
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
