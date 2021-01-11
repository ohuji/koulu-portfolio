$(document).ready(function(){

    $.get("../../php/haeviestit.php", function(data) {
        $("#viestit").html(data);
    })

    setInterval(function() {
        $.get("../../php/haeviestit.php", function(data) {
            $("#viestit").html(data);
        })
    }, 5000)

    $("#laheta").click(function(event) {
        event.preventDefault();
        $.post("../../php/tallennaviesti.php", 
        {
            nimi: $("#nimi").val(),
            teksti: $("#teksti").val()
        },
        function(data) {
            console.log(data);
            location.reload();
        })
    })

})