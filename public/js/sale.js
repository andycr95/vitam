const formatterPeso = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0
})

for (let i = 0; i < document.getElementsByClassName('precio').length; i++) {
    const e = document.getElementsByClassName('precio')[i];
    e.innerHTML = formatterPeso.format(e.innerHTML)
}

$.ajax({
    method: 'GET',
    url: 'http://localhost:8000/api/clients'
}).done(function (params) {
    clients = []
    for (let i = 0; i < params.length; i++) {
        const e = params[i];
        e.name = e.name + " " + e.last_name
        clients.push(e)
    }
    $('#select-client').selectize({
        maxItems: null,
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        options: clients,
        create: false,
        maxItems: 1
    });
})

$.ajax({
    method: 'GET',
    url: 'http://localhost:8000/api/vehicles'
}).done(function (params) {
    $('#select-vehi').selectize({
        maxItems: null,
        valueField: 'id',
        labelField: 'placa',
        searchField: 'placa',
        options: params,
        create: false,
        maxItems: 1
    });

})
