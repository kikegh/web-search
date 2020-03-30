<?php

   function insert_data($titulo, $palabras_clave, $autor, $contenido, $fecha, $url, $tamanio){
        $info = "";
        $status = "";

        $mysqli = new mysqli('localhost','root','','buscador_oaw');
        if(!$mysqli){
            $status = "No se pudo realizar la conexión PHP - MySQL";
        }
        else {
            $contenido = $mysqli->real_escape_string($contenido);
            $sql = 'insert into website(titulo, palabras_clave, autor, contenido, fecha, url, tamanio) values("'.$titulo.'", "'.$palabras_clave.'", "'.$autor.'", "'.$contenido.'", "'.$fecha.'", "'.$url.'", "'.$tamanio.'")';
            //echo $sql;
            try{
                $resultado = $mysqli->query($sql);
            }catch (Exception $e) {
                echo "Error al insertar". $e;
            }
        
           
            if($resultado){
                $info = "Datos registrados con éxito ;)";
            }
            else{
                $info = "Algo salió mal, no se registraron los datos ;(";
            }
        $mysqli->close();

        echo $status;
        return $info;
        }
    } 
 
    function select_url($url){
        $status = "";
        /*$link = mysql_connect("localhost", "root", "");
        mysql_select_db("buscador_oaw", $link); */

        $mysqli = new mysqli('localhost','root','','buscador_oaw');
        if(!$mysqli){
        $status = "No se pudo realizar la conexión PHP - MySQL, :c";
        }
        else {
            $status = "Si se conecto, yay!";
            $sql = 'select * from website where url="'.$url.'"';
            //echo $sql;
            $resultado = $mysqli->query($sql);
            //echo $resultado;
            if($resultado->num_rows > 0){
                $aValues = $resultado->fetch_array();
                $info[0] = $aValues['tamanio'];
                $info[1] = $aValues['ID'];

            }
            else {
                $info[0] = "No se encontraron resultados";
            }
        
        //$resultado->free();
        $mysqli->close();
        echo $status;
        }
        return $info;
    }

    function update_data($id, $titulo, $palabras_clave, $autor, $contenido, $fecha, $url, $tamanio){
        $info = "";
        $status = "";

        $mysqli = new mysqli('localhost','root','','buscador_oaw');
        if(!$mysqli){
            $status = "No se pudo realizar la conexión PHP - MySQL";
        }
        else {
            $contenido = $mysqli->real_escape_string($contenido);
            $sql = 'update website SET titulo="'.$titulo.'", palabras_clave="'.$palabras_clave.'", autor="'.$autor.'", contenido="'.$contenido.'", fecha="'.$fecha.'", url="'.$url.'", tamanio="'.$tamanio.'" where ID= '.$id;
            //echo $sql;
            try{
                $resultado = $mysqli->query($sql);
            }catch (Exception $e) {
                echo "Error al actualizar". $e;
            }
        
           
            if($resultado){
                $info = "Datos actualizados con éxito ;)";
            }
            else{
                $info = "Algo salió mal, no se actualizaron los datos ;(";
            }
        $mysqli->close();

        echo $status;
        return $info;
        }
    }
    
    function deleteFromList(){
        $info = "";
        $status = "";

        $mysqli = new mysqli('localhost','root','','buscador_oaw');
        if(!$mysqli){
            $status = "No se pudo realizar la conexión PHP - MySQL";
        }
        else {
            $contenido = $mysqli->real_escape_string($contenido);
            $sql = 'delete from website WHERE ID = '.id;
            //echo $sql;
            try{
                $resultado = $mysqli->query($sql);
            }catch (Exception $e) {
                echo "Error: no se pudo eliminar". $e;
            }
        
           
            if($resultado){
                $info = "Eliminado de la lista ;)";
            }
            else{
                $info = "Algo salió mal, no se eliminó de la lista ;(";
            }
        $mysqli->close();

        echo $status;
        return $info;
        }
    }

    function showList(){
        $info = "";
        $status = "";

        $mysqli = new mysqli('localhost','root','','buscador_oaw');
        if(!$mysqli){
            $status = "No se pudo realizar la conexión PHP - MySQL";
        }
        else {
            $contenido = $mysqli->real_escape_string($contenido);
            $sql = 'select * from ';
            //echo $sql;
            try{
                $resultado = $mysqli->query($sql);
            }catch (Exception $e) {
                echo "Error: no se pudo eliminar". $e;
            }
        
           
            if($resultado){
                $info = "Eliminado de la lista ;)";
            }
            else{
                $info = "Algo salió mal, no se eliminó de la lista ;(";
            }
        $mysqli->close();

        echo $status;
        return $info;
        }
    }
?>