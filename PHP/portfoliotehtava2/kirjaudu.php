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
                    <?php
                        session_start();
                        include_once("tietokantayhteys2.php");
                        
                        if (isset($_SESSION["nimimerkki"])) {
                            echo "<a href=\"http://localhost/php/neuvontapalsta.php?ulos\">Kirjaudu ulos</a>";

                            if (isset($_GET["ulos"])) {
                                session_unset();
                                session_destroy();
                            }
                        } else {
                            echo "<a href=\"http://localhost/php/kirjaudu.php\">Kirjaudu</a>";
                        }
                    ?>
                </h3>
                <h3 class="rekisteroidy">
                    <a href="http://localhost/php/rekisteroidy.php">
                        Rekisteröidy
                    </a>
                </h3>
            </nav>
            <div class="kirjaudu-sisaan">
                <h1>
                    Kirjaudu sisään
                </h1>
                <form action="kirjaudu.php" method="post">
                    <label for="nimimerkki">Nimimerkki:</label>
                        <input type="text" name="nimimerkki" id="nimimerkki" placeholder="nimimerkki">
                        <label for="salsana">Salasana:</label>
                        <input type="password" name="salasana" id="salsana" placeholder="salasana">
                        <input type="submit" name="laheta">
                </form>
                <?php
                
                    if (isset($_POST["laheta"])) {
                        $nimimerkki = $_POST["nimimerkki"];
                        $salasana = $_POST["salasana"];

                        $nmki = strip_tags($nimimerkki);
                        $slsna = strip_tags($salasana);

                        $tNimimerkki = trim($nmki);
                        $tSalasana = trim($slsna);

                        if (strlen($tNimimerkki) > 0 && strlen($tSalasana) > 0) {
                            $hashSalasana = sha1($tSalasana);

                            $etsiKayttaja = "SELECT kayttajaID FROM kayttajat
                            WHERE nimimerkki = '$tNimimerkki'
                            AND salasana = '$hashSalasana'";

                            $tulos = $yhteys->query($etsiKayttaja);
                            $rivi = $tulos->fetch_assoc();
                            $id = $rivi["kayttajaID"];

                            if ($id) {
                                $_SESSION["nimimerkki"] = $tNimimerkki;
                                echo "<p class=\"lahetetty\">Kirjauduttu onnistuneesti
                                sisään. Tervetuloa takaisin!";
                            } else {
                                echo "<p class=\"tayta\">Väärä käyttäjätunnus tai salasana</p>";
                            }
                        } else {
                            echo "<p class=\"tayta\">**Täytä kaikki kentät!**</p>";
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