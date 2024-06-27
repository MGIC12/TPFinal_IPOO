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


    /**
     * Funcion para buscar un pasajero por DNI en la base de datos
     * 
     * @param string $dni El DNI del pasajero a buscar
     * @return bool Devuelve true si se encontró al pasajero, false si no
     */
    public function buscar($dni){
		$base=new BaseDatos();
		$consulta="SELECT * FROM pasajero WHERE pdocumento= '".$dni."'";
		$resp= false;
		if($base->iniciar()){
			if($base->ejecutar($consulta)){
				if($row2=$base->registro()){
                    parent::buscar($dni);
					$this->setTelefono($row2['ptelefono']);
					$this->setIdViaje($row2['idviaje']);
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
     * Funcion para listar pasajeros en la base de datos
     * 
     * @param string $condicion La condición opcional para filtrar los pasajeros
     * @return array|null Devuelve un array de objetos Pasajero o null si no hay pasajeros
     */
    public function listar($condicion=""){
        $arrayPasajero=null;
        $base=new BaseDatos();
        $consulta="SELECT * FROM pasajero ";
        if($condicion!=""){
            $consulta=$consulta." WHERE ".$condicion;
        }
        $consulta.=" ORDER BY pdocumento ";
        if($base->iniciar()){
            if($base->ejecutar($consulta)){
                $arrayPasajero= array();
                while($row2=$base->registro()){
                    /*
                    $telefono=$row2['ptelefono'];
                    $idViaje=$row2['idviaje'];
                    */
                    $pasajero=new Pasajero();
                    $pasajero->buscar($row2['pdocumento']);
                    array_push($arrayPasajero,$pasajero);
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $arrayPasajero;
    }



    /**
     * Funcion para insertar un pasajero en la base de datos
     * 
     * @return bool Devuelve true si se insertó correctamente, false si no
     */
    public function insertar(){
        $base=new BaseDatos();
        $resp=false;
        if(parent::insertar()){
            $consulta="INSERT INTO pasajero(pdocumento, ptelefono, idviaje)
                    VALUES ('".$this->getDocumento()."','".$this->getTelefono()."','".$this->getIdViaje()."')";
                    /*agregar Id al pasajero*/
            if($base->iniciar()){
                if($base->ejecutar($consulta)){
                    $resp=true;
                }else{
                    $this->setMensaje($base->getError());
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }
        return $resp;
    }



    /**
     * Funcion para modificar un pasajero en la base de datos
     * 
     * @return bool Devuelve true si se modificó correctamente, false si no
     */
    public function modificar(){
        $resp=false;
        $base=new BaseDatos();
        if(parent::modificar()){
            $consulta="UPDATE pasajero SET ptelefono='".$this->getTelefono()."',idviaje='".$this->getIdViaje()."' WHERE pdocumento=".$this->getDocumento();
        
            if($base->iniciar()){
                if($base->ejecutar($consulta)){
                    $resp=true;
                }else{
                    $this->setMensaje($base->getError());
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }
        return $resp;
    }



    /**
     * Funcion para eliminar un pasajero de la base de datos
     * 
     * @return bool Devuelve true si se eliminó correctamente, false si no
     */
    public function eliminar(){
        $base=new BaseDatos();
        $resp=false;
        if(parent::eliminar()){
            if($base->iniciar()){
                $consultaBorrar="DELETE FROM pasajero WHERE pdocumento=".$this->getDocumento();
                if($base->ejecutar($consultaBorrar)){
                    $resp=true;
                }else{
                    $this->setMensaje($base->getError());
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }
        
        return $resp;
    }

    /*metodo tostring no deberia existir debido al metodo listar*/
    public function __toString(){
        $cadena=parent::__toString();
        $cadena .=
        "Telefono: ".$this->getTelefono()."\n".
        "Id del viaje: ".$this->getIdViaje()."\n";
        return $cadena;

    }
}