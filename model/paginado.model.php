<?php

class paginadoModel {
    
    //
    public $total_regs = 0;
    public $regs_x_pag = 20;
    private $num_pags = 0;
    public $pag = 0;
    private $margen_pags = 5;
    
    /* function get_menu_paginacion($str_ruta) {
        //echo 'Total regs:'.$this->total_regs;
        $this->num_pags = ceil($this->total_regs / $this->regs_x_pag);
        
        $mpag = '';
        
        if ($this->num_pags > 0) { //mostrar paginado solo cuando sea necesario
            $mpag .= ' <a href="'.$str_ruta.'pag=0"><<</a> ';
            if ($this->pag > 0) { 
                $mpag .= ' <a href="'.$str_ruta.'pag='.($this->pag-1).'"><</a> ';
            } else $mpag .= '<span><</span>';
            for($i=0;$i<$this->num_pags;$i++) {
                if ($this->pag != $i) {
                    //i >= pag-$valor || i <= pag+$valor
                    if ($i >= ($this->pag - $this->margen_pags) && $i <= ($this->pag + $this->margen_pags)) {
                        $mpag .= ' <a href="'.$str_ruta.'pag='.$i.'">'.($i+1).'</a> ';
                    }
                } else {
                    $mpag .= ' <span class="menu_paginacion_selected">'.($i+1).'</span> ';
                }
            }
            if (($this->pag+1) < $this->num_pags) {
                $mpag .= '<a href="'.$str_ruta.'pag='.($this->pag+1).'">></a> ';
            } else $mpag .= '<span>></span>';
            $mpag .= ' <a href="'.$str_ruta.'pag='.($this->num_pags-1).'">>></a> ';
        }
        return $mpag;
    } */
    function get_menu_paginacion($str_ruta) {
        //echo 'Total regs:'.$this->total_regs;
        $this->num_pags = ceil($this->total_regs / $this->regs_x_pag);
        $mpag = '';
        if ($this->num_pags > 0) { //mostrar paginado solo cuando sea necesario
            //$mpag .= ' <a href="'.$str_ruta.'pag=0"><<</a> ';
            $mpag .= '<li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>';
            if ($this->pag > 0) { 
                //$mpag .= ' <a href="'.$str_ruta.'pag='.($this->pag-1).'"><</a> ';
                $mpag .= '<li class="page-item">
                            <a class="page-link" href="'.$str_ruta.'pag='.($this->pag-1).'">&laquo;</a>
                        </li>';
            } else $mpag .= '<li class="page-item">
                                <a class="page-link" href="#">&lsaquo;</a>
                            </li>';
            for($i=0;$i<$this->num_pags;$i++) {
                if ($this->pag != $i) {
                    //i >= pag-$valor || i <= pag+$valor
                    if ($i >= ($this->pag - $this->margen_pags) && $i <= ($this->pag + $this->margen_pags)) {
                        //$mpag .= ' <a href="'.$str_ruta.'pag='.$i.'">'.($i+1).'</a> ';
                        $mpag .= '<li class="page-item">
                                    <a class="page-link" href="'.$str_ruta.'pag='.$i.'">'.($i+1).'</a>
                                </li>';
                    }
                } else {
                    //$mpag .= ' <span class="menu_paginacion_selected">'.($i+1).'</span> ';
                    $mpag .= '<li class="page-item active">
                                <a class="page-link" href="#">'.($i+1).'</a>
                            </li>';
                }
            }
            if (($this->pag+1) < $this->num_pags) {
                //$mpag .= '<a href="'.$str_ruta.'pag='.($this->pag+1).'">></a> ';
                $mpag .= '<li class="page-item">
                            <a class="page-link" href="'.$str_ruta.'pag='.($this->pag+1).'" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>';
            } else $mpag .= '<li class="page-item">
                                <a class="page-link" href="#">&rsaquo;</a>
                            </li>';
            $mpag .= '<li class="page-item">
                        <a class="page-link" href="'.$str_ruta.'pag='.($this->num_pags-1).'" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>';
        }
        return $mpag;
    }
    
}
?>