<?php
header("Content-Type: text/html;charset=utf-8");
include_once("./classes/control.php");
include_once("./classes/vista.php");



if (isset($_POST["opcio"]))
{
	
	$opcio = $_POST["opcio"];
	$v = new Vista();
	switch ($opcio)
	{
		case "Alta Soci":
		{
			if (isset($_POST["DNI"]) and isset($_POST["nom"]) and isset($_POST["cognoms"]) and isset($_POST["nivell"]))
			{
				$DNI = $_POST["DNI"];
				$nom = $_POST["nom"];	
				$cognoms = $_POST["cognoms"];
				$nivell = $_POST["nivell"];
				
				$c = new Control();
				$res = $c->altaSoci($DNI, $nom, $cognoms, $nivell);
				
				$v->mostrarCapsalera('');
				$v->mostrarMissatge($res);
				$v->mostrarPeu();
			}
			else
			{
				$v->mostrarCapsalera('');
				$v->mostrarMissatge('Falten dades per informar');
				$v->mostrarPeu();
			}
			break;	
		}

		case "login";
		{
			if(isset($_POST["contrasenya"]))
			{
				$contrasenya = $_POST["contrasenya"];
				$c = new Control();
				$res = $c->login($contrasenya);
				if ($res =="Login correcte")
				{
					include_once("ferLlistatdiari.html");
				}
				else{
					$v = new Vista();
					$v->mostrarCapsalera("");
					$v->mostrarError($res);
					$v->mostrarPeu();
				}
			}
			break;
		}

		case "llistatDiari":
		{
			
			if (isset($_POST["data"]))
			{
				$data = $_POST["data"];				
								
				$c = new Control();
				$llistat = $c->llistatDiari($data);
				if ($llistat<>"")
				{
					$v->mostrarCapsalera('LLISTAT DE RESERVES' );
					$v->mostrarLlistatDiari ($llistat);
				}
				else
				{
					$v->mostrarCapsalera("");
					$v->mostrarError("ERROR: no hi ha cap reserva per al dia $data");
				}
				
				$v->mostrarPeu();
			}
			break;	
		}

		case "ocuparReserva":
		{
			if (isset($_POST["DNI"]) and isset($_POST["duo"]) )
			{
				$DNI = $_POST["DNI"];
				$prova = $_POST["duo"];
				$duo = explode('|',$_POST["duo"]); //per recuperar dos valors amb un sol input
				$idPista = $duo[0];
				$datahora = $duo[1];
				$c = new Control();
				$res = $c->ocuparReserva($idPista, $datahora, $DNI);
				
				$v->mostrarCapsalera('');
				$v->mostrarMissatge($res);
				$v->mostrarPeu();
			}
			else
			{
				$v->mostrarCapsalera('');
				$v->mostrarError('ERROR: El soci no te aquesta reserva feta');
				$v->mostrarPeu();
			}
			break;
		} 
		
/*****************************************************************************/
	}
}

	



