$('#employeeUpdate').click(function ($event) { 
    $event.preventDefault();

    if (document.getElementsByName("first_name")[0].disabled== false) {
        document.getElementsByName("first_name")[0].disabled = true;   
        document.getElementsByName("last_name")[0].disabled = true;  
        document.getElementsByName("password")[0].disabled = true;  
        $('#pass').attr('type', 'password') 
        document.getElementsByName("email")[0].disabled = true;
        $("#employeeSave").attr({disabled: true});   
        $("#employeeUpdate span").remove();   
        $("#employeeUpdate").attr({
            class:'btn btn-info btn-sm'
        }).append('<span>Actualizar</span>');
    } else {
        document.getElementsByName("first_name")[0].disabled = false;   
        document.getElementsByName("last_name")[0].disabled = false;  
        document.getElementsByName("password")[0].disabled = false; 
        $("#employeeSave").attr({disabled: false});
        $('#pass').attr('type', 'text') 
        document.getElementsByName("email")[0].disabled = false;
        $("#employeeUpdate span").remove();   
        $("#employeeUpdate").attr({
            class:'btn btn-danger btn-sm'
        }).append('<span>Cancelar</span>');
    }
})