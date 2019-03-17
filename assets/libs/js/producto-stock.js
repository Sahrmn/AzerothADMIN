$(document).ready(function(){
    cargarTabla();
    $('#busqueda').keyup(buscar);
    $('#guardarStock').click(guardarStock);
});

var token = localStorage.token;
var id_producto = 0;

function guardarStock()
{
    var cantidad = $('#inputStock').val();
    if(cantidad == "")
    {
        //mensaje de ingresar stock
    }
    else
    {
        var parametros = {
            'cantidad': cantidad
        };
        $.ajax({
            url: "../stock/carga/"+ id_producto,
            type: 'POST',
            data: parametros,
            //dataType: 'json',
            headers: {
                'token':token
            },
            success: function (respuesta) {
                //console.log(respuesta);
                alert(respuesta);
                cargarListadoUnProducto(id_producto);
            },
            error: function (xhr, status) {
                errores(xhr.status);
                alert(status + " " + xhr.status + " " + xhr.statusText);
            }
        });
    }
}

function buscar()
{
    $('#busqueda').keyup(function () {
        var rex = new RegExp($(this).val(), 'i');
        $('.buscar tr').hide();
        $('.buscar tr').filter(function () {
            return rex.test($(this).text());
        }).show();
    });
}

function cargarTabla()
{
    $.ajax({
        url: "../stock/mostrar/",
        dataType: 'json',
        headers: {
            'token':token
        },
        success: function (respuesta) {
            var texto = "<thead><tr><th>Id</th><th>Nombre</th><th>Cantidad</th></tr></thead><tbody class='buscar'>";
            for (let i = 0; i < respuesta.length; i++) {
                if(respuesta[i].cantidad != 0)
                {
                    texto += "<tr><td class='idp'>"+ respuesta[i].id +"</td><td>"+ respuesta[i].nombre +"</td><td>"+ respuesta[i].total +"</td></tr>";
                }
            }
            texto += "</tbody>";
            $('#tabla-stock').html(texto);

            var tabla = $('#tabla-stock');
            var tbody = tabla.children().find("tr");//todos los tr de la tabla
            for (let i = 1; i-1 < tbody.length; i++) {
                //agrego eventos
                $(tbody[i]).mouseover(function(){
                    $(tbody[i]).css('background-color', '#d9d9ea');
                });
                $(tbody[i]).mouseout(function(){
                    $(tbody[i]).css('background-color', '#fff');
                });
                $(tbody[i]).click(function(){
                    //recorro todos los td buscando el id
                    $(tbody[i]).children().each(function(){
                        id_producto = $(this).text();
                        return false;
                    });

                    for (let f = 1; f-1 < tbody.length; f++) {
                        //quito formatos de otras filas que podrian ser seleccionadas
                        $(tbody[f]).removeClass('btn-seleccion');
                    }

                    $(tbody[i]).addClass('btn-seleccion');
                    $('#stockModal').modal('show');
                    cargarListadoUnProducto(id_producto);
                });
            }
        },
        error: function (xhr, status) {
            errores(xhr.status);
        }
    });
}

function cargarListadoUnProducto(id)
{
    $.ajax({
        url: "../stock/mostrar/"+ id,
        dataType: 'json',
        headers: {
            'token':token
        },
        success: function (respuesta) {
            //console.log(respuesta);
            var texto = "<thead><tr><th>Id</th><th>Cantidad</th><th>Fecha</th></tr></thead><tbody class='buscar'>";
            for (let i = 0; i < respuesta.length; i++) {
                if(respuesta[i].cantidad != 0)
                {
                    texto += "<tr><td class='idp'>"+ respuesta[i].id +"</td><td>"+ respuesta[i].cantidad +"</td><td>"+ respuesta[i].fecha +"</td></tr>";
                }
            }
            texto += "</tbody>";
            var nombre = respuesta[0].nombre;
            nombre = nombre.toUpperCase();
            //console.log(nombre);
            $('#nombreProducto').text(nombre);
            $('#tabla-listado-stock').html(texto);
        },
        error: function (xhr, status) {
            errores(xhr.status);
        }
    });
}