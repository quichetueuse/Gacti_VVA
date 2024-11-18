const len_code_anim = 8;
const len_nom_diff_anim = 40;
const len_comment_desc = 250

const min_duree = 1;

const min_age = 4;
const max_age = 100;

const min_tarif = 0;

const min_place = 1;
const max_place = 50;

var valid_code_anim = false;
var valid_type_anim = false;
var valid_date_validite = true;
var valid_title = false;
var valid_desc = false;
var valid_comment = false;
var valid_duree = true;

var valid_tarif = true;
var valid_limite_age = true;
var valid_nb_place = true;
var valid_difficulte = false;




//
// function addAnimation() {
//     if (anim === "") {
//         document.getElementById("act-card-container").innerHTML = "";
//         return;
//     } else {
//         var xmlhttp = new XMLHttpRequest();
//         xmlhttp.onreadystatechange = function () {
//             if (this.readyState == 4 && this.status == 200) {
//                 document.getElementById("act-card-container").innerHTML = this.responseText;
//             }
//         };
//         xmlhttp.open("GET", "../Controllers/test_ajax.php?code_anim=", true);
//         xmlhttp.send();
//     }
// }

//
// function test_sweetalert() {
//     // or via CommonJS
//
//     // Swal.fire({
//     //     title: 'Error!',
//     //     text: 'Do you want to continue',
//     //     icon: 'error',
//     //     confirmButtonText: 'Cool'
//     // })
//
//     Swal.fire({
//         title: "Voulez-vous ajouter l'animation?",
//         showDenyButton: false,
//         showCancelButton: true,
//         confirmButtonText: "Oui",
//         cancelButtonText: "Annuler"
//     }).then((result) => {
//         /* Read more about isConfirmed, isDenied below */
//         if (result.isConfirmed) {
//
//             Swal.fire("Saved!", "", "success");
//         }
//     });
// }


function confirmFormSubmission()
{
    Swal.fire({
        title: "Voulez-vous ajouter l'animation?",
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
            generateSweetAlertPopup('Aucun ajout effectué!', '', 'info', null);
            // Swal.fire("Aucun ajout effectué!", "", "info");
        }
    });
}

function submitForm()
{
    // var $anim_form = document.getElementById('add-anim-form');
    // $anim_form.submit();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // document.getElementById("est1").innerHTML = this.responseText;
            $json_response = JSON.parse(this.responseText);
            console.log($json_response)
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
    xmlhttp.open("POST", "../Controllers/add_anim_ajax.php", true);
    xmlhttp.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    xmlhttp.getResponseHeader("Content-type", "application/json");
    ajax_str = generateAjaxString();
    xmlhttp.send(ajax_str);
}

function generateAjaxString(){
    $code_anim = document.getElementById('add-num-anim').value;
    $type_anim = document.getElementById('add-type-anim').value;
    $date_validite_anim = document.getElementById('add-date-validite-anim').value;
    $titre_anim = document.getElementById('add-titre-anim').value;
    $desc_anim = document.getElementById('add-desc-anim').value;
    $comment_anim = document.getElementById('add-comment-anim').value;
    $duree_anim = document.getElementById('add-duree-anim').value;
    $tarif = document.getElementById('add-tarif-anim').value;
    $limite_age = document.getElementById('add-limiteage-anim').value;
    $nb_place = document.getElementById('add-nbplace-anim').value;
    $difficulte = document.getElementById('add-difficulte-anim').value;

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

function isValidDatevalidite(date_time_validite)
{
    if (date_time_validite.toString() < new Date( ).toLocaleDateString('en-CA'))
    {
        document.getElementById('error-date-validite').innerHTML = 'Date invalide, veuillez rentrer une date supérieure à celle d\'aujourdh\'hui!'
        valid_date_validite = false;
    }
    else
    {
        document.getElementById('error-date-validite').innerHTML = ''
        valid_date_validite = true;
    }
    // document.getElementById('error-date-validite').innerHTML = new Date( ).toLocaleDateString('en-CA');
    // document.getElementById('error-date-validite').innerHTML = new Date ( ).toLocaleString(); //date_time_validite.toString()
    // date_time_validite = new DateTime()
}

function validate_field(sender_id, sender_value)
{
    // console.log(sender_id, sender_value)
    switch (sender_id)
    {
        //validation for title field
        case "add-num-anim": {
            if (!isValidString(sender_value, len_code_anim))
            {
                // if (sender_value === '') {
                //     document.getElementById("error-code-anim").innerHTML = "La description ne doit pas être vide"
                //     valid_code_anim = false;
                //     return;
                // }
                document.getElementById("error-code-anim").innerHTML = "le code doit faire moins de " + len_code_anim + " caractères! ("+ (parseInt(sender_value.length) - len_code_anim) +" caractère(s) de trop) et ne doit pas contenir de caractères spéciaux";
                valid_code_anim = false;
            }
            else {
                document.getElementById("error-code-anim").innerHTML = "";
                valid_code_anim = true;
            }
            break
        }

        //validation for title field
        case "add-titre-anim": {
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

        case 'add-type-anim': {
            if (document.getElementById('add-type-anim').value === '') {
                document.getElementById("error-code-type-anim").innerHTML = "Aucune animation sélectionnée!";
                valid_type_anim = false;
            }
            else {
                document.getElementById("error-code-type-anim").innerHTML = "";
                valid_type_anim = true;
            }
            break;
        }


        //validation for
        case "add-desc-anim": {
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


        case "add-comment-anim": {
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

        case "add-difficulte-anim": {
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

        case 'add-duree-anim': {
            if (!isIntInRange(sender_value, min_duree)){
                document.getElementById("error-duree").innerHTML = "Durée invalide";
                valid_duree = false;
            }
            else {
                document.getElementById("error-duree").innerHTML = "";
                valid_difficulte = true;
            }
            break
        }

        case 'add-tarif-anim': {
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

        case 'add-limiteage-anim': {
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

        case 'add-nbplace-anim': {
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

function updateFieldsValidity() {
    validate_field('add-num-anim', document.getElementById('add-num-anim').value);
    validate_field('add-type-anim', document.getElementById('add-type-anim').value);
    validate_field('add-titre-anim', document.getElementById('add-titre-anim').value);
    validate_field('add-desc-anim', document.getElementById('add-desc-anim').value);
    isValidDatevalidite('add-date-validite-anim', document.getElementById('add-date-validite-anim').value)


    validate_field('add-comment-anim', document.getElementById('add-comment-anim').value);
    validate_field('add-difficulte-anim', document.getElementById('add-difficulte-anim').value);
    validate_field('add-duree-anim', document.getElementById('add-duree-anim').value);
    validate_field('add-tarif-anim', document.getElementById('add-tarif-anim').value);
    validate_field('add-limiteage-anim', document.getElementById('add-limiteage-anim').value);
    validate_field('add-nbplace-anim', document.getElementById('add-nbplace-anim').value);
    return;
}




function isValidString(value, length) {
    // console.log("^[a-z]{0," + length + "}$")
    // console.log(value)
    const re = new RegExp("^[a-zA-Z0-9 !\.:]{0," + length + "}$");
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


function areFieldsValid() {
    return valid_code_anim &&
        valid_type_anim &&
        valid_date_validite &&
        valid_title &&
        valid_desc &&
        valid_comment &&
        valid_duree &&
        valid_tarif &&
        valid_limite_age &&
        valid_nb_place &&
        valid_difficulte;
}

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

