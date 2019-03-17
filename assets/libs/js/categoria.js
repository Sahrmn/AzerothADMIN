$(document).ready(function(){
    cargarTabla();
    $('#btnAgregar').click(function(){
        $('#modificar').hide();
        $('#cargar').show();
        $('#datosCategoria').modal('show');
        limpiarCampos();
    });
    $('#btnCancelar').click(function(){
        $('#datosCategoria').modal('hide');
    });
    $('#cargar').click(cargar);
    $('#btnEliminar').click(eliminar);
    $('#busqueda').keyup(buscar);
    $('#modificar').click(modificar);
    
    //validaciones del form
    $('#validationform').find('.form-control').each(function(){
        $(this).focusout(validar);
    });
});

var token = localStorage.token;
var id_categoria = 0;

function cargarTabla()
{
    $.ajax({
        url: "../categoria/traerTodos/",
        dataType: 'json',
        headers: {
            'token':token
        },
        beforeSend: function () {
            $("#info").html('<span class="dashboard-spinner spinner-md"></span>');
        },
        success: function (respuesta) {
            //console.log(respuesta);
            $("#info").html('');
            var texto = "<thead><tr><th>Id</th><th>Nombre</th></tr></thead><tbody class='buscar'>";
            for (let i = 0; i < respuesta.length; i++) {
                texto += "<tr><td class='idp'>"+ respuesta[i].id +"</td><td class='alineacion-tabla alinear-tabla'><div>"+ respuesta[i].nombre + "</div>";
                texto += "<div class='btn-group'><button id='btnModificar' class='btn btn-sm btn-outline-light'>Edit</button><button id='btnEliminarCategoria' class='btn btn-sm btn-outline-light'><i class='far fa-trash-alt'></i></button></div></td></tr>";
            }
            texto += "</tbody>";
            $('#tabla-categorias').html(texto);

            var tabla = $('#tabla-categorias');
            var tbody = tabla.children().find("tr");//todos los row de la tabla
            for (let i = 1; i-1 < tbody.length; i++) {
                //agrego eventos
                $(tbody[i]).mouseover(function(){
                    $(tbody[i]).css('background-color', '#f1f1f5');
                    //tomo el id de la fila 
                    $(tbody[i]).children().each(function(){
                        id_categoria = $(this).text();
                        return false;
                    });
                });
                $(tbody[i]).mouseout(function(){
                    $(tbody[i]).css('background-color', '#fff');
                });

                //evento click
                $(tbody[i]).click(ponerFoco);

                //agrego eventos de cada boton de cada row
                $(tbody[i]).find('#btnEliminarCategoria').click(function(){
                    $('#eliminarModal').modal('show');
                });
                $(tbody[i]).find('#btnModificar').click(mostrarBoxModifica);
            }

        },
        error: function (xhr, status) {
            //errores(xhr.status);
            alert(status + " " + xhr.status + " " + xhr.statusText);
            errores(xhr.status);
        }
    });
}

function modificar()
{
    var nom = $('#nombre').val();
    var desc = $('#descripcion').val();

    if(nom == "" || desc == "")
    {
        alert("Faltan campos para rellenar");
    }
    else
    {
        var parametros = {
            "nombre": nom,
            "descripcion": desc
        };

        $.ajax({
            type: 'POST',
            url: "../categoria/modificar/" + id_categoria,
            data: parametros,
            headers: {
                'token':token
            },
            success: function (respuesta) {
                //mostrar mensaje
                console.log(respuesta);
                $('#msj').text("Categoria modificada correctamente");
                $('#datosCategoria').modal('hide');
                $('#msj').show();
                cargarTabla();
                limpiarCampos();
                $('#msj').fadeOut(5000);
            },
            error: function (xhr, status) {
                alert(status + " " + xhr.status + " " + xhr.statusText);
                errores(xhr.status);
            }
        });
    }
}

function eliminar()
{
    $.ajax({
        url: "../categoria/baja/" + id_categoria,
        headers: {
            'token':token
        },
        success: function (respuesta) {
            //mostrar mensaje
            $('#msj').text("Categoria eliminada correctamente!");
            $('#eliminarModal').modal('hide');
            $('#msj').show();
            cargarTabla();
            $('#msj').fadeOut(4500);
        },
        error: function (xhr, status) {
            alert(status + " " + xhr.status + " " + xhr.statusText);
            errores(xhr.status);
        }
    });
}

function cargar(e)
{
    e.preventDefault();
    var nom = $('#nombre').val();
    var desc = $('#descripcion').val();

    if(nom == "" || desc == "")
    {
        alert("Faltan campos para rellenar");
    }
    else
    {
        var parametros = {
            "nombre": nom,
            "descripcion": desc
        };

        $.ajax({
            type: 'POST',
            url: "../categoria/",
            data: parametros,
            headers: {
                'token':token
            },
            success: function (respuesta) {
                //console.log(respuesta);
                //mensaje de producto cargado
                $('#msj').text("Categoria cargada correctamente");
                $('#msj').removeClass('no-mostrar');
                $('#datosCategoria').modal('hide');
                $('#msj').show();
                cargarTabla();
                limpiarCampos();
                $('#msj').fadeOut(5000);
            },
            error: function (xhr, status) {
                alert(status + " " + xhr.status + " " + xhr.statusText);
                errores(xhr.status);//llamo a funcion
            }
        });
    }
}

function mostrarBoxModifica()
{
    $('#modificar').show();
    $('#cargar').hide();
    quitarValidacion();

    //relleno campos
    $.ajax({
        url: "../categoria/traer/" + id_categoria,
        //dataType: 'json',
        headers: {
            'token':token
        },
        success: function (respuesta) {
            //mostrar mensaje
            $('#nombre').val(respuesta[0].nombre);
            $('#descripcion').val(respuesta[0].descripcion);
        },
        error: function (xhr, status) {
            alert(status + " " + xhr.status + " " + xhr.statusText);
            errores(xhr.status);
        }
    });
    $('#datosCategoria').modal('show');
}

function ponerFoco()
{
    var tabla = $('#tabla-categorias');
    var tbody = tabla.children().find("tr");//todos los tr de la tabla

    //recorro todos los td buscando el id 
    $(this).children().each(function(){
        id_categoria = $(this).text();
        return false;
    });
    
    //quito formatos de otras filas que podrian ser seleccionadas
    for (let f = 1; f-1 < tbody.length; f++) {
        $(tbody[f]).removeClass('btn-seleccion');
    }
    $(this).addClass('btn-seleccion');
}

function limpiarCampos()
{
    $('#nombre').val("");
    $('#descripcion').val("");
    quitarValidacion();
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

function validar()
{
    if($(this).val() == ""){
        $(this).removeClass('validado');
        $(this).addClass('no-validado');
    }
    else
    {
        $(this).removeClass('no-validado');
        $(this).addClass('validado');
    }
}

function quitarValidacion()
{
    $('#nombre').removeClass('no-validado');
    $('#nombre').removeClass('validado');
    $('#descripcion').removeClass('no-validado');
    $('#descripcion').removeClass('validado');
    $('#precio-compra').removeClass('no-validado');
    $('#precio-compra').removeClass('validado');
    $('#precio-venta').removeClass('no-validado');
    $('#precio-venta').removeClass('validado');
    $('#input-select-proveedor').removeClass('no-validado');
    $('#input-select-proveedor').removeClass('validado');
    $('#input-select-categoria').removeClass('no-validado');
    $('#input-select-categoria').removeClass('validado');
}
