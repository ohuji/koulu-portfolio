<?php
    include_once("tietokanta3.php");

    if (isset($_POST["nimi"], $_POST["teksti"])) {
        $nimi = $_POST["nimi"];
        $teksti = $_POST["teksti"];
        $date = date("Y-m-d H:i:s");

        $nmi = strip_tags($nimi);
        $tki = strip_tags($teksti);

        $tNimi = trim($nmi);
        $tTeksti = trim($tki);

        if (strlen($tNimi) > 0 && strlen($tTeksti) > 0) {
            $vieViesti = "INSERT INTO viesti (nimi, aika, sisalto)
            VALUES ('$tNimi', '$date', '$tTeksti')";

            $tulos = $yhteys->query($vieViesti);
        } 
    }

    $yhteys->close();
?>