<?php
//Classe de MODEL encarregada de la gestió de la taula SOCI de la base de dades
include_once ("taccesbd.php");
class Soci
{
    private $DNI;
    private $nom;
    private $cognoms;
    private $nivell;
    

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

    public function existeixSoci ($DNI)
    {
        $res = FALSE;
        $this->abd->connectarBD();
        $SQL = "select count(*) from soci where DNI = '$DNI'";
        $res = $this->abd->consultaUnica($SQL);
        return $res;
    }

    public function altaSoci ($DNI, $nom, $cognoms, $nivell)
    {
        $res = "";
        if ($this->existeixSoci($DNI))
        {
            $res = "ERROR: El soci ja existeix al sistema";
        }
        else
        {
            $this->abd->connectarBD();
            $SQL = "insert into soci values ('$DNI','$nom','$cognoms',$nivell);";
            $correcte = $this->abd->consultaSQL($SQL);
            if ($correcte)
            {
                $res ="Soci donat d'alta correctament"; 
            }
            else
            {
                $res ="ERROR: No s'ha pogut donar d'alta al soci";
            }
        }
        return $res;
    }

    public function comprovarContrasenya ($contrasenya)
    {
        $res = "";
        $this->abd->connectarBD();
        $SQL = "select count(*) from soci where DNI = '0' and nom = '$contrasenya'";
        $res = $this->abd->consultaUnica($SQL);
        if ($res == 1)
        {
            $res = "Login correcte";
        }
        else
        {
            $res = "ERROR: contrasenya incorrecta";
        }
        $this->abd-> desconnectarBD();
        return $res;
    }

    public function llistatSocis()
    {
        $res = array();
        $this->abd->connectarBD();
        if ($this->abd->consultaSQL("SELECT DNI, nom, cognoms, nivell FROM soci where DNI <> '0'"))
        {
            $fila = $this->abd->consultaFila();
            $i = 0;
            while ($fila != null)
            {
                $res[$i]["DNI"] = $this->abd->consultaDada("DNI");
                $res[$i]["nom"] = $this->abd->consultaDada("nom");
                $res[$i]["cognoms"] = $this->abd->consultaDada("cognoms");
                $res[$i]["nivell"] = $this->abd->consultaDada("nivell");
                
                $i++;
                $fila = $this->abd->consultaFila();
            }
            $this->abd->tancarConsulta();
        }
        $this->abd->desconnectarBD();
        return $res; 
    }
/*******************************************************************************/

   

}