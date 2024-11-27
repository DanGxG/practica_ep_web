<?php
header("Content-Type: text/html;charset=utf-8");

if (isset($_POST["opcio"]))
{
	$opcio = $_POST["opcio"];
	switch ($opcio)
	{
		case "altaSoci":
			include_once("altaSoci.html");
			break;

		/*
		case "baixaSoci":
			include_once("baixaSoci.html");
			break;
			
		case "reservarPista":
			include_once("reservarPista.html");
			break;
		
		case "cancelarReserva":
			include_once("cancelarReserva.html");
			break;
		*/
		case "ocuparReserva":
			include_once("ocuparReserva.html");
			break;

		case "llistatDiari":
			include_once("llistatDiari.html");
			break;

		case "llistatSocis":
			include_once("llistatSocis.html");
			break;
			
		default:
			echo "<br>ERROR: Opció no disponible<br>";
	}
}
?>