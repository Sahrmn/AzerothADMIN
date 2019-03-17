$(document).ready(function(){
    $('#msj').hide();
    cargarTabla();
    rellenarCombo();
    
    $('#guardarStock').click(agregarStock);
    $('#btnEliminar').click(eliminar);
    $('#modificar').click(modificar);  
    $('#btnAgregar').click(function(){
        limpiarCampos();
        $('#modificar').hide();
        $('#cargar').show();
        $('#datosProductos').modal('show');
    });
    $('#cargar').click(cargarProducto);
    $('#btnCancelar').click(function(){
        $('#datosProductos').modal('hide');
    });

    $('#busqueda').keyup(buscar);

    //validaciones del form
    $('#validationform').find('.form-control').each(function(){
        $(this).focusout(validar);
    });
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
        beforeSend: function () {
            $("#info").html('<span class="dashboard-spinner spinner-md"></span>');
        },
        success: function (respuesta) {
            //console.log(respuesta);
            $("#info").html('');
            var texto = "<thead><tr><th>Id</th><th>Stock</th><th>Nombre</th></tr></thead><tbody class='buscar'>";
            for (let i = 0; i < respuesta.length; i++) {
                texto += "<tr><td class='idp'>"+ respuesta[i].id +"</td><td>"+ respuesta[i].total +"</td><td class='alineacion-tabla alinear-tabla'><div>"+ respuesta[i].nombre + "</div>";
                texto += "<div class='btn-group'><button id='btnVer' class='btn btn-sm btn-outline-light'>Ver</button><button id='btnStock' class='btn btn-sm btn-outline-light'>Stock</button><button id='btnModificar' class='btn btn-sm btn-outline-light'>Edit</button><button id='btnEliminarProducto' class='btn btn-sm btn-outline-light'><i class='far fa-trash-alt'></i></button></div></td></tr>";
            }
            texto += "</tbody>";
            $('#tabla-productos').html(texto);

            var tabla = $('#tabla-productos');
            var tbody = tabla.children().find("tr");//todos los row de la tabla
            for (let i = 1; i-1 < tbody.length; i++) {
                //agrego eventos
                $(tbody[i]).mouseover(function(){
                    $(tbody[i]).css('background-color', '#f1f1f5');
                    //tomo el id de la fila 
                    $(tbody[i]).children().each(function(){
                        id_producto = $(this).text();
                        return false;
                    });
                });
                $(tbody[i]).mouseout(function(){
                    $(tbody[i]).css('background-color', '#fff');
                });

                //evento click
                $(tbody[i]).click(ponerFoco);

                //agrego eventos de cada boton de cada row
                $(tbody[i]).find('#btnEliminarProducto').click(function(){
                    $('#eliminarModal').modal('show');
                });
                $(tbody[i]).find('#btnStock').click(function(){
                    cargarListadoUnProducto();
                    $('#stockModal').modal('show');
                });
                $(tbody[i]).find('#btnModificar').click(mostrarBoxModifica);
                $(tbody[i]).find('#btnVer').click(verProducto);
                    
            }

        },
        error: function (xhr, status) {
            //errores(xhr.status);
            alert(status + " " + xhr.status + " " + xhr.statusText);
            errores(xhr.status);
        }
    });
}

function verProducto()
{
    $.ajax({
        url: "../producto/traerInfo/"+ id_producto,
        dataType: 'json',
        headers: {
            'token':token
        },
        success: function (respuesta) {
            console.log(respuesta);
            var producto = respuesta.producto[0];
            $('#tdNombre').text(producto.nombre);
            $('#tdDescripcion').text(producto.descripcion);
            $('#tdPC').text(producto.precio_compra);
            $('#tdPVP').text(producto.pvp);
            $('#tdProveedor').text(producto.proveedor);
            $('#tdCategoria').text(producto.categoria);
            $('#tdStock').text(respuesta.stock[0].stock);
            var propietarios = respuesta.propietarios;
            console.log(propietarios);
            var prop = "";
            //cargo nombres de propietarios
            for (let i = 0; i < propietarios.length; i++) {
                prop += propietarios[i].nombre;
                if(i != (propietarios.length - 1))
                {
                    prop += ", ";
                }
            }
            $('#tdPropietarios').text(prop);
        },
        error: function (xhr, status) {
            errores(xhr.status);
            alert(status + " " + xhr.status + " " + xhr.statusText);
        }
    });
    $('#mostrarModal').modal('show');
}

