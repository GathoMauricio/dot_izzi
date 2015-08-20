<?php 
$empleado[]=array("nombre"=>"juan","edad"=>5);
$empleado[]=array("nombre"=>"maria","edad"=>6);
$json=json_encode($empleado);
//printf($json);
 ?>

<script type="text/javascript">

var json =eval(<?php echo $json; ?>);

for (var i = 0; i < json.length; i++) {
	document.write(json[i].nombre+" "+json[i].edad+"<br>");
};
</script>