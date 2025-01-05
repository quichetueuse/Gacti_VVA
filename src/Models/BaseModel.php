<?php
namespace Models;
require_once('../autoloader.php');

use PDO;

class BaseModel
{
    protected PDO $pdoClient;
    protected $DbManager;
    public function __construct(){

        //creating connection object
        $this->DbManager = new Db('localhost', 'gacti', 'gacti_app', 'v3ryStr0ngPa55w0rd');
        $this->pdoClient = $this->DbManager->getPdoClient();
    }
}