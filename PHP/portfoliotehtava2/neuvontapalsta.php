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
            <div id="content">
                <div class="menu">
                    <div class="menu-title">
                        <h3>
                            Kategoriat
                        </h3>
                    </div>
                    <div class="menu-item">
                        <p>
                            <a href="http://localhost/php/kategoria.php?kategoria=videopelit">
                                Videopelit
                            </a>
                        </p>
                    </div>
                    <div class="menu-item">
                        <p>
                            <a href="http://localhost/php/kategoria.php?kategoria=urheilu">
                                Urheilu
                            </a>
                        </p>
                    </div>
                    <div class="menu-item">
                        <p>
                            <a href="http://localhost/php/kategoria.php?kategoria=autot">
                                Autot
                            </a>
                        </p>
                    </div>
                    <div class="menu-item">
                        <p>
                            <a href="http://localhost/php/kategoria.php?kategoria=kamppailulajit">
                                Kamppailulajit
                            </a>
                        </p>
                    </div>
                </div>
                <div class="kysy">
                    <h1>Kysy kysymys</h1>
                    <p>Voit kysyä minkä tahansa kysymyksen rekisteröitymällä
                        /kirjautumalla sisään. Alla voit täyttää kysymys lomakkeen.
                    </p>
                    <form method="post" action="neuvontapalsta.php">
                        <label for="otsikko">Anna otsikko</label>
                        <input type="text" name="otsikko" id="otsikko" placeholder="otsikko">
                        <label for="kategoria">Valitse kategoria</label>
                        <select name="kategoria">
                            <option value="videopelit">Videopelit</option>
                            <option value="urheilu">Urheilu</option>
                            <option value="autot">Autot</option>
                            <option value="kamppailulajit">Kamppailulajit</option>
                        </select>
                        <label for="kysymys">Kysymyksesi</label>
                        <textarea name="kysymys" id="kysymys"></textarea>
                        <input type="submit" name="laheta">
                    </form>
                    <?php

                        if (isset($_POST["laheta"])) {
                            if (isset($_SESSION["nimimerkki"])) {
                                $nimimerkki = $_SESSION["nimimerkki"];
                                $otsikko = $_POST["otsikko"];
                                $kategoria = $_POST["kategoria"];
                                $sisalto = $_POST["kysymys"];
                                $date = date("Y-m-d H:i:s");

                                $otk = strip_tags($otsikko);
                                $slto = strip_tags($sisalto);

                                $tOtsikko = trim($otk);
                                $tSisalto = trim($slto);

                                if (strlen($tOtsikko) > 0 && strlen($tSisalto) > 0) {
                                    $vieKysymys = "INSERT INTO kysymykset
                                    (kategoria, otsikko, julkaisuaika, sisalto, nimimerkki)
                                    VALUES ('$kategoria', '$tOtsikko', '$date', '$tSisalto', '$nimimerkki')";

                                    $tulos = $yhteys->query($vieKysymys);
                                    if ($tulos === TRUE) {
                                        echo "<p class=\"lahetetty\">Kysymyksesi on lähetetty!</p>";
                                    } else {
                                        echo "<p class=\"tayta\">Jokin meni pieleen</p>".$yhteys->error;
                                    }
                                } else {
                                    echo "<p class=\"tayta\">**Täytä kaikki kentät!**</p>";
                                }

                            } else {
                                header("Location: http://localhost/php/kirjaudu.php/");
                                die();
                            }
                        }

                        $yhteys->close();
                    ?>
                </div>
            </div>
            <footer>
                <h4>
                    ©2020 Juhon neuvontapalsta
                </h4>
            </footer>
        </div>
    </body>
</html>