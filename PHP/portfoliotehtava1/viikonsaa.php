<?php
    include_once("tietokantayhteys1.php");

    if (isset($_GET["vko"])) {
        $vko = $_GET["vko"];

        $haeSaa = "SELECT * FROM saa WHERE vko = '".$vko."'";                        
        $saaTulos = $yhteys->query($haeSaa);

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><viikonsaa viikko="'.$vko.'"></viikonsaa>');

        if ($saaTulos->num_rows > 0) {
            while ($rivi = $saaTulos->fetch_assoc()) {
                $saa = $xml->addChild("saa");

                $saa->addAttribute("paiva", $rivi["paiva"]);
                $saa->addChild("lampotila", $rivi["lampotila"]);
                $saa->addChild("saatila", utf8_encode($rivi["saatila"]));
                $saa->addChild("tuulennopeus", $rivi["tuulennopeus"]); 

                $xmlTeksti = $xml->asXML();
            }
        }

        $tiedosto = fopen("../../omadata/viikonsaa.xml", "w") or 
        die("Tiedoston avaaminen ei onnistu");

        fwrite($tiedosto, $xmlTeksti);
        fclose($tiedosto);

        $yhteys->close();
    }
?>