function agregarStock()
{
    var cantidad = $('#inputStock').val();
    if(cantidad == "" || cantidad == 0)
    {
        //mensaje de ingresar stock
        alert("Ingrese una cantidad");
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
                cargarListadoUnProducto();
                cargarTabla();
            },
            error: function (xhr, status) {
                errores(xhr.status);
                alert(status + " " + xhr.status + " " + xhr.statusText);
            }
        });
    }
}

function cargarListadoUnProducto()
{

    $.ajax({
        url: "../stock/mostrar/"+ id_producto,
        dataType: 'json',
        headers: {
            'token':token
        },
        success: function (respuesta) {
            //console.log(respuesta);
            if(respuesta.bool != false)
            {
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
            }
            else
            {
                //si no hay stock cargado dejo todo en 0
                $('#nombreProducto').text("PRODUCTO NUEVO STOCK");
                var texto = "<thead><tr><th>Id</th><th>Cantidad</th><th>Fecha</th></tr></thead><tbody class='buscar'>";
                texto += "<tr><td class='idp'>0</td><td>0</td><td>Nunca cargado</td></tr>";
                texto += "</tbody>";
                $('#tabla-listado-stock').html(texto);
            }
        },
        error: function (xhr, status) {
            errores(xhr.status);
        }
    });
}

function mostrarBoxModifica()
{
    $('#modificar').show();
    $('#cargar').hide();
    quitarValidacion();

    //limpiar checkbox
    $('input:checkbox:checked').each(
        function(){
            $(this).prop('checked', false);
        }
    );

    //relleno campos
    $.ajax({
        url: "../producto/traer/" + id_producto,
        //dataType: 'json',
        headers: {
            'token':token
        },
        success: function (respuesta) {
            //mostrar mensaje
            //console.log(respuesta);
            var producto = respuesta.producto[0];
            var arrayProp = respuesta.propietarios;

            for (let i = 0; i < arrayProp.length; i++) {
                var valor = arrayProp[i].id_usuario;
                //console.log(valor);
                $('input[value='+ valor +']').prop('checked', true);
            }

            $('#nombre').val(producto.nombre);
            $('#descripcion').val(producto.descripcion);
            $('#precio-compra').val(producto.precio_compra);
            $('#precio-venta').val(producto.pvp);
            $('#input-select-proveedor').val(producto.id_proveedor).change();
            $('#input-select-categoria').val(producto.id_categoria).change();
        },
        error: function (xhr, status) {
            alert(status + " " + xhr.status + " " + xhr.statusText);
            errores(xhr.status);
        }
    });
    $('#datosProductos').modal('show');
}

