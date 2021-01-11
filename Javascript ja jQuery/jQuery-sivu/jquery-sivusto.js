$(document).ready(function(){
    $("nav > h3").click(function() {
        if ($(this).parent().hasClass("auki")) {
            $(this).parent().removeClass("auki");
            $(this).parent().addClass("kiinni");
        } else if ($(this).parent().hasClass("kiinni")) {
            $(this).parent().removeClass("kiinni");
            $(this).parent().addClass("auki");
        }
    });

    $("nav > ul > li").click(function() {
        let a = $(this).attr("data-tab");
        $("li").removeClass("valittu");
        $(this).addClass("valittu");
        $("div").removeClass("valittu");
        $("#tab"+a).addClass("valittu");
    });
 
    $("#rekisteroityminen").submit(function(e) {
        if ($("#nimimerkkikentta").val() === "") {
            $("#nimimerkkikentta").css("background-color", "red");
            e.preventDefault(e);
        } else if ($("#sahkopostikentta").val() === ""){
            $("#sahkopostikentta").css("background-color", "red");
            e.preventDefault(e);
        } else if ($("#salasanakentta1").val() === ""){
            $("#salasanakentta1").css("background-color", "red");
            e.preventDefault(e);
        } else if ($("#salasanakentta2").val() === ""){
            $("#salasanakentta2").css("background-color", "red");
            e.preventDefault(e);
        } else {
            $("#nimimerkkikentta, #sahkopostikentta").css("background-color", "black");
        }
    });

    $("#hyvaksykayttoehdot").change(function() {
        if ($(this).is(":checked")) {
            $("input[type=submit]").removeAttr("disabled");
        } else {
            $("input[type=submit]").attr("disabled", "disabled");
        }
    });

    $("#salasanakentta1").focus(function() {
        $(".ohje").css("display", "block");
    });

    $("#salasanakentta1").blur(function() {
        $(".ohje").css("display", "none");
    });

    $("#salasanakentta1").keypress(function() {
        $(this).css("background-color", "#FFB6C1");
    });

    $("#rekisteroityminen").submit(function(e) {
        if ($("#salasanakentta1").val().length < 8) {
            $("#salasanakentta1").css("background-color", "red");
            e.preventDefault(e);
        } else if ($("#salasanakentta1").val() != $("#salasanakentta2").val()) {
            $("#salasanakentta2").css("background-color", "red");
            e.preventDefault(e);
        } else {
            $("#salasanakentta1, #salasanakentta2").css("background-color", "green");
        }
    });

    $(document).on("dblclick", "#laskentataulukko td" , function() {
        let sana = [];

        $("td.active").removeClass("active");
        $(this).addClass("active");
        $("body").keydown(function(e) {
            let letter = String.fromCharCode(e.which);

            if (e.which === 13) {
                $("td.active").removeClass("active");
            } else if (e.which === 8) {
                sana.pop();
                $("td.active").text(sana.join(""));
            } else {
                sana.push(letter); 
                $("td.active").text(sana.join(""));
            }
        });
    });

    $("#lisaarivi").click(function() {
        $("#laskentataulukko").append("<tr><td></td><td></td><td></td><td></td><td></td><td><button>Poista</button></td></tr>")
        .find("td:last")
        .addClass("poisto");
    });
    
    $(document).on("click", ".poisto", function() {
        $(this).parent().remove();
    });

    let cards = ["aurinko", "sydan", "sydanrikki", "tyhjakortti"];
    let clicks = 0;

    const shuffle = (array) => {
        let currentIndex = array.length, temporaryValue, randomIndex;
        while (0 !== currentIndex) {
          randomIndex = Math.floor(Math.random() * currentIndex);
          currentIndex -= 1;
      
          temporaryValue = array[currentIndex];
          array[currentIndex] = array[randomIndex];
          array[randomIndex] = temporaryValue;
        }
        return array;
    }

    let data = 0;

    $("#aloitusnappi").click(function() {
        shuffle(cards);
        clicks = 0;
        $("#kortit td img").attr("src", "kortti.png");
        $(".clicked").removeClass("clicked");
        $("#viesti").text("Peli Alkoi!");    
        $("#kortit td img").click(function() {
            data = $(this).attr("data-indeksi");

            if (!$(this).parent().hasClass("clicked")) {
                $(this).parent().addClass("clicked");
                clicks++;
            } 

            if (clicks === 3) {
                $("#viesti").text("Käytit kaikki yrityksesi");
            } else if (clicks === 2) {
                $("#viesti").text("Yrityksiä jäljellä: 1");
            } else if (clicks === 1) {
                $("#viesti").text("Yrityksiä jäljellä: 2");
            } else if (clicks === 0) {
                $("#viesti").text("Yrityksiä jäljellä: 3");
            } 

            const random = Math.floor(Math.random() * cards.length);

            $("img[data-indeksi= "+data+"]").attr("src", cards[random] + ".png");
            if (cards[random] === "sydan") {
                $("#viesti").text("voitit");
            } else if (cards[random] === "sydanrikki") {
                $("#viesti").text("hävisit");
            } else if (cards[random] === "aurinko") {
                if (clicks === 1) {
                    clicks = 0;
                } else if (clicks === 2) {
                    clicks = 1;
                } 
            } 

        });
    });
});