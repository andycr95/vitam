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
    url: 'http://localhost:8000/api/salesvehicles'
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
