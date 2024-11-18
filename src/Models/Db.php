<?php

namespace Models;
require_once('../autoloader.php');
//require_once ("../_config.inc");
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
            // $pdoClient = new PDO('mysql:host=localhost;dbname=bd_actionportal;charset=utf8', 'root', '');
            // $pdoClient = new PDO('mysql:host=localhost;dbname=bd_actionportal;charset=utf8', 'root', 'mysql');
            // $pdoClient = new PDO('mysql:host=localhost;dbname=bd_actionportal;charset=utf8', 'AdminACTIONPORTAL', 'AdminACTIONPORTAL');
            $pdoClient = new PDO('mysql:host='. $this->host .';dbname='. $this->db_name .';charset=utf8', $this->user, $this->password);
        } catch (Exception $e) {
            die('Error : ' . $e->getMessage());
        }
//        $pdoClient->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdoClient;
    }
}

//$test = new Db('localhost', 'gacti', 'root', '');
//$pdoClient = $test->getPdoClient();
//$sqlQuery = 'SELECT * FROM compte WHERE USER=:user';
//$actionStatement = $pdoClient->prepare($sqlQuery);
//$actionStatement->execute(['user' => 'fokrfr']);
//echo $actionStatement->fetch()['USER'];