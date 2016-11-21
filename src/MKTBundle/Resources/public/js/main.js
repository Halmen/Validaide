$(document).ready(function () {

    $(".temperature").focus();


    var error1 = "Please enter all the numeric value!!!";
    var error2 = "Please fill out all the fields, and enter a valid e-mail address!!!";

    $validate = function () {


        if (!$('#energy').val() || !$('#gas').val() || !$('.temperature').val()) {

            return false;
        }
        return true;

    }


    $ajaxFun = function ($url, $message, $response) {

        request = $.ajax({
            url: $url,
            type: "POST",
            data: {
                value: $message
            }
        });

        request.done(function (respons) {

            $response.text(respons.data);


        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );

            alert("The following error occurred: " +
                textStatus, errorThrown);
        });

    };


    $("#plus").click(function () {


        $(".temperatures").prepend(
            '<div class="T">' +
            '<input type="number" class="temperature" value="0" name=temp> ' +
            '<button id="minus" type="button">-</button> ' +
            '</div>');


    })


    $(".temperatures").on("click", "#minus", function () {
        $(this).parents('.T').remove();


    });


    $("input").focusout(function () {

        if ($validate()) {

            $("#errors").empty();
            var energy = $("#energy").val();
            var gas = $("#gas").val();

            var values = [];
            $('.temperature').each(function () {
                values.push(this.value);
            });

            var data = [];
            data.push(energy, gas, values);

            var message = JSON.stringify(data);
            var url = "http://localhost/Validaide/web/app_dev.php/mkt/calc";

            $ajaxFun(url, message, $("#mkt"));

        }
        else {
            $("#errors").text(error1);
        }
    });


    $('#send').click(function () {


        var energy = $("#energy").val();
        var gas = $("#gas").val();

        var values = [];
        $('.temperature').each(function () {
            values.push(this.value);
        });
        var mkt = $("#mkt").text();
        var email = $("#email").val();

        var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        if (!testEmail.test(email) || !$validate()) {
            $("#errors").text(error2);
        }

        else {
            $("#errors").empty();
            var data = [];
            data.push(energy, gas, values, mkt, email);


            var url = "http://localhost/Validaide/web/app_dev.php/mkt/send"
            var message = JSON.stringify(data);

            $ajaxFun(url, message, $("#errors"));
        }

    })


    $('#save').click(function () {


        var energy = $("#energy").val();
        var gas = $("#gas").val();

        var values = [];
        $('.temperature').each(function () {
            values.push(this.value);
        });
        var mkt = $("#mkt").text();
        var email = $("#email").val();
        var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

        if (!testEmail.test(email) || !$validate()) {
            $("#errors").text(error2);
        }

        else {
            $("#errors").empty();
            var data = [];
            data.push(energy, gas, values, mkt, email);
            var url = "http://localhost/Validaide/web/app_dev.php/mkt/save"
            var message = JSON.stringify(data);
            $ajaxFun(url, message, $("#errors"));
        }
    })


    $('option').click(function () {


        var message = JSON.stringify($(this).text());
        request = $.ajax({
            url: "http://localhost/Validaide/web/app_dev.php/mkt/load",
            type: "POST",
            data: {
                value: message
            }
        });

        request.done(function (respons) {

            $("#energy").val(respons.E);
            $("#gas").val(respons.R);
            $("#mkt").text(respons.mkt + " °C");


            var arr = $.map(respons.T, function (el) {
                return el
            });
            $('.T').remove();

            for (i in arr) {
                $(".temperatures").prepend(
                    '<div class="T">' +
                    '<input type="number" class="temperature" name=temp value=' + arr[i] + '> ' +
                    '<button id="minus" type="button">-</button> ' +
                    '</div>');


            }

        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );

            alert("The following error occurred: " +
                textStatus, errorThrown);
        });

    });


    $('#show').click(function () {

        $(".send_save").toggle(500);

    });

});