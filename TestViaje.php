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
            $ingresarEmp=ingresarEmpresa();
            if($ingresarEmp){
                echo "\nLa empresa a sido ingresada a la base de datos con exito. \n";
            }else{
                echo "\nHubo un error al tratar de ingresar la empresa a la base de datos. \n";
            }
            break;
        case 3:
            $modifEmp=modificarEmpresa();
            if($modifEmp){
                echo "\nLa empresa a sido modificada con exito. \n";
            }else{
                echo "\nHubo un error al tratar de modificar la empresa. \n";
            }
            break;
        case 4:
            $elimEmp=eliminarEmpresa();
            if($elimEmp){
                echo "\nLa empresa a sido eliminada con exito.\n";
            }else{
                echo "\nHubo un error al eliminar la empresa. \n";
            }
            break;
        case 5:
            mostrarResponsable();
            break;
        case 6:
            $ingresarResp=ingresarResponsable();
            if($ingresarResp){
                echo "\nEl responsable a sido ingresado a la base de datos con exito. \n";
            }else{
                echo "\nHubo un error al tratar de ingresar el responsable a la base de datos. \n";
            }
            break;
        case 7:
            $modifResp=modificarResponsable();
            if($modifResp){
                echo "\nEl responsable a sido modificado con exito. \n";
            }else{
                echo "\nHubo un error al tratar de modificar el responsable. \n";
            }
            break;
        case 8:
            $elimResp=eliminarResponsable();
            if($elimResp){
                echo "\nEl responsable a sido eliminado con exito.\n";
            }else{
                echo "\nHubo un error al eliminar el responsable. \n";
            }
            break;
        case 9:
            mostrarViajes();
            break;
        case 10:
            $ingresarViaje=ingresarViaje();
            if($ingresarViaje){
                echo "\nEl viaje a sido ingresado a la base de datos con exito. \n";
            }else{
                echo "\nHubo un error al tratar de ingresar el viaje a la base de datos. \n";
            }
            break;
        case 11:
            $modifViaje=modificarViaje();
            if($modifViaje){
                echo "\nEl viaje a sido modificada con exito. \n";
            }else{
                echo "\nHubo un error al tratar de modificar el viaje. \n";
            }
            break;
        case 12:
            $elimViaje=eliminarViaje();
            if($elimViaje){
                echo "\nEl viaje a sido eliminado con exito.\n";
            }else{
                echo "\nHubo un error al eliminar el viaje. \n";
            }
            break;
        case 13:
            mostrarPasajeros();
            break;
        case 14:
            $ingresarPasaj=ingresarPasajero();
            if($ingresarPasaj){
                echo "\nEl pasajero a sido ingresado a la base de datos con exito. \n";
            }else{
                echo "\nHubo un error al tratar de ingresar el pasajero a la base de datos. \n";
            }
            break;
        case 15:
            $modifPasaj=modificarPasajero();
            if($modifPasaj){
                echo "\nEl pasajero a sido modificado con exito. \n";
            }else{
                echo "\nHubo un error al tratar de modificar el pasajero. \n";
            }
            break;
        case 16:
            $elimPasaj=eliminarPasajero();
            if($elimPasaj){
                echo "\nEl pasajero a sido eliminado con exito.\n";
            }else{
                echo "\nHubo un error al eliminar el pasajero. \n";
            }
            break;
        default:
            echo"\nLa opcion ingresada es invalida.\n";
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
    echo "Ingrese el Id de la empresa que desea modificar: \n";
    $id=trim(fgets(STDIN));
    if(!$empresa->buscar($id)){
        do{
            echo "No se encontro ninguna empresa con el ID ingresado.\n";
            echo "Ingrese un ID valido: \n";
            $id=trim(fgets(STDIN));
        }while(!$empresa->buscar($id));
    }
    echo "\nLa empresa es ".$empresa->getNombre()."\n";
    echo "Ingrese el nuevo nombre: \n";
    $nom=trim(fgets(STDIN));
    echo "Ingrese la nueva direccion: \n";
    $direc=trim(fgets(STDIN));
    $empresa->setNombre($nom);
    $empresa->setDireccion($direc);
    return $empresa->modificar();
    
    

}

