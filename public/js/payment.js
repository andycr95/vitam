$(document).on("change", "#type", function (e) {
    type = document.getElementById("type").value;
    if (type == 'abono') {
        $(`<label id="name" for="amount"><strong>Monto</strong></label>
        <input id="value" class="form-control" type="number" name="amount" placeholder="20000" required/>`).appendTo('#amount');
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
    url: 'http://127.0.0.1:8001/api/salesvehicles'
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

const formatterPeso = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0
})

for (let i = 0; i < document.getElementsByClassName('precio').length; i++) {
    const e = document.getElementsByClassName('precio')[i];
    e.innerHTML = formatterPeso.format(e.innerHTML)
}
