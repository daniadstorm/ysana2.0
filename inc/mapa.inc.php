<div id="mapaFarmacia" class="container-fluid mt-3">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-5 col-lg-3">
            <div class="farmacias mt-2 h-100 d-flex flex-column align-items-center justify-content-center">
                <form action="">
                    <?php echo $iM->get_input_text('frm_buscar', $frm_buscar, $class='form-control border-frm-contact', $lbl='', $placeholder='Introduce tu CP'); ?>
                </form>
                <div class="lista">
                    <div id="listafarmacia">

                    </div>
                    <!-- <?php
                            foreach($lista_farmacias as $value=>$key){
                                echo '<div class="farmacia d-flex">
                                <div class="numero">
                                    <h3>'.($value+1).'</h3>
                                </div>
                                <div class="texto">
                                    <p class="mb-0">'.$key['nombre'].'</p>
                                    <p class="mb-0">'.$key['calle'].'</p>
                                </div>
                            </div>';
                            }
                            ?> -->
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-7 col-lg-9 px-0">
            <div class="mapa w-100">
                <div class="google-maps-b">
                    <iframe id="mapagoogle" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3190.483052807071!2d-4.116296!3d36.9027133!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6237b22e1ad04b%3A0xe2df25345e536b7!2sFarmacia+Berna+Quiles!5e0!3m2!1ses!2ses!4v1523614113372"
                        width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    consulta = '';
    $(document).ready(function(){
        $("#frm_buscar").keyup(function(e){
            consulta = $("#frm_buscar").val();
            $.ajax({
                url: "http://192.168.1.2/ysana/buscar-farmacia.php",
                method: "POST",
                data: { valorBusqueda: consulta },
                dataType: "json",
                beforeSend: function(){
                    $("#listafarmacia").html('<div class="sublistafarmacia"><img style="width:64px;" src="https://www.voya.ie/Interface/Icons/LoadingBasketContents.gif"></div>');
                }
            })
            .done(function(data, textStatus, jqXHR){
                strData = '';
                data.forEach(function(element){
                    console.log(element);
                    strData += '<p>'+element.nombrecompleto_farmacia+'</p>';
                });
                $("#listafarmacia").html(strData);
            })
            .fail(function(){

            });
        });
    });
</script>