<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10; url=listado.php" />	
    <link rel="stylesheet" href="dwes.css" type="text/css">
    <title>DWES03</title>
</head>
<body>
    <?php
 
    if(isset($_POST['cod'])) $cod=$_POST['cod'];
    
    try {
        $dwes = new PDO('mysql:host=localhost;dbname=dwes', 'dwes', 'abc123.');
        $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch (PDOException $e) {
                $error = $e->getCode();
                $mensaje = $e->getMessage();
    }
   
    ?>
    <div id="contenido">

         <h1>Producto:</h1><br>
         <form id="form_actualizar" action="listado.php" method="post">
         <?php
            if (!isset($error)&& isset($_POST['cod'])) { 
                if (isset($_POST['Actualizar'])){

                    //Preparamos la consulta
                    $cod=$_POST['cod'];
                    $nomcorto=$_POST['nomcorto'];
                    $nombre=$_POST['nombre'];
                    $descripcion=$_POST['descripcion'];
                    $pvp=$_POST['pvp'];
                    
                    $sql="UPDATE producto set nombre=:nombre, nombre_corto=:nomcorto, descripcion=:descripcion, PVP=:pvp WHERE cod='$cod'";
          
                    $resultado=$dwes->prepare($sql);

                    //Ejecutamos la consulta
                    $resultado->bindParam(":nombre",$nombre);
                    $resultado->bindParam(":nomcorto",$nomcorto);
                    $resultado->bindParam(":descripcion",$descripcion);
                    $resultado->bindParam(":pvp",$pvp);
                    $resultado->execute();
                    echo "<h3>Se han actualizado los datos del producto</h3>"; 
                }else{
                    echo "<h3>Ha pulsado en cancelar por lo que no se han modificado el producto</h3>";
                }

                $sql='SELECT cod,nombre, nombre_corto,descripcion,PVP,familia FROM producto WHERE cod="'.$cod.'"';
                

                $resultado=$dwes->prepare($sql);
                $resultado->setFetchMode(PDO::FETCH_OBJ);
                $resultado->execute();
                
                if ($resultado){
                    
                    if ($resultado->rowCount()==1){
                            
                        while ($row=$resultado->fetch()){
                            echo '<p></p><input type="hidden" value="'.$row->cod.'" name="cod" disabled/></p>';
                            echo '<input type="hidden" value="'.$row->familia.'" name="familia"/>';
                            echo '<fieldset><legend>Nombre corto:</legend><input type="text" value="'.$row->nombre_corto.'" name="nomcorto" size=48 disabled/></fieldset><br>';
                            echo '<fieldset><legend>Nombre:     </legend><textarea name="nombre" rows="4" cols="50" disabled>'.$row->nombre.'</textarea></fieldset>';
                            echo "<fieldset><legend>Descripción:</legend><textarea name=".'"'."descripcion".'"'." rows='7' cols='50' disabled>$row->descripcion</textarea></fieldset>";
                            echo "<fieldset><legend>PVP:</legend><input type=".'"'."text".'"'.'value="'."$row->PVP".'"'." name=".'"'."pvp".'"'."disabled/></fieldset><br>";
                        }
                    }else{
                        echo "<fieldset><legend>El artículo no existe</legend></fieldset>";
                    }
                }else{
                    echo "<fieldset><legend>Error en la consulta</legend></fieldset>";
                }
            }else{
                echo"<p>Se ha producido un error! $mensaje</p>";
                unset($dwes);
            }
         ?>        
   
            <input type="submit" value="Continuar" name="Continuar"/>

        </form>

    </div>

</div>
</body>
</html>