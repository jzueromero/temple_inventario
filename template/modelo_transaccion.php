<?php

class tran_cabecera
{
    public $tcodigo ;
    public $ttipo ;
    public $testado ;
    public $tconcepto_codigo ;
    public $tconcepto_nombre ;
    public $tcliente_codigo ;
    public $tcliente_nombre ;
    public $tproveedor_codigo ;
    public $tproveedor_nombre ;
    public $tactualizar_costo ;
    public $treferencia ;
    public $tcantidad_articulos ;
    public $trecibido ;
    public $tcambio ;
    public $ttotal ;
    public $tusuario_inicia ;
    public $tusuario_final ;
    public $tfecha ;
    public $tfecha_final ; 

     function __construct()
    {
        $this->tcodigo = 0;
        $this->ttipo = -1;
        $this->testado = 0;
        $this->tconcepto_codigo = 0;
        $this->tconcepto_nombre = '';
        $this->tcliente_codigo = 0;
        $this->tcliente_nombre = '';
        $this->tproveedor_codigo = 0;
        $this->tproveedor_nombre = '';
        $this->tactualizar_costo = 0;
        $this->treferencia = '';
        $this->tcantidad_articulos = 0;
        $this->trecibido = 0.00;
        $this->tcambio = 0.00;
        $this->ttotal = 0.00;
        $this->tusuario_inicia = 0;
        $this->tusuario_final = 0;
        $this->tfecha = '';
        $this->tfecha_final = ''; 
    }
}

class tran_detalle
{
    public $dcodigo ;
    public $dnombre ;
    public $dcantidad ;
    public $dunidad ;
    public $dprecio ;
    public $dsubtotal ; 


    function __construct()
    {
        $this->dcodigo = 0;
        $this->dnombre = '';
        $this->dcantidad = 0;
        $this->dunidad = '';
        $this->dprecio = 0.00;
        $this->dsubtotal = 0.00; 

    }
}


?>