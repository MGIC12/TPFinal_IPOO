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


    public function buscar($idEmpresa){
		$base=new BaseDatos();
		$consulta="SELECT * FROM empresa WHERE idempresa= '".$idEmpresa."'";
		$resp= false;
		if($base->iniciar()){
			if($base->ejecutar($consulta)){
				if($row2=$base->registro()){					
				    $this->setIdEmpresa($idEmpresa);
					$this->setNombre($row2['enombre']);
					$this->setDireccion($row2['edireccion']);
					$resp= true;
				}				
		 	}	else {
		 			$this->setMensaje($base->getError());
			}
		 }	else {
		 		$this->setMensaje($base->getError());
		 }		
		 return $resp;
	}


    public function listar($condicion=""){
        $arrayEmpresa=null;
        $base=new BaseDatos();
        $consulta="SELECT * FROM empresa ";
        if($condicion!=""){
            $consulta=$consulta." WHERE ".$condicion;
        }
        $consulta.=" ORDER BY idEmpresa ";
        if($base->iniciar()){
            if($base->ejecutar($consulta)){
                $arrayEmpresa= array();
                while($row2=$base->registro()){
                    $idEmpresa=$row2['idempresa'];
                    $nombre=$row2['enombre'];
                    $direccion=$row2['edireccion'];

                    $empresa=new Empresa();
                    $empresa->cargar($idEmpresa, $nombre, $direccion);
                    array_push($arrayEmpresa,$empresa);
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $arrayEmpresa;
    }



    public function insertar(){
        $base=new BaseDatos();
        $resp=false;
        $consulta="INSERT INTO empresa(idempresa, enombre, edireccion)
                VALUES ('".$this->getIdEmpresa()."','".$this->getNombre()."','".$this->getDireccion()."')";
        if($base->iniciar()){
            if($base->ejecutar($consulta)){
                $resp=true;
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $resp;
    }



    public function modificar(){
        $resp=false;
        $base=new BaseDatos();
        $consulta="UPDATE empresa SET enombre='".$this->getNombre()."',edireccion='".$this->getDireccion()."' WHERE idempresa=".$this->getIdEmpresa();
        if($base->iniciar()){
            if($base->ejecutar($consulta)){
                $resp=true;
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $resp;
    }



    public function eliminar(){
        $base=new BaseDatos();
        $resp=false;
        if($base->iniciar()){
            $consultaBorrar="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa();
            if($base->ejecutar($consultaBorrar)){
                $resp=true;
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $resp;
    }



    public function __toString(){
        return
        "ID Empresa: ".$this->getIdEmpresa()."\n".
        "Nombre: ".$this->getNombre()."\n".
        "Direccion: ".$this->getDireccion()."\n";
    }
}