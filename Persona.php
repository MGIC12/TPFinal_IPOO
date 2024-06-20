<?php

class Persona{
    private $nombre;
    private $apellido;
    private $documento;
    private $mensajeOperacion;

    //metodo constructor
    public function __construct(){
        $this->nombre="";
        $this->apellido="";
        $this->documento="";
    }

    public function cargar($nom, $apell, $doc){
        $this->setNombre($nom);
        $this->setApellido($apell);
        $this->setDocumento($doc);
    }

    //metodos de acceso

    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getDocumento(){
        return $this->documento;
    }
    public function getMensaje(){
        return $this->mensajeOperacion;
    }

    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    public function setApellido($apellido){
        $this->apellido=$apellido;
    }
    public function setDocumento($documento){
        $this->documento=$documento;
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
				if($persona=$base->registro()){					
				    $this->setDocumento($persona['documento']);
					$this->setNombre($persona['nombre']);
					$this->setApellido($persona['apellido']);
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


    //hacer funcion listar


    
    public function insertar(){
        $base=new BaseDatos();
        $resp=false;
        $consulta="INSERT INTO persona(nombre, apellido, documento)
                VALUES ('".$this->getNombre()."','".$this->getApellido().",'".$this->getDocumento()."')";
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



    public function __tostring(){
        return
        "Nombre: ".$this->getNombre()."\n".
        "Apellido: ".$this->getApellido()."\n".
        "Documento: ".$this->getDocumento()."\n";

    }
}