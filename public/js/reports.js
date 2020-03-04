$(document).on("change", "#type_report_c_i", function (e) {
    type = e.target.value;
    if (type == '2') {
        $.ajax({
            method: 'GET',
            url: 'http://vitamventure.com:8000/api/investors'
        }).done(function (params) {
            $(`<label id="name" for="amount"><strong>Inversionista</strong></label>
            <select id="select-inv" name="investor_id" placeholder="Seleccione una opción..."></select>`).appendTo('#form-control-i-c');
            $('#select-inv').selectize({
                maxItems: null,
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                options: params,
                create: false,
                maxItems: 1
            });

        })
    } else {
    }
});

$(document).on("change", "#type_report_t", function (e) {
    type = e.target.value;
    $(`
    <div class="form-row">
    <div class="col">
            <label id="name" for="amount"><strong>Fecha inicio</strong></label>
            <input id="datepicker" autocomplete="off" name="dateinit" class="form-control" placeholder="Seleccione una fecha..." />
        </div>
        <div class="col">
            <label id="name" for="amount"><strong>Fecha fin</strong></label>
            <input id="datepicker2" autocomplete="off" name="dateend" class="form-control" placeholder="Seleccione una fecha..." />
        </div>
    </div>`
    ).appendTo('#form-control-t');
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
        'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'yy/mm/dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
    $("#datepicker").datepicker();
    $("#datepicker2").datepicker();
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
