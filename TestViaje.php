<?php

include_once 'BaseDatos.php';
include_once 'Empresa.php';
include_once 'Persona.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'Viaje.php';

while(true){
    echo "\n MENU \n";
    echo "1- Ver Empresas\n";
    echo "2- Ingresar Empresa\n";
    echo "3- Modificar Empresa\n";
    echo "4- Eliminar Empresa\n";
    echo "5- Ver Responsables\n";
    echo "6- Ingresar Responsable\n";
    echo "7- Modificar Responsable\n";
    echo "8- Eliminar Responsable\n";
    echo "9- Ver Viajes\n";
    echo "10- Ingresar Viaje\n";
    echo "11- Modificar Viaje\n";
    echo "12- Eliminar Viaje\n";
    echo "13- Ver Pasajeros\n";
    echo "14- Ingresar Pasajero\n";
    echo "15- Modificar Pasajero\n";
    echo "16- Eliminar Pasajero\n";
    echo "Opcion: \n";
    $opcion=trim(fgets(STDIN));

    switch ($opcion) {
        case 1:
            mostrarEmpresas();
            break;
        case 2:
            ingresarEmpresa();
            break;
        case 3:
            modificarEmpresa();
            break;
        case 4:
            eliminarEmpresa();
            break;
        case 5:
            mostrarResponsable();
            break;
        case 6:
            ingresarResponsable();
            break;
        case 7:
            modificarResponsable();
            break;
        case 8:
            eliminarResponsable();
            break;
        case 9:
            mostrarViajes();
            break;
        case 10:
            ingresarViaje();
            break;
        case 11:
            modificarViaje();
            break;
        case 12:
            eliminarViaje();
            break;
        case 13:
            mostrarPasajeros();
            break;
        case 14:
            ingresarPasajero();
            break;
        case 15:
            modificarPasajero();
            break;
        case 16:
            eliminarPasajero();
            break;
        default:
            echo"La opcion ingresada es invalida.\n";
            break;
    }
}

function mostrarEmpresas(){
    $empresa=new Empresa();
    $empresas=$empresa->listar();
    foreach($empresas as $empresa){
        echo "\n$empresa";
    }
}

function ingresarEmpresa(){
    echo "Ingrese el nombre de la Empresa: \n";
    $nom=trim(fgets(STDIN));
    echo "Ingrese la direccion de la Empresa: \n";
    $dir=trim(fgets(STDIN));
    $empresa=new Empresa();
    $empresa->cargar(null, $nom, $dir);
    return $empresa->insertar();
}

function modificarEmpresa(){
    $empresa=new Empresa();
    echo "Ingrese el Id de la empresa: \n";
    $id=trim(fgets(STDIN));
    if(!$empresa->buscar($id)){
        echo "No se encontro ninguna empresa con el ID ingresado.\n";
    }else{
        echo "La empresa es ".$empresa->getNombre()."\n";
        echo "Ingrese el nuevo nombre: \n";
        $nom=trim(fgets(STDIN));
        echo "Ingrese la nueva direccion: \n";
        $direc=trim(fgets(STDIN));
        $empresa->setNombre($nom);
        $empresa->setDireccion($direc);
        return $empresa->modificar();
    }
    

}

function eliminarEmpresa(){
    echo "Ingrese el id de la empresa que desea eliminar: \n";
    $id=trim(fgets(STDIN));
    $empresa=new Empresa();
    if(!$empresa->buscar($id)){
        echo "No se encontro ninguna empresa con el ID ingresado.\n";
    }else{
        return $empresa->eliminar();
    }
}

function mostrarResponsable(){
    $responsable=new ResponsableV();
    $responsables=$responsable->listar();
    foreach($responsables as $responsable){
        echo "\n$responsable";
    }
}
    
