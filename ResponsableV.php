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



    /**
     * Función que busca un empleado en la base de datos por número de empleado.
     * 
     * @param int $numEmple Número de empleado a buscar.
     * @return bool true si se encontró el empleado, false si no.
     */
    public function buscar($numEmple){
		$base=new BaseDatos();
		$consulta="SELECT * FROM responsable WHERE rnumeroempleado= '".$numEmple."'";
		$resp= false;
		if($base->iniciar()){
			if($base->ejecutar($consulta)){
				if($row2=$base->registro()){
                    parent::buscar($row2['rdocumento']);
					$this->setNumEmpleado($row2['rnumeroempleado']);
					$this->setNumLicencia($row2['rnumerolicencia']);
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
     * Función que lista los responsables en la base de datos según una condición dada.
     * 
     * @param string $condicion Condición opcional para filtrar la lista de responsables.
     * @return array|null Un array de objetos ResponsableV si se encontraron responsables, o null si no se encontró ninguno.
     */
    public function listar($condicion=""){
        $arrayResponsable=null;
        $base=new BaseDatos();
        $consulta="SELECT * FROM responsable ";
        if($condicion!=""){
            $consulta=$consulta." WHERE ".$condicion;
        }
        $consulta.=" ORDER BY rnumeroempleado ";
        if($base->iniciar()){
            if($base->ejecutar($consulta)){
                $arrayResponsable= array();
                while($row2=$base->registro()){
                    /*
                    $primaryKey=$row2['primaryKey'];
                    $atributo1=$row2['atributo1'];
                    $atributo2=$row2['atributo2'];
                    */
                    $responsable=new ResponsableV();
                    $responsable->buscar($row2['rnumeroempleado']);
                    array_push($arrayResponsable,$responsable);
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $arrayResponsable;
    }



    /**
     * Función que inserta un nuevo responsable en la base de datos.
     * 
     * @return bool true si la inserción fue exitosa, false si no.
     */
    public function insertar(){
        $base=new BaseDatos();
        $resp=false;
        if(parent::insertar()){
            $consulta="INSERT INTO responsable(rnumeroempleado, rnumerolicencia, rdocumento)
                VALUES ('".$this->getNumEmpleado()."','".$this->getNumLicencia()."','".$this->getDocumento()."')";
                /*numEmpleado(id) no deberia estar el en INSERT*/
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
     * Función que modifica el número de licencia de un responsable en la base de datos.
     * 
     * @return bool true si la modificación fue exitosa, false si no.
     */
    public function modificar(){
        $resp=false;
        $base=new BaseDatos();
        if(parent::modificar()){
            $consulta="UPDATE responsable SET rnumerolicencia='".$this->getNumLicencia()."' WHERE rnumeroempleado=".$this->getNumEmpleado();
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
     * Función que elimina un responsable de la base de datos.
     * 
     * @return bool true si la eliminación fue exitosa, false si no.
     */
    public function eliminar(){
        $base=new BaseDatos();
        $resp=false;
        if(parent::eliminar()){
            if($base->iniciar()){
                $consultaBorrar="DELETE FROM responsable WHERE rnumeroempleado=".$this->getNumEmpleado();
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

    public function __toString(){
        $cadena=parent::__toString();
        $cadena.=
        "Numero de empleado: ".$this->getNumEmpleado()."\n".
        "Numero de licencia: ".$this->getNumLicencia()."\n";
        return $cadena;
    }
}