<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
if(!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'4') == TRUE) and !(stristr($_SESSION['cargo'],'5') == TRUE) and !(stristr($_SESSION['cargo'],'8') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}  
?>
<?php
 include("../../menu.php");
 include("menu.php");
?>
<div align="center">
<div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Registro de actividades</small></h2>
</div>
</div>
<?
if(isset($_POST['submit1'])){
include("inserta.php");
}
 
else{
?>

  <div class="row-fluid">
<div class="span1"></div>
<div class="span5">
<div class="well">
  <FORM action="index.php" method="POST" name="Cursos">
           
                <label>Fecha de la actividad:<br /> 
                      <div class="input-append" >
            <input name="fecha_act" type="text" class="input input-small" value="<? echo $fecha_act; ?>" data-date-format="dd-mm-yyyy" id="fecha_act" >
  <span class="add-on"><i class="icon-calendar"></i></span>
</div> 
              </label>
              <hr>
                <label>Titulo: <br />
                <input name="actividad" type="text" id="actividad" value="<? echo $actividad; ?>" class="span10">
                </label>
               <hr>
                <label>Departamento:  <br />
                <SELECT name="departamento" onChange="submit()">
                    <OPTION><? echo $departamento; ?></OPTION>

                    <?
if (!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'5') == TRUE)) {
	  // Datos del alumno que hace la consulta. No aparece el nombre del a&ntilde;o de la nota. Se podr&iacute;a incluir.
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos  where departamento = '". $_SESSION['dpt'] ."' order by departamento asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }
}
else{
	?>
	    <OPTION>Actividades Extraescolares</OPTION>
        <OPTION>Relaciones de G�nero</OPTION>
	<?
  // Datos del alumno que hace la consulta. No aparece el nombre del a&ntilde;o de la nota. Se podr&iacute;a incluir.
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos  where departamento not like '%Admin%' and departamento not like '%Conserjeria%' and departamento not like '%Administracion%' order by departamento asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	     // echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }		
	}

	?>
                  </select>
                </label>
               <hr>
                <label>Profesor: <br />
                <SELECT multiple name='profesor[]' class="input-xlarge">
                    <?
					if($departamento == "Actividades Extraescolares"){
					echo "<OPTION>Mart&iacute;nez Mart&iacute;nez, M&ordf; Pilar</OPTION>";
					}
					elseif($departamento == "Relaciones de G�nero"){	
					$texto = "where departamento = '$departamento'";
					echo "<OPTION>Cabezas S�nchez, Esther</OPTION>";
					}
					else{$texto = "where departamento = '$departamento'";}

  $profe = mysql_query(" SELECT distinct NOMBRE FROM departamentos " . $texto. " order by NOMBRE asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {
if($departamento == "Religi�n")
{} else{
	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      //echo "$opcion1";
}

	} while($filaprofe = mysql_fetch_array($profe));
        }
	?>
                  </select>
                  </label>
                  <p class="help-block" > (*) Para seleccionar varios profesores, mant�n apretada la tecla Ctrl mientras los vas marcando con el rat�n.</p> <hr>
                    <input type="hidden" name="hoy"  value="<? $hoy = date('Y\-m\-d'); echo $hoy;?>">
                <label>Descripci&oacute;n: <br />
                <textarea name="descripcion" id="textarea" cols="35" rows="4" class="span11"><? echo $descripcion; ?></textarea>
              </label>
              
</div>
</div>
<div class="span5">
<div class="well ">          
<a href="javascript:seleccionar_todo()" class="btn btn-success">Marcar todos los Grupos</a>
<a href="javascript:deseleccionar_todo()" class="btn btn-warning pull-right">Desmarcarlos todos</a> <br />
              <br />
              <h4>Grupos de alumnos que realizan la actividad</h4>
            
<?
$curso0 = "select distinct nivel from FALUMNOS order by nivel";
$curso1 = mysql_query($curso0);
while($curso = mysql_fetch_array($curso1))
{
	echo "<br />";
$niv = $curso[0];
?>
           <? echo "<strong style='margin-right:12px;'> ".$niv." </strong>"; ?>
                <?  
$alumnos0 = "select distinct nivel, grupo from FALUMNOS where nivel = '$niv' order by grupo";

$alumnos1 = mysql_query($alumnos0);
while($alumno = mysql_fetch_array($alumnos1))
{
$grupo = $alumno[0].$alumno[1];
$nivel = $alumno[1];

?>
                  <? echo "<span style='margin-right:2px;color:#08c;'>".$nivel."</span>";?>
                  <input name="<? echo "grt".$grupo;?>" type="checkbox" id="A" value="<? echo $grupo;?>"  style="margin-right:5px;margin-top:0px;margin-bottom:2px;">
                  <? } ?>              
 <? } ?>
    <br /><br />
                <label>Justificaci�n: <br />
                <textarea name="justificacion" id="textarea" cols="35" rows="4" class="span11"><? echo $justificacion; ?></textarea>
              </label>
			   <br />
            <label>Horario: <br />
                <input name="horario" type="text" value="<? echo $horario; ?>" size="30" maxlength="64" class="input-xlarge">
              </label>        
            <input name="id" type="hidden" value="<? echo $id; ?>">
            
       
  </div>
  </div>
  </div>
  </div>
  </div>
  <br />
  <div align="center">
       <? 
		  if($modificar == '1'){?>
            <INPUT type="submit" name="submit2" value="Actualizar datos de la  Actividad" class="btn btn-primary">
  <? }
else{?>
  <? }
  if (!(date('m')>3 and date('m')<10)) {
  	if ( stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE ) {
  			echo '  <INPUT  type="submit" name="submit1" value="Registrar la Actividad" class="btn btn-primary" >';
  	}
  }
  else{
  	echo '  <INPUT  type="submit" name="submit1" value="Registrar la Actividad" class="btn btn-primary" >';
  }
  
 
  ?>


  </FORM>
  <br /><br />
  <div class="well well-large" style="width:500px;text-align:left;">
  <div style="font-weight:bold; color:#08c;">Informaci�n sobre Transporte en las Actividades.</div>
  <p>Autobusus Ricardo<br /> 952 80 86 45 (Oficina);<br /> 671 527 372 (M�vil de contacto para confirmaci�n);<br /> 649 45 70 99 (M�vil de Antonio -Due�o de la Empresa- S�lo en caso de emergencia).</p>
  </div>
  </div>
  
 
<? } ?>
<script>

function seleccionar_todo(){
	for (i=0;i<document.Cursos.elements.length;i++)
		if(document.Cursos.elements[i].type == "checkbox")	
			document.Cursos.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.Cursos.elements.length;i++)
		if(document.Cursos.elements[i].type == "checkbox")	
			document.Cursos.elements[i].checked=0
}
</script>
<? include("../../pie.php");?>
	<script>  
	$(function ()  
	{ 
		$('#fecha_act').datepicker()
		.on('changeDate', function(ev){
			$('#fecha_act').datepicker('hide');
		});
		});  
	</script>
  </BODY>
</HTML>
