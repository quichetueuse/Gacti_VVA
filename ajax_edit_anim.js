const len_nom_diff_anim = 40;
const len_comment_desc = 250

const min_duree = 1;

const min_age = 4;
const max_age = 100;

const min_tarif = 0;

const min_place = 1;
const max_place = 50;

var valid_date_validite = true;
var valid_title = false;
var valid_desc = false;
var valid_comment = false;
var valid_duree = true;

var valid_tarif = true;
var valid_limite_age = true;
var valid_nb_place = true;
var valid_difficulte = false;



/**
 * Fonction qui demande à l'utilisateur une confirmation avant l'envoie du formulaire, une vérification de la validité
 * des données saisies est effectuée
 * @return
 */
function confirmFormSubmission()
{
    Swal.fire({
        title: "Voulez-vous appliquer les changements apportés sur l'animation ?",
        icon: "question",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: "Oui",
        cancelButtonText: "Annuler"
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            if (!areFieldsValid()){
                updateFieldsValidity();
                generateSweetAlertPopup('Valeurs invalides', 'Vérifiers les champs', 'error', null);
                return;
            }
            submitForm();
        } else if (result.isDenied) {
            generateSweetAlertPopup('Aucun changements effectués!', '', 'info', null);
            // Swal.fire("Aucun ajout effectué!", "", "info");
        }
    });
}
/**
 * Fonction qui effectue l'envoie du formulaire d'édition d'animation
 * @return
 */
function submitForm()
{

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $json_response = JSON.parse(this.responseText);
            if ($json_response['success'])
            {
                generateSweetAlertPopup($json_response['title'], $json_response['message'], 'success', null);
                // Swal.fire("Animation ajoutée!", "", "success");
            }
            else {
                generateSweetAlertPopup($json_response['title'], $json_response['message'], 'error', null);
                // Swal.fire({
                //     icon: "error",
                //     title: "Erreur",
                //     text: "Vérifier les valeurs écrites ou sélectionnées dans les champs!",
                //     // footer: '<a href="#">Why do I have this issue?</a>'
                // });
            }
        }
    }
    xmlhttp.open("POST", "../Controllers/edit_anim_ajax.php", true);
    xmlhttp.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    xmlhttp.getResponseHeader("Content-type", "application/json");
    ajax_str = generateAjaxString();
    xmlhttp.send(ajax_str);
}

/**
 * Fonction qui génère la chaine de caractère contenant les valeurs du formulaire afin de simuler l'envoie d'une requête
 * POST
 * @return {string} - POST string
 */
function generateAjaxString(){
    $code_anim = document.getElementById('edit-num-anim').value;
    $type_anim = document.getElementById('edit-type-anim').value;
    $date_validite_anim = document.getElementById('edit-date-validite-anim').value;
    $titre_anim = document.getElementById('edit-titre-anim').value;
    $desc_anim = document.getElementById('edit-desc-anim').value;
    $comment_anim = document.getElementById('edit-comment-anim').value;
    $duree_anim = document.getElementById('edit-duree-anim').value;
    $tarif = document.getElementById('edit-tarif-anim').value;
    $limite_age = document.getElementById('edit-limiteage-anim').value;
    $nb_place = document.getElementById('edit-nbplace-anim').value;
    $difficulte = document.getElementById('edit-difficulte-anim').value;

    ajax_str = 'code_anim=' + $code_anim +
        '&type_anim=' + $type_anim +
        '&date_validite_anim=' + $date_validite_anim +
        '&titre_anim=' + $titre_anim +
        '&desc_anim=' + $desc_anim +
        '&comment_anim=' + $comment_anim +
        '&duree_anim=' + $duree_anim +
        '&tarif_anim=' + $tarif +
        '&limite_age=' + $limite_age +
        '&nb_place=' + $nb_place +
        '&difficulte=' + $difficulte;


    return ajax_str

}

/**
 * Fonction qui teste les conditions de validité enregistrées pour chaque champs
 * @return
 */
