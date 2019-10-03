$('#branchUpdate').click(function ($event) { 
    $event.preventDefault();

    if (document.getElementsByName("first_name")[0].disabled== false) {
        document.getElementsByName("first_name")[0].disabled = true;   
        document.getElementsByName("encargado")[0].disabled = true;  
        document.getElementsByName("address")[0].disabled = true;  
        document.getElementsByName("city")[0].disabled = true;  
        $('#pass').attr('type', 'password') 
        document.getElementsByName("email")[0].disabled = true;
        $("#branchSave").attr({disabled: true});   
        $("#branchUpdate span").remove();   
        $("#branchUpdate").attr({
            class:'btn btn-info btn-sm'
        }).append('<span>Actualizar</span>');
    } else {
        document.getElementsByName("first_name")[0].disabled = false;   
        document.getElementsByName("encargado")[0].disabled = false;  
        document.getElementsByName("address")[0].disabled = false;  
        document.getElementsByName("city")[0].disabled = false; 
        $("#branchSave").attr({disabled: false});
        $('#pass').attr('type', 'text') 
        document.getElementsByName("email")[0].disabled = false;
        $("#branchUpdate span").remove();   
        $("#branchUpdate").attr({
            class:'btn btn-danger btn-sm'
        }).append('<span>Cancelar</span>');
    }
})

$(document).on("click", "#deletebranch", function(e) {
    var id = $(this).data("id");
    document.getElementById("id").value = id;
});