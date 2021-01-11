<?php
    include_once("tietokanta2.php");

    if (isset($_POST["nimimerkki"], $_POST["otsikko"], $_POST["teksti"], $_POST["id"])) {
        $nimimerkki = $_POST["nimimerkki"];
        $otsikko = $_POST["otsikko"];
        $teksti = $_POST["teksti"];
        $id = $_POST["id"];
        $date = date("Y-m-d");

        $nmki = strip_tags($nimimerkki);
        $otk = strip_tags($otsikko);
        $tki = strip_tags($teksti);

        $tNimimerkki = trim($nmki);
        $tOtsikko = trim($otsikko);
        $tTeksti = trim($teksti);

        $vieKommentti = "INSERT INTO kommentti (otsikko, teksti, 
        pvm, kommentoija, asiakirja_id) VALUES ('$tOtsikko', '$tTeksti', 
        '$date', '$tNimimerkki', '$id')";

        $tulos = $yhteys->query($vieKommentti);      
    }

    $yhteys->close();
?>