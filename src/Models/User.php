<?php

namespace Models;
require_once('../autoloader.php');
use Models\Db;
use PDO;

class User extends BaseModel
{
    public function __construct(){
        parent::__construct();
    }


    public function verify_credentials(string $email, string $password){
        $sqlQuery = 'SELECT USER, MDP, NOMCOMPTE, PRENOMCOMPTE, DATEINSCRIP, DATEFERME, TYPEPROFIL, DATEDEBSEJOUR, DATEFINSEJOUR, DATENAISCOMPTE, ADRMAILCOMPTE, NOTELCOMPTE FROM compte WHERE ADRMAILCOMPTE=:email AND MDP=:mdp';
        $loginStatement = $this->pdoClient->prepare($sqlQuery);
        $loginStatement->execute(['email' => $email, 'mdp' => $password]);
        return $loginStatement->fetch();
    }


    public function getAllUser(): array {
        $sqlQuery = 'SELECT USER, NOMCOMPTE, PRENOMCOMPTE, TYPEPROFIL FROM compte';
        $userStatement = $this->pdoClient->prepare($sqlQuery);
        $userStatement->execute();
        return $userStatement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getNomPrenomByUser(string $user_id)
    {
        $sqlQuery = 'SELECT NOMCOMPTE, PRENOMCOMPTE FROM compte WHERE USER=:user_id';
        $userStatement = $this->pdoClient->prepare($sqlQuery);
        $userStatement->execute(['user_id' => $user_id]);
        //if no users are found
        if ($userStatement->rowCount() == 0) {
            return false;
        } else {
            return $userStatement->fetch(PDO::FETCH_ASSOC);

        }
    }
}