function modificar()
{
    var nom = $('#nombre').val();
    var desc = $('#descripcion').val();
    var pc = $('#precio-compra').val();
    var precio_vp = $('#precio-venta').val();
    var proveedor = $('#input-select-proveedor').val();
    var categoria = $('#input-select-categoria').val();
    
    var prop = 0;
    $('input:checkbox:checked').each(
        function(){
            prop = prop + 1;
        }
    );
    if(nom == "" || desc == "" || pc == "" || precio_vp == "" || prop == 0)
    {
        if(prop == 0)
        {
            //si no hay checkbox seleccionados, los pinto de rojo
            $('input:checkbox').each(
                function(){
                    //console.log(this);
                    $(this).addClass('is-invalid');
                    
                    //si hago click en un checkbox se despintan de rojo todos los checkbox
                    $(this).click(function(){
                        $('input:checkbox').removeClass('is-invalid');
                    });
                }
            );
        }
        alert("Faltan campos para rellenar");
    }
    else
    {
        var parametros = {
            "nombre": nom,
            "descripcion": desc,
            "precio_compra": pc,
            "pvp": precio_vp,
            "id_proveedor": proveedor,
            "id_categoria": categoria
        };

        var i = 1;
        $('input:checkbox:checked').each(
            function(){
                parametros["id_usuario" + i] = $(this).val();
                i++;
            }
        );
        
        $.ajax({
            type: 'POST',
            url: "../producto/modificar/" + id_producto,
            data: parametros,
            headers: {
                'token':token
            },
            success: function (respuesta) {
                //mostrar mensaje
                //console.log(respuesta);
                $('#msj').text("Producto modificado correctamente");
                $('#datosProductos').modal('hide');
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
            //mostrar mensaje
            $('#eliminarModal').modal('hide');
            $('#msj').show();
            cargarTabla();
        },
        error: function (xhr, status) {
            alert(status + " " + xhr.status + " " + xhr.statusText);
            errores(xhr.status);
        }
    });

}

function ponerFoco()
{
    var tabla = $('#tabla-productos');
    var tbody = tabla.children().find("tr");//todos los tr de la tabla

    //recorro todos los td buscando el id 
    $(this).children().each(function(){
        id_producto = $(this).text();
        return false;
    });
    
    //quito formatos de otras filas que podrian ser seleccionadas
    for (let f = 1; f-1 < tbody.length; f++) {
        $(tbody[f]).removeClass('btn-seleccion');
    }
    $(this).addClass('btn-seleccion');
}

function validar()
{
    //console.log("valor:" + $(this).val());
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

function rellenarCombo()
{    
    //recupero proveedores
    $.ajax({
        url: "../proveedor/traerTodos/",
        dataType: 'json',
        headers: {
            'token':token
        },
        success: function (respuesta) {
            //console.log(respuesta);
            var texto = "";
            for (let i = 0; i < respuesta.length; i++) {
                texto += "<option value='" + respuesta[i].id + "'>" + respuesta[i].nombre + "</option>";
            }
            $('#input-select-proveedor').html(texto);
        },
        error: function (xhr, status) {
            errores(xhr.status);
        }
    });

    //recupero propietarios
    $.ajax({
        url: "../usuario/traerTodos/",
        dataType: 'json',
        headers: {
            'token':token
        },
        success: function (respuesta) {
            //console.log(respuesta);
            var texto = "";
            for (let i = 0; i < respuesta.length; i++) {
                texto += "<label class='custom-control custom-checkbox'><input id='chk"+ i +"' type='checkbox' value='" + respuesta[i].id + "' class='custom-control-input'><span class='custom-control-label'>" + respuesta[i].nombre + "</span></label>";
                
            }
            $('#checkbox-propietario').html(texto);
            
            //agrego evento change a cada checkbox agregado
            for (let i = 0; i < respuesta.length; i++) {
                var selector = '#chk' + i;
                //$(selector).change(checkNoCheck);
            }
        },
        error: function (xhr, status) {
            errores(xhr.status);
        }
    });

    //recupero categorias
    $.ajax({
        url: "../categoria/traerTodos/",
        dataType: 'json',
        headers: {
            'token':token
        },
        success: function (respuesta) {
            //console.log(respuesta);
            var texto = "";
            for (let i = 0; i < respuesta.length; i++) {
                texto += "<option value='" + respuesta[i].id + "'>" + respuesta[i].nombre + "</option>";
            }
            $('#input-select-categoria').html(texto);
        },
        error: function (xhr, status) {
            errores(xhr.status);//llamo a funcion
        }
    });
}

function cargarProducto(e)
{
    e.preventDefault();
    var nom = $('#nombre').val();
    var desc = $('#descripcion').val();
    var pc = $('#precio-compra').val();
    var precio_vp = $('#precio-venta').val();
    var proveedor = $('#input-select-proveedor').val();
    var categoria = $('#input-select-categoria').val();
    var stock = $('#stock').val();
    
    var prop = 0;
    $('input:checkbox:checked').each(
        function(){
            prop = prop + 1;
        }
    );

    if(nom == "" || desc == "" || pc == "" || precio_vp == "" || prop == 0)
    {
        //e.stopPropagation();
        if(prop == 0)
        {
            //si no hay checkbox seleccionados, los pinto de rojo
            $('input:checkbox').each(
                function(){
                    //console.log(this);
                    $(this).addClass('is-invalid');
                    
                    //si hago click en un checkbox se despintan de rojo todos los checkbox
                    $(this).click(function(){
                        $('input:checkbox').removeClass('is-invalid');
                    });
                }
            );
        }
        //mensaje de faltan campos para rellenar
        alert("Faltan campos para rellenar");
    }
    else
    {
        var parametros = {
            "nombre": nom,
            "descripcion": desc,
            "precio_compra": pc,
            "pvp": precio_vp,
            "id_proveedor": proveedor,
            "id_categoria": categoria,
            "stock": stock
        };

        var i = 1;
        $('input:checkbox:checked').each(
            function(){
                parametros["id_usuario" + i] = $(this).val();
                i++;
            }
        );
        //console.log(parametros);

        $.ajax({
            type: 'POST',
            url: "../producto/",
            data: parametros,
            headers: {
                'token':token
            },
            success: function (respuesta) {
                console.log(respuesta);
                //mensaje de producto cargado
                $('#msj').text("Producto cargado correctamente");
                $('#msj').removeClass('no-mostrar');
                $('#datosProductos').modal('hide');
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

function limpiarCampos()
{
    $('#nombre').val("");
    $('#descripcion').val("");
    $('#precio-compra').val("");
    $('#precio-venta').val("");
    $('input:checkbox:checked').each(
        function(){
            $(this).prop('checked', false);
        }
    );
    $('#stock').val(1);
    quitarValidacion();
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
