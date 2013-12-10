<?php

class Conexao extends PDO{

     private $dsn = 'mysql:host=127.0.0.1;dbname=wordpress;charset=utf8',
             $user = 'root',
             $pass = '';
 
    
    public $handle = null;
    
    public function __construct() {
        try{
            if($this->handle == null){
                $dbh = parent::__construct($this->dsn, $this->user, $this->pass);
                $this->handle = $dbh;
                return $this->handle;
            }
            
        }catch(PDOException $e){
            echo "Conexão falhou. Erro: " . $e->getMessage();
            return false;
        }
    }
    
    public function __destruct(){
        $this->handle = null;
    }
    
}

?>
