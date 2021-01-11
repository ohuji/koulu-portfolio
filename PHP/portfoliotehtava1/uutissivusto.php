<!DOCTYPE html>
<html>
    <head>
        <title>Satuvaltakunnan tarinat</title>
        <link rel="stylesheet" type="text/css" href="uutissivusto.css"/>
    </head>
    <body>
        <div id="wrapper">
            <header>
                <h1>Satuvaltakunnan tarinat</h1>
                <h2>Uutisia lumotusta maasta</h2>
            </header>
            <div id="saa">
                <div class="saa-otsikko">
                    <?php
                        $xml = simplexml_load_file("../../omadata/viikonsaa.xml")
                        or die("Virhe XML syötteen käsittelyssä");
   
                        $vko = $xml["viikko"];

                        echo "<h3>Viikon sää - viikko ".$vko."</h3>";  
                    ?>
                </div>
                <div class="saa-content">
                    <?php    
                        foreach($xml->children() as $paiva) {          
                            echo "<div class=\"paivan-saa\"><p class=\"paiva\">".$paiva["paiva"]."</p>";
                            echo "<h3 class=\"lampotila\">".$paiva->lampotila."°C</h3>";
                            echo "<p class=\"saatila-p\">Säätila:</p>";
                            echo "<p class=\"saatila\">".utf8_decode($paiva->saatila)."</p>";
                            echo "<p class=\"tuulennopeus-p\">Tuulennopeus:</p>";
                            echo "<p class=\"tuulennopeus\">".$paiva->tuulennopeus."m/s</p></div>";
                        }
                    ?>
                </div>
                <div class="uutiset">
                    <div class="paauutiset">
                        <?php
                            include_once("tietokantayhteys1.php");

                            $haeUutiset = "SELECT * FROM uutiset";

                            $tulos = $yhteys->query($haeUutiset);
                            if ($tulos->num_rows > 0) {
                                while($rivi = $tulos->fetch_assoc()) {
                                    if ($rivi["paauutinen"] == 1) {
                                        echo "<div class=\"paauutinen\"><h3>".$rivi["otsikko"]."</h3>";
                                        echo "<p class=\"uutis-tiedot\">".$rivi["julkaisuaika"]." || ".$rivi["kirjoittaja"]."</p>";
                                        echo "<p class=\"kirjoitus\">".$rivi["sisalto"]."</p></div>";
                                    }
                                }
                            }

                        ?>
                    </div>
                    <div class="sivupaneeli">
                        <div class="uusimmat-uutiset">
                            <h3>
                                Uusimmat uutiset
                            </h3>
                            <?php
                                $toinenTulos = $yhteys->query($haeUutiset);
                                if ($toinenTulos->num_rows > 0) {
                                    while($rivi = $toinenTulos->fetch_assoc()) {
                                        echo "<div class=\"uutinen\"><h4>".$rivi["otsikko"]."</h4>";
                                        echo "<p class=\"uutis-tiedot\">".$rivi["julkaisuaika"]." || ".$rivi["kirjoittaja"]."</p></div>";
                                    }
                                }
                            ?>
                        </div>
                        <div class="blogi-kirjoitukset">
                            <h3>
                                Vierailevat kirjoittajat
                            </h3>
                            <?php
                                $json = file_get_contents("http://localhost/php/blogijson.php");

                                $blogi = json_decode($json, true);
                                
                                foreach($blogi as $kirjoitus) {
                                    echo "<div class=\"blogi-kirjoitus\"><h4>".utf8_decode($kirjoitus["nimi"]).": ".utf8_decode($kirjoitus["otsikko"])."</h4>";
                                    echo "<p class=\"kirjoittaja\">".utf8_decode($kirjoitus["kirjoittaja"])."</p>";
                                    echo "<p class=\"julkaistu\">".$kirjoitus["julkaisuaika"]."</p></div>";
                                }

                                $yhteys->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>