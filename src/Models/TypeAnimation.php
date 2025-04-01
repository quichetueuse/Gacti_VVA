<?php

namespace Models;
use PDO;

require_once('../autoloader.php');

class TypeAnimation extends BaseModel

{
    public function __construct(){
        parent::__construct();
    }

    public function getAllTypeAnimations(): array {
        $sqlQuery = 'SELECT CODETYPEANIM, NOMTYPEANIM FROM type_anim';
        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute();
        return $animstatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountTypeAnimations(): int {
        $sqlQuery = 'SELECT COUNT(CODETYPEANIM) as nbre_anim FROM type_anim';
        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute();

        return $animstatement->fetch()['nbre_anim'];
    }

    function getTypesName() : array {
        $sqlQuery = 'SELECT CODETYPEANIM FROM type_anim';
        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute();

        $query_result = $animstatement->fetchAll(PDO::FETCH_NUM);
        $types = array();
        foreach ($query_result as $arr){
            array_push($types, $arr[0]);
        }
        return $types;
    }
}