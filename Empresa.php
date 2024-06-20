<?php

class Empresa{
    private $idEmpresa;
    private $nombre;
    private $direccion;
    private $mensajeOperacion;

    public function __construct(){
        $this->idEmpresa="";
        $this->nombre="";
        $this->direccion="";
    }

    public function cargar($id, $nom, $direc){
        $this->setIdEmpresa($id);
        $this->setNombre($nom);
        $this->setDireccion($direc);
    }

    //metodos de acceso

    public function getIdEmpresa(){
        return $this->idEmpresa;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getMensaje(){
        return $this->mensajeOperacion;
    }


    public function setIdEmpresa($id){
        $this->idEmpresa=$id;
    }
    public function setNombre($nom){
        $this->nombre=$nom;
    }
    public function setDireccion($direc){
        $this->direccion=$direc;
    }
    public function setMensaje($mensaje){
        $this->mensajeOperacion=$mensaje;
    }
}