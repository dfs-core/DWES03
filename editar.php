<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dwes.css" type="text/css">
    <title>Editar</title>
</head>
<body>
    <?php
 
    if(isset($_GET['cod'])) $cod=$_GET['cod'];
    
    $dwes = new PDO('mysql:host=localhost;dbname=dwes', 'dwes', 'abc123.');
    
    //Comprobamos si debemos actualiar

    if (isset($_POST['Actualizar'])){

        //Preparamos la consulta
        $cod=$_POST['cod'];
        $nomcorto=$_POST['nomcorto'];
        $nombre=$_POST['nombre'];
        $descripcion=$_POST['descripcion'];
        $pvp=$_POST['pvp'];
        
        $sql="UPDATE producto set nombre=:nombre, nombre_corto=:nomcorto, descripcion=:descripcion, PVP=:pvp WHERE cod='$cod'";
        //$sql="UPDATE producto set nombre=:nombre, nombre_corto=:nomcorto WHERE cod='$cod'";
        $resultado=$dwes->prepare($sql);

        //Ejecutamos la consulta
        $resultado->bindParam(":nombre",$nombre);
        $resultado->bindParam(":nomcorto",$nomcorto);
        $resultado->bindParam(":descripcion",$descripcion);
        $resultado->bindParam(":pvp",$pvp);
        $resultado->execute();
    }
    
 
    ?>
    <div id="encabezado">
        <h1>Tarea: edición de un producto</h1>
    </div>
    <div id="contenido">

         <h1>Producto:</h1><br>
         <form id="form_actualizar" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
         <?php
            //echo $_GET['cod'];
            //if(isset($_GET['cod'])) $cod=$_GET['cod'];
            echo $cod;
            $sql='SELECT cod,nombre, nombre_corto,descripcion,PVP FROM producto WHERE cod="'.$cod.'"';
            echo $sql;
            //$resultado=$dwes->query($sql);
            $resultado=$dwes->prepare($sql);
            $resultado->setFetchMode(PDO::FETCH_OBJ);
            $resultado->execute();
            
            if ($resultado){
                
                if ($resultado->rowCount()==1){
                        
                    while ($row=$resultado->fetch()){
                        echo '<input type="hidden" value="'.$row->cod.'" name="cod"/>';
                        
                        echo '<fieldset><legend>Nombre corto:</legend><input type="text" value="'.$row->nombre_corto.'" name="nomcorto" size=48/></fieldset><br>';
                        echo '<fieldset><legend>Nombre:     </legend><textarea name="nombre" rows="4" cols="50">'.$row->nombre.'</textarea></fieldset>';
                        echo "<fieldset><legend>Descripción:</legend><textarea name=".'"'."descripcion".'"'." rows='7' cols='50'>$row->descripcion</textarea></fieldset>";
                        echo "<fieldset><legend>PVP:</legend><input type=".'"'."text".'"'.'value="'."$row->PVP".'"'." name=".'"'."pvp".'"'."/></fieldset><br>";
                    }
                }else{
                    echo "<fieldset><legend>El artículo no existe</legend></fieldset>";
                }
            }else{
                echo "<fieldset><legend>Error en la consulta</legend></fieldset>";
            }
            
         ?>        
   
            <input type="submit" value="Actualizar" name="Actualizar"/>
            <input type="submit" value="Cancelar" name="Cancelar"/>
        </form>

    </div>

</body>
</html>