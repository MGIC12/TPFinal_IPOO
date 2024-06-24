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
    echo "Ingrese el id de la Empresa: \n";
    $id=trim(fgets(STDIN));
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
    
}

function modificarResponsable(){}

function eliminarResponsable(){}

function mostrarViajes(){
    $viaje=new Viaje();
    $viajes=$viaje->listar();
    foreach($viajes as $viaje){
        echo "\n$viaje";
    }
}

function ingresarViaje(){}

function modificarViaje(){}

function eliminarViaje(){}

function mostrarPasajeros(){
    $pasajero=new Pasajero();
    $pasajeros=$pasajero->listar();
    foreach($pasajeros as $pasajero){
        echo "\n$pasajero";
    }
}

function ingresarPasajero(){}

function modificarPasajero(){}

function eliminarPasajero(){}