<?php
    include_once("tietokanta2.php");

    if (strlen($_GET["id"]) > 0) {
        $id = $_GET["id"];

        $haeAsiakirja = "SELECT * FROM asiakirja
        WHERE asiakirja_id = '$id'";

        $tulos = $yhteys->query($haeAsiakirja);
        if ($tulos->num_rows > 0) {
            $rivi = $tulos->fetch_assoc();
            echo "<h2>".$rivi["otsikko"]."</h2>";
            echo "<p class=\"kirjoittaja-info\">
            <b>Kirjoittanut: </b>".$rivi["kirjoittaja"]." (".$rivi["pvm"].")</p>";
            echo "<p>".$rivi["teksti"]."</p>";
        }
    } else {
        $haeAsiakirjat = "SELECT * FROM asiakirja";
        
        $toinenTulos = $yhteys->query($haeAsiakirjat);
        if ($toinenTulos->num_rows > 0) {
            while($rivi = $toinenTulos->fetch_assoc()) {
                echo "<h2>".$rivi["otsikko"]."</h2>";
                echo "<p class=\"kirjoittaja-info\">
                <b>Kirjoittanut: </b>".$rivi["kirjoittaja"]." (".$rivi["pvm"].")</p>";
                echo "<p>".$rivi["teksti"]."</p>";
            }
        }
    }

    $yhteys->close();
?>