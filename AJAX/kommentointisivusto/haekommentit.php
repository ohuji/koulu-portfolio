<?php
    include_once("tietokanta2.php");

    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $haeKommentti = "SELECT * FROM kommentti
        WHERE asiakirja_id = '$id'";

        $tulos = $yhteys->query($haeKommentti);
        if ($tulos->num_rows > 0) {
            while($rivi = $tulos->fetch_assoc()) {
                echo "<div class=\"kommentti\"><p class=\"kommentoijainfo\">";
                echo $rivi["kommentoija"]." (".$rivi["pvm"].")</p>";
                echo "<h2>".$rivi["otsikko"]."</h2>";
                echo "<div class=\"kommenttisisalto\"><p>".$rivi["teksti"]."</p></div></div>";
            }
            echo "<div id=\"lisaa-kommentti\">";
            echo "<h2>Lisää oma kommenttisi</h2>";
            echo "<p><span class=\"kommentti-label\">Nimi tai nimimerkki:</span> <input type=\"text\" id=\"kommenttinimimerkki\" size=\"30\"></p>";
            echo "<p><span class=\"kommentti-label\">Kommenttiotsikko:</span> <input type=\"text\" id=\"kommenttiotsikko\" size=\"30\"></p>";
            echo "<p><textarea id=\"kommenttiteksti\" cols=\"60\" rows=\"10\"></textarea></p>";
            echo "<p><button id=\"laheta-kommentti\">Laheta</button></p>";
            echo "</div>";
        } else {
            echo "<div id=\"lisaa-kommentti\">";
            echo "<h2>Lisää oma kommenttisi</h2>";
            echo "<p><span class=\"kommentti-label\">Nimi tai nimimerkki:</span> <input type=\"text\" id=\"kommenttinimimerkki\" size=\"30\"></p>";
            echo "<p><span class=\"kommentti-label\">Kommenttiotsikko:</span> <input type=\"text\" id=\"kommenttiotsikko\" size=\"30\"></p>";
            echo "<p><textarea id=\"kommenttiteksti\" cols=\"60\" rows=\"10\"></textarea></p>";
            echo "<p><button id=\"laheta-kommentti\">Lähetä</button></p>";
            echo "</div>";
        }
    } 

    $yhteys->close();
?>