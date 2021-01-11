<?php
    $palvelin = "localhost";
    $kayttaja = "root";
    $salasana = "";
    $tietokanta = "kommentointisivusto";

    $yhteys = new mysqli($palvelin, $kayttaja, $salasana, $tietokanta);

    if($yhteys->connect_error) {
        die("virhe tietokantaan yhdistäessä: ".$yhteys->connect_error);
    }

    $yhteys->set_charset("utf8");
?>