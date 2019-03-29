<div id="farmaciacercana" class="w-100">
    <div id="franjafarmacia" class="max-ysana">
        <h2>Encuentra la farmacia más cercana</h2>
        <button type="button" class="btn btn-bg-color-2 b-white ml-3" data-toggle="modal" data-target="#modalFarmacia">Encontrar</button>
    </div>
</div>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="modalFarmacia" tabindex="-1" role="dialog" aria-labelledby="modalFarmaciaTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                    <?php echo $iM->get_input_text('frm_buscar', '', 'form-control', '', $lng['experiencia-carrito'][18], '', false, false, false, 'form-group mb-0 w-100'); ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <div class="d-flex">
                        <?php echo $iM->get_input_text('frm_buscar', '', 'form-control', '', $lng['experiencia-carrito'][18]); ?>
                    </div> -->
                    <ul id="listafarmacias" class="list-group"></ul>
                    <iframe id="mapagoogle" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2993.646854966821!2d2.0426110154256225!3d41.38175667926477!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a49bb51f35af05%3A0x2ea746b2bdcac9ce!2sFarmacia!5e0!3m2!1ses!2ses!4v1552415539622" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
            </div>
        </div>
    </div>
    <!-- Modal -->

<script>
    function buscarFarmacia(){
        consulta = $("#frm_buscar").val();
            $.ajax({
                //url: "http://192.168.1.2/ysana/buscar-farmacia.php",
                url: "https://adstorm.es/ysana/buscar-farmacia.php",
                method: "POST",
                data: { valorBusqueda: consulta },
                dataType: "json",
                beforeSend: function(){
                    $("#listafarmacias").html('<div class="w-100 d-flex justify-content-center"><label>Cargando...</label></div>');
                }
            })
            .done(function(data, textStatus, jqXHR){
                strData = '';
                data.forEach(function(element){
                    strData += '<li class="list-group-item item-farmacia" url-mapa="'+element.link_embed_farmacia+'"><div class="d-flex align-items-center"><label class="mb-0">'+element.nombrecompleto_farmacia+'</label><a class="img-g-maps ml-auto" href="'+element.link_gmaps_farmacia+'"><img src="https://img.icons8.com/color/32/000000/google-maps.png"></a></div></li>';
                });
                $("#listafarmacias").html(strData);
                $(".item-farmacia").on('click', function(e){
                    $(".item-farmacia").removeClass('active');
                    $(this).addClass('active');
                    $("#mapagoogle").attr("src",$(this).attr('url-mapa'));
                });
            })
            .fail(function(){
                $("#listafarmacias").html('<div class="w-100 d-flex justify-content-center"><label>Error al cargar las farmacias</label></div>');
            });
    }
    buscarFarmacia();
    consulta = '';
    $(document).ready(function(){
        $("#frm_buscar").keyup(function(e){
            buscarFarmacia();
        });
    });
    
</script>