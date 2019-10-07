$(document).on("click", "#deleteclient", function(e) {
    var id = $(this).data("id");
    document.getElementById("id").value = id;
});

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