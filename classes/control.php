<?php
header("Content-Type: text/html;charset=utf-8");

//Classe de CONTROLADOR
include_once ("soci.php");
//include_once ("pista.php");
include_once ("reserva.php");

class Control
{
	
	function __construct()
	{
		// Res aquí
	}

	///// CASOS D'US DE PRIMER NIVELL //////
	public function altaSoci ($DNI, $nom, $cognom, $nivell)
	{
		$res = "";
		$s = new Soci();
		$res = $s->altaSoci($DNI, $nom, $cognom, $nivell);
		return $res;
	}

	public function login ($password)
	{
		$res = "";
		$s = new soci();
		$res = $s->comprovarContrasenya($password);
		return ($res);
	}


	public function llistatDiari($data)
	{
		$res = "";
		$r = new reserva();
		$res = $r->llistatDiari($data);
		return ($res);
	}

	public function llistatSocis()
	{
		$res = "";
		$s = new Soci();
		$res = $s->llistatSocis();
		return($res);
	}

	public function ocuparReserva($idPista, $datahora, $DNI)
	{
		$res = "";
		$r = new reserva();
		$res = $r->ocuparReserva($idPista, $datahora, $DNI);
		return ($res);
	}

	public function llistatReservesNoOcupades()
	{
		$res = "";
		$r = new reserva();
		$res = $r->llistatReservesNoOcupades();
		return ($res);
	}

/*******************************************************************************/



}