<!DOCTYPE html>
<html>
    <head>
        <title>Juhon neuvontapalsta</title>
        <link rel="stylesheet" type="text/css" href="neuvontapalsta.css"/>
        <link href="https://fonts.googleapis.com/css2?family=Andika+New+Basic&family=Anton&display=swap" rel="stylesheet"/>
    </head>
    <body>
        <div id="wrapper">
            <nav>
                <h3 class="logo">
                    <a href="http://localhost/php/neuvontapalsta.php">
                        Neuvontapalsta
                    </a>
                </h3>
                <h3 class="kirjaudu">
                    <a href="http://localhost/php/kirjaudu.php">
                        Kirjaudu
                    </a>
                </h3>
                <h3 class="rekisteroidy">
                    <a href="http://localhost/php/rekisteroidy.php">
                        Rekisteröidy
                    </a>
                </h3>
            </nav>
            <div class="rekisteroidy-kayttajaksi">
                <h1>
                    Rekisteröidy käyttäjäksi
                </h1>
                <form action="rekisteroidy.php" method="post">
                    <label for="nimimerkki">Anna nimimerkki</label>
                    <input type="text" name="nimimerkki" id="nimimerkki" placeholder="nimimerkki">
                    <label for="sposti">Anna sähköpostiosoitteesi</label>
                    <input type="text" name="sposti" id="sposti" placeholder="sähköposti">
                    <label for="salsana">Anna salasana</label>
                    <input type="password" name="salasana" id="salsana" placeholder="salasana">
                    <input type="submit" name="laheta">
                </form>
                <?php
                    include_once("tietokantayhteys2.php");
                    
                    if (isset($_POST["laheta"])) {
                        $nimimerkki = $_POST["nimimerkki"];
                        $sposti = $_POST["sposti"];
                        $salasana = $_POST["salasana"];

                        $nmki = strip_tags($nimimerkki);
                        $spsti = strip_tags($sposti);
                        $slsna = strip_tags($salasana);

                        $tNimimerkki = trim($nmki);
                        $tSposti = trim($spsti);
                        $tSalasana = trim($slsna);

                        if (strlen($tNimimerkki) > 0 && strlen($tSposti) > 0 && strlen($tSalasana) > 6) {
                            $hashSalasana = sha1($tSalasana);

                            $vieKayttaja = "INSERT INTO kayttajat
                            (nimimerkki, salasana, sposti) VALUES
                            ('$tNimimerkki', '$hashSalasana', '$tSposti')";

                            $tulos = $yhteys->query($vieKayttaja);
                            if ($tulos === TRUE) {
                                echo "<p class=\"lahetetty\">Käyttäjä rekisteröity
                                onnistuneesti sisään, ole hyvä ja kirjaudu sisään!";
                            } else {
                                echo "<p class=\"tayta\">Jokin meni pieleen</p>".$yhteys->error;
                            }
                        } else {
                            echo "<p class=\"tayta\">**Täytä kaikki kentät
                            (Salasana pitää olla pidempi, kuin 6 merkkiä)!**</p>";     
                        }
                    }

                    $yhteys->close();
                ?>
            </div>
            <footer>
                <h4>
                    ©2020 Juhon neuvontapalsta
                </h4>
            </footer>
        </div>
    </body>
</html>