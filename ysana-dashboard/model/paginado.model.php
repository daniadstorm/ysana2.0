<?php

class paginadoModel {
    
    public $total_regs = 0;
    public $regs_x_pag = 20;
    public $num_pags = 0;
    public $pag = 0;
    private $margen_pags = 5;
    
    function get_menu_paginacion($str_ruta) {
        
        $this->num_pags = ceil($this->total_regs / $this->regs_x_pag);
        
        $mpag = '';
        
        if ($this->num_pags > 0) { //mostrar paginado solo cuando sea necesario
            $mpag .= ' <a href="'.$str_ruta.'&pag=0"><<</a> ';
            if ($this->pag > 0) { 
                $mpag .= ' <a href="'.$str_ruta.'&pag='.($this->pag-1).'"><</a> ';
            } else $mpag .= '<span><</span>';
            for($i=0;$i<$this->num_pags;$i++) {
                if ($this->pag != $i) {
                    //i >= pag-$valor || i <= pag+$valor
                    if ($i >= ($this->pag - $this->margen_pags) && $i <= ($this->pag + $this->margen_pags)) {
                        $mpag .= ' <a href="'.$str_ruta.'&pag='.$i.'">'.($i+1).'</a> ';
                    }
                } else {
                    $mpag .= ' <span class="menu_paginacion_selected">'.($i+1).'</span> ';
                }
            }
            if (($this->pag+1) < $this->num_pags) {
                $mpag .= '<a href="'.$str_ruta.'&pag='.($this->pag+1).'">></a> ';
            } else $mpag .= '<span>></span>';
            $mpag .= ' <a href="'.$str_ruta.'&pag='.($this->num_pags-1).'">>></a> ';
        }
        
        return $mpag;
    }
    
}
?>