<?php

namespace Models;

use PDO;

class Activite extends BaseModel
{
    public function __construct(){
        parent::__construct();
    }

    /**
     * Méthode qui retourne toutes les activités en fonction d'une animation précise et/ou d'un mode de sélection
     * (par défaut toutes les activités sont séléctionnées peut importe leur validitée)
     * @param string $anim [optionnal] - Animation dont les activités font partie
     * @param string $select_mode [optionnal] - Mode de sélection ('invalid' ou 'valid')
     * @return array - Array contenant toutes les activités (array associatif)
     */
    public function getActivities(string $anim='all', string $select_mode='') : array{

        //base sql query
        $sqlQuery = 'SELECT act.CODEANIM, act.DATEACT, act.CODEETATACT, act.HRRDVACT, act.PRIXACT, act.HRDEBUTACT, 
            act.HRFINACT, act.DATEANNULEACT, act.NOMRESP, act.PRENOMRESP, anim.NOMANIM, anim.DESCRIPTANIM, 
            anim.COMMENTANIM, anim.DIFFICULTEANIM, anim.NBREPLACEANIM, anim.DUREEANIM, anim.LIMITEAGE 
            from activite as act INNER JOIN animation as anim ON anim.CODEANIM = act.CODEANIM';


        //pour récupérer toutes les activités d'une animation précise
        if ($anim !== 'all') {
            $sqlQuery .= ' WHERE act.CODEANIM=:code_anim';
        }

        //selection des activités dont la date d'annulation est vide
        if ($select_mode === 'valid' and $anim !== 'all'){
            $sqlQuery .= ' AND act.DATEANNULEACT IS NULL';
        } elseif($select_mode === 'valid' and $anim === 'all') {
            $sqlQuery .= ' WHERE act.DATEANNULEACT IS NULL';
        }


        //selection des activités dont la date d'annulation contient quelque chose
        if ($select_mode === 'invalid' and $anim !== 'all') {
            $sqlQuery .= ' AND act.DATEANNULEACT IS NOT NULL';
        } elseif ($select_mode === 'invalid' and $anim === 'all') {
            $sqlQuery .= ' WHERE act.DATEANNULEACT IS NOT NULL';
        }



        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute(['code_anim' => $anim]);
        return $animstatement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant de supprimer une activité
     * @param string $act_id - Identifiant de l'activité
     * @param string $date_act - Date de l'activité
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *   le méssage du popup à afficher
     */
    public function deleteActivite(string $act_id, string $date_act) : array {
//        $sqlQuery = 'DELETE FROM activite WHERE CODEANIM=:act_id AND DATEACT=:date_act';
        $sqlQuery = 'UPDATE activite SET DATEANNULEACT= current_date WHERE CODEANIM= :act_id AND DATEACT= :date_act';
        $actstatement = $this->pdoClient->prepare($sqlQuery);
        $actstatement->execute(['act_id' => $act_id, 'date_act' => $date_act]);
        if ($actstatement->rowCount() > 0)
        {
            return ['success' => true, 'title' => 'Activité supprimée!', 'message' => 'Tous les utilisateurs inscrits ont été désinscrits'];
        }
        else {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'La suppréssion à échouée! (@r)'];
        }
    }

    /**
     * Méthode permettant de restaurer une activité supprimée
     * @param string $act_id - Identifiant de l'activité
     * @param string $date_act - Date de l'activité
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *  le méssage du popup à afficher
     */
    public function restoreActivite(string $act_id, string $date_act): array {
        $sqlQuery = 'UPDATE activite SET DATEANNULEACT= NULL WHERE CODEANIM= :act_id AND DATEACT= :date_act';
        $actstatement = $this->pdoClient->prepare($sqlQuery);
        $actstatement->execute(['act_id' => $act_id, 'date_act' => $date_act]);
        if ($actstatement->rowCount() > 0)
        {
            return ['success' => true, 'title' => 'Activité Restaurée!', 'message' => ''];
        }
        else {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Erreur durant l\'éxécution de la requête'];
        }
    }

    /**
     * Méthode se connectant à la base de données afin d'ajouter une activité dans la table 'activite'
     * @param array $new_act - Array contenant toutes les valeurs des champs du formulaire d'ajout d'activité néttoyées
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     * le méssage du popup à afficher
     */
    public function addActivite(array $new_act): array {
        $sqlQuery = 'INSERT INTO activite (CODEANIM, DATEACT, CODEETATACT, HRRDVACT, HRDEBUTACT, 
                     HRFINACT, PRIXACT, NOMRESP, PRENOMRESP) 
                     VALUES (:code_anim, :date_act, :code_act, :heure_arrive, :heure_depart, 
                             :heure_fin, :tarif, :nom_resp, :prenom_resp)';
        $actstatement = $this->pdoClient->prepare($sqlQuery);
        $actstatement->execute(
            ['code_anim' => $new_act[0],
                'date_act' => $new_act[4],
                'code_act' => $new_act[1],
                'heure_arrive' => $new_act[5],
                'heure_depart' => $new_act[6],
                'heure_fin' => $new_act[7],
                'tarif' => $new_act[8],
                'nom_resp' => $new_act[2],
                'prenom_resp' => $new_act[3] ]);
