<?php

namespace Models;
require_once('../autoloader.php');
use Exception;
use PDO;

class Db
{
    private string $host;
    private string $db_name;
    private string $user;
    private string $password;


    public function __construct(string $host, string $db_name, string $user, string $password){
        $this->host = $host;
        $this->db_name = $db_name;
        $this->user = $user;
        $this->password = $password;
//        return $this->getPdoClient();
    }

    public function getPdoClient(){
        try {
            $pdoClient = new PDO('mysql:host='. $this->host .';dbname='. $this->db_name .';charset=utf8', $this->user, $this->password, [PDO::FETCH_ASSOC]);
        } catch (Exception $e) {
            die('Error : ' . $e->getMessage());
        }
        return $pdoClient;
    }
}
