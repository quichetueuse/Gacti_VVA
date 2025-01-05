<?php

namespace Models;

use Models\BaseModel;
use PDO;

class EtatAct extends BaseModel
{
    public function __construct(){
        parent::__construct();
    }


    /**
     * Méthode permettant de récupérer de la table 'etat_act' les différents états possibles d'une
     * activité (incertaine, annulée, etc...)
     * @return array - Contenu de la table 'etat_act'
     */
    public function getAllEtat(): array {
        $sqlQuery = 'SELECT CODEETATACT, NOMETATACT FROM etat_act';
        $userStatement = $this->pdoClient->prepare($sqlQuery);
        $userStatement->execute();
        return $userStatement->fetchAll(PDO::FETCH_ASSOC);
    }

}