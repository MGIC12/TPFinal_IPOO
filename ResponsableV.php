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
                    $responsable->buscar($row2['rdocumento']);
                    array_push($arrayResponsable,$responsable);
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
    }



    public function insertar(){
        $base=new BaseDatos();
        $resp=false;
        if(parent::insertar()){
            $consulta="INSERT INTO responsable(rnumeroempleado, rnumerolicencia, rdocumento)
                VALUES ('".$this->getNumEmpleado()."','".$this->getNumLicencia()."','".$this->getDocumento()."')";
        
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