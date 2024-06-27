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

    //Métodos de acceso

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


    /**
    * Busca una empresa en la base de datos por su ID.
    *
    * @param int $idEmpresa El ID de la empresa a buscar.
    * @return bool Devuelve true si se encuentra la empresa, false en caso contrario.
    */
    public function buscar($idEmpresa){
		$base=new BaseDatos();
        // Construir la consulta SQL para buscar la empresa por su ID
		$consulta="SELECT * FROM empresa WHERE idempresa= '".$idEmpresa."'";
		$resp= false;
        // Ejecutar la consulta
		if($base->iniciar()){
			if($base->ejecutar($consulta)){
                // Verificar si se encontro la empresa
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


    /**
    * Lista todas las empresas en la base de datos, filtradas por una condición opcional.
    *
    * @param string $condicion La condición para filtrar las empresas (opcional).
    * @return array|null Devuelve un array de objetos Empresa si se encuentran empresas, null en caso contrario.
    */
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


    /**
    * Inserta una nueva empresa en la base de datos.
    *
    * @return bool Devuelve true si la inserción fue exitosa, false en caso contrario.
    */
    public function insertar(){
        $base=new BaseDatos();
        $resp=false;
        $consulta="INSERT INTO empresa(idempresa, enombre, edireccion)
                VALUES ('".$this->getIdEmpresa()."','".$this->getNombre()."','".$this->getDireccion()."')";
                /*no es necesario el id*/
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
    * Modifica una empresa existente en la base de datos.
    *
    * @return bool Devuelve true si la modificación fue exitosa, false en caso contrario.
    */
    public function modificar(){
        $resp=false;
        $base=new BaseDatos();
        $consulta="UPDATE empresa SET enombre='".$this->getNombre()."',edireccion='".$this->getDireccion()."' WHERE idempresa=".$this->getIdEmpresa();
        if($base->iniciar()){
            /*verificar si el id existe*/
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
    * Elimina una empresa de la base de datos.
    *
    * @return bool Devuelve true si la eliminación fue exitosa, false en caso contrario.
    */
    public function eliminar(){
        $base=new BaseDatos();
        $resp=false;
        if($base->iniciar()){
            $consultaBorrar="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa();
            /*verificar si el ID existe*/
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