//        echo $this->pdoClient->lastInsertId();
        if ($actstatement->rowCount() > 0)
        {
            return ['success' => true, 'title' => 'Activité ajoutée!', 'message' => ''];
        }
        else {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Erreur durant l\'éxécution de la requête'];
        }

    }

    /**
     * Méthode Qui retourne true si une activité possédant le même code d'animation et la même date d'animation éxiste sinon false
     * @param string $code_anim - Code de l'animation de l'activité dont on souhaite vérifier l'éxistence
     * @param string $date_act - Date de l'activité dont on souhaite vérifier l'éxistence
     * @return bool - Est ce que l'activité éxiste
     */
    public function doesActiviteExist(string $code_anim, string $date_act): bool {
        $sqlQuery = 'SELECT CODEANIM FROM activite WHERE CODEANIM= :code_anim AND DATEACT= :date_act';
        $actStatement = $this->pdoClient->prepare($sqlQuery);
        $actStatement->execute(['code_anim' =>$code_anim, 'date_act' => $date_act]);
        if ($actStatement->rowCount() > 0) {
            return true;
        }
        return false;
    }



    /**
     * Method that return an activity by given id
     * @param string $code_anim - act id
     * @param string $date_act - act date
     * @return array - All activity information
     */
    public function getActiviteInformationById(string $code_anim, string $date_act, int $mode): array {
        $sqlQuery = 'SELECT act.CODEANIM, act.CODEETATACT, compte.USER, act.DATEACT, act.HRRDVACT, act.HRDEBUTACT, act.HRFINACT, act.PRIXACT FROM activite as act 
            INNER JOIN compte ON compte.PRENOMCOMPTE = act.PRENOMRESP AND compte.NOMCOMPTE = act.NOMRESP 
            WHERE CODEANIM=:code_anim AND DATEACT=:date_act;';
        $actStatement = $this->pdoClient->prepare($sqlQuery);
        $actStatement->execute(['code_anim' =>$code_anim, 'date_act' => $date_act]);

        $result = $actStatement->fetch($mode);
        //if no activite is found
        if ($result === false)
        {
            return array();
        }

        return $result;
    }

    /**
     * Méthode se connectant à la base de données afin de mettre à jour une activité
     * @param array $new_act - Array contenant toutes les valeurs à mettre à jour
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     * le méssage du popup à afficher
     */
    public function updateActivite(array $act): array {
        $sqlQuery = 'UPDATE activite SET CODEETATACT=:code_act, HRRDVACT=:heure_arrive, HRDEBUTACT=:heure_depart, 
                     HRFINACT=:heure_fin, PRIXACT=:tarif, NOMRESP=:nom_resp, PRENOMRESP=:prenom_resp 
                     WHERE CODEANIM=:code_anim AND DATEACT=:date_act
                     ';
        $actstatement = $this->pdoClient->prepare($sqlQuery);
        $actstatement->execute(
            ['code_anim' => $act[0],
                'date_act' => $act[4],
                'code_act' => $act[1],
                'heure_arrive' => $act[5],
                'heure_depart' => $act[6],
                'heure_fin' => $act[7],
                'tarif' => $act[8],
                'nom_resp' => $act[2],
                'prenom_resp' => $act[3] ]);
        if ($actstatement->rowCount() > 0)
        {
            return ['success' => true, 'title' => 'Activité mise à jour!', 'message' => ''];
        }
        else {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Erreur durant l\'éxécution de la requête'];
        }

    }

    /**
     * Method that check if an activity is cancelled or not
     * @param string $code_anim - act id
     * @param string $date_act - act date
     * @return bool - Return true if act is cancelled, else false
     */
    public function isActCancelled(string $code_anim, string $date_act): bool {
        $sqlQuery = 'SELECT CODEANIM FROM activite WHERE CODEANIM=:code_anim AND DATEACT=:date_act AND DATEANNULEACT IS NOT NULL';

        $actstatement = $this->pdoClient->prepare($sqlQuery);
        $actstatement->execute(['code_anim' => $code_anim, 'date_act' => $date_act]);

        // If act is cancelled
        if ($actstatement->rowCount() > 0) {
            return true;
        }
        return false;
    }

}
