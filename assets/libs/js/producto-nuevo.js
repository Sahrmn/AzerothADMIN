$(document).ready(function(){
    rellenarCombo();
    $('#nav-producto').addClass('active');
    $('#btn-limpiar').click(limpiarCampos);
    $('#cargar').click(cargarProducto);

    //console.log($('#validationform').find('.form-control'));
    //agrego evento para validacion de cada input
    $('#validationform').find('.form-control').each(function(){
        $(this).focusout(validar);
    });

});

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
    var token = localStorage.token;
    
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

function limpiarCampos()
{
    $('#nombre').val("");
    $('#descripcion').text("");
    $('#precio-compra').text("");
    $('#precio-venta').text("");
}

function cargarProducto(e)
{
    e.preventDefault();
    var token = localStorage.token;

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
        $('#titulo-modal').text("Productos");
        $('.modal-body').html("<p>Faltan campos para rellenar.</p>");
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
        
        //console.log(parametros);

        $.ajax({
            type: 'POST',
            url: "../producto/",
            data: parametros,
            /*dataType: 'json',*/
            headers: {
                'token':token
            },
            success: function (respuesta) {
                //console.log(respuesta);
                //mensaje de producto cargado
                $('#titulo-modal').text("Productos");
                $('.modal-body').html("<p>Producto cargado correctamente.</p>");
            },
            error: function (xhr, status) {
                alert(status + " " + xhr.status + " " + xhr.statusText);
                errores(xhr.status);//llamo a funcion
            }
        });
    }
}

function checkNoCheck()
{
    var chk0 = $('#chk0')[0].checked;
    console.log(chk0);
}


