<?php


class ResponsableV extends Persona{
    private $numEmpleado;
    private $numLicencia;
    private $mensajeOperacion;


    public function __construct(){
        parent::__construct();
        $this->numEmpleado="";
        $this->numLicencia="";
    }

    public function cargar($doc, $nom, $apell, $numEmple=null, $numLic=null){
        parent::cargar($doc, $nom, $apell);
        $this->setNumEmpleado($numEmple);
        $this->setNumLicencia($numLic);
    }

    //metodos de acceso

    public function getNumEmpleado(){
        return $this->numEmpleado;
    }
    public function getNumLicencia(){
        return $this->numLicencia;
    }
    public function getMensaje(){
        return $this->mensajeOperacion;
    }


    public function setNumEmpleado($numEmple){
        $this->numEmpleado=$numEmple;
    }
    public function setNumLicencia($numLic){
        $this->numLicencia=$numLic;
    }
    public function setMensaje($mensaje){
        $this->mensajeOperacion=$mensaje;
    }

}