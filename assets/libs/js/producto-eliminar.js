$(document).ready(function(){
    $('#msjElim').hide();
    cargarTabla();
    $('#btnEliminar').click(eliminar);
    $('#busqueda').keyup(buscar);
});

var token = localStorage.token;
var id_producto = 0;

function cargarTabla()
{
    $.ajax({
        url: "../producto/traerTodos/",
        dataType: 'json',
        headers: {
            'token':token
        },
        success: function (respuesta) {
            var texto = "<thead><tr><th>Id</th><th>Nombre</th><th>Descripcion</th><th>Precio Compra</th><th>PVP</th><th>Proveedor</th><th>Categoria</th></tr></thead><tbody class='buscar'>";
            for (let i = 0; i < respuesta.length; i++) {
                texto += "<tr><td class='idp'>"+ respuesta[i].id +"</td><td>"+ respuesta[i].nombre +"</td><td>"+ respuesta[i].descripcion +"</td><td>"+ respuesta[i].precio_compra +"</td><td>"+ respuesta[i].pvp +"</td><td>"+ respuesta[i].proveedor +"</td><td>"+ respuesta[i].categoria +"</td></tr>";
                
            }
            texto += "</tbody>";
            $('#tabla-productos').html(texto);

            var tabla = $('#tabla-productos');
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
                    $('#eliminarModal').modal('show');
                });
            }
        },
        error: function (xhr, status) {
            //errores(xhr.status);
            alert(status + " " + xhr.status + " " + xhr.statusText);
            errores(xhr.status);
        }
    });
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

function eliminar()
{
    //console.log("eliminar!");
    $.ajax({
        url: "../producto/baja/" + id_producto,
        headers: {
            'token':token
        },
        success: function (respuesta) {
            //console.log(respuesta);
            //mostrar mensaje
            $('#eliminarModal').modal('hide');
            $('#msjElim').show();
            cargarTabla();
        },
        error: function (xhr, status) {
            alert(status + " " + xhr.status + " " + xhr.statusText);
            errores(xhr.status);
        }
    });

}