<?php
//Classe de VISTA encarregada de formatejar la sortida de dades

class Vista
{
    public function mostrarError ($missatge)
    {
        echo "<table bgcolor=grey align=center border = 1 cellpadding = 10>";
        echo "<tr><td><br><h2> $missatge </h2><br><br></td></tr>";
        echo "</table>";		
    }

    public function mostrarCapsalera($titol)
    {
        echo ('<!DOCTYPE HTML><html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <title> GESTIÓ DE PISTES DE PÀDEL </title>
                    </head>
                    <body>
                        <center>
                        <br> <h1>' . $titol . '</h1><br><br>');
    }

    public function mostrarMissatge ($missatge)
    {
        echo "<table bgcolor=#ffffb7 align=center border = 1 cellpadding = 10>";
        echo "<tr><td><br><h2> $missatge </h2><br><br></td></tr>";
        echo "</table>";		
    }

    public function mostrarPeu()
    {
        echo ('<br><a href="index.html"> Tornar </a></center></body></html>');
    }

    private function formatData($data)
    {
        //Canvia el format a dia-mes-any hora:minit:segon
        date_default_timezone_set("europe/Madrid");
        $dataOk = date_create($data);
        $dataOk = date_format($dataOk,'d-m-Y H:i:s'); 
        return $dataOk;
    }
    public function mostrarLlistatDiari ($llistat)
    {
        $data = $llistat[0]['data'];

        $data = $this->formatData($data);
        
        $res = "<h2>Data del llistat: $data</h2><hr><br>";

        $res = $res . "<table border=1><tr bgcolor='lightgray'>
                            <th>DNI</th>
                            <th>Nom</th>
                            <th>Cognoms</th>
                            <th>idPista</th>
                            <th>Hora</th>
                            <th>Ocupació</th>
                        </tr> ";
        /******** VERSIÓ 1 *************************************************************
        $i= 0;               
        foreach ($llistat as $reserva)
        {
            if ($i>=1 && $i < count($llistat) - 1)
            {
                $res = $res . "<tr>";
                            
                $DNI = $reserva["DNI"];
                $nom = $reserva["nom"];
                $cognoms = $reserva["cognoms"];
                $idPista = $reserva["idPista"];
                $datahora = $reserva["datahora"];
                $ocupacio = $reserva["ocupacio"];

                $res = $res . "<td>$DNI</td>";
                $res = $res . "<td>$nom</td>";
                $res = $res . "<td>$cognoms</td>";
                $res = $res . "<td>$idPista</td>";
                if ($ocupacio) 
                {
                    $res = $res . "<td>Ocupada</td>";
                }
                else
                {
                    $res = $res . "<td>No ocupada</td>";
                }
            }
            $i++;
        }
        $res = $res . "</table>";
        $i--;
        ********************************************************************************/

        //Versió alternativa ////////////////////////////////////////////////////////////
        for ($i = 1; $i < count($llistat)-1; $i++)
        {
            $res = $res . "<tr>";
                            
            $DNI = $llistat[$i]["DNI"];
            $nom = $llistat[$i]["nom"];
            $cognoms = $llistat[$i]["cognoms"];
            $idPista = $llistat[$i]["idPista"];
            $datahora = $llistat[$i]["datahora"];
            $ocupacio = $llistat[$i]["ocupacio"];

            $res = $res . "<td>$DNI</td>";
            $res = $res . "<td>$nom</td>";
            $res = $res . "<td>$cognoms</td>";
            $res = $res . "<td>$idPista</td>";
            $dataok= $this->formatData($datahora);
            $res = $res . "<td>$dataok</td>";
            if ($ocupacio) 
            {
                $res = $res . "<td>Ocupada</td>";
            }
            else
            {
                $res = $res . "<td>No ocupada</td>";
            }    
        }
        $res = $res . "</table>";
        ///////////////////////////////////////////////////////////////////////////////

        $numReserves = $llistat[$i]['numReserves'];

        $res = $res . "<h2>Número de reserves del dia: $numReserves</h2><br>";
        echo ($res);  
    }


    //Si el segon paràmetre és TRUE, mostrarà botons de radio per a triar una serie
    public function mostrarLlistatSocis ($llistaSocis, $triar)
    {
        $res="<table border=1><tr bgcolor='lightgray'>
                            <th>DNI</th>
                            <th>Nom</th>
                            <th>Cognom</th>
                            <th>Nivell</th>";
        if ($triar)
        {
            $res = $res . "<th>Seleccionar</th>";
        }
        $res = $res . "</tr> ";
                        
        foreach ($llistaSocis as $soci)
        {
            $res = $res . "<tr>";
            $DNI = $soci["DNI"];
            $nom = $soci["nom"];
            $cognoms = $soci["cognoms"];
            $nivell = $soci["nivell"];
            
            $res = $res . "<td>$DNI</td>";
            $res = $res . "<td>$nom</td>";
            $res = $res . "<td>$cognoms</td>";
            $res = $res . "<td>$nivell</td>";
            if ($triar)
            {
                $res = $res . "<td><input type='radio' name='DNI' value='$DNI'></td>";
            }
        }
        $res = $res . "</table>";
        echo ($res);
    }


    //Si el segon paràmetre és TRUE, mostrarà botons de radio per a triar una serie
    public function mostrarLlistatReservesNoOcupades ($llistaReserves, $triar)
    {
        $res="<table border=1><tr bgcolor='lightgray'>
                            <th>Pista</th>
                            <th>data</th>";
        if ($triar)
        {
            $res = $res . "<th>Seleccionar</th>";
        }
        $res = $res . "</tr> ";
                        
        foreach ($llistaReserves as $reserva)
        {
            $res = $res . "<tr>";
            $idPista = $reserva["idPista"];
            $datahora = $reserva["datahora"];
            $datahora = $this->formatData($datahora);
            $res = $res . "<td>$idPista</td>";
            $res = $res . "<td>$datahora</td>";
            if ($triar)
            {
                $duo = $idPista."|".$datahora; //per retornar dos valors amb un sol input
                $res = $res . "<td><input type='radio' name='duo' value='$duo'></td>";
            }
        }
        $res = $res . "</table>";
        echo ($res);
    }

/**************************************************************************************/

}