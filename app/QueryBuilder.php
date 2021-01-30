<?php
namespace app;

use app\Database;




class QueryBuilder
{
    protected $table;
    protected $data;

    public function insert($table, array $data, Database $database)
    {
        $pdo = $database->conect();
        $this->data = $data;
        $this->table = $table;
        
        
        $arrayColumn = array_keys($this->data);
        $arrayValues = array_values($this->data);
        
        $column = implode(",", $arrayColumn);
        
        $countPlaceholder = count($this->data);
        
        $placeholder = (!empty($placeholder)) ? $placeholder = '?,' : str_repeat('?,', $countPlaceholder);
        $placeholder = rtrim($placeholder, ',');
        
        

        try {
            $sql = "INSERT INTO $this->table ({$column}) VALUES({$placeholder})";
            $stn = $pdo->prepare($sql);
            $stn->execute($arrayValues);
        } catch (PDOEexeption $e) {
            echo $e->getMessage();
        }
        
    }
}
