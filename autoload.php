<?php
try {
    spl_autoload_register(function($class){
        $class = str_replace('\\', '/', $class);
        include __DIR__ . "/$class.php";
    });
} catch (\Exeption $e) {
    echo $e->Message();
}