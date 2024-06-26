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


    /**
    * Función que lista las personas según una condición opcional.
    * 
    * @param string $condicion Condición opcional para filtrar las personas.
    * @return array|null Arreglo de objetos de la clase Persona que cumplen con la condición o null si hay un error.
    */
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


    
    /**
    * Función que inserta una nueva persona en la base de datos.
    * 
    * @return bool Devuelve true si la inserción fue exitosa, false en caso contrario.
    */
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


    /**
    * Función que modifica los datos de una persona en la base de datos.
    * 
    * @return bool Devuelve true si la modificación fue exitosa, false en caso contrario.
    */
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


    /**
     * Función que elimina una persona de la base de datos.
     * 
     * @return bool Devuelve true si la eliminación fue exitosa, false en caso contrario.
     */
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


    //el __toString si es util ya que es llamado a la hora de imprimir los datos de las instancias de la clase en el testViaje
    public function __toString(){
        return
        "Documento: ".$this->getDocumento()."\n".
        "Nombre: ".$this->getNombre()."\n".
        "Apellido: ".$this->getApellido()."\n";

    }
}