function validate_field(sender_id, sender_value)
{
    // console.log(sender_id, sender_value)
    switch (sender_id)
    {

        //validation for title field
        case "edit-titre-anim": {
            if (!isValidString(sender_value, len_nom_diff_anim))
            {
                document.getElementById("error-titre").innerHTML = "le titre doit faire moins de " + len_nom_diff_anim + " caractères! ("+ (parseInt(sender_value.length) - len_nom_diff_anim) +" caractère(s) de trop) et ne doit pas contenir de caractères spéciaux";
                valid_title = false;
            }
            else {
                document.getElementById("error-titre").innerHTML = "";
                valid_title = true;
            }
            break
        }


        //validation for
        case "edit-desc-anim": {
            if (!isValidString(sender_value, len_comment_desc)){
                document.getElementById("error-desc").innerHTML = ("la description doit faire moins de " + len_comment_desc + " caractères! ("+ (parseInt(sender_value.length) - len_comment_desc) +" caractère(s) de trop) et ne doit pas contenir de caractères spéciaux");
                valid_desc = false;
            }
            else {
                document.getElementById("error-desc").innerHTML = "";
                valid_desc = true;
            }
            break
        }


        case "edit-comment-anim": {
            if (!isValidString(sender_value, len_comment_desc)){
                document.getElementById("error-comment").innerHTML = ("le commentaire doit faire moins de " + len_comment_desc + " caractères! ("+ (parseInt(sender_value.length) - len_comment_desc) +" caractère(s) de trop) et ne doit pas contenir de caractères spéciaux");
                valid_comment = false;
            }
            else {
                document.getElementById("error-comment").innerHTML = "";
                valid_comment = true;
            }
            break
        }

        case "edit-difficulte-anim": {
            if (!isValidString(sender_value, len_nom_diff_anim)){
                document.getElementById("error-diff").innerHTML = ("la difficulté doit faire moins de " + len_nom_diff_anim + " caractères! ("+ (parseInt(sender_value.length) - len_nom_diff_anim) +" caractère(s) de trop) et ne doit pas contenir de caractères spéciaux");
                valid_difficulte = false;
            }
            else {
                document.getElementById("error-diff").innerHTML = "";
                valid_difficulte = true;
            }
            break
        }

        case 'edit-duree-anim': {
            if (!isIntInRange(sender_value, min_duree)){
                document.getElementById("error-duree").innerHTML = "Durée invalide";
                valid_duree = false;
            }
            else {
                document.getElementById("error-duree").innerHTML = "";
                valid_duree = true;
            }
            break
        }

        case 'edit-tarif-anim': {
            if (!isIntInRange(sender_value, min_tarif)){
                document.getElementById("error-tarif").innerHTML = "Tarif invalide";
                valid_tarif = false;
            }
            else {
                document.getElementById("error-tarif").innerHTML = "";
                valid_tarif = true;
            }
            break
        }

        case 'edit-limiteage-anim': {
            if (!isIntInRange(sender_value, min_age, max_age)){
                document.getElementById("error-age").innerHTML = "Limite d'age invalide";
                valid_limite_age = false;
            }
            else {
                document.getElementById("error-age").innerHTML = "";
                valid_limite_age = true;
            }
            break
        }

        case 'edit-nbplace-anim': {
            if (!isIntInRange(sender_value, min_place, max_place)){
                document.getElementById("error-place").innerHTML = "Nombre de place invalide";
                valid_nb_place = false;
            }
            else {
                document.getElementById("error-place").innerHTML = "";
                valid_nb_place = true;
            }
            break
        }
    }
}

/**
 * Fonction simulant une intéraction des champs par l'utilisateur afin de générer la les messages d'érreur sur les
 * donn"es invalides du formulaire d'édition d'animation
 * @return
 */
function updateFieldsValidity() {
    validate_field('edit-titre-anim', document.getElementById('edit-titre-anim').value);
    validate_field('edit-desc-anim', document.getElementById('edit-desc-anim').value);

    isValidDatevalidite(document.getElementById('edit-date-validite-anim').value)
    validate_field('edit-comment-anim', document.getElementById('edit-comment-anim').value);
    validate_field('edit-difficulte-anim', document.getElementById('edit-difficulte-anim').value);
    validate_field('edit-duree-anim', document.getElementById('edit-duree-anim').value);
    validate_field('edit-tarif-anim', document.getElementById('edit-tarif-anim').value);
    validate_field('edit-limiteage-anim', document.getElementById('edit-limiteage-anim').value);
    validate_field('edit-nbplace-anim', document.getElementById('edit-nbplace-anim').value);
    return;
}

