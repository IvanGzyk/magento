<?php

class Conexao {

private $caminho = '192.168.0.241';
private $usuario = 'root';
private $senha = 'root';
private $banco = 'magento';
public $con;

public function __construct() {
    try {
        $this->con = new PDO("mysql:host=$this->caminho;dbname=$this->banco", $this->usuario, $this->senha);
        echo "Conectado a $this->banco em $this->caminho com sucesso.";
    } catch (PDOException $pe) {
        die("Não foi possível se conectar ao banco de dados $this->banco :" . $pe->getMessage());
    }
}

public function getCon() {
    return $this->con;
}
}
?>