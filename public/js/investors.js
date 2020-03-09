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

$(document).on("click", "#investorSave", function(e) {
    var vali = document.getElementById('vali').value
    if (vali == true) {
        toastr.error('Verifica la información digitada.', 'Registro de invesionista')
    } else {
        $('#createinvestorFrom').submit()
    }
});

$(document).on("click", '#investorDelete', function(e) {
    e.preventDefault()
    id = document.getElementById('iddelete').value
    $.ajax({
        method: 'GET',
        data: {'id':id},
        url: 'http://127.0.0.1:8000/api/validate/investor/vehicles'
    }).done(function(params) {
        for (let i = 0; i < params.length; i++) {
            const e = params[i];
            if (e.vehicles.length > 0) {
                toastr.error('Este inversionista tiene vehiculos asociados')
            } else {
                $('#deleteinvestor').submit()
            }
        }
    })
})

$(document).on("change", "#email", function (e) {
    email = document.getElementById("email").value;
    url = "http://127.0.0.1:8000/api/validate/email";
    if (email.indexOf(".com") > 0) {
        $.ajax({
            method: "POST",
            url: url,
            data: { 'email': email },
            success: function (res) {
                if (res != true) {
                    $(`<div class="alert alert-danger">${res}</div> <input id="vali" value="true" type="hidden"/>`).appendTo('#form-group-email');
                    $('#investorSave').attr({disabled: true});
                    var i = 0;
                    setInterval(function () {
                        i++
                        if (i > 2) {
                            $("#form-group-email .alert ").remove();
                        }
                    }, 1000)

                } else {
                    $(`<input id="vali" value="false" type="hidden"/>`).appendTo('#form-group-email');
                    document.getElementById('vali').value = false
                    $('#investorSave').attr({disabled: false});
                }
            }
        })
    }
});

$(document).on("change", "#type", function (e) {
    if (e.target.value == 1) {
        $.ajax({
            method: 'GET',
            url: 'http://127.0.0.1:8000/api/titulares'
        }).done(function (params) {
            $(`
        <div class="form-group">
            <label for="address"><strong>Titular</strong></label>
            <select id="select-tit" name="titular_id" placeholder="Seleccione una opción..."></select>
        </div>`).appendTo('#form-group-tit');
            $('#select-tit').selectize({
                maxItems: null,
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                options: params,
                create: false,
                maxItems: 1
            });
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
