<?php


class Viaje{


    private $codigo;
    private $destino;
    private $cantMaxPasajeros;
    private $colObjPasajero;
    private $objResponsableV;
    private $costo;
    private $sumaCostosAbonados;
    private $objEmpresa;
    private $mensajeOperacion;

    public function __construct(){
        $this->codigo="";
        $this->destino="";
        $this->cantMaxPasajeros="";
        $this->colObjPasajero=[];
        $this->objResponsableV=null;
        $this->costo="";
        $this->sumaCostosAbonados=0;
        $this->objEmpresa="";
    }


    public function cargar($cod, $dest, $maxPas, $colObjPasaj, $objResp, $costo, $objEmp){
        $this->setCodigo($cod);
        $this->setDestino($dest);
        $this->setCantMaxPasajeros($maxPas);
        $this->setColObjPasajero($colObjPasaj);
        $this->setObjResponsable($objResp);
        $this->setCosto($costo);
        $this->setObjEmpresa($objEmp);
    }

    //metodos de acceso

    public function getCodigo(){
        return $this->codigo;
    }
    public function getDestino(){
        return $this->destino;
    }
    public function getCantMaxPasajeros(){
        return $this->cantMaxPasajeros;
    }
    public function getColObjPasajero(){
        return $this->colObjPasajero;
    }
    public function getObjResponsable(){
        return $this->objResponsableV;
    }
    public function getCosto(){
        return $this->costo;
    }
    public function getSumaCostosAbonados(){
        return $this->sumaCostosAbonados;
    }
    public function getObjEmpresa(){
        return $this->objEmpresa;
    }
    public function getMensaje(){
        return $this->mensajeOperacion;
    }



    public function setCodigo($cod){
        $this->codigo=$cod;
    }
    public function setDestino($dest){
        $this->destino=$dest;
    }
    public function setCantMaxPasajeros($cantMaxPas){
        $this->cantMaxPasajeros=$cantMaxPas;
    }
    public function setColObjPasajero($colObjPas){
        $this->colObjPasajero=$colObjPas;
    }
    public function setObjResponsable($objResp){
        $this->objResponsableV=$objResp;
    }
    public function setCosto($costo){
        $this->costo=$costo;
    }
    public function setSumaCostosAbonados($sumCostAbon){
        $this->sumaCostosAbonados=$sumCostAbon;
    }
    public function setObjEmpresa($objEmp){
        $this->objEmpresa=$objEmp;
    }
    public function setMensaje($mensaje){
        $this->mensajeOperacion=$mensaje;
    }



    public function buscar($idViaje){
		$base=new BaseDatos();
		$consulta="SELECT * FROM viaje WHERE idviaje= '".$idViaje."'";
		$resp= false;
		if($base->iniciar()){
			if($base->ejecutar($consulta)){
				if($row2=$base->registro()){					
				    $this->setCodigo($idViaje);
					$this->setDestino($row2['vdestino']);
					$this->setCantMaxPasajeros($row2['vcantmaxpasajeros']);
					$this->setObjEmpresa($row2['idempresa']);
					$this->setObjResponsable($row2['rnumeroempleado']);
					$this->setCosto($row2['vimporte']);
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
        $arrayViaje=null;
        $base=new BaseDatos();
        $consulta="SELECT * FROM viaje ";
        if($condicion!=""){
            $consulta=$consulta." WHERE ".$condicion;
        }
        $consulta.=" ORDER BY idviaje ";
        if($base->iniciar()){
            if($base->ejecutar($consulta)){
                $arrayViaje= array();
                while($row2=$base->registro()){
                    $idViaje=$row2['idviaje'];
                    $destino=$row2['vdestino'];
                    $cantMaxPas=$row2['vcantmaxpasajeros'];
                    $idEmpresa=$row2['idempresa'];
                    $numEmp=$row2['rnumeroempleado'];
                    $importe=$row2['vimporte'];

                    $viaje=new Viaje();
                    $viaje->cargar($idViaje, $destino, $cantMaxPas, $idEmpresa, $numEmp, $importe);
                    array_push($arrayViaje,$viaje);
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $arrayViaje;
    }



    public function insertar(){
        $base=new BaseDatos();
        $resp=false;
        $consulta="INSERT INTO viaje(idviaje, vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte)
                VALUES ('".$this->getCodigo()."','".$this->getDestino()."','".$this->getCantMaxPasajeros()."','".$this->getObjEmpresa()."','".$this->getObjResponsable()."','".$this->getCosto()."')";
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
        $consulta="UPDATE viaje SET
                    vdestino='".$this->getDestino()."',
                    vcantmaxpasajeros='".$this->getCantMaxPasajeros()."',
                    idempresa='".$this->getObjEmpresa()."',
                    rnumeroempleado='".$this->getObjResponsable()."',
                    vimporte='".$this->getCosto()."'
                    WHERE idviaje='".$this->getCodigo()."'";
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
            $consultaBorrar="DELETE FROM viaje WHERE idviaje=".$this->getCodigo();
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

    public function retornarCadena($cadena){
        $nuevaCadena="";
        foreach($cadena as $valor){
            $nuevaCadena.=$valor."\n";
        }
        return $nuevaCadena;
    }

    public function __toString(){
        return
        "Codigo de viaje: ".$this->getCodigo()."\n".
        "Destino: ".$this->getDestino()."\n".
        "Cantidad maxima de Pasajeros: ".$this->getCantMaxPasajeros()."\n".
        "Pasajeros: ".$this->retornarCadena($this->getColObjPasajero())."\n".
        "Responsable: ".$this->getObjResponsable()."\n".
        "Costo del viaje: ".$this->getCosto()."\n".
        "Suma de costos abonados por pasajeros: ".$this->getSumaCostosAbonados();
    }

    
}