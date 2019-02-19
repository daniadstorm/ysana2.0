//javascript library for 'come-ink'

jQuery(function ($) {
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $.datepicker.setDefaults({firstDay: 1, dateFormat: "dd/mm/yy"});
});

function close_claimer_top() {
    $(".franja_top").css({'top': '0'});
    $(".section_top").css({'margin-top': '5em'});
    $(".claimer_top").hide();
}

function set_txt_input_file(i, value){
    var inicio = value.lastIndexOf('\\') + 1;
    var final = value.length;
    var aux_value = value.substr(inicio, final);
    $("#txt_input_file_"+i).html(aux_value);
}

function toggle_main_menu() {
    $("#responsive_main_menu").toggleClass('responsive_main_menu_hidden');
}

/*Si no devuelve ningun articulo, se desactiva el campo, de lo contrario, lo contrario..*/
$(document).ready(function () {
    $("#fecharecogida").addClass("disable_input");
});
$("#seleccionarArticulos").on("change", "input", function () {
    var desmarcado = false;
    $('#seleccionarArticulos input[type="checkbox"]').each(function () {
        if (!this.checked) {
            desmarcado = true;
        }
    });
    if (!desmarcado) {
        $("#fecharecogida").addClass("disable_input");

    } else {
        $("#fecharecogida").removeClass("disable_input");
    }
});

function vertical_menu_click(element, parent, ind) {

    var aux_has_class = $(element).hasClass('menu_vertical_active');

    if (parent == 0) {
        $(".menu_vertical_active").next().css("display", "none");
        $(".menu_vertical_active").removeClass("menu_vertical_active");
    } else {
        $('div[id^="vertical_menu_' + parent + '"]').next().css("display", "none");
        $('div[id^="vertical_menu_' + parent + '"]').removeClass("menu_vertical_active");
    }

    if (aux_has_class == true) {
        $(element).removeClass("menu_vertical_active");
        $(element).next().css("display", "none");
    } else {
        $(element).attr('class', "menu_vertical_active menu_vertical_accordion");
        $(element).next().css("display", "block");
    }
}

function option_slider_navigate(direction = "next") {
    var ultimo = parseInt($("#slider_last_option").val() - 1);
    var actual = parseInt($("#slider_this_option").val());
    var siguiente = 0;

    $(".option_slider_navigator a").prop("disabled", true);

    if (direction === 'next') {
        if ((actual + 1) <= ultimo) {
            siguiente = actual + 1;
        }
    } else {
        if ((actual - 1) >= 0) {
            siguiente = actual - 1;
        } else if ((actual - 1) <= 0) {
            siguiente = ultimo;
        }
    }

    $("#slider_option_" + actual).hide(); //actual
    $("#slider_option_" + siguiente).show(); //siguiente
    //$("#slider_option_" + siguiente).show("slow"); //siguiente
    //$("#slider_option_" + siguiente).show("slow", { direction: direction }, 100, enable_navigators); //siguiente
    //$("#slider_option_" + siguiente).show("slow", { direction: direction }, 500); //siguiente
    $("#slider_this_option").val(siguiente);
}
;

function enable_navigators() {
    $(".option_slider_navigator a").prop("disabled", false);
}

function apply_filters(actual_url) {
    document.location.replace(actual_url);
}

function aleatorio(inferior, superior) {
    numPosibilidades = superior - inferior
    aleat = Math.random() * numPosibilidades
    aleat = Math.round(aleat)
    return parseInt(inferior) + aleat
}
function date_to_timestamp(valor, separador = '/') {
    var fecha = valor;
    fecha = fecha.split(separador);
    var datafin = fecha[1] + separador + fecha[0] + separador + fecha[2];
    return new Date(datafin).getTime();
}

function accept_cookies_policy(root) {
    
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("selector_impresora_modelo_hint").innerHTML = this.responseText;
            $("#cookies_policy_wrapper").hide();
        }
    };
    //xmlhttp.open("GET","inc/accept_cookies_policy.inc.php");
    xmlhttp.open("GET",root+"accept-cookies-policy");
    xmlhttp.send();
}