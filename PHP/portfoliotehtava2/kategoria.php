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
                <div class="kategoria-kysymykset">
                    <?php
                    
                        if (isset($_GET["kategoria"])) {
                            $kategoria = $_GET["kategoria"];

                            echo "<h1>Kysymykset: {$kategoria}</h1>";

                            $haeKysymykset = "SELECT * FROM kysymykset 
                            WHERE kategoria = '$kategoria' ORDER BY julkaisuaika DESC";

                            $tulos = $yhteys->query($haeKysymykset);
                            if ($tulos->num_rows > 0) {
                                while($rivi = $tulos->fetch_assoc()) {
                                    echo "<div class=\"k-kysymys\"><h3>".$rivi["otsikko"]."</h3>";
                                    echo "<p class=\"k-sisalto\">".$rivi["sisalto"]."</p>";
                                    echo "<p class=\"k-nimimerkki\">".$rivi["nimimerkki"]."</p>";
                                    echo "<p class=\"k-julkaisuaika\">".$rivi["julkaisuaika"]."</p>";
                                    echo "<a href=\"http://localhost/php/kysymys.php?kysymys=".$rivi["kysymysID"]."\">";
                                    echo "<button type\"button\" class=\"nayta\">Näytä vastaukset</button></a></div>";
                                }
                            }
                        } else {
                            echo "<h1>Kategoriaa ei löytynyt</h1>";
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