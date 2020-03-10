$(document).on("change", "#photo", function(e) {
    var id = $(this).data("id");
    document.getElementById("form").submit();
});

$(document).on("change", "#photo1", function(e) {
    var id = $(this).data("id");
    document.getElementById("form1").submit();
});

$(document).on("change", "#photo2", function(e) {
    var id = $(this).data("id");
    document.getElementById("form2").submit();
});

$('#clientUpdate').click(function ($event) {
    $event.preventDefault();

    if (document.getElementsByName("first_name")[0].disabled== false) {
        document.getElementsByName("first_name")[0].disabled = true;
        document.getElementsByName("last_name")[0].disabled = true;
        document.getElementsByName("documento")[0].disabled = true;
        document.getElementsByName("address")[0].disabled = true;
        document.getElementsByName("celphone")[0].disabled = true;
        document.getElementsByName("phone")[0].disabled = true;
        document.getElementsByName("email")[0].disabled = true;
        $("#clientSave").attr({disabled: true});
        $("#clientUpdate span").remove();
        $("#clientUpdate").attr({
            class:'btn btn-info btn-sm'
        }).append('<span>Actualizar</span>');
    } else {
        document.getElementsByName("first_name")[0].disabled = false;
        document.getElementsByName("last_name")[0].disabled = false;
        document.getElementsByName("documento")[0].disabled = false;
        document.getElementsByName("address")[0].disabled = false;
        document.getElementsByName("phone")[0].disabled = false;
        document.getElementsByName("celphone")[0].disabled = false;
        document.getElementsByName("email")[0].disabled = false;
        $("#clientSave").attr({disabled: false});
        $("#clientUpdate span").remove();
        $("#clientUpdate").attr({
            class:'btn btn-danger btn-sm'
        }).append('<span>Cancelar</span>');
    }
})

$(document).on("blur", "#email", function (e) {
    email = document.getElementById("email").value;
    url = "http://vitamventure.com/api/validate/client/email";
    if (email.indexOf(".com") > 0) {
        $.ajax({
            method: "POST",
            url: url,
            data: { 'email': email },
            success: function (res) {
                if (res != true) {
                    $(`<div class="alert alert-danger">${res}</div> <input id="vali" value="true" type="hidden"/>`).appendTo('#form-group-email');
                    $('#clientSave').attr({disabled: true});
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
                    $('#clientSave').attr({disabled: false});
                }
            }
        })
    }
});

$(document).on("keyup", "#password", function (e) {
    password = document.getElementById("password").value;
    $("#form-group-password .alert ").remove();
    if (password.length < 6) {
        $(`<div class="alert alert-danger">La contraseña debe ser mayor a 6 digitos</div>`).appendTo('#form-group-password');
        var i = 0;
        setInterval(function () {
            i++
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

$(document).on("click", "#deleteclient", function (e) {
    e.preventDefault()
    id = $(this).data("id")
    $.ajax({
        method: 'GET',
        data: {'id':id},
        url: 'http://vitamventure.com/api/validate/client/sales'
    }).done(function(params) {
        var id_sale
        var id_vehicle
        for (let i = 0; i < params.length; i++) {
            const e = params[i];
            id_sale = e.sale
            id_vehicle = e.vehicle
        }


        if (params) {
            $.confirm({
                title: 'Eliminando cliente',
                content: 'Este cliente tiene ventas en curso, desea cancelarlas?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    Si: {
                        text: 'Si',
                        btnClass: 'btn-green',
                        action: function(){
                            $.confirm({
                                title: 'Eliminando cliente',
                                content: `
                                <form action="{{ route('deleteclient') }}" id="deleteform"  enctype="multipart/form-data"  method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <label for="phone">Este vehiculo cambiará de estado, desea cambiar su precio y dias de pago?</label>
                                    <div class="form-group">
                                        <label for="phone"><strong>Precio</strong></label>
                                        <input class="form-control" id="fee" type="text" name="new_fee" placeholder=""/>
                                    </div>
                                    <input type="hidden" name="sale" value="${id_sale}"/>
                                    <input type="hidden" name="vehicle" value="${id_vehicle}"/>
                                    <input class="form-control" type="hidden" value="${id}" name="id" id="iddelete" required/>
                                    </div><div class="form-group">
                                        <label for="phone"><strong>Dias</strong></label>
                                        <input class="form-control" type="text" name="new_days" placeholder=""/>
                                    </div>
                                </form>`,
                                type: 'red',
                                typeAnimated: true,
                                buttons: {
                                    formSubmit: {
                                        text: 'Enviar',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            var name = this.$content.find('.name').val();
                                            if(!name){
                                                $.alert('provide a valid name');
                                                return false;
                                            }
                                            $.alert('Your name is ' + name);
                                        }
                                    },
                                    cancel: function () {
                                        //close
                                    },
                                    Si: {
                                        text: 'Enviar',
                                        btnClass: 'btn-green',
                                        action: function(){
                                            var fee = this.$content.find('#fee').val();
                                            var sale = this.$content.find('#sale').val();
                                            var fee = this.$content.find('#fee').val();
                                            var fee = this.$content.find('#fee').val();
                                            console.log(name);

                                        }
                                    },
                                    No: {
                                        text: 'No',
                                        btnClass: 'btn-red',
                                        action: function(){
                                            $('#deleteform').submit()
                                        }
                                    }
                                },
                                onContentReady: function () {
                                    // bind to events
                                    var jc = this;
                                    this.$content.find('form').on('submit', function (e) {
                                        // if the user submits the form by pressing enter in the field.
                                        e.preventDefault();
                                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                                    });
                                }
                            });

                        }
                    },
                    No: {
                        text: 'No',
                        btnClass: 'btn-red',
                        action: function(){
                            toastr.info('Cliente no eliminado')
                        }
                    },
                    close: function () {
                    }
                }
            });
        } else {
            $("#deleteform ").submit();
        }

    })
})
