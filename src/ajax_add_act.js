const min_tarif = 0;
const max_tarif = 10000;

//valids fields boolean
var valid_code_anim = false;
var valid_resp_act = false;
var valid_etat_act = false;
var valid_date_activite = true;
var valid_tarif = true;
var valid_heure_arrive = true;
var valid_heure_depart = false;
var valid_heure_fin = false;

/**
 * Fonction qui va soumettre l'envois du formulaire à condition que l'utilisateur ai accepté et que les différentes
 * valeurs dans les champs du formulaire soient valides
 */
function confirmFormSubmission()
{
    Swal.fire({
        title: "Voulez-vous ajouter l'activité?",
        icon: "question",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: "Oui, ajouter",
        cancelButtonText: "Annuler"
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            if (!areFieldsValid()){
                updateFieldsValidity();
                generateSweetAlertPopup('Valeurs invalides', 'Vérifiers les champs', 'error', null);
                return;
            }
            // Swal.fire("Animation ajoutée!", "", "success");
            submitForm();
        } else if (result.isDenied) {
            generateSweetAlertPopup('Aucun ajout effectué!', '', 'info', null);
        }
    });
}

/**
 * Fonction qui soumet l'envois du formulaire en attente d'une réponse (positive en cas de succès de la
 * requête, négative pour tout autre raison)
 */
function submitForm()
{
    // var $anim_form = document.getElementById('add-anim-form');
    // $anim_form.submit();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // document.getElementById("est3").innerHTML = this.responseText;
            let $json_response = JSON.parse(this.responseText);
            // console.log($json_response)
            if ($json_response['success'])
            {
                generateSweetAlertPopup($json_response['title'], $json_response['message'], 'success', null);
            }
            else {
                generateSweetAlertPopup($json_response['title'], $json_response['message'], 'error', null);
            }
        }
    }
    xmlhttp.open("POST", "../Controllers/add_act_ajax.php", true);
    xmlhttp.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    xmlhttp.getResponseHeader("Content-type", "application/json");
    ajax_str = generateAjaxString();
    xmlhttp.send(ajax_str);
}

/**
 * Fonction construisant une chaine de caractères servant à un post de formulaire artificiel
 * @return {string} - Retourne la chaine de caractère contenant les valeurs qui vont être postés ($_REQUEST_METHOD)
 */
function generateAjaxString(){
    $code_anim = document.getElementById('add-code-anim').value;
    $etat_act = document.getElementById('add-code-etat-act').value;
    $resp_act = document.getElementById('add-resp-act').value;
    $date_act = document.getElementById('add-date-act').value;
    $heure_arrive = document.getElementById('add-time-arrive').value;
    $heure_depart = document.getElementById('add-time-depart').value;
    $heure_fin = document.getElementById('add-time-fin').value;
    $tarif = document.getElementById('add-tarif-act').value;

    ajax_str = 'code_anim=' + $code_anim +
        '&etat_act=' + $etat_act +
        '&resp_act=' + $resp_act +
        '&date_act=' + $date_act +
        '&heure_arrive=' + $heure_arrive +
        '&heure_depart=' + $heure_depart +
        '&heure_fin=' + $heure_fin +
        '&tarif=' + $tarif;


    return ajax_str

}

/**
 * Fonction testant la validité d'une date selon des critère précis
 * @param {string} date_time_activite - Date que l'on doit vérifier
 */
function isValidDateActivite(date_time_activite) {
    var current_date = new Date( ).toLocaleDateString('en-CA');
    var tomorrow_date = new Date(+new Date() + 86400000).toLocaleDateString('en-CA');
    if (date_time_activite.toString() < tomorrow_date)
    {
        document.getElementById('error-date-act').innerHTML = 'Date invalide, veuillez rentrer une date supérieure à celle d\'aujourd\'hui!';
        valid_date_activite = false;
    }
    else
    {
        document.getElementById('error-date-act').innerHTML = '';
        valid_date_activite = true;
    }
    // document.getElementById('error-date-validite').innerHTML = new Date( ).toLocaleDateString('en-CA');
    // document.getElementById('error-date-validite').innerHTML = new Date ( ).toLocaleString(); //date_time_validite.toString()
    // date_time_validite = new DateTime()
}


/**
 * Fonction gérant la validité des champs en fonction de leur identifiant
 * @param {string} sender_id - Identifiant du champ à vérifier
 */
