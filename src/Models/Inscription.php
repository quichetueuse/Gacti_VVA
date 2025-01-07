<?php

namespace Models;

use PDO;
use Models\BaseModel;

class Inscription extends BaseModel
{
    public function __construct(){
        parent::__construct();
    }


//    public function getInscription(): array {
//        return  array();
//    }
    /**
     * Méthode permettant de vérifier si une inscription éxiste déja dans la table 'inscription'
     * @param string $user_id - Identifiant de l'utilisateur
     * @param string $code_anim - Identifiant de l'activité
     * @param string $date_act - Date de l'activité
     * @return bool - Retourne True si l'inscription éxiste déjà, sinon false
     */
    public function isInscriptionAlreadyExist(string $user_id, string $code_anim, string $date_act): bool {
        $sqlQuery = 'SELECT NOINSCRIP FROM inscription WHERE USER = :user_id AND CODEANIM= :code_anim AND DATEACT= :date_act AND DATEANNULE IS NOT NULL';
        $inscriptStatement = $this->pdoClient->prepare($sqlQuery);
        $inscriptStatement->execute([':user_id' => $user_id, 'code_anim' => $code_anim, 'date_act' => $date_act]);

        if ($inscriptStatement->fetch()){
            return true;
        }
        return false;
    }

    /**
     * Méthode pour voir si un utilisateur est inscrit à une certaine activité
     * @param string $user_id - Identifiant de l'utilisateur
     * @param string $code_anim - Identifiant de l'activité
     * @param string $date_act - Date de l'activité
     * @return bool - Retourne True si l'utilisateur est déja inscrit à l'activité, sinon False
     */
    public function isUserAlreadyInscrit(string $user_id, string $code_anim, string $date_act, bool $reverse_mode = false): bool {
        $sqlQuery = 'SELECT NOINSCRIP FROM inscription WHERE USER= :user_id AND CODEANIM= :code_anim AND DATEACT= :date_act AND DATEANNULE IS NULL';
        $inscriptStatement = $this->pdoClient->prepare($sqlQuery);
        $inscriptStatement->execute([':user_id' => $user_id, 'code_anim' => $code_anim, 'date_act' => $date_act]);
        if (!$reverse_mode){
            if ($inscriptStatement->fetch()){
                return true;
            }
            return false;
        }
        elseif ($reverse_mode) {
            if ($inscriptStatement->fetch()){
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Méthode d'inscription d'utilisateur
     * @param string $user_id - Identifiant de l'utilisateur
     * @param string $code_anim - Identifiant de l'activité pour lequel l'utilisateur
     * @param string $date_act - Date de l'activité pour lequel l'utilisateur
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *    le méssage du popup à afficher
     */
    public function inscritUserToAct(string $user_id, string $code_anim, string $date_act, bool $inscription_exist=false): array {
        $sqlQuery = '';
        if ($inscription_exist)
        {
            $sqlQuery = 'UPDATE inscription SET DATEANNULE= NULL WHERE USER= :user_id AND CODEANIM= :code_anim AND DATEACT= :date_act';
        }
        elseif (!$inscription_exist) {
            $sqlQuery = 'INSERT INTO inscription (USER, CODEANIM, DATEACT, DATEINSCRIP) VALUES (:user_id, :code_anim, :date_act, current_date);';
        }
//        $sqlQuery = 'INSERT INTO inscription (USER, CODEANIM, DATEACT, DATEINSCRIP) VALUES (:user_id, :code_anim, :date_act, current_date);';
        $inscriptStatement = $this->pdoClient->prepare($sqlQuery);
        $inscriptStatement->execute([':user_id' => $user_id, 'code_anim' => $code_anim, 'date_act' => $date_act]);
        if ($inscriptStatement->rowCount() > 0)
        {
            $inscription_id = $inscription_exist ? '' : ('(Votre code d\'inscription est '. $this->pdoClient->lastInsertId() .')');
            return ['success' => true, 'title' => 'Inscription réussite!' . $inscription_id, 'message' => ''];
        }
        else {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'L\'inscription à échouée! (@r)'];
        }
    }

    /**
     * Méthode de désinscription d'utilisateur
     * @param string $user_id - Identifiant de l'utilisateur
     * @param string $code_anim - Identifiant de l'activité pour lequel l'utilisateur
     * @param string $date_act - Date de l'activité pour lequel l'utilisateur
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *    le méssage du popup à afficher
     */
    public function desincritUserToAct(string $user_id, string $code_anim, string $date_act): array {
//        $sqlQuery = 'DELETE FROM inscription WHERE USER= :user_id AND CODEANIM= :code_anim AND DATEACT= :date_act';
        $sqlQuery = 'UPDATE inscription SET DATEANNULE= current_date WHERE USER= :user_id AND CODEANIM= :code_anim AND DATEACT= :date_act';
        $inscriptStatement = $this->pdoClient->prepare($sqlQuery);
        $inscriptStatement->execute([':user_id' => $user_id, 'code_anim' => $code_anim, 'date_act' => $date_act]);
        if ($inscriptStatement->rowCount() > 0)
        {
            return ['success' => true, 'title' => 'Désinscription réussite!', 'message' => ''];
        }
        else {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'La désinscription à échouée! (@r)'];
        }
    }

    /**
     * Méthode pour récupérer le nombre d'inscrit à une activité
     * @param string $code_anim - Identifiant de l'activité
     * @param string $date_act - Date de l'activité
     * @return int - Retourne le nombre d'inscrit à une activité
     */
    public function getNumberInscritByActCodeAnim(string $code_anim, string $date_act): int {
        //SELECT COUNT(NOINSCRIP) FROM inscription as ins GROUP BY ins.CODEANIM, ins.DATEACT;
        $sqlQuery = 'SELECT COUNT(NOINSCRIP) as nbre_inscrit FROM inscription as ins WHERE CODEANIM= :code_anim AND DATEACT= :date_act AND DATEANNULE IS NULL GROUP BY ins.CODEANIM, ins.DATEACT';
        $inscriptStatement = $this->pdoClient->prepare($sqlQuery);
        $inscriptStatement->execute(['code_anim' => $code_anim, 'date_act' => $date_act]);
        if ($inscriptStatement->rowCount() > 0)
        {
            return $inscriptStatement->fetch()['nbre_inscrit'];
        }
        return 0;
    }

    /**
     * Method that get How many activity a specific user is registered to
     * @param string $nom_compte - Last name
     * @param string $prenom_compte - First name
     * @return int - Return How many activity a specific user is registered to
     */
    public function getCountInscriptionByUser(string $nom_compte, string $prenom_compte): int {
        $sqlQuery = 'SELECT COUNT(ins.NOINSCRIP) as total_inscript FROM inscription as ins
                    INNER JOIN compte as c ON c.USER = ins.USER
                    WHERE c.NOMCOMPTE=:nom AND c.PRENOMCOMPTE=:prenom';

        $ins_statement = $this->pdoClient->prepare($sqlQuery);
        $ins_statement->execute(['nom'=> $nom_compte, 'prenom' => $prenom_compte]);

        if ($ins_statement->rowCount() > 0)
        {
            return $ins_statement->fetch()['total_inscript'];
        }
        // si aucune inscription n'est trouvé
        return 0;
    }


    /**
     * Method that get All the information about all user from specific inscription
     * @param string $code_anim - act id
     * @param string $date_act - act date
     * @return array - Return All the information about all user from specific inscription
     */
    public function getAllUserInscrit(string $code_anim, string $date_act): array {
        $sqlQuery = 'SELECT ins.NOINSCRIP, ins.DATEACT, ins.DATEINSCRIP, c.NOMCOMPTE, c.PRENOMCOMPTE, c.USER, c.DATEDEBSEJOUR, c.DATEFINSEJOUR FROM inscription as ins
                    INNER JOIN compte as c ON c.USER = ins.USER
                    WHERE CODEANIM=:code_anim AND DATEACT=:date_act';
        $ins_statement = $this->pdoClient->prepare($sqlQuery);
        $ins_statement->execute(['code_anim' => $code_anim, 'date_act' => $date_act]);
        return $ins_statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode that return a number corresponding to how many activity the user is registered to
     * @param string $code_anim - act code
     * @param string $date_act - act date
     * @return bool - Return True if act is full, else False
     */
    public function isActFull(string $code_anim, string  $date_act): bool {
        $sqlQuery = 'SELECT (SELECT COUNT(NOINSCRIP) as nbre_inscrit FROM inscription AS ins WHERE ins.CODEANIM=:code_anim AND ins.DATEACT= :date_act AND DATEANNULE IS NULL GROUP BY ins.CODEANIM, ins.DATEACT) >= NBREPLACEANIM as nbre_place FROM animation WHERE CODEANIM= :code_anim ;';

        $ins_statement = $this->pdoClient->prepare($sqlQuery);
        $ins_statement->execute(['code_anim' => $code_anim, 'date_act' => $date_act]);

        $result = $ins_statement->fetch(PDO::FETCH_NUM)[0];;
        # If act is full
        if ($result == 1) {
            return True;
        }
        else {
            return False;
        }
    }
}