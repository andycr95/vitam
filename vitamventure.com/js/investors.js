$('#investorUpdate').click(function ($event) {
    $event.preventDefault();

    if (document.getElementsByName("first_name")[0].disabled== false) {
        document.getElementsByName("first_name")[0].disabled = true;
        document.getElementsByName("last_name")[0].disabled = true;
        document.getElementsByName("password")[0].disabled = true;
        document.getElementsByName("address")[0].disabled = true;
        $('#pass').attr('type', 'password')
        document.getElementsByName("email")[0].disabled = true;
        $("#investorSave").attr({disabled: true});
        $("#investorUpdate span").remove();
        $("#investorUpdate").attr({
            class:'btn btn-info btn-sm'
        }).append('<span>Actualizar</span>');
    } else {
        document.getElementsByName("first_name")[0].disabled = false;
        document.getElementsByName("last_name")[0].disabled = false;
        document.getElementsByName("password")[0].disabled = false;
        document.getElementsByName("address")[0].disabled = false;
        $("#investorSave").attr({disabled: false});
        $('#pass').attr('type', 'text')
        document.getElementsByName("email")[0].disabled = false;
        $("#investorUpdate span").remove();
        $("#investorUpdate").attr({
            class:'btn btn-danger btn-sm'
        }).append('<span>Cancelar</span>');
    }
})

$(document).on("click", "#deleteinvestor", function(e) {
    var id = $(this).data("id");
    document.getElementById("iddelete").value = id;
});

$(document).on("change", "#email", function(e) {
    email = document.getElementById("email").value;
    url = "http://127.0.0.1:8001/validate/email";
    if (email.indexOf(".com") > 0) {
        $.ajax({
            method: "POST",
            url: url,
            data: {'email':email},
            success: function(res) {
                if (res != true) {
                    $(`<div class="alert alert-danger">${res}</div>`).appendTo('#form-group-email');
                    var i = 0;
                    setInterval(function() {i++
                        if (i > 2) {
                            $("#form-group-email .alert ").remove();
                        }
                    }, 1000)
                }
            }
        })
    }
});

$(document).on("keyup", "#password", function(e) {
    password = document.getElementById("password").value;
    $("#form-group-password .alert ").remove();
    if (password.length < 6) {
        $(`<div class="alert alert-danger">La contraseña debe ser mayor a 6 digitos</div>`).appendTo('#form-group-password');
        var i = 0;
        setInterval(function() {i++
            if (i > 2) {
                $("#form-group-password .alert ").remove();
                clearInterval()
            }
        }, 1000)
    } else if (password.length == 0) {
        $("#form-group-password .alert ").remove();
    } else {
        $("#form-group-password .alert ").remove();
    }
});
