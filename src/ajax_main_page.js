
function showConfirmInscription(act_id, date_act) {
    Swal.fire({
        title: "Voulez-vous vraiment vous inscrire à cette activité (date d'activité " + date_act + ") ?",
        text: "Vous pourrez toujours vous désinscrire plus tard",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#4ed630",
        cancelButtonColor: "#d33",
        cancelButtonText: "Annuler",
        confirmButtonText: "Oui, m'inscrire"
    }).then((result) => {
        if (result.isConfirmed) {
            inscritUserToAct(act_id, date_act);
        }
    });
}

function inscritUserToAct(act_id, date_act) {

    if (date_act === "" || act_id === "") {
        console.log("error")
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let $json_response = JSON.parse(this.responseText);
                // document.getElementById('test2').innerHTML = $json_response;
                if ($json_response['success']) {
                    generateSweetAlertPopup($json_response['title'], $json_response['message'], 'success', 5000);
                    // Swal.fire("Inscription réussite!", "", "success");
                    showActivitiesByAnim(document.getElementById('select-anim').value);
                } else {
                    generateSweetAlertPopup($json_response['title'], $json_response['message'], 'error', null);
                    // Swal.fire({
                    //     icon: "error",
                    //     title: "Erreur",
                    //     text: "L'inscription à échouée!",
                    //     timer: 5000
                    // });
                    showActivitiesByAnim(document.getElementById('select-anim').value);
                }
            }
        };
        xmlhttp.open("GET", "../Controllers/inscrit_user_ajax.php?act_id=" + act_id + '&date_act=' + date_act, true);
        xmlhttp.send();
    }

}


function showConfirmDesinscription(act_id, date_act) {
    Swal.fire({
        title: "Voulez-vous vraiment vous désinscrire à cette activité (date d'activité " + date_act + ") ?",
        text: "Vous pourrez toujours vous ré-inscrire plus tard",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#4ed630",
        cancelButtonColor: "#d33",
        cancelButtonText: "Annuler",
        confirmButtonText: "Oui, me désinscrire"
    }).then((result) => {
        if (result.isConfirmed) {
            desinscritUserToAct(act_id, date_act);
        }
    });
}

function desinscritUserToAct(act_id, date_act) {

    if (date_act === "" || act_id === "") {
        console.log("error")
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let $json_response = JSON.parse(this.responseText);
                // document.getElementById('test2').innerHTML = $json_response;
                if ($json_response['success']) {
                    generateSweetAlertPopup($json_response['title'], $json_response['message'], 'success', 5000);
                    // Swal.fire("Désinscription réussite!", "", "success");
                    showActivitiesByAnim(document.getElementById('select-anim').value);
                } else {
                    generateSweetAlertPopup($json_response['title'], $json_response['message'], 'error', null);
                    // Swal.fire({
                    //     icon: "error",
                    //     title: "Erreur",
                    //     text: "La désinscription à échouée!",
                    //     timer: 5000
                    // });
                    showActivitiesByAnim(document.getElementById('select-anim').value);
                }
            }
        };
        xmlhttp.open("GET", "../Controllers/desinscrit_user_ajax.php?act_id=" + act_id + '&date_act=' + date_act, true);
        xmlhttp.send();
    }

}

function showConfirmDelete(act_id, date_act) {
    Swal.fire({
        title: "Voulez-vous vraiment supprimer cette activité (date d'activité " + date_act + ") ?",
        text: "Cette action est irréversible",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#4ed630",
        cancelButtonColor: "#d33",
        cancelButtonText: "Annuler",
        confirmButtonText: "Oui, Supprimer"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteActivity(act_id, date_act);
        }
    });
}

function deleteActivity(act_id, date_act) {

    if (act_id === "") {
        console.log("error")
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let $json_response = JSON.parse(this.responseText);
                if ($json_response['success'])
                {
                    generateSweetAlertPopup($json_response['title'], $json_response['message'], 'success', 5000);
                    // generateSweetAlertPopup('Activité supprimée!', '', 'success', 5000);
                    // Swal.fire("Activité supprimée!", "", "success");
                    showActivitiesByAnim(document.getElementById('select-anim').value);
                }
                else {
                    generateSweetAlertPopup($json_response['title'], $json_response['message'], 'error', null);
                    // Swal.fire({
                    //     icon: "error",
                    //     title: "Erreur",
                    //     text: "La suppréssion à échouée!",
                    // });
                }
            }
        };
        xmlhttp.open("GET", "../Controllers/delete_act_ajax.php?act_id=" + act_id + '&date_act=' + date_act, true);
        xmlhttp.send();

        // Swal.fire({
        //     icon: "success",
        //     title: "Youpi",
        //     text: "Nickel!",
        //     // footer: '<a href="#">Why do I have this issue?</a>'
        // });

    }
}

function goToLoginForm() {
    window.location.href = 'login.php';
}


function showConfirmDisconnect(){
    Swal.fire({
        title: "Voulez-vous vraiment vous déconnecter ?",
        text: "Il faudra se reconnecter",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Annuler",
        confirmButtonText: "Oui, je me déconnecte!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.location.href = '../Controllers/disconnect.php'
        }
    });
}

function filterActivitiesByAnim(){
    // var truc = 'new_animation2.php?code_anim=' + document.getElementById('select-anim').value;
    // console.log(truc)
    // window.location.href = truc;
    showActivitiesByAnim(document.getElementById('select-anim').value)
    // console.log(truc)
}


function showActivitiesByAnim(anim)
{
    if (anim === "") {
        document.getElementById("act-card-container").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("act-card-container").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "../Controllers/act_ajax.php?code_anim=" + anim, true);
        xmlhttp.send();
    }
}



function showConfirmRestore(act_id, date_act) {
    Swal.fire({
        title: "Voulez-vous vraiment restaurer cette activité (date d'activité " + date_act + ") ?",
        text: "Cette action est irréversible",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#4ed630",
        cancelButtonColor: "#d33",
        cancelButtonText: "Annuler",
        confirmButtonText: "Oui, Restaurer"
    }).then((result) => {
        if (result.isConfirmed) {
            restoreActivity(act_id, date_act);
        }
    });
}

function restoreActivity(act_id, date_act) {

    if (act_id === "") {
        console.log("error")
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let $json_response = JSON.parse(this.responseText);
                if ($json_response['success'])
                {
                    generateSweetAlertPopup($json_response['title'], $json_response['message'], 'success', 5000);
                    // generateSweetAlertPopup('Activité Restaurée!', '', 'success', 5000);
                    // Swal.fire("Activité Restaurée!", "", "success");
                    showActivitiesByAnim(document.getElementById('select-anim').value);
                }
                else {
                    generateSweetAlertPopup($json_response['title'], $json_response['message'], 'success', null);
                    // generateSweetAlertPopup('Erreur', 'La restauration à échouée!', 'error', null);
                    // Swal.fire({
                    //     icon: "error",
                    //     title: "Erreur",
                    //     text: "La restauration à échouée!",
                    // });
                }
            }
        };
        xmlhttp.open("GET", "../Controllers/restore_act_ajax.php?act_id=" + act_id + '&date_act=' + date_act, true);
        xmlhttp.send();

        // Swal.fire({
        //     icon: "success",
        //     title: "Youpi",
        //     text: "Nickel!",
        //     // footer: '<a href="#">Why do I have this issue?</a>'
        // });

    }
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