function ingresarResponsable(){
    echo "Ingrese el nombre: \n";
    $nom=trim(fgets(STDIN));
    echo "Ingrese el apellido: \n";
    $apell=trim(fgets(STDIN));
    echo "Ingrese el numero de documento: \n";
    $nroDoc=trim(fgets(STDIN));
    echo "Ingrese el numero de licencia: \n";
    $numLic=trim(fgets(STDIN));
    $responsable=new ResponsableV();
    $responsable->cargar($nroDoc, $nom, $apell, null, $numLic);
    return $responsable->insertar();
}

function modificarResponsable(){
    echo "ingrese el numero de empleado: \n";
    $numEmpl=trim(fgets(STDIN));
    $responsable=new ResponsableV();
    if(!$responsable->buscar($numEmpl)){
        echo "no se encontro ningun responsable con dicho numero de empleado. \n";
    }else{
        echo "Ingrese el numero de licencia: \n";
        $numLic=trim(fgets(STDIN));
        echo "Ingrese el nombre: \n";
        $nom=trim(fgets(STDIN));
        echo "Ingrese el apellido: \n";
        $apell=trim(fgets(STDIN));
        $responsable->setNumLicencia($numLic);
        $responsable->setNombre($nom);
        $responsable->setApellido($apell);
        return $responsable->modificar();
    }
    
    
    
}

function eliminarResponsable(){
    echo "ingrese el numero de empleado: \n";
    $numEmpl=trim(fgets(STDIN));
    $responsable=new ResponsableV();
    if(!$responsable->buscar($numEmpl)){
        echo "no se encontro ningun responsable con dicho numero de empleado. \n";
    }else{
        return $responsable->eliminar();
    }
}

function mostrarViajes(){
    $viaje=new Viaje();
    $viajes=$viaje->listar();
    foreach($viajes as $viaje){
        echo "\n$viaje";
    }
}

function ingresarViaje(){
    echo "Ingrese el id de la empresa: \n";
    $id=trim(fgets(STDIN));
    $empresa=new Empresa();
    if(!$empresa->buscar($id)){
        do{
            echo "no existe ninguna empresa con ese ID. \n";
            echo "ingrese el ID de una empresa valido: \n";
            $id=trim(fgets(STDIN));
        }while(!$empresa->buscar($id));
    }else{
        echo "La empresa es ".$empresa->getNombre()."\n";
    }
    echo "Ingrese el numero de empleado del responsable: \n";
    $numEmpl=trim(fgets(STDIN));
    $objResponsable=new ResponsableV();
    if(!$objResponsable->buscar($numEmpl)){
        do{
            echo "no existe ningun responsable con este numero de empleado. \n";
            echo "ingrese un numero de empleado valido: \n";
            $numEmpl=trim(fgets(STDIN));
        }while(!$objResponsable->buscar($numEmpl));
    }else{
        echo "El responsable es: ".$objResponsable->getNombre()." ".$objResponsable->getApellido()."\n";
    }
    echo "Ingrese el destino: \n";
    $dest=trim(fgets(STDIN));
    echo "Ingrese la cantidad maxima de pasajeros: \n";
    $cantMax=trim(fgets(STDIN));
    echo "Ingrese el costo del viaje: \n";
    $costo=trim(fgets(STDIN));
    $arrayPasajeros=[];
    $viaje=new Viaje();
    $viaje->cargar(null, $dest, $cantMax, $arrayPasajeros, $objResponsable->getNumEmpleado(), $costo, $id);
    return $viaje->insertar();
}

