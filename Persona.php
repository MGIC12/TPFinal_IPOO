<?php

class Persona{
    private $documento;
    private $nombre;
    private $apellido;
    private $mensajeOperacion;

    //metodo constructor
    public function __construct(){
        $this->documento="";
        $this->nombre="";
        $this->apellido="";
    }

    public function cargar($doc, $nom, $apell){
        $this->setDocumento($doc);
        $this->setNombre($nom);
        $this->setApellido($apell);
    }

    //metodos de acceso

    
    public function getDocumento(){
        return $this->documento;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getMensaje(){
        return $this->mensajeOperacion;
    }

    
    public function setDocumento($documento){
        $this->documento=$documento;
    }
    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    public function setApellido($apellido){
        $this->apellido=$apellido;
    }
    public function setMensaje($mensaje){
        $this->mensajeOperacion=$mensaje;
    }


    

    /**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function buscar($dni){
		$base=new BaseDatos();
		$consulta="SELECT * FROM persona WHERE documento= '".$dni."'";
		$resp= false;
		if($base->iniciar()){
			if($base->ejecutar($consulta)){
				if($row2=$base->registro()){					
				    $this->setDocumento($dni);
					$this->setNombre($row2['nombre']);
					$this->setApellido($row2['apellido']);
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
        $arrayPersona=null;
        $base=new BaseDatos();
        $consulta="SELECT * FROM persona ";
        if($condicion!=""){
            $consulta=$consulta." WHERE ".$condicion;
        }
        $consulta.=" ORDER BY apellido ";
        if($base->iniciar()){
            if($base->ejecutar($consulta)){
                $arrayPersona= array();
                while($row2=$base->registro()){
                    $documento=$row2['documento'];
                    $nombre=$row2['nombre'];
                    $apellido=$row2['apellido'];

                    $persona=new Persona();
                    $persona->cargar($documento, $nombre, $apellido);
                    array_push($arrayPersona,$persona);
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $arrayPersona;
    }


    
    public function insertar(){
        $base=new BaseDatos();
        $resp=false;
        $consulta="INSERT INTO persona(documento, nombre, apellido)
                VALUES ('".$this->getDocumento()."','".$this->getNombre()."','".$this->getApellido()."')";
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
        $consulta="UPDATE persona SET nombre='".$this->getNombre()."',apellido='".$this->getApellido()."' WHERE documento=".$this->getDocumento();
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
            $consultaBorrar="DELETE FROM persona WHERE documento=".$this->getDocumento();
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
        "Documento: ".$this->getDocumento()."\n".
        "Nombre: ".$this->getNombre()."\n".
        "Apellido: ".$this->getApellido()."\n";

    }
}