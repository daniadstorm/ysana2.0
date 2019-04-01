<?php
include_once('lib/fpdf181/fpdf.php');

class fpdfModel extends FPDF {
    
    private $url_img = '';
    
    private $pw = 0; //ancho de pag = 210
    private $ch = 6; //cell height
    private $fs = 10; //font size
    private $ft = 'Arial';  //font type
    
    function set_url_img($url_img) {
        $this->url_img = $url_img;
    }
    
    function generar_factura_pdf($ruta_inicio, $num_factura, $d) {
        $cM = load_model('carrito');
        //$dM = load_model('direcciones');
        //$pM = load_model('pedidos');

        $aM = load_model('articulos');
        $cM = load_model('carrito');
        
        define('EURO',chr(128));
        $mla = 72; //max length allowed
        
        $zona = -1;
        $base_imponible = 0;
        $total_iva = 0;
        $envio = 0;
        $aux_precio = 0;
        $total_absoluto = 0;
        
        //$d['fecha'] = 'fecha';
        //$d['fullname'] = 'fullname';
        //$d['nombre_direccion'] = 'nombre direccion';
        $d['dni'] = '';
        $d['direccion'] = 'direccion';
        //$d['telf'] = 'telf';
        $d['poblacion'] = 'poblacion';
        //$d['codigo_postal'] = '';
        //$d['email'] = 'email';
        $d['provincia'] = 'barcelona';
        
        $this->AddPage();
        $this->pw = $this->GetPageWidth();
        //$this->SetFont('Arial','B',16);
        
        //DIRECCION ENVIO_______________________________________________________
        /*
        $rgds = $dM->get_direccion_selected($d['iduser']);
        if ($rgds) {
            if ($rgds->num_rows > 0) {
                while ($fgds = $rgds->fetch_assoc()) {
                    $d['nombre_direccion'] = utf8_decode($fgds['nombre_direccion']);
                    $d['direccion'] = utf8_decode($fgds['direccion']);
                    $d['poblacion'] = utf8_decode($fgds['poblacion']);
                    $d['codigo_postal'] = utf8_decode($fgds['codigo_postal']);
                    $d['provincia'] = utf8_decode($fgds['provincia']);
                    $d['zona'] = $dM->get_zona_by_id($fgds['zona']);
                }
            } //else adstormlog($num_factura.'    NINGUNA DIRECCION SELECCIONADA ');    
        } //else adstormlog($num_factura.'    ERROR CARGANDO DIRECCIONES ');    
        */
        //DIRECCION ENVIO_______________________________________________________
        
        //LISTADO ARTICULOS_____________________________________________________
        //detalle pedido
        /*
        $rgpbf = $pM->get_pedido_by_factura($num_factura);
        if ($rgpbf) {
            
            $aux_i = 0;
            $total_articulos = $rgpbf->num_rows;
            
            $da = array();
            
            while ($fgpbf = $rgpbf->fetch_assoc()) {
                //$total_precio_productos = $fgpbf['subtotal'];
                $envio = $fgpbf['envio'];
                $total_absoluto = $fgpbf['total'];
                $fecha = mysql_to_date($fgpbf['fecha'],'/');
                
                $base_imponible = $base_imponible + (($fgpbf['precio'] + $fgpbf['canon']) * $fgpbf['cantidad']);
                $total_iva = $base_imponible * IVA_GENERAL;
                
                //$aux_precio = $fgpbf['precio'] + $fgpbf['canon'];
                //$aux_precio = $aux_precio + $aux_precio * IVA_GENERAL;
                //$aux_lbl_canon = $fgpbf['canon'] > 0 ? '<div class="ficha_producto_mini_canon">(canon incluido)</div>' : '<div style="height:12px;">&nbsp;</div>';
                
                //$aux_nombre = str_replace('/',' / ',$fgpbf['nombre']);
                $aux_nombre = utf8_decode(html_entity_decode($fgpbf['nombre']));
                
                if (strlen($aux_nombre) > $mla) {
                    $aux_nombre = substr($aux_nombre, 0, $mla).'...';
                }
                
                $da[$fgpbf['id_articulo']]['descripcion'] = $aux_nombre;
                $da[$fgpbf['id_articulo']]['uds'] = $fgpbf['cantidad'];
                $da[$fgpbf['id_articulo']]['pud'] = $cM->get_formatted_price($fgpbf['precio']);
                $da[$fgpbf['id_articulo']]['total_base'] = $cM->get_formatted_price($fgpbf['cantidad'] * $fgpbf['precio']);
                $da[$fgpbf['id_articulo']]['total'] = $cM->get_formatted_price($fgpbf['cantidad'] * $fgpbf['precio'] + $fgpbf['cantidad'] * $fgpbf['precio'] * IVA_GENERAL);
                
            }
            
        } else {
            //error cargando archivos
        }
        */
        //header________________________________________________________________
        $this->Image($this->url_img.'ysana-logo-home.png',10,10,$this->ch*8);
        //http://192.168.1.14/ysana/img/ysana-logo-home.png
        
        $this->SetFont($this->ft,'B',$this->fs);
        
        $this->SetX(120);
        $this->Cell(80,$this->ch,'FACTURA',1,0,'C');
        $this->Ln($this->ch+2);
        
        $this->SetX(120);
        $this->SetFont($this->ft,'',$this->fs);
        $this->Cell(20,$this->ch,'Fecha',0,0);
        $this->SetFont($this->ft,'B',$this->fs);
        $this->Cell(60,$this->ch,$d['fecha'],0,0,'R');
        $this->Ln($this->ch);
        
        $this->SetX(120);
        $this->SetFont($this->ft,'',$this->fs);
        $this->Cell(20,$this->ch,utf8_decode('Número'),0,0);
        $this->SetFont($this->ft,'B',$this->fs);
        $this->Cell(60,$this->ch,$num_factura,0,0,'R');
        $this->Ln($this->ch + $this->ch / 2);
        //header________________________________________________________________
        
        //datos-emisor__________________________________________________________
        $this->SetFont($this->ft,'B',$this->fs);
        $this->Cell($this->pw-20,$this->ch,'PHARMALINK SL','LTRB');
        $this->Ln($this->ch);
        
        $this->SetFont($this->ft,'B',$this->fs);
        $this->Cell($this->pw-20,$this->ch,'B62152335','LR');
        $this->Ln($this->ch-2);
        
        $this->SetFont($this->ft,'',$this->fs-1);
        
        $this->Cell($this->pw-20,$this->ch-1,utf8_decode('AV. UNIVERSITAT AUTÒNOMA, 13-PARC TECNOLÒGIC 08290'),'LR');
        $this->Ln($this->ch-2);
        
        $this->Cell($this->pw-20,$this->ch-2,utf8_decode('CERDANYOLA DEL VALLÈS'),'LR');
        $this->Ln($this->ch-2);
        
        $this->Cell($this->pw-20,$this->ch-2,'Barcelona','LR');
        $this->Ln($this->ch-2);
        
        //$this->Cell($this->pw-20,$this->ch-2,'Tlf. 664 68 17 47','LR');
        //$this->Ln($this->ch-2);
        
        $this->Cell($this->pw-20,$this->ch-2,'info@ysana.es','LR');
        $this->Ln(1);
        
        $this->Cell($this->pw-20,$this->ch-2,'','LRB');
        $this->Ln($this->ch);
        //datos-emisor__________________________________________________________
        
        //datos-receptor________________________________________________________
        $this->SetFont($this->ft,'',$this->fs-2);
        $this->Cell($this->pw/2-10,$this->ch,'Datos cliente');
        $this->Cell($this->pw/2-10,$this->ch,utf8_decode('Dirección de envío y facturación'));
        $this->Ln($this->ch);
        
        $this->SetFont($this->ft,'B',$this->fs);
        $this->Cell($this->pw/2-10,$this->ch,$d['fullname'],'LT');
        $this->Cell($this->pw/2-10,$this->ch,$d['nombre_direccion'],'RT');
        $this->Ln($this->ch-2);
        
        $this->SetFont($this->ft,'',$this->fs-1);
        $this->Cell($this->pw/2-10,$this->ch,$d['dni'],'L');
        $this->Cell($this->pw/2-10,$this->ch,$d['direccion'],'R');
        $this->Ln($this->ch-2);
        
        $this->SetFont($this->ft,'',$this->fs-1);
        $this->Cell($this->pw/2-10,$this->ch,$d['telf'],'L');
        $this->Cell($this->pw/2-10,$this->ch,$d['poblacion'].' ('.$d['codigo_postal'].')','R');
        $this->Ln($this->ch-2);
        
        $this->SetFont($this->ft,'',$this->fs-1);
        $this->Cell($this->pw/2-10,$this->ch,$d['email'],'LB');
        //$this->Cell($this->pw/2-10,$this->ch,$d['provincia'],'RB');
        $this->Cell($this->pw/2-10,$this->ch,'','RB');
        $this->Ln($this->ch-2);
        //datos-receptor________________________________________________________
        
        //listado-articulos_____________________________________________________
        //listado-header--------------------------------------------------------
        $this->SetFont($this->ft,'B',$this->fs-2);
        $this->SetFillColor(0,0,0);
        $this->SetTextColor(255,255,255);
        
        $this->Ln($this->ch);
        
        $this->Cell(($this->pw/3)*2-10,$this->ch,utf8_decode('Descripción'),'L',0,'L',true);
        $this->Cell($this->pw/12-10,$this->ch,'Uds.',0,0,'R',true);
        $this->Cell($this->pw/12,$this->ch,'P.Ud.',0,0,'R',true);
        $this->Cell($this->pw/12,$this->ch,'Total Base',0,0,'R',true);
        $this->Cell($this->pw/12,$this->ch,'Total',0,0,'R',true);
        
        $this->Ln($this->ch);
        //listado-header--------------------------------------------------------
        //listado-body----------------------------------------------------------
        $this->SetTextColor(0,0,0);
        //for each producto...
        /*
        foreach ($da as $k => $v) {
            $this->SetFont($this->ft,'B',$this->fs-2);
            $this->Cell(($this->pw/3)*2-10,$this->ch,$v['descripcion'],'L');
            
            $this->SetFont($this->ft,'',$this->fs-2);
            $this->Cell($this->pw/12-10,$this->ch,$v['uds'],0,0,'R');
            $this->Cell($this->pw/12,$this->ch,$v['pud'],0,0,'R');
            $this->Cell($this->pw/12,$this->ch,$v['total_base'].' '.EURO,0,0,'R');
            
            $this->SetFont($this->ft,'B',$this->fs-2);
            $this->Cell($this->pw/12,$this->ch,$v['total'].' '.EURO,'R',0,'R');
            
            $this->Ln($this->ch);
        } 
        */
        $this->Cell($this->pw-20,$this->ch-2,'','LRB');
        $this->Ln($this->ch);
        //listado-body----------------------------------------------------------
        //listado-articulos_____________________________________________________
        
        //footer________________________________________________________________
        $this->SetY(-44.1);
        
        $this->SetFont($this->ft,'',$this->fs-2);
        $this->Cell($this->pw/2-10,$this->ch,'Desglose Bases Imponibles');
        
        $this->SetFont($this->ft,'B',$this->fs);
        
        $this->Cell($this->pw/2-10,$this->ch,utf8_decode('Total Factura'));
        $this->Ln($this->ch);
        
        $this->SetFont($this->ft,'B',$this->fs-2);
        $this->Cell(($this->pw/2)/3,$this->ch,'Base','LT',0,'R');
        $this->Cell(($this->pw/2)/3-10,$this->ch,'Tipo IVA','T',0,'R');
        $this->Cell(($this->pw/2)/3,$this->ch,'Cuota','TR',0,'R');
        
        $this->SetFont($this->ft,'',$this->fs-2);
        
        $this->Cell(($this->pw/2)/2-10,$this->ch,'Base imponible','T');
        $this->Cell(($this->pw/2)/2,$this->ch,$cM->get_formatted_price($base_imponible).' '.EURO,'RT',0,'R');
        
        $this->Ln($this->ch-2);
        
        $this->Cell(($this->pw/2)/3,$this->ch,$cM->get_formatted_price($base_imponible).' '.EURO,'L',0,'R');
        $this->Cell(($this->pw/2)/3-10,$this->ch,'21%',0,0,'R');
        $this->Cell(($this->pw/2)/3,$this->ch,$cM->get_formatted_price($total_iva).' '.EURO,'R',0,'R');
        
        $this->Cell(($this->pw/2)/2-10,$this->ch,'Total IVA');
        $this->Cell(($this->pw/2)/2,$this->ch,$cM->get_formatted_price($total_iva).' '.EURO,'R',0,'R');
        
        $this->Ln($this->ch-2);
        
        $this->Cell($this->pw/2-10,$this->ch,'','LR');
        
        //$base_imponible
        
        $this->Cell(($this->pw/2)/2-10,$this->ch,utf8_decode('Envío'));
        $this->Cell(($this->pw/2)/2,$this->ch,$cM->get_formatted_price($envio).' '.EURO,'R',0,'R');
        
        $this->Ln($this->ch-2);
        
        $this->Cell($this->pw/2-10,$this->ch,'','LBR');
        
        $this->SetFont($this->ft,'B',$this->fs);
        
        $this->Cell(($this->pw/2)/2-10,$this->ch,'Total Factura', 'B');
        $this->Cell(($this->pw/2)/2,$this->ch,$cM->get_formatted_price($total_absoluto).' '.EURO,'RB',0,'R');
        //footer________________________________________________________________
        
        $this->Output();
        
        return true;
    }
    
}
?>