<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="dwes.css" rel="stylesheet" type="text/css">
    <title>DWES03</title>
</head>
<body>
    <div id="encabezado">
        <h1>Tarea:  Listado de productos de un familia</h1>
        <form id="form_seleccion" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <span>Familia:</span>
        <select name="familia">
        <?php 
            echo $familia;
            if (isset($_POST['familia'])) $familia = $_POST['familia'];
            $dwes = new PDO('mysql:host=localhost;dbname=dwes', 'dwes', 'abc123.');
            $sql = "SELECT cod, nombre FROM familia";
            $resultado=$dwes->query($sql);
            
                if ($resultado){
                    $row=$resultado->fetch();
                    while($row!=null){
                        echo "<option value='${row['cod']}'";
                        // Si se recibió un código de familia lo seleccionamos
                        // en el desplegable usando selected='true'
                        if (isset($familia) && $familia == $row['cod'])
                        echo " selected='true'";
                        echo ">${row['nombre']}</option>";
                        $row = $resultado->fetch();
                    }
                } 
        ?>
        </select> 
            <input type="submit" value="Mostrar Productos" name="enviar"/>  
        </form>
    </div>
    <div id="contenido">
        <h2>Productos de la familia:</h2>
        <?php
        //Si recibimos un cod de familia
        //Mostramos los productos de la familia seleccionada
        if (isset($familia)){
            $sql="SELECT producto.cod,producto.nombre,producto.nombre_corto,PVP FROM producto INNER JOIN familia ON producto.familia=familia.cod WHERE producto.familia='$familia'";
            $resultado=$dwes->query($sql);
            
            if($resultado){
                $row=$resultado->fetch();
                while($row!=null){
                    /*<form id="form_seleccion" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">*/
                    //echo "<p>Producto : ${row['nombre']}, ${row['nombre_corto']}, ${row['PVP']}</p>";
                    //echo "<p>Producto : ${row['nombre']}, ${row['nombre_corto']}, ${row['PVP']} <input type=".'"'."submit ".'"'.'value="'."Editar".'"'." name=".'"'."editar".'"'."/></p>";
                    echo "<form id=".'"'."form_producto".'"'.'action="'."editar.php".'"'."method=".'"'."get".'"'."/>";
                    //echo '<p>Producto : '. $row['cod'].'</p>';
                    echo '<input type="hidden" name="cod" value="'. $row['cod'].'"/>';
                    echo "<p>Producto : ${row['nombre_corto']}, ${row['PVP']} <input type=".'"'."submit".'"'.'value="'."Editar".'"'." name=".'"'."editar".'"'."/></p>";
                    echo "</form>";
                    $row=$resultado->fetch();
                } 
            }
        }
        ?>
    </div>
    <div id="pie">
        <?php
            unset($dwes);
        ?>
    </div>
</body>
</html>