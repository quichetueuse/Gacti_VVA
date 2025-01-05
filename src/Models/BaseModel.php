<?php
namespace Models;
require_once('../autoloader.php');

use PDO;

class BaseModel
{
    private PDO $pdoClient;
    private $DbManager;
    public function __construct(){

        //creating connection object
        $this->DbManager = new Db('localhost', 'gacti', 'root', '');
        $this->pdoClient = $this->DbManager->getPdoClient();
    }


//    protected function selectAll(): array {
//
//        return array();
//    }
//
//
//
//    protected function countAll(): int () {
//
//}
}