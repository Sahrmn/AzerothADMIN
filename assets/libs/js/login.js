
$(document).ready(function(){
    $('#showPass').click(showPassword);
    $('#btn-login').click(validar);
    $('#incorrecto').hide();
    $('#falta-pass').hide();
    $('#falta-usuario').hide();
});

function showPassword() {
    var key_attr = $('#key').attr('type');
    //console.log(key_attr);
    if(key_attr != 'text') {
        
        $('.checkbox').addClass('show');
        $('#key').attr('type', 'text');
        
    } else {
        
        $('.checkbox').removeClass('show');
        $('#key').attr('type', 'password');
    }
}

function validar(e)
{
    e.preventDefault();
    $('#incorrecto').hide();
    $('#falta-pass').hide();
    $('#falta-usuario').hide();
    $('#user').css('border', '1px solid #ced4da');
    $('#key').css('border', '1px solid #ced4da');

    var nombre = $('#user').val();
    var clave = $('#key').val();
    
    if(nombre == '')
    {
        $('#user').css('border', '1px solid red');
        $('#falta-usuario').show();
    }
    if(clave == '')
    {
        $('#key').css('border', '1px solid red');
        $('#falta-pass').show();
    }
    else
    {
        $.post("login/", { nombre: nombre, clave: clave }, function(e){
            //console.log(e);
            var element = JSON.parse(e);
            if(element.bool != false)
            {
                localStorage.setItem("token", element);
                //console.log(localStorage.getItem("token"));
                window.location.href = "./pages/index.php";
            }
            else
            {
                console.log(element.respuesta);
                $('#key').css('border', '1px solid red');
                $('#incorrecto').show();
            }
        });
    }
}