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
            <div class="kysy-ja-vastaukset">
                <?php
                    if (isset($_GET["kysymys"])) {
                        $id = $_GET["kysymys"];
                        
                        $haeKysymys = "SELECT * FROM kysymykset
                        WHERE kysymysID = '$id'";

                        $tulos = $yhteys->query($haeKysymys);
                        if ($tulos->num_rows > 0) {
                            $rivi = $tulos->fetch_assoc();
                            echo "<div class=\"kv-kysymys\"><h1 class=\"kv-otsikko\">".$rivi["otsikko"]."</h1>";
                            echo "<p class=\"kv-sisalto\">".$rivi["sisalto"]."</p>";
                            echo "<p class=\"kv-nimimerkki\">".$rivi["nimimerkki"]."</p>";
                            echo "<p class=\"kv-julkaisuaika\">".$rivi["julkaisuaika"]."</p></div>";
                        }       
                    } else {
                        echo "<h1>Kysymystä ei ole olemassa (404)</h1>";
                    }
                ?>
                <div class="vastaukset">
                    <h2>
                        Vastaukset
                    </h2>
                    <div class="vastaa">
                        <form action="kysymys.php" method="post">
                            <textarea name="vastaus-sisalto" id="vastaus-sisalto" placeholder="Kirjoita vastauksesi"></textarea>
                            <input type="hidden" name="k-id" value="<?php echo htmlspecialchars($_GET["kysymys"]);?>">
                            <input type="submit" id="v-laheta" name="laheta">
                        </form>
                        <?php
                            if (isset($_POST["laheta"])) {
                                if (isset($_SESSION["nimimerkki"])) {
                                    $nimimerkki = $_SESSION["nimimerkki"];
                                    $sisalto = $_POST["vastaus-sisalto"];
                                    $date = date("Y-m-d H:i:s");
                                    $id = $_POST["k-id"];

                                    $slto = strip_tags($sisalto);
                                    $tSisalto = trim($slto);

                                    if (strlen($tSisalto) > 0) {
                                        $vieVastaus = "INSERT INTO vastaukset
                                        (sisalto, julkaisuaika, kysymysID, nimimerkki)
                                        VALUES ('$tSisalto', '$date', '$id', '$nimimerkki')";

                                        $toinenTulos = $yhteys->query($vieVastaus);
                                        if ($toinenTulos === TRUE) {
                                            echo "<p class=\"lahetetty\">Vastauksesi on lähetetty!</p>";
                                            header("Location: http://localhost/php/kysymys.php?kysymys=".$id);
                                        } else {
                                            echo "<p class=\"tayta\">Jokin meni pieleen</p>".$yhteys->error;
                                        }
                                    } else {
                                        echo "<p class=\"tayta\">**Täytä kenttä**</p>";
                                        header("Location: http://localhost/php/kysymys.php?kysymys=".$id);
                                    }
                                } else {
                                    header("Location: http://localhost/php/kirjaudu.php/");
                                    die();
                                }
                            }
                        ?>
                    </div>
                <?php

                    $haeVastaukset = "SELECT * FROM vastaukset
                    WHERE kysymysID = '$id' ORDER BY julkaisuaika DESC";
                        
                    $kolmasTulos = $yhteys->query($haeVastaukset);
                    if ($kolmasTulos->num_rows > 0) {
                        while($rivi = $kolmasTulos->fetch_assoc()) {
                            echo "<div class=\"vastaus\"><h4>".$rivi["nimimerkki"]."</h4>";
                            echo "<p class=\"v-julkaisuaika\">".$rivi["julkaisuaika"]."</p>";
                            echo "<p class=\"v-sisalto\">".$rivi["sisalto"]."</p></div>";
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