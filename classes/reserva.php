<?php
//Classe de MODEL encarregada de la gestió de la taula RESERVA de la base de dades
include_once ("taccesbd.php");

class Reserva
{
    private $idPista;
    private $datahora;
    private $DNI;
    private $ocupacio;
        
    private $abd;
    
    function __construct()
    {
        $this->abd = new TAccesbd();        
        
    }

    function __destruct()
    {
        if (isset($this->abd))
        {
        unset($this->abd);
        }
    }


    public function llistatDiari($data)
    {
        $res = "";
        $this->abd->connectarBD();
        $SQL = "select count(*) as numReserves from reserva where date(datahora) = '$data'";
        $quants = $this->abd->consultaUnica($SQL);
        if ($quants > 0)
        {
            $res = array();
            //Capçalera: Afegir data
            $res[0]["data"] = $data;
            
            if ($this->abd->consultaSQL("SELECT r.DNI, s.nom, s.cognoms, r.idPista, r.datahora , r.ocupacio
                                            FROM RESERVA r INNER JOIN SOCI s ON r.DNI = s.DNI
                                            WHERE date(r.datahora) = '$data'"))
            {   
                //Cos
                $fila = $this->abd->consultaFila();
                $i=1;
                while ($fila != null)
                {
                    $res[$i]["DNI"] = $this->abd->consultaDada("DNI");
                    $res[$i]["nom"] = $this->abd->consultaDada("nom");
                    $res[$i]["cognoms"] = $this->abd->consultaDada("cognoms");
                    $res[$i]["idPista"] = $this->abd->consultaDada("idPista");
                    $res[$i]["datahora"] = $this->abd->consultaDada("datahora");
                    $res[$i]["ocupacio"] = $this->abd->consultaDada("ocupacio");
                    $i++;
                    $fila = $this->abd->consultaFila();
                }
                $this->abd->tancarConsulta();
                
                //Peu: Afegir Total
                $res[$i]["numReserves"]=$quants;
            }
        }
        $this->abd->desconnectarBD();
        return ($res);
    }


    private function comprovarDNI ($idPista, $datahora, $DNI)
    {
        $res = false;
        $this->abd->connectarBD();
        $SQL = "select count(*) as quants from reserva where idPista = $idPista and date_format(datahora,'%d-%m-%Y %h:%i:%s') = '$datahora' and DNI = '$DNI'";
        //echo ("$SQL <br>");
        $quants = $this->abd->consultaUnica($SQL);
        if ($quants > 0)
        {  
            $res = true;
        }
        return $res;
    }


    public function ocuparReserva($idPista, $datahora, $DNI)
    {
        $res = "";

        if ($this->comprovarDNI($idPista, $datahora, $DNI))
        {
            $res="A punt de l'update";
            $this->abd->connectarBD();
            $SQL = "update reserva set ocupacio = 1 where idPista = $idPista and date_format(datahora,'%d-%m-%Y %h:%i:%s') = '$datahora'";
            $correcte = $this->abd->consultaSQL($SQL);   
            if ($correcte)
            {
                $res = "Pista ocupada correctament";
            }
            else
            {
                $res = "Error en ocupar la pista";
            }
        }
        else
        {
            $res = "Aquest soci no te aquesta reserva feta";
        }
        return $res;
    }


    public function llistatReservesNoOcupades()
    {
        $res = "";
        $this->abd->connectarBD();
            $res = array();
           
            if ($this->abd->consultaSQL("SELECT idPista, datahora FROM reserva WHERE ocupacio = 0 ORDER BY datahora"))
            {   
                
                $fila = $this->abd->consultaFila();
                $i=0;
                while ($fila != null)
                {
                    $res[$i]["idPista"] = $this->abd->consultaDada("idPista");
                    $res[$i]["datahora"] = $this->abd->consultaDada("datahora");
                    $i++;
                    $fila = $this->abd->consultaFila();
                }
                $this->abd->tancarConsulta();
            }
        $this->abd->desconnectarBD();
        return ($res);
    }
/******************************************************************************************/

   
}