idleTimer = null;
idleState = false;
idleWait = 60000; // un minuto

(function ($) {

    $(document).ready(function () {

        $('*').bind('mousemove keydown scroll', function () {

            clearTimeout(idleTimer);

            if (idleState == true) {

                // Reactivated event
                $(".reload").append("<p>Welcome Back.</p>");
            }

            idleState = false;

            idleTimer = setInterval(function () {

                // Idle Event
                location.reload();
                $(".reload").append("<p>Has estado " + idleWait/1000 + " secondos Desconectado, Hemos recargado la pantalla.</p>");

                idleState = true; }, idleWait);
        });

        $("body").trigger("mousemove");

    });
}) (jQuery)