function validateFields(sender_id) {
    switch (sender_id) {
        // case 'add-time-arrive': {
        //     if (document.getElementById('add-time-arrive').value > document.getElementById('add-time-depart').value || document.getElementById('add-time-arrive').value > document.getElementById('add-time-fin').value) {
        //         document.getElementById("error-time-arrive").innerHTML = "L'heure d'arrivée ne peut pas être supérieure à celle de départ ou de fin de l'activité!";
        //     }
        //     else {
        //         document.getElementById("error-time-arrive").innerHTML = "";
        //     }
        //     break;
        // }

        // case 'add-time-depart': {
        //     if (document.getElementById('add-time-depart').value < document.getElementById('add-time-arrive').value || document.getElementById('add-time-depart').value > document.getElementById('add-time-fin').value) {
        //         document.getElementById("error-time-depart").innerHTML = "L'heure de départ ne peut pas être inférieure à celle d'arrivée ou être supérieure à celle de fin de l'activité!";
        //     }
        //     else {
        //         document.getElementById("error-time-depart").innerHTML = "";
        //     }
        //     break;
        // }


        // case 'add-time-fin': {
        //     if (document.getElementById('add-time-fin').value < document.getElementById('add-time-depart').value || document.getElementById('add-time-fin').value < document.getElementById('add-time-arrive').value) {
        //         document.getElementById("error-time-fin").innerHTML = "L'heure de fin ne peut pas être inférieure à celle de départ ou d'arrivée!";
        //     }
        //     else {
        //         document.getElementById("error-time-depart").innerHTML = "";
        //     }
        //     break;
        // }

        case 'hour': {

            if (document.getElementById('add-time-arrive').value > document.getElementById('add-time-depart').value || document.getElementById('add-time-arrive').value > document.getElementById('add-time-fin').value) {
                document.getElementById("error-time-arrive").innerHTML = "L'heure d'arrivée ne peut pas être supérieure à celle de départ ou de fin de l'activité!";
                valid_heure_arrive = false;
            }
            else {
                document.getElementById("error-time-arrive").innerHTML = "";
                valid_heure_arrive = true;
            }

            if (document.getElementById('add-time-depart').value < document.getElementById('add-time-arrive').value || document.getElementById('add-time-depart').value >= document.getElementById('add-time-fin').value) {
                document.getElementById("error-time-depart").innerHTML = "L'heure de départ ne peut pas être inférieure à celle d'arrivée ou être supérieure à celle de fin de l'activité!";
                valid_heure_depart = false;
            }
            else {
                document.getElementById("error-time-depart").innerHTML = "";
                valid_heure_depart = true;
            }

            if (document.getElementById('add-time-fin').value <= document.getElementById('add-time-depart').value || document.getElementById('add-time-fin').value <= document.getElementById('add-time-arrive').value) {
                document.getElementById("error-time-fin").innerHTML = "L'heure de fin ne peut pas être inférieure ou égale à celle de départ ou d'arrivée!";
                valid_heure_fin = false;
            }
            else {
                document.getElementById("error-time-fin").innerHTML = "";
                valid_heure_fin = true;
            }
            break;
        }


        case 'add-tarif-act': {
            if (document.getElementById('add-tarif-act').value < min_tarif || document.getElementById('add-tarif-act').value > max_tarif) {
                document.getElementById("error-tarif").innerHTML = "Le prix rentré n'est pas valide! (il doit être compris entre 0 et 10000)";
                valid_tarif = false;
            }
            else {
                document.getElementById("error-tarif").innerHTML = "";
                valid_tarif = true;
            }
            break;
        }

        case 'add-code-anim': {
            if (document.getElementById('add-code-anim').value === '') {
                document.getElementById("error-code-anim").innerHTML = "Aucune animation sélectionnée!";
                valid_code_anim = false;
            }
            else {
                document.getElementById("error-code-anim").innerHTML = "";
                valid_code_anim = true;
            }
            break;
        }


        case 'add-code-etat-act': {
            if (document.getElementById('add-code-etat-act').value === '') {
                document.getElementById("error-code-etat-act").innerHTML = "Aucun état d'activité sélectionné!";
                valid_etat_act = false;
            }
            else {
                document.getElementById("error-code-etat-act").innerHTML = "";
                valid_etat_act = true;
            }
            break;
        }

        case 'add-resp-act': {
            if (document.getElementById('add-resp-act').value === '') {
                document.getElementById("error-resp-act").innerHTML = "Aucun responsable d'activité sélectionné!";
                valid_resp_act = false;
            }
            else {
                document.getElementById("error-resp-act").innerHTML = "";
                valid_resp_act = true;
            }
            break;
        }
    }
}

/**
 * Fonction testant la validité de tous les champs du formulaire d'ajout d'activité
 */
function updateFieldsValidity() {
    validateFields('hour');
    validateFields('add-code-anim');
    validateFields('add-code-etat-act');
    validateFields('add-resp-act');
    isValidDateActivite('add-date-act');
    validateFields('add-tarif-act');
    return;
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

function areFieldsValid() {
    return valid_heure_arrive &&
        valid_heure_depart &&
        valid_heure_fin &&
        valid_tarif  &&
        valid_date_activite &&
        valid_code_anim &&
        valid_resp_act &&
        valid_etat_act;
}

