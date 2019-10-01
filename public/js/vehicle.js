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
    $('#editForm').append(`<input name="id" id="id" value="${id}" type="hidden"/>`);
    document.getElementById("placa").value = placa;
    document.getElementById("color").value = color;
    document.getElementById("model").value = model;
    document.getElementById("motor").value = motor;
    document.getElementById("chasis").value = chasis;
    document.getElementById("optionInv").value = investor;
    $('#editForm #optionInv').append(`${nameinv}`);

    document.getElementById("optionTyp").value = type;
    $('#editForm #optionTyp').append(`${nametype}`);

    document.getElementById("optionBr").value = Br;
    $('#editForm #optionBr').append(`${nameBr}`);
});
