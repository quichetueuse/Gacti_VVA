<?php

namespace Models;
use PDO;

require_once('../autoloader.php');

class Animation
{
    private $pdoClient;
    private $DbManager;
    public function __construct(){
//        $this->pdoClient = new Db('localhost', 'gacti', 'root', '');
        $this->DbManager = new Db('localhost', 'gacti', 'root', '');
        $this->pdoClient = $this->DbManager->getPdoClient();
    }


    /**
     * Méthode qui récupère toutes les animations de la table 'animation'
     * @return array - array contenant toutes les animations
     */
    public function getAllAnimations(): array { //todo creer une méthode capable de prendre ou non une id pour le select
        $sqlQuery = 'SELECT CODEANIM, NOMANIM, DESCRIPTANIM, COMMENTANIM FROM animation';
        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute();
        return $animstatement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant de récupérer toutes les informations d'une animation à partir de son code d'animation
     * @param string $code_anim - code de l'animation
     * @return array - informations de l'animation
     */
    public function getAnimationInformationsByCodeAnim(string $code_anim, int $mode): array {
        $sqlQuery = 'SELECT CODEANIM, CODETYPEANIM, NOMANIM, DATEVALIDITEANIM, DUREEANIM, LIMITEAGE, TARIFANIM, NBREPLACEANIM, DESCRIPTANIM, COMMENTANIM, DIFFICULTEANIM FROM animation WHERE CODEANIM=:code_anim'; //todo verifier si CODEANIM et CODETYPEANIM sont nécessaire
        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute(['code_anim' => $code_anim]);

        $result = $animstatement->fetch($mode);
        //if no animation is found
        if ($result === false)
        {
            return array();
        }

        return $result;
    }





    /**
     * Méthode permettant de vérifier si une animation éxiste
     * @param string $code_anim - code de l'animation dont on souhaite vérifier l'éxistence
     * @return bool - Retourne True si l'animation éxiste, sinon False
     */
    public function getAnimationByCodeAnim(string $code_anim): bool {
        $sqlQuery = 'SELECT CODEANIM FROM animation WHERE CODEANIM=:code_anim';
        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute(['code_anim' => $code_anim]);
        if ($animstatement->rowCount() == 0)
        {
            return false;
        }
        return true;
    }


    /**
     * Méthode comptant le nombre d'animations de la table 'animation'
     * @return int
     */
    public function getCountAnimations(): int {
        $sqlQuery = 'SELECT COUNT(CODEANIM) as nbre_anim FROM animation';
        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute();

        return $animstatement->fetch()['nbre_anim'];
    }

    public function getAnimationById(int $id) {

    }

    public function updateAnimationById(array $updated_animation) {

    }

    public function delAnimationById(int $id) {

    }

    /**
     * Méthode se connectant à la base de données afin d'ajouter une nouvelle animation dans la table 'animation'
     * @param array $anim_to_add - Array contenant toutes les valeurs des champs du formulaire d'ajout d'activité néttoyées
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *  le méssage du popup à afficher
     */
    public function addAnimation(array $anim_to_add): array{
        $sqlQuery = 'INSERT INTO animation (CODEANIM, CODETYPEANIM, NOMANIM, DATECREATIONANIM, DATEVALIDITEANIM, 
                     DUREEANIM, LIMITEAGE, TARIFANIM, NBREPLACEANIM, DESCRIPTANIM, COMMENTANIM, DIFFICULTEANIM) 
                     VALUES (:code_anim, :code_type_anim, :nom_anim, current_timestamp, :date_validite_anim, 
                             :duree_anim, :limite_age, :tarif, :nbre_place, :desc_anim, :comment_anim, 
                             :difficulte_anim)';
        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute(
            ['code_anim' => $anim_to_add[0],
                'code_type_anim' => $anim_to_add[1],
                'nom_anim' => $anim_to_add[2],
                'date_validite_anim' => $anim_to_add[3],
                'duree_anim' => $anim_to_add[4],
                'limite_age' => $anim_to_add[5],
                'tarif' => $anim_to_add[6],
                'nbre_place' => $anim_to_add[7],
                'desc_anim' => $anim_to_add[8],
                'comment_anim' => $anim_to_add[9],
                'difficulte_anim' => $anim_to_add[10]]);
//        echo $this->pdoClient->lastInsertId();
        if ($animstatement->rowCount() > 0)
        {
            return ['success' => true, 'title' => 'Animation ajoutée!', 'message' => ''];
        }
        else {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Erreur durant l\'éxécution de la requête'];
        }
    }