function eliminarEmpresa(){
    echo "Ingrese el id de la empresa que desea eliminar: \n";
    $id=trim(fgets(STDIN));
    $empresa=new Empresa();
    if(!$empresa->buscar($id)){
        do{
            echo "No se encontro ninguna empresa con el ID ingresado.\n";
            echo "Ingrese un ID valido: ";
            $id=trim(fgets(STDIN));
        }while(!$empresa->buscar($id));
    }
    return $empresa->eliminar();
    
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
    echo "ingrese el ID del responsable que desea modificar: \n";
    $idResp=trim(fgets(STDIN));
    $responsable=new ResponsableV();
    if(!$responsable->buscar($idResp)){
        do{
            echo "no se encontro ningun responsable con dicho ID. \n";
            echo "Ingrese un ID valido: \n";
            $idResp=trim(fgets(STDIN));
        }while(!$responsable->buscar($idResp));
    }
    echo "\nEl responsable es ".$responsable->getNombre()." ".$responsable->getApellido()."\n";
    echo "Ingrese el nuevo numero de licencia: \n";
    $numLic=trim(fgets(STDIN));
    echo "Ingrese el nuevo nombre: \n";
    $nom=trim(fgets(STDIN));
    echo "Ingrese el nuevo apellido: \n";
    $apell=trim(fgets(STDIN));
    $responsable->setNumLicencia($numLic);
    $responsable->setNombre($nom);
    $responsable->setApellido($apell);
    return $responsable->modificar();
    
}

function eliminarResponsable(){
    echo "ingrese el ID del responsable que desea eliminar: \n";
    $idResp=trim(fgets(STDIN));
    $responsable=new ResponsableV();
    if(!$responsable->buscar($idResp)){
        do{
            echo "no se encontro ningun responsable con dicho ID. \n";
            echo "Ingrese un ID valido: \n";
            $idResp=trim(fgets(STDIN));
        }while(!$responsable->buscar($idResp));
    }
    return $responsable->eliminar();
    
}

function mostrarViajes(){
    $viaje=new Viaje();
    $viajes=$viaje->listar();
    foreach($viajes as $viaje){
        echo "\n$viaje\n";
    }
}

function ingresarViaje(){
    echo "Ingrese el ID de la empresa: \n";
    $id=trim(fgets(STDIN));
    $empresa=new Empresa();
    if(!$empresa->buscar($id)){
        do{
            echo "No existe ninguna empresa con ese ID. \n";
            echo "ingrese el ID de una empresa valido: \n";
            $id=trim(fgets(STDIN));
        }while(!$empresa->buscar($id));
    }
    echo "\nLa empresa es ".$empresa->getNombre()."\n";
    
    echo "Ingrese el ID del responsable: \n";
    $idResp=trim(fgets(STDIN));
    $objResponsable=new ResponsableV();
    if(!$objResponsable->buscar($idResp)){
        do{
            echo "No existe ningún responsable con este ID. \n";
            echo "Ingrese un ID válido: \n";
            $idResp=trim(fgets(STDIN));
        }while(!$objResponsable->buscar($idResp));
    }
    echo "\nEl responsable es: ".$objResponsable->getNombre()." ".$objResponsable->getApellido()."\n";
    
    echo "Ingrese el destino: \n";
    $dest=trim(fgets(STDIN));
    echo "Ingrese la cantidad máxima de pasajeros: \n";
    $cantMax=trim(fgets(STDIN));
    echo "Ingrese el costo del viaje: \n";
    $costo=trim(fgets(STDIN));
    $viaje=new Viaje();
    $viaje->cargar(null, $dest, $cantMax, $objResponsable->getIdResponsable(), $costo, $id);
    return $viaje->insertar();
}

