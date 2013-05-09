<!DOCTYPE html>
<?php include("../php/AccessControl.php"); ?>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Inventarios</title>
        <link rel="stylesheet" type="text/css" href="../css/ventas.css" />
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />   

    </head>    
    <body>
        <?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
            <nav>
                <div class="button" onclick="redirect('compras_mp.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Compras Pendientes</div>
                <div class="button" onclick="redirect('gestion_ma.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión de Materia Prima</div>
                <div class="selected-button" onclick="redirect('ingresar_ma.php');"><img src="../img/note.png"  alt="Icono" class="img-icon" />Ingresar Materia Prima</div>
                <div class="button" onclick="redirect('gestion_p.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión de Productos</div>
                <div class="button" onclick="redirect('reportes_ma.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes de Materia Prima</div>
                <div class="button" onclick="redirect('reportes_p.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes de Productos</div>
            </nav>  

            <div id="all-content">
				
                <h2 id="titulo">Ingresar Materia Prima</h2>

                <div id="content">
                    <form id="altaMA" action="AgregarMA.php"name="altaMA" method ="POST">
    					<div class="box">
                            
    					<table>

                            <tr>
                               <td style="color: white;">Nombre: </td>
                               <td>
                            <?php
                                include("../php/DataConnection.class.php");
                                include("../php/Validations.class.php");
                                $db = new DataConnection();
                                $result = $db->executeQuery("SELECT * FROM materiaprima;");
                                $name = "name";
                                
                                echo "<select  style= 'width:160px;' id='".$name."' name='".$name."'>";
                                while( $dato = mysql_fetch_assoc($result) ){
                                    echo "<option value='".$dato["Nombre"]."'>".$dato["Nombre"]."</option>";
                                }
                                echo "</select>";
                            ?></td>
                            </tr>

    						<tr>
    						   <td style="color: white;">Proveedor: </td>
    						   <td>
                            <?php
                                include("../php/DataConnection.class.php");
                                include("../php/Validations.class.php");
                                $db = new DataConnection();
                                $result = $db->executeQuery("SELECT * FROM Proveedor;");
                                $name = "provider";
                                
                                echo "<select  style= 'width:160px;' id='".$name."' name='".$name."'>";
                                while( $dato = mysql_fetch_assoc($result) ){
                                    echo "<option value='".$dato["Nombre"]."'>".$dato["Nombre"]."</option>";
                                }
                                echo "</select>";
                            ?></td>
    						</tr>

    						<tr>
    							<td style="color: white;">Cantidad: </td>
    							<td>
                                    <input type="text" style="width:150px;" id="cantidad" onblur="valida(this.value,'cant','numero');" name="cantidad" min="0" max="10000">
                                    <span id="cant"></span>
                                </td>
    						</tr>

    						<tr>
    							<td style="color: white;">Precio por unidad:</td>
    							<td>
                                    <input type="text" style="width:150px;" id="precio" onblur="valida(this.value,'prec','numero');"  name="precio" min="0" max="10000"> 
                                    <span id="prec"></span>
                                </td>
    						</tr>

    						<tr>
    						   <td style="color: white;">Fecha inicial: </td>
    						   <td><input type="text" style="width:150px;"id="from" name="from" placeholder="Fecha de inicio"/></td>  
    						</tr>
    						<tr>
    						   <td style="color: white;">Fecha de caducidad: </td>
    						   <td><input type="text" style="width:150px;"id="to" name="to" placeholder="Fecha de inicio"/></td>   
    						</tr>
    					</table>
    					</div>
                        <div class="box">
                            <div id="buttonOK" class="form-button" onclick="agregarMA();">Agregar</div>
                            <div class="form-button" onclick="redirect('gestion_ma.php')">Cancelar</div>   
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
        include("../php/Materia_Prima.class.php");
        $ma = $_GET["id"];
        $encontrado = MateriaPrima::findById($ma);

?>
    <script type="text/javascript">


        document.getElementById('name').value = "<?php echo $encontrado->getNombre(); ?>"
        document.getElementById('name').disabled="disabled";
        document.getElementById('provider').value = "<?php echo $encontrado->getProveedor(); ?>";
        document.getElementById('provider').disabled="disabled";        
        document.getElementById('cantidad').value = "<?php echo $encontrado->getCantidad(); ?>";
        document.getElementById('precio').value = "<?php echo $encontrado->getUniad(); ?>";
        document.getElementById('from').value = "<?php echo $encontrado->getFechaL(); ?>";
        document.getElementById('to').value = "<?php echo $encontrado->getFechaC(); ?>";     


        document.getElementById('titulo').innerHTML = "Agregar Materia Prima";
        document.getElementById('buttonOK').innerHTML = "Agregar a Inventario";

        modify = true;
    </script>

<?php
    }
?>
<?php include("scripts.php"); ?>

<script type="text/javascript">
    /* Agrega el empleado a la base de datos */
    function valida( str, target, validate ){

         if ( validate == "numero" ){
            str = str.trim();
            if ( str.length == 0 ){
                document.getElementById(target).innerHTML = "<img src='../img/error.png' />";   
            }
            else{
                //document.write(/^\d+\.?\d*$/.test('15.22'));
                var re = /^\d+\.?\d*$/;
                ok = re.exec(str);
                if ( !ok ){
                    document.getElementById(target).innerHTML = "<img src='../img/error.png' />";   
                }else{
                    document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
                }
            }
        }
    }
    function ValidaSoloNumeros() {
 if ((event.keyCode < 48) || (event.keyCode > 57))
  event.returnValue = false;
}

    function agregarMA(){

        alert("<?php echo $encontrado->getIdCompra(); ?>" );

        parametros = "idc=" + "<?php echo $encontrado->getIdCompra(); ?>" + "&";
        parametros+= "nombre=" + document.getElementById('name').value + "&";
        parametros+= "proveedor=" + document.getElementById('provider').value + "&";
        parametros+= "cantidad=" + document.getElementById('cantidad').value + "&";
        parametros+= "precio=" + document.getElementById('precio').value + "&";
        parametros+= "fecha_l=" + document.getElementById('from').value + "&";
        parametros+= "fecha_c=" + document.getElementById('to').value;


        if ( modify ){

            parametros +="&edit=1";
        }

        parametros = parametros.replace("#","%23");
        alert(parametros);
        sendPetitionQuery("AgregarMA.php?" + encodeURI(parametros));
        console.log("AgregarMA.php?" + encodeURI(parametros));
        /* returnedValue almacena el valor que devolvio el archivo PHP */
            if ( modify ){
                alert("Materia Prima editada correctamente");
            }else{
                alert("Materia Prima agregada correctamente");
            }
            window.location = "/gestion_ma.php";
        

        window.location = "gestion_ma.php";
        //alert(returnedValue);
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
        $(function () {
            var dates = $("#from, #to").datepicker
            (
                {

                    defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 1,
                    dateFormat: 'yy/mm/dd',

                    onSelect: function (selectedDate) {
                        var option = this.id == "from" ? "minDate" : "maxDate",
                            instance = $(this).data("datepicker"),
                            date = $.datepicker.parseDate(
                                instance.settings.dateFormat ||
                                $.datepicker._defaults.dateFormat,
                                selectedDate, instance.settings);
                        dates.not(this).datepicker("option", option, date);
                    }
                }
            );
        });
</script> 
<script type="text/javascript" src="../js/jquery-1.5.1.js"></script>
<script type="text/javascript" src="../js/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../js/navigation.js"></script>      