$(document).on("change", "#type", function (e) {
    type = document.getElementById("type").value;
    id = document.getElementById('select-tools').value
    if (type == 'abono') {
        if (document.getElementById('name')) {
            $(".modal-body #amount #value").remove();
            $(".modal-body #amount #name").remove();            
        }
        if (document.getElementById('pays')) {
            $(".modal-body #amount #_pay").remove();
            $(".modal-body #amount #pays").remove();            
        }
        $.ajax({
            method: 'GET',
            data: {'id':id},
            url: 'https://vitamventure.com/api/validate/payment'
        }).done(function (params) {
            if (params.type == 'abono') {
                val = params.fee - params.amount
                $(`<label id="name" for="amount"><strong>Monto</strong></label>
                <input id="value" class="form-control" type="number" name="amount" value="${val}"placeholder="20000" required/>`).appendTo('#amount');
            } else {
                $(`<label id="name" for="amount"><strong>Monto</strong></label>
                <input id="value" class="form-control" type="number" name="amount" placeholder="20000" required/>`).appendTo('#amount');
            }
        })
    } else if (type == 'pago') {
        $(".modal-body #amount #pays").remove();
        $(".modal-body #amount #_pay").remove();
        $(".modal-body #amount #value").remove();
        $(".modal-body #amount #name").remove();
    } else if (type == 'pagos') {
        if (document.getElementById('name')) {
            $(".modal-body #amount #value").remove();
            $(".modal-body #amount #name").remove();            
        }
        $(`<label id="_pay" for="pays"><strong>Pagos a realizar</strong></label>
                <input id="pays" class="form-control" type="number" name="pays" value="1" required/>`).appendTo('#amount');
    } else {
        $(".modal-body #amount #name").remove();
        $(".modal-body #amount #pays").remove();
        $(".modal-body #amount #_pay").remove();
        $(".modal-body #amount #value").remove();
        $(".modal-body #amount #name").remove();
    }
});

$.ajax({
    method: 'GET',
    url: 'https://vitamventure.com/api/salesvehicles'
}).done(function (params) {
    $('#select-tools').selectize({
        maxItems: null,
        valueField: 'id',
        labelField: 'placa',
        searchField: 'placa',
        options: params,
        create: false,
        maxItems: 1
    });

})


$(document).on("change", "#select-tools", function(e) {
    document.getElementsByName("type")[0].disabled = false;
});

$(document).on("click", "#saveButton", function(e) {
    id = document.getElementById('select-tools').value
    if (document.getElementById('type').value == '#') {
        toastr.error('Debe seleccionar un tipo de pago')
    } else {
        $.ajax({
            method: 'GET',
            data: {'id':id},
            url: 'https://vitamventure.com/api/validate/payment'
        }).done(function (params) {
            val = params.fee - params.amount
            if (document.getElementById('type').value == 'pago') {
                if (params.type == "abono") {
                    toastr.error(`Tiene un pago de ${val} pendiente por saldar`)
                } else {
                    $.confirm({
                        title: `Registrando pago a ${params.placa}`,
                        content: 'Está seguro de realizar este pago',
                        type: 'green',
                        typeAnimated: true,
                        buttons: {
                            Si: {
                                text: 'Si',
                                btnClass: 'btn-green',
                                action: function(){
                                    $('#paymentForm').submit()
                                }
                            },
                            No: {
                                text: 'No',
                                btnClass: 'btn-red',
                                action: function(){
                                    toastr.info('pago cancelado')
                                }
                            },
                            close: function () {
                            }
                        }
                    });
                }
            } else if (document.getElementById('type').value == 'abono') {
                value = document.getElementById('value').value
                if (params.type == "abono") {
                    if (value > val) {
                        toastr.error(`Tiene un pago de ${val} primero saldelo`)
                    } else {
                        $.confirm({
                            title: `Registrando abono a ${params.placa}`,
                            content: 'Está seguro de realizar este abono',
                            type: 'green',
                            typeAnimated: true,
                            buttons: {
                                Si: {
                                    text: 'Si',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        $('#paymentForm').submit()
                                    }
                                },
                                No: {
                                    text: 'No',
                                    btnClass: 'btn-red',
                                    action: function(){
                                        toastr.info('pago cancelado')
                                    }
                                },
                                close: function () {
                                }
                            }
                        });
                    }
                } else {
                    $.confirm({
                        title: `Registrando abono a ${params.placa}`,
                        content: 'Está seguro de realizar este abono',
                        type: 'green',
                        typeAnimated: true,
                        buttons: {
                            Si: {
                                text: 'Si',
                                btnClass: 'btn-green',
                                action: function(){
                                    $('#paymentForm').submit()
                                }
                            },
                            No: {
                                text: 'No',
                                btnClass: 'btn-red',
                                action: function(){
                                    toastr.info('pago cancelado')
                                }
                            },
                            close: function () {
                            }
                        }
                    });
                }
            }
        })
    }
});


const formatterPeso = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0
})

for (let i = 0; i < document.getElementsByClassName('precio').length; i++) {
    const e = document.getElementsByClassName('precio')[i];
    e.innerHTML = formatterPeso.format(e.innerHTML)
}