/**
 * Fonction vérifiant si la date de validité de l'animation est inférieure à celle avant changement
 * @return
 */
function isValidDatevalidite(date_time_validite, old_date='')
{
    if (date_time_validite.toString() < old_date)
    {
        document.getElementById('error-date-validite').innerHTML = 'Date invalide, veuillez rentrer une date supérieure à celle d\'aujourdh\'hui!'
        valid_date_validite = false;
    }
    else
    {
        document.getElementById('error-date-validite').innerHTML = ''
        valid_date_validite = true;
    }
}


/**
 * Fonction testant la taile d'une chaine de caractère
 * @param {string} value - Chaine de caractère dont on veut tester la longeur
 * @param {int} length - Entier contenant la taille du la chaine
 * @return
 */
function isValidString(value, length) {
    // console.log("^[a-z]{0," + length + "}$")
    // console.log(value)
    const re = new RegExp("^[a-zA-Z0-9 !\.:àâäèéêëôöùûüîï',]{0," + length + "}$");
    if (re.test(value))
    {
        // console.log("true")
        return true;
    }
    else {
        return false;
        // console.log("false");
    }
}

/**
 * Fonction testant la validité de tous les champs du formulaire d'édition d'animation
 * @return {boolean} - retourne true si tous les champs ont des valeurs valides, sinon false
 */
function areFieldsValid() {
    console.log('title:' + valid_title);
    console.log('date:' + valid_date_validite);
    console.log('desc:' + valid_desc);
    console.log('comment:' + valid_comment);
    console.log('duree:' + valid_duree);
    console.log('tarif:' + valid_tarif);
    console.log('limite:' + valid_limite_age);
    console.log('nb place:' + valid_nb_place);
    console.log('diff:' + valid_difficulte);

    return valid_title &&
        valid_date_validite &&
        valid_desc &&
        valid_comment &&
        valid_duree &&
        valid_tarif &&
        valid_limite_age &&
        valid_nb_place &&
        valid_difficulte;
}

/**
 * Fonction testant si un nombre est compris dans un interval
 * @param {int} value - Valeur à tester
 * @param {int} min - [optionnal] valeur minimale de l'interval
 * @param {int} max - [optionnal] valeur maximale de l'interval
 * @return {boolean} - retourne true si la valeur est comprise dans la plage, sinon false
 */
function isIntInRange(value, min = 0, max = 1000000) {
    return min <= value && value <= max;

}

/**
 * Fonction générant des popup mySweetAlert2 à partir de paramètres
 * @param {string} title - titre du popup
 * @param {string} text - texte du popup
 * @param {string} icon - type de message (success, error, warning, question, info)
 * @param {number} timer - durée de vie du message (null si aucun)
 * @return {sweetAlert} - retourne le popup
 */
function generateSweetAlertPopup(title, text, icon, timer= null) {

    return Swal.fire({
        title: title,
        text: text,
        icon: icon,
        timer: timer
    });
}


function getAnimationByCodeAnim(anim)
{
    if (anim === "") {
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                json_response = JSON.parse(this.responseText);
                console.log();

                //setting values in field
                document.getElementById('edit-num-anim').value = json_response['CODEANIM'];
                document.getElementById('edit-type-anim').value = json_response['CODETYPEANIM'];
                document.getElementById('edit-date-validite-anim').value = json_response['DATEVALIDITEANIM'];
                document.getElementById('edit-titre-anim').value = json_response['NOMANIM'];
                document.getElementById('edit-desc-anim').value = json_response['DESCRIPTANIM'];
                document.getElementById('edit-comment-anim').value = json_response['COMMENTANIM'];
                document.getElementById('edit-duree-anim').value = json_response['DUREEANIM'];
                document.getElementById('edit-tarif-anim').value = json_response['TARIFANIM'];
                document.getElementById('edit-limiteage-anim').value = json_response['LIMITEAGE'];
                document.getElementById('edit-nbplace-anim').value = json_response['NBREPLACEANIM'];
                document.getElementById('edit-difficulte-anim').value = json_response['DIFFICULTEANIM'];

                updateFieldsValidity();




            }
        };
        xmlhttp.open("GET", "../Controllers/get_anim_by_code_ajax.php?code_anim=" + anim, true);
        xmlhttp.send();
    }
}


