$(document).on("click", "#deletevehicle", function(e) {
    var id = $(this).data("id");
    document.getElementById("id").value = id;
});

$(document).on("click", "#editvehicle", function(e) {
    var id = $(this).data("id");
    var placa = $(this).data("placa");
    var motor = $(this).data("motor");
    var model = $(this).data("model");
    var chasis = $(this).data("chasis");
    var investor = $(this).data("investor");
    var color = $(this).data("color");
    var nameinv = $(this).data("nameinv");
    var type = $(this).data("type");
    var nametype = $(this).data("nametype");
    var Br = $(this).data("branchid");
    var nameBr = $(this).data("branchname");
    var amount = $(this).data("amount");
    $('#editForm').append(`<input name="id" id="id" value="${id}" type="hidden"/>`);
    document.getElementById("placa").value = placa;
    document.getElementById("color").value = color;
    document.getElementById("model").value = model;
    document.getElementById("motor").value = motor;
    document.getElementById("chasis").value = chasis;
    if (amount != '') {
        document.getElementById("amount").value = amount;
    }else {
        document.getElementById("amount").value = 365;
    }
    document.getElementById("optionInv").value = investor;
    $('#editForm #optionInv').append(`${nameinv}`);

    document.getElementById("optionTyp").value = type;
    $('#editForm #optionTyp').append(`${nametype}`);

    document.getElementById("optionBr").value = Br;
    $('#editForm #optionBr').append(`${nameBr}`);
});

$(document).on("change", "#type_id", function(e) {
    var type = document.getElementById("type_id").value;
    if (type > 1) {
        $("#groupAmount .nono").remove();
        $("#groupAmount .form-control").remove();
        $("#groupAmount").append(`<label class="nono" for="amount"><strong>Cantidad de dias</strong></label> <input class="form-control" type="text" id="amount" name="amount" placeholder="365" required/>`);  
    } else {
        $("#groupAmount .nono").remove();
        $("#groupAmount .form-control").remove();
        $("#groupAmount").append(`<input class="form-control" type="hidden" id="amount" value="365" name="amount" placeholder="365" required/>`);
    }
});