function modificarViaje(){
    echo "Ingrese el id del viaje a modificar: \n";
    $id=trim(fgets(STDIN));
    $viaje=new Viaje();
    if(!$viaje->buscar($id)){
        echo "No se encontro ningun viaje con dicho ID. \n";
    }else{
        echo "Ingrese el nuevo destino: \n";
        $dest=trim(fgets(STDIN));
        echo "Ingrese la cantidad maxima de pasajeros: \n";
        $cantmax=trim(fgets(STDIN));
        echo "Ingrese el numero de empleado: \n";
        $numEmp=trim(fgets(STDIN));
        $responsable=new ResponsableV();
        if(!$responsable->buscar($numEmp)){
            do{
                echo "No se encontro ningun responsable con ese numero de empleado: \n";
                echo "Ingrese un numero de empleado valido: ";
                $numEmp=trim(fgets(STDIN));
            }while(!$responsable->buscar($numEmp));
        }
        echo "Ingrese el costo de viaje: \n";
        $costo=trim(fgets(STDIN));
        echo "Ingrese el ID de la empresa: \n";
        $idEmp=trim(fgets(STDIN));
        $empresa=new Empresa();
        if(!$empresa->buscar($idEmp)){
            do{
                echo "No se encontro ninguna empresa con dicho ID. \n";
                echo "Ingrese un ID de empresa valido: \n";
                $idEmp=trim(fgets(STDIN));
            }while(!$empresa->buscar($idEmp));
        }
        $viaje->setDestino($dest);
        $viaje->setCantMaxPasajeros($cantmax);
        $viaje->setColObjPasajero([]);
        $viaje->setObjResponsable($responsable->getNumEmpleado());
        $viaje->setCosto($costo);
        $viaje->setObjEmpresa($idEmp);
        return $viaje->modificar();
    }
}

function eliminarViaje(){
    echo "Ingrese el ID del viaje a eliminar: \n";
    $id=trim(fgets(STDIN));
    $viaje=new Viaje();
    if(!$viaje->buscar($id)){
        echo "No se encontro ningun viaje con dicho ID. \n";
    }else{
        return $viaje->eliminar();
    }
}

function mostrarPasajeros(){
    $pasajero=new Pasajero();
    $pasajeros=$pasajero->listar();
    foreach($pasajeros as $pasajero){
        echo "\n$pasajero";
    }
}

function ingresarPasajero(){
    echo "Ingrese el nombre del pasajero: \n";
    $nom=trim(fgets(STDIN));
    echo "Ingrese el apellido: \n";
    $apell=trim(fgets(STDIN));
    echo "Ingrese el numero de documento: \n";
    $doc=trim(fgets(STDIN));
    echo "Ingrese el numero de telefono: \n";
    $tel=trim(fgets(STDIN));
    echo "Ingrese el ID del viaje: \n";
    $id=trim(fgets(STDIN));
    $pasajero=new Pasajero();
    $pasajero->cargar($doc, $nom, $apell, $tel, $id);
    return $pasajero->insertar();
}

function modificarPasajero(){
    echo "Ingrese el numero de documento del pasajero a modificar: \n";
    $doc=trim(fgets(STDIN));
    $pasajero=new Pasajero();
    if(!$pasajero->buscar($doc)){
        do{
            echo "No se encontro ningun pasajero con ese documento. \n";
            echo "Ingrese un numero de documento valido: \n";
            $doc=trim(fgets(STDIN));
        }while(!$pasajero->buscar($doc));
    }else{
        echo "Ingrese el nuevo nombre: \n";
        $nom=trim(fgets(STDIN));
        echo "Ingrese el apellido: \n";
        $apell=trim(fgets(STDIN));
        echo "Ingrese el telefono: \n";
        $tel=trim(fgets(STDIN));
        echo "Ingrese el ID del viaje: \n";
        $id=trim(fgets(STDIN));
        $pasajero->setNombre($nom);
        $pasajero->setApellido($apell);
        $pasajero->setTelefono($tel);
        $pasajero->setIdViaje($id);
        return $pasajero->modificar();
    }
}

function eliminarPasajero(){
    echo "Ingrese el numero de documento del pasajero a eliminar: \n";
    $doc=trim(fgets(STDIN));
    $pasajero=new Pasajero();
    if(!$pasajero->buscar($doc)){
        echo "No se encontro ningun pasajero con ese documento. \n";
    }else{
        return $pasajero->eliminar();
    }
}