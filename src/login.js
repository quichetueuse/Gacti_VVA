function view_password_v2(element_id) {
    var input_p = document.getElementById(element_id);
    if (input_p.type === "password") {
        input_p.type = "text";
    } else {
        input_p.type = "password";
    }
}
