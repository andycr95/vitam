$(document).on("change", "#type", function (e) {
    type = document.getElementById("type").value;
    id = document.getElementById('select-tools').value
    if (type == 'abono') {
        $.ajax({
            method: 'GET',
            data: {'id':id},
            url: 'http://vitamventure.com:8000/api/validate/payment'
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
        $(".modal-body #amount #name").remove();
        $(".modal-body #amount #value").remove();
    } else {
        $(".modal-body #amount #name").remove();
        $(".modal-body #amount #value").remove();
    }
});

$.ajax({
    method: 'GET',
    url: 'http://vitamventure.com:8000/api/salesvehicles'
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
            url: 'http://vitamventure.com:8000/api/validate/payment'
        }).done(function (params) {
            if (document.getElementById('type').value == 'pago') {
                val = params.fee - params.amount
                if (params.type == "abono") {
                    toastr.error(`Tiene un pago de ${val} pendiente por saldar`)
                } else {
                    $('#paymentForm').submit()
                }
            } if (document.getElementById('type').value == 'abono') {
                $('#paymentForm').submit()
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
