$(document).ready(function(){

    $.get("../../php/paivitaAsiakirjat.php", function(data) {
        $("#asiakirjavalinta").append(data);
    })

    $.get("../../php/haeasiakirja.php",
    {
       id: "" 
    },
    function(data) {
        $("article").html(data);
    })

    if ($("#asiakirjavalinta").val() === "") {
        $("#kommentit").hide();
    } else {
        $("#kommentit").show();
    }

    $("#asiakirjavalinta").change(function() {
        if ($("#asiakirjavalinta").val() === "") {
            $("#kommentit").hide();
        } else {
            $("#kommentit").show();
        }

        $.get("../../php/haeasiakirja.php",
        {
           id: $("#asiakirjavalinta").val() 
        },
        function(data) {
            $("article").html(data);
        })

        $.get("../../php/haekommentit.php",
        {
            id: $("#asiakirjavalinta").val() 
         },
         function(data) {
             $("#kommentit").html(data);
         })
    })

    $(document).on("click", "#laheta-kommentti", function(event) {
        event.preventDefault();
        $.post("../../php/lisaakommentti.php",
        {
            nimimerkki: $("#kommenttinimimerkki").val(),
            otsikko: $("#kommenttiotsikko").val(),
            teksti: $("#kommenttiteksti").val(),
            id: $("#asiakirjavalinta").val()
        },
        function(data) {
            console.log(data);
            location.reload();
        }
        )
    })

})