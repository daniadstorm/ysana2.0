/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


 $(document).ready(function () {

        $('#inicio_descuento_articulo').keyup(function () {
            if ($('#inicio_descuento_articulo').val() == '') {
                $('#fin_descuento_articulo').val('');
                $('#checkbox_porcentaje').prop('checked', false);
                $('#descuento_porcentaje_articulo').val('');
                $('#descuento_euros_articulo').val('');
                $(":submit").prop('disabled', false);
            }
        });

        $('#fin_descuento_articulo').change(function () {
            //console.log('captura');
            var ts_inicio = date_to_timestamp($('#inicio_descuento_articulo').val());
            var ts_fin = date_to_timestamp($('#fin_descuento_articulo').val());

            if (ts_fin < ts_inicio) {
                //console.log('captura2');
                alert('la fecha fin no puede ser menor a la fech inicio');
                $(":submit").prop('disabled', true);
            }

        });


        //Viene del POST o el GET___________________________________________________________   
        //si no está vacío y mide 10
        if ($('#inicio_descuento_articulo').val() != '' && $('#inicio_descuento_articulo').val().length === 10) {
            $('#fin_descuento_articulo').removeAttr('disabled');
            
           if ($('#checkbox_porcentaje').prop('checked')) {
                //console.log('hola');
                //$('#descuento_euros_articulo').val('');
                $("#descuento_porcentaje_articulo_wrapper").css('display', 'block');

            } else {
                //console.log('hola2');
                //$('#descuento_porcentaje_articulo').val('');
                $('#descuento_euros_articulo_wrapper').css('display', 'block');
            }

            $('#checkbox_porcentaje').prop('disabled', false).click(function () {
                //alert('hola2');
                $('#descuento_porcentaje_articulo').val('');
                $("#checkbox_porcentaje").attr('checked', true);
                $("#descuento_porcentaje_articulo_wrapper").css('display', 'block');
                $("#checkbox_euros").attr('checked', false);
                $("#descuento_euros_articulo_wrapper").css('display', 'none');

            });

            $('#checkbox_euros').prop('disabled', false).click(function () {
                //alert('hola');
                $('#descuento_euros_articulo').val('')
                $("#checkbox_euros").attr('checked', true);
                $("#descuento_euros_articulo_wrapper").css('display', 'block');
                $("#checkbox_porcentaje").attr('checked', false);
                $("#descuento_porcentaje_articulo_wrapper").css('display', 'none');

            });

            $('#descuento_porcentaje_articulo').keyup(function () {
                console.log('funciona');
                if ($('#descuento_porcentaje_articulo').val() > 100) {
                    alert('el valor del porcentaje no puede ser mayor a 100');
                    $(":submit").prop('disabled', true);
                } else {
                    $(":submit").prop('disabled', false);
                }
                if ($('#descuento_porcentaje_articulo').val() == '') {
                    alert('el campo del descuento no puede estar vacío');
                    $(":submit").prop('disabled', true);
                }
            });

            $('#descuento_euros_articulo').keyup(function () {
                console.log('funciona');
                if ($('#descuento_euros_articulo').val() > 999 || $('#descuento_euros_articulo').val() === '') {
                    alert('el valor del porcentaje no puede ser mayor a 999');
                    $(":submit").prop('disabled', true);
                } else {
                    $(":submit").prop('disabled', false);
                }
                if ($('#descuento_euros_articulo').val() == '') {
                    alert('el campo del descuento no puede estar vacío');
                    $(":submit").prop('disabled', true);
                }
            });




//ACABAR EL POST________________________________________________________________
//VIENE DEL ORIGEN______________________________________________________________
        } else {
            $('#inicio_descuento_articulo').change(function () {
                //si la fecha inicio no está vacia y es tamaño 10, habilita el campo fecha fin y bloquea el submit
                if ($('#inicio_descuento_articulo').val() != '') {
                    if ($('#inicio_descuento_articulo').val().length === 10) {
                        $(":submit").prop('disabled', true);
                        $('#fin_descuento_articulo').prop('disabled', false);
                        $('#fin_descuento_articulo').datepicker();
                    } else {
                        alert('formato incorrecto para la fecha de inicio');
                        $(":submit").prop('disabled', true);
                    }
                    // fecha inicio vacia, bloquea todo y deja libre el sumbit
                } else {
                    $(":submit").prop('disabled', false);
                    $('#fin_descuento_articulo').prop('disabled', true);
                    $('#checkbox_porcentaje').attr('checked', false);
                    $('#checkbox_euros').attr('checked', false);

                    $('#checkbox_porcentaje').prop('disabled', true);
                    $('#checkbox_euros').prop('disabled', true);
                    $("#descuento_euros_articulo_wrapper").css('display', 'none');
                    $("#descuento_porcentaje_articulo_wrapper").css('display', 'none');
                    $('#fin_descuento_articulo').val('');
                    $('#descuento_porcentaje_articulo').val('');
                    $('#descuento_euros_articulo').val('');

                    $("#checkbox_euros_wrapper").css('display', 'block');
                    $("#checkbox_porcentaje_wrapper").css('display', 'block');
                }

            });
            // si fecha fin no está bloqueado 
            //alert($('#fin_descuento_articulo').prop('disabled'));
            $('#fin_descuento_articulo').change(function () {
                if (!$('#fin_descuento_articulo').prop('disabled')) {
                    //y cumple con los requisitos
                    if ($('#fin_descuento_articulo').val().length === 10) {
                        if ($('#fin_descuento_articulo').val() > $('#inicio_descuento_articulo').val()) {


                            alert('guay!');
                            //desbloquea checkboxs
                            $('#checkbox_porcentaje').prop('disabled', false);
                            $('#checkbox_euros').prop('disabled', false);
                            //cuando se clique en checkbox_porcentaje

                            $('#checkbox_porcentaje').click(function () {

                                $("#descuento_porcentaje_articulo_wrapper").css('display', 'block');
                                $("#checkbox_euros").attr('checked', false);
                                $("#descuento_euros_articulo_wrapper").css('display', 'none');
                                $("#descuento_euros_articulo").val('');

                            });

                            $('#descuento_porcentaje_articulo').keyup(function () {
                                console.log('funciona');
                                if ($('#descuento_porcentaje_articulo').val() > 100) {
                                    //alert ($('#descuento_porcentaje_articulo').val());
                                    alert('el valor del porcentaje no puede ser mayor a 100');
                                    $(":submit").prop('disabled', true);
                                } else {
                                    $(":submit").prop('disabled', false);
                                }
                            });

                            $('#checkbox_euros').click(function () {

                                //$("#checkbox_porcentaje_wrapper").css('display', 'none');
                                $("#descuento_euros_articulo_wrapper").css('display', 'block');
                                $("#checkbox_porcentaje").attr('checked', false);
                                $("#descuento_porcentaje_articulo_wrapper").css('display', 'none');
                                $("#descuento_porcentaje_articulo").val('');
                            });

                            $('#descuento_euros_articulo').keyup(function () {
                                console.log('funciona');
                                if ($('#descuento_euros_articulo').val() > 999) {
                                    alert('el valor del porcentaje no puede ser mayor a 999');
                                    $(":submit").prop('disabled', true);
                                } else {
                                    $(":submit").prop('disabled', false);
                                }
                            });

                        } else {
                            //alert('la fecha fin no puede ser mayor a la fecha inicio');

                            $('#checkbox_porcentaje').attr("checked", false);
                            $('#checkbox_euros').attr("checked", false);
                            $('#checkbox_porcentaje').prop('disabled', true);
                            $('#checkbox_euros').prop('disabled', true);
                            $("#descuento_porcentaje_articulo_wrapper").css('display', 'none');
                            $("#descuento_euros_articulo_wrapper").css('display', 'none');
                            $('#checkbox_porcentaje').checked == false;
                            $('#checkbox_euros').checked == false;
                            $(":submit").prop('disabled', true);

                        }
                    } else {
                        alert('el formato es incorrecto');
                    }
                }
            });
        }
//ACABA EL ORIGEN_______________________________________________________________        
    });