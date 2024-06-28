<?php


class ResponsableV extends Persona{
    private $idResponsable;
    private $numLicencia;
    private $mensajeOperacion;


    public function __construct(){
        parent::__construct();
        $this->idResponsable="";
        $this->numLicencia="";
    }

    public function cargar($doc, $nom, $apell, $idResp=null, $numLic=null){
        parent::cargar($doc, $nom, $apell);
        $this->setIdResponsable($idResp);
        $this->setNumLicencia($numLic);
    }

    //metodos de acceso

    public function getIdResponsable(){
        return $this->idResponsable;
    }
    public function getNumLicencia(){
        return $this->numLicencia;
    }
    public function getMensaje(){
        return $this->mensajeOperacion;
    }


    public function setIdResponsable($idResp){
        $this->idResponsable=$idResp;
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
     * @param int $idResp Id de responsable a buscar.
     * @return bool true si se encontró el empleado, false si no.
     */
    public function buscar($idResp){
		$base=new BaseDatos();
		$consulta="SELECT * FROM responsable WHERE idResponsable= '".$idResp."'";
		$resp= false;
		if($base->iniciar()){
			if($base->ejecutar($consulta)){
				if($row2=$base->registro()){
                    parent::buscar($row2['rdocumento']);
					$this->setIdResponsable($row2['idResponsable']);
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
        $consulta.=" ORDER BY idResponsable ";
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
                    $responsable->buscar($row2['idResponsable']);
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
            $consulta="INSERT INTO responsable(rnumerolicencia, rdocumento)
                VALUES ('".$this->getNumLicencia()."','".$this->getDocumento()."')";
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
                $consulta="UPDATE responsable SET rnumerolicencia='".$this->getNumLicencia()."' WHERE idResponsable=".$this->getIdResponsable();
                if($base->iniciar()){
                    if($base->ejecutar($consulta)){
                        $resp=true;
                    }else{
                        $this->setMensaje($base->getError());
                    }
                }else{
                    $this->setMensaje($base->getError());
                }
            }else{
                $this->setMensaje($base->getError());
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
        if($this->buscar($this->getIdResponsable())){
            if(parent::eliminar()){
                if($base->iniciar()){
                    $consultaBorrar="DELETE FROM responsable WHERE idResponsable=".$this->getIdResponsable();
                    if($base->ejecutar($consultaBorrar)){
                        $resp=true;
                    }else{
                        $this->setMensaje($base->getError());
                    }
                }else{
                    $this->setMensaje($base->getError());
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        
        
        return $resp;
    }

    public function __toString(){
        $cadena=parent::__toString();
        $cadena.=
        "ID de responsable: ".$this->getIdResponsable()."\n".
        "Numero de licencia: ".$this->getNumLicencia()."\n";
        return $cadena;
    }
}