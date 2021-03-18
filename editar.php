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
    
    if(isset($_POST['cod'])) $cod=$_POST['cod'];
    
    $dwes = new PDO('mysql:host=localhost;dbname=dwes', 'dwes', 'abc123.');
    //Comprobamos si debemos actualiar

    if (isset($_POST['Actualizar'])){

        //Preparamos la consulta
        $nomcorto=$_POST['nomcorto'];
        $nombre=$_POST['nombre'];
        $descripcion=$_POST['descripcion'];
        $pvp=$_POST['pvp'];
        
        $sql="UPDATE producto set nombre=:nombre, nombre_corto=:nomcorto, descripcion=:descripcion, PVP=:pvp WHERE cod=$cod";
        $consulta=$dwes->prepare($sql);

        //Ejecutamos la consulta
        $consulta=bindParam("nombre",$nombre);
        $consulta=bindParam("nombre_corto",$nomcorto);
        $consulta=bindParam("descripcion",$descripcion);
        $consulta=bindParam("PVP",$pvp);
    }
    
    ?>
    <div id="encabezado">
        <h1>Tarea: edición de un producto</h1>
    </div>
    <div id="contenido">

         <h1>Producto:</h1><br>
         <form id="form_actualizar" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
         <?php
            $sql="SELECT FROM cod,nombre, nombre_corto,descripcion,PVP, familia WHERE cod=$cod";
            $resultado=$dwes->query($sql);

            if ($resultado){
                $row=$resultado->fetch();
                while ($row!=null){
                    echo "<input type=".'"'."hidden".'"'.'value="'."$cod".'"'." name=".'"'."cod".'"'."/>";
                    echo "<fieldset><legend>Nombre corto:</legend><input type=".'"'."text".'"'.'value="'."$nomcorto".'"'." name=".'"'."nomcorto".'"'."/></fieldset><br>";
                    echo "<fieldset><legend>Nombre:</legend><textarea name=".'"'."descripcion rows='4' cols='50'>$nombre</textarea></fieldset>";
                    echo "<fieldset><legend>Descripción:</legend><textarea name=".'"'."descripcion rows='7' cols='50'>$descripcion</textarea></fieldset>";
                    echo "<fieldset><legend>PVP:</legend><input type=".'"'."text".'"'.'value="'."$pvp".'"'." name=".'"'."pvp".'"'."/></fieldset><br>";
                }
            }


            
         ?>        
   
            <input type="submit" value="Actualizar" name="Actualizar"/>
            <input type="submit" value="Cancelar" name="Cancelar"/>
        </form>

    </div>

</body>
</html>