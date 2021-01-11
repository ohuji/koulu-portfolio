<?php
    include_once("tietokanta3.php");

    $haeViestit = "SELECT * FROM viesti ORDER BY aika DESC LIMIT 20";

    $tulos = $yhteys->query($haeViestit);
    if ($tulos->num_rows > 0) {
        while($rivi = $tulos->fetch_assoc()) {
            $date = $rivi["aika"];
            echo "<div class=\"viesti\"><h4>".$rivi["nimi"].
            " [".date("H:i", strtotime($date))."]</h4>";
            echo "<p class=\"teksti\">".$rivi["sisalto"]."</p></div>";
        }
    }

    $yhteys->close();
?>