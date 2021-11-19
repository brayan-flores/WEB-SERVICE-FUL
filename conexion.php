<?php

 //Estableciendo conexion a la BD mediante la clase Conexion usando PDO

 class Conexion extends PDO{

    // DECLARAMOS LAS VARIABLES NECESARIAS PARA LA CONEXION

    private $hostBd = 'localhost';
    private $nombreBd = 'mydb';
    private $usuarioBd = 'root';
    private $passwordBd = '';

    // Usamos un constructor para capturar la conexion
    public function __construct(){
        try{ 
            parent::__construct('mysql:host=' .$this->hostBd . ';dbname=' . $this->nombreBd . ';charset=utf8', $this->usuarioBd, $this->passwordBd, array(PDO:: 
            ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 
        }catch(PDOException $e){echo 'Error: ' . $e->getMessage();exit;}
    } 
 }

?>