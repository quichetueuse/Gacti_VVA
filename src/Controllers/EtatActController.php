<?php

namespace Controllers;

use Controllers\BaseController;

use Models\EtatAct;

class EtatActController extends BaseController
{

    private EtatAct $etatact_controller;

    public function __construct() {
        $this->etatact_controller = new EtatAct();
    }

    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode de
     * récupération des états possibles des activités. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param bool $raw_mode [optionnal] - mode de récupération des états (row mode True signifie que les états sont
     * dans un même array, False signifie que les données sont retournées tel quelle)
     * @return array - array des états des activités
     */
    public function getAllEtat(bool $raw_mode=true): array {
        $result = $this->etatact_controller->getAllEtat();
        if ($raw_mode) {
            return $result;
        }

        //if raw_mode = false;
        $code_etats = array();

        foreach ($result as $etat) {
            array_push($code_etats, $etat['CODEETATACT']);
        }

        return $code_etats;
    }

}