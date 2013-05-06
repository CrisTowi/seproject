<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Inventarios</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="/resources/demos/style.css" />

        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

    </head>    
    <body>
        <?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
            <nav>
                <div class="button" onclick="redirect('compras_mp.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Compras Pendientes</div>
                <div class="button" onclick="redirect('gestion_ma.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestió de Materia Prima</div>
                <div class="button" onclick="redirect('ingresar_ma.php');"><img src="../img/note.png"  alt="Icono" class="img-icon" />Ingresar Materia Prima</div>
                <div class="button" onclick="redirect('gestion_p.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión de Productos</div>
                <div class="button" onclick="redirect('reportes_ma.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes de Materia Prima</div>
                <div class="button" onclick="redirect('reportes_p.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes de Productos</div>
            </nav>  

            <div id="all-content">
				
                <h2 id="titulo">Ingresar Producto</h2>

                <div id="content">
                    <form id="altaProd" action="AgregarProducto.php"name="altaProd" method ="POST">
    					<div class="box">
    					<table>

    						<tr>
    						   <td style="color: white;">Nombre: </td>
    						   <td><input type="text" style="width:150px;" id="name" name="name" placeholder="Escriba su nombre"/></td>
    						</tr>

    						<tr>
    						   <td style="color: white;">Lote: </td>
    						   <td>
                            <?php
                                include("../php/DataConnection.class.php");
                                include("../php/Validations.class.php");
                                $db = new DataConnection();
                                $result = $db->executeQuery("SELECT * FROM Lote;");
                                $name = "lote";
                                
                                echo "<select  style= 'width:160px;' id='".$name."' name='".$name."'>";
                                while( $dato = mysql_fetch_assoc($result) ){
                                    echo "<option value='".$dato["idLote"]."'>".$dato["idLote"]."</option>";
                                }
                                echo "</select>";
                            ?></td>
    						</tr>

                            <tr>
                                <td style="color: white;">Presentacion:</td>
                                <td>
                                    <select name="presentacion" id="presentacion" style="width:165px;">
                                        <option value="Fam">Paquete Familiar</option>
                                        <option value="6">Paquete c/6 Galletas</option>
                                        <option value="10">Paquete c/10 Galletas</option>
                                        <option value="Mini">Paquete mini</option>
                                    </select>
                                </td>
                            </tr>
    						<tr>
    							<td style="color: white;">Precio por unidad:</td>
    							<td>
                                    <input type="text" style="width:150px;" id="precio" name="precio" min="0" max="10000"> 
                                </td>
    						</tr>
    					</table>
    					</div>
                        <div class="box">
                            <div id="buttonOK" class="form-button" onclick="AgregarProducto();">Agregar</div>
                            <div class="form-button" onclick="redirect('gestion_p.php')">Cancelar</div>   
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<script type="text/javascript">
    var modify = false;
</script>

<?php
    /*
        Verifica si es la opcion de modificar un empleado, si lo es, agrega los scripts y carga los datos correspondientes
    */
    if ( isset($_GET["id"]) ){
        include("../php/Producto.class.php");
        $id = $_GET["id"];
        $encontrado = Producto::findById($id);

?>
    <script type="text/javascript">
    
        document.getElementById('name').value = "<?php echo $encontrado->getNombre(); ?>";
        document.getElementById('idLote').disabled="disabled";
        document.getElementById('presentacion').value = "<?php echo $encontrado->getPresentacion(); ?>";
        document.getElementById('precio').value = "<?php echo $encontrado->getPrecio(); ?>";
    
    
        document.getElementById('titulo').innerHTML = "Editar Producto";
        document.getElementById('buttonOK').innerHTML = "Editar";

        modify = true;
    </script>

<?php
    }
?>
<?php include("scripts.php"); ?>

<script type="text/javascript">
    /* Agrega el empleado a la base de datos */
    function AgregarProducto(){

        parametros = "nombre=" + document.getElementById('name').value + "&";
        parametros+= "lote=" + document.getElementById('lote').value + "&";
        parametros+= "Presentacion=" + document.getElementById('presentacion').value + "&";
        parametros+= "precio=" + document.getElementById('precio').value + "&";
        parametros+= "idp=" + "<?php echo $prod ?>";

        if ( modify ){

            parametros +="&edit=1";
        }

        parametros = parametros.replace("#","%23");

        //alert(parametros);
        sendPetitionQuery("AgregarProducto.php?" + encodeURI(parametros));
        console.log("AgregarProducto.php?" + encodeURI(parametros));
        /* returnedValue almacena el valor que devolvio el archivo PHP */
        if (returnedValue == "OK" ){
            if ( modify ){
                alert("Producto editado correctamente");
            }else{
                alert("Producto agregado correctamente");
            }
            window.location = "./gestion_p.php";
        }

        alert(returnedValue);
    }
    
</script>

<script type="text/javascript" src="../js/color.js"></script>
<script type="text/javascript" src="../js/inventarios.js"></script>
<script type="text/javascript">
        window.onload = initialize;
        window.onresize = function () { resizeWindow(document) };
        function initialize() {
            resizeWindow(document);
        }

</script> 
<script type="text/javascript" src="../js/jquery-1.5.1.js"></script>
<script type="text/javascript" src="../js/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../js/navigation.js"></script>      