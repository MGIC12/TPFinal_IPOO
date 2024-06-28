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


    public function cargar($cod, $dest, $maxPas, $objResp, $costo, $objEmp){
        $this->setCodigo($cod);
        $this->setDestino($dest);
        $this->setCantMaxPasajeros($maxPas);
        $this->setObjResponsable($objResp);
        $this->setCosto($costo);
        $this->setObjEmpresa($objEmp);
    }

    //Métodos de acceso

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



    /**
     * Busca un viaje en la base de datos por su ID.
     *
     * @param int $idViaje El ID del viaje a buscar.
     * @return bool Devuelve true si se encontró el viaje, false en caso contrario.
     */
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
					$this->setObjResponsable($row2['idResponsable']);
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


    /**
     * Lista los viajes que cumplen con una condición opcional.
     *
     * @param string $condicion La condición opcional para filtrar los viajes.
     * @return array|null Un array de objetos Viaje que cumplen con la condición, o null si no se encontraron viajes.
     */
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
                    $viaje->cargar($idViaje, $destino, $cantMaxPas, $numEmp, $importe, $idEmpresa);
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



    /**
     * Inserta un nuevo viaje en la base de datos.
     *
     * @return bool Devuelve true si la inserción se realizó correctamente, false en caso contrario.
     */
    public function insertar(){
        $base=new BaseDatos();
        $resp=false;
        $consulta="INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, idResponsable, vimporte)
                VALUES ('".$this->getDestino()."','".$this->getCantMaxPasajeros()."','".$this->getObjEmpresa()."','".$this->getObjResponsable()."','".$this->getCosto()."')";
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
     * Modifica un viaje existente en la base de datos.
     *
     * @return bool Devuelve true si la modificación se realizó correctamente, false en caso contrario.
     */
    public function modificar(){
        $resp=false;
        $base=new BaseDatos();
        $consulta="UPDATE viaje SET
                    vdestino='".$this->getDestino()."',
                    vcantmaxpasajeros='".$this->getCantMaxPasajeros()."',
                    idempresa='".$this->getObjEmpresa()."',
                    idResponsable='".$this->getObjResponsable()."',
                    vimporte='".$this->getCosto()."'
                    WHERE idviaje='".$this->getCodigo()."'";
        if($base->iniciar()){
            if($this->buscar($this->getCodigo())){
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
     * Elimina un viaje existente de la base de datos.
     *
     * @return bool Devuelve true si la eliminación se realizó correctamente, false en caso contrario.
     */
    public function eliminar(){
        $base=new BaseDatos();
        $resp=false;
        if($base->iniciar()){
            $consultaBorrar="DELETE FROM viaje WHERE idviaje=".$this->getCodigo();
            if($this->buscar($this->getCodigo())){
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
        return $resp;
    }

    public function __toString(){
        return
        "Codigo de viaje: ".$this->getCodigo()."\n".
        "Destino: ".$this->getDestino()."\n".
        "Cantidad maxima de Pasajeros: ".$this->getCantMaxPasajeros()."\n".
        "Numero de empleado del Responsable: ".$this->getObjResponsable()."\n".
        "Costo del viaje: ".$this->getCosto()."\n";
    }
}