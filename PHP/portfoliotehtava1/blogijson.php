<?php
    include_once("tietokantayhteys1.php");

    $haeKirjoitukset = "SELECT otsikko, teksti,
    julkaisuaika, blogikirjoitus.blogi_id, 
    blogi.blogi_id, blogi.nimi, blogi.kirjoittaja 
    FROM blogikirjoitus JOIN blogi
    ON blogikirjoitus.blogi_id = blogi.blogi_id";

    $tulos = $yhteys->query($haeKirjoitukset);
    if ($tulos->num_rows > 0) {
        $rivit = array();
        while($kirjoitukset = mysqli_fetch_assoc($tulos)) {
            $rivit[] = array_map("utf8_encode", $kirjoitukset);
        }
        
        header("Content-Type: application/json; charset=UTF-8");
        $json = json_encode($rivit);
        echo $json;
    }

    $yhteys->close();
?>