$(document).ready(inicializarEventos);
var token = localStorage.token;

function inicializarEventos()
{
    identificarNombreUsuario();
    $('#logout').click(logOut);
    $('.nav-link').click(resaltarMenu);
}

function identificarNombreUsuario()
{
    var token = localStorage.token;
    $.ajax({
        type: 'POST',
        url: "../usuario/traerDatos",
        headers: {
            'token':token
        },
        dataType: 'json',
        success: function (respuesta) {
            //console.log(respuesta);
            var nombre = respuesta.nombre;
            nombre = nombre.toUpperCase();
            $('#user-name').text(nombre);//nombre de usuario
        },
        error: function (xhr, status) {
            //alert(status + " " + xhr.status + " " + xhr.statusText);
            errores(xhr.status);
        }
    });
}

function logOut()
{
    localStorage.clear();
    window.location.replace("../login.php");
}

function errores(status)
{
    if(status == '404')
    {
        //alert(status + " " + xhr.status + " " + xhr.statusText);
        window.location.href = "../pages/404.php";//pagina error 404
    }
    if(status == '403')
    {
        //alert(status + " " + xhr.status + " " + xhr.statusText);
        window.location.href = "../pages/403.html";//pagina error 403
    }
    if(status == '500')
    {
        window.location.href = "../login.php";
    }
}

function resaltarMenu()
{
    $(this).parent();
}