//    public function addAnimation(array $anim_to_add): bool{
//        $sqlQuery = 'INSERT INTO animation (CODEANIM, CODETYPEANIM, NOMANIM, DATECREATIONANIM, DATEVALIDITEANIM,
//                     DUREEANIM, LIMITEAGE, TARIFANIM, NBREPLACEANIM, DESCRIPTANIM, COMMENTANIM, DIFFICULTEANIM)
//                     VALUES (:code_anim, :code_type_anim, :nom_anim, current_timestamp, :date_validite_anim,
//                             :duree_anim, :limite_age, :tarif, :nbre_place, :desc_anim, :comment_anim,
//                             :difficulte_anim)';
//        $animstatement = $this->pdoClient->prepare($sqlQuery);
//        $animstatement->execute(
//            ['code_anim' => $anim_to_add[0],
//            'code_type_anim' => $anim_to_add[1],
//            'nom_anim' => $anim_to_add[2],
//            'date_validite_anim' => $anim_to_add[3],
//            'duree_anim' => $anim_to_add[4],
//            'limite_age' => $anim_to_add[5],
//            'tarif' => $anim_to_add[6],
//            'nbre_place' => $anim_to_add[7],
//            'desc_anim' => $anim_to_add[8],
//            'comment_anim' => $anim_to_add[9],
//            'difficulte_anim' => $anim_to_add[10]]);
////        echo $this->pdoClient->lastInsertId();
//        if ($animstatement->rowCount() > 0)
//        {
//            return true;
//        }
//        else{
//            return false;
//        }
//    }

    public function deleteAnimation(): bool {


        return true;
    }

    /**
     * Méthode permettant de récupérer le nombre d'inscrit à une animation.
     * @param string $code_anim - Code de l'animation dont on souhaite la connaitre le nombre d'inscrit
     * @return int - Nombre d'inscrit
     */
    public function checkNbrePlaceAnim(string $code_anim): int {
        $sqlQuery = 'SELECT NBREPLACEANIM as nbre_place FROM animation WHERE CODEANIM= :code_anim ';
        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute(['code_anim'=> $code_anim]);

        if ($animstatement->rowCount() > 0)
        {
            return $animstatement->fetch()['nbre_place'];
        }
        return 0;
    }

    /**
     * Méthode récupérant Les codes et noms de toutes les animations de la table 'animation'
     * @return array - array contenant tout les codes des animations
     */
    public function getAllCodeAnim(): array {
        $sqlQuery = 'SELECT CODEANIM, NOMANIM FROM animation;';
        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute();
        return $animstatement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode se connectant à la base de données afin de mettre à jour une animation
     * @param array $anim - Array contenant toutes les valeurs à mettre à jour
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *  le méssage du popup à afficher
     */
    public function updateAnimation($anim): array {
        $sqlQuery = 'UPDATE animation SET NOMANIM=:nom_anim, DATEVALIDITEANIM=:date_validite_anim, 
                     DUREEANIM=:duree_anim, LIMITEAGE=:limite_age, TARIFANIM=:tarif, NBREPLACEANIM=:nbre_place, 
                     DESCRIPTANIM=:desc_anim, COMMENTANIM=:comment_anim, DIFFICULTEANIM=:difficulte_anim WHERE CODEANIM=:code_anim';
        $animstatement = $this->pdoClient->prepare($sqlQuery);
        $animstatement->execute(
            ['code_anim' => $anim[0],
                'nom_anim' => $anim[2],
                'date_validite_anim' => $anim[3],
                'duree_anim' => $anim[4],
                'limite_age' => $anim[6],
                'tarif' => $anim[5],
                'nbre_place' => $anim[7],
                'desc_anim' => $anim[8],
                'comment_anim' => $anim[9],
                'difficulte_anim' => $anim[10]]);
//        echo $this->pdoClient->lastInsertId();
        if ($animstatement->rowCount() > 0)
        {
            return ['success' => true, 'title' => 'Animation mise à jour!', 'message' => ''];
        }
        else {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Erreur durant l\'éxécution de la requête'];
        }
    }
}