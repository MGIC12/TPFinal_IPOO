<?php


class Pasajero extends Persona{
    private $telefono;
    private $idViaje;
    private $mensajeOperacion;

    public function __construct(){
        parent::__construct();
        $this->telefono="";
        $this->idViaje="";
    }

    public function cargar($doc, $nom, $apell, $tel=null, $idViaj=null){
        parent::cargar($doc, $nom, $apell);
        $this->setTelefono($tel);
        $this->setIdViaje($idViaj);
    }

    //metodos de acceso

    public function getTelefono(){
        return $this->telefono;
    }
    public function getIdViaje(){
        return $this->idViaje;
    }
    public function getMensaje(){
        return $this->mensajeOperacion;
    }


    public function setTelefono($tel){
        $this->telefono=$tel;
    }
    public function setIdViaje($idViaj){
        $this->idViaje=$idViaj;
    }
    public function setMensaje($mensaje){
        $this->mensajeOperacion=$mensaje;
    }
}