function modificarViaje(){
    echo "Ingrese el ID del viaje que desea modificar: \n";
    $id=trim(fgets(STDIN));
    $viaje=new Viaje();
    if(!$viaje->buscar($id)){
        do{
            echo "No se encontró ningun viaje con dicho ID. \n";
            echo "Ingrese un ID de empresa válido: \n";
            $id=trim(fgets(STDIN));
        }while(!$viaje->buscar($id));
    }
    echo "Ingrese el nuevo destino: \n";
    $dest=trim(fgets(STDIN));
    echo "Ingrese la nueva cantidad máxima de pasajeros: \n";
    $cantmax=trim(fgets(STDIN));
    echo "Ingrese el ID del nuevo responsable: \n";
    $idResp=trim(fgets(STDIN));
    $responsable=new ResponsableV();
    if(!$responsable->buscar($idResp)){
        do{
            echo "No se encontró ningun responsable con ese ID: \n";
            echo "Ingrese un ID válido: \n";
            $idResp=trim(fgets(STDIN));
        }while(!$responsable->buscar($idResp));
    }
    echo "Ingrese el nuevo costo de viaje: \n";
    $costo=trim(fgets(STDIN));
    echo "Ingrese el ID de la nueva empresa: \n";
    $idEmp=trim(fgets(STDIN));
    $empresa=new Empresa();
    if(!$empresa->buscar($idEmp)){
        do{
            echo "No se encontró ninguna empresa con dicho ID. \n";
            echo "Ingrese un ID de empresa valido: \n";
            $idEmp=trim(fgets(STDIN));
        }while(!$empresa->buscar($idEmp));
    }
    $viaje->setDestino($dest);
    $viaje->setCantMaxPasajeros($cantmax);
    $viaje->setColObjPasajero([]);
    $viaje->setObjResponsable($responsable->getIdResponsable());
    $viaje->setCosto($costo);
    $viaje->setObjEmpresa($idEmp);
    return $viaje->modificar();
    
}

function eliminarViaje(){
    echo "Ingrese el ID del viaje que desea eliminar: \n";
    $id=trim(fgets(STDIN));
    $viaje=new Viaje();
    if(!$viaje->buscar($id)){
        do{
            echo "No se encontró ningun viaje con dicho ID. \n";
            echo "Ingrese un ID válido: \n";
            $id=trim(fgets(STDIN));
        }while(!$viaje->buscar($id));
    }
    return $viaje->eliminar();
    
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
    echo "Ingrese el número de documento del pasajero que desea modificar: \n";
    $doc=trim(fgets(STDIN));
    $pasajero=new Pasajero();
    if(!$pasajero->buscar($doc)){
        do{
            echo "No se encontró ningún pasajero con ese documento. \n";
            echo "Ingrese un número de documento válido: \n";
            $doc=trim(fgets(STDIN));
        }while(!$pasajero->buscar($doc));
    }
    echo "\nEl pasajero es ".$pasajero->getNombre()." ".$pasajero->getApellido()."\n";
    echo "Ingrese el nuevo nombre: \n";
    $nom=trim(fgets(STDIN));
    echo "Ingrese el nuevo apellido: \n";
    $apell=trim(fgets(STDIN));
    echo "Ingrese el nuevo telefono: \n";
    $tel=trim(fgets(STDIN));
    echo "Ingrese el ID del nuevo viaje: \n";
    $id=trim(fgets(STDIN));
    $pasajero->setNombre($nom);
    $pasajero->setApellido($apell);
    $pasajero->setTelefono($tel);
    $pasajero->setIdViaje($id);
    return $pasajero->modificar();
    
}

function eliminarPasajero(){
    echo "Ingrese el número de documento del pasajero que desea eliminar: \n";
    $doc=trim(fgets(STDIN));
    $pasajero=new Pasajero();
    if(!$pasajero->buscar($doc)){
        do{
            echo "No se encontró ningún pasajero con ese documento. \n";
            echo "Ingrese un número de documento válido: \n";
        }while(!$pasajero->buscar($doc));
    }
    return $pasajero->eliminar();
    
}