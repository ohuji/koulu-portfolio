$(document).ready(function() {
    let current = 0;
    let timer;
    
    if ($("#tab1").hasClass("active")) {
        current = $("#tab1").attr("data-picture-index");
    } else if ($("#tab2").hasClass("active")) {
        current = $("#tab2").attr("data-picture-index");
    } else if ($("#tab3").hasClass("active")) {
        current = $("#tab3").attr("data-picture-index");
    } else if ($("#tab4").hasClass("active")) {
        current = $("#tab4").attr("data-picture-index");
    }

    const picChange = () => { 
        let next = current + 1;
        if (next <= 4) {
            $("#tab"+current).removeClass("active");
            $("#tab"+next).addClass("active");
            $("#pic"+current).removeClass("active");
            $("#pic"+next).addClass("active");
            current++;
        } else if (next > 4) {
            next = 1;
            $("#tab"+current).removeClass("active");
            $("#tab"+next).addClass("active");
            $("#pic"+current).removeClass("active");
            $("#pic"+next).addClass("active");
            current = 1;
        } 
    }

    timer = setInterval(picChange, 5000);

    $("#tab1, #tab2, #tab3, #tab4").click(function() {
        let newCurrent = $(this).attr("data-picture-index");
        clearInterval(timer);
        $("#tab"+current).removeClass("active");
        $("#tab"+newCurrent).addClass("active");
        $("#pic"+current).removeClass("active");
        $("#pic"+newCurrent).addClass("active");
        current = newCurrent;
        timer = setInterval(picChange, 5000);
    });
});