<?php
    include_once("tietokanta2.php");

    $haeAsiakirjaID = "SELECT asiakirja_id, otsikko FROM asiakirja";

    $tulos = $yhteys->query($haeAsiakirjaID);
    if ($tulos->num_rows > 0) {
        while($rivi = $tulos->fetch_assoc()) {
            echo "<option value=\"".$rivi["asiakirja_id"]."\">"
            .$rivi["otsikko"]."</option>";
        }
    }

    $yhteys->close();
?>