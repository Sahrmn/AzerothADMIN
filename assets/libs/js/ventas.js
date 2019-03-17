$(document).ready(function(){
  //calendario
    $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        autoPick: true,
        format: 'dd-mm-yyyy',
        zIndex: 2048,
    });

    //botones ingreso/egreso
    $('#ingreso1').click(SetIngreso);
    $('#egreso1').click(SetEgreso);
    
    $(".search-box").keyup(traerProductos);
    $('.cantidad').val(1);
    $('.cantidad').change(calculoPrecio);
    $('#btnAgregarP1').click(agregarFila);
    $('#trash1').click(eliminar);
    $('#total1').change(calculoTotal);
    $('#btnCargarVenta').click(cargaVenta);
    
});

var cantLista = 1;
var listProd = new Array();

function traerProductos()
{
    if($(this).attr('id').length == 11)
    {
        var id = $(this).attr('id').substr(-1,1);
    }
    else
    {
        var id = $(this).attr('id').substr(-2,2);
    }
    var nom_search = "#search-box" + id;
    var cadena = $(nom_search).val();
    var nom_suggesstion = "#suggesstion-box" + id;
    
    if(cadena != "")
    {
        $.ajax({
            url: "../producto/buscar/" + cadena,
            dataType: 'json',
            headers: {
                'token':token
            },
            beforeSend: function(){
                $(nom_search).css("background","#fff url('../assets/images/preloader.gif') no-repeat 165px");
            },
            success: function (respuesta) {
                //console.log(respuesta);
                var data = "<ul class='list-group'>";
                for (let i = 0; i < respuesta.length; i++) {
                    data += "<li class='list-group-item item-prod z999' value="+ respuesta[i].id +">"+ respuesta[i].nombre +"</li>";
                }
                data += "</ul>";
                $(nom_suggesstion).show();
                $(nom_suggesstion).html(data);
                $('li').click(seleccionarItem);
            },
            error: function (xhr, status) {
                alert(status + " " + xhr.status + " " + xhr.statusText);
                errores(xhr.status);
            }
        });
    }
    else
    {
        $(nom_suggesstion).hide();   
    }
}    

function seleccionarItem()
{
    //console.log($(this).parent().parent().siblings().prop('id'));
    var nom_search = "#" + $(this).parent().parent().siblings().prop('id');
    var idProd = $(this).val();
    $(nom_search).val($(this).text());//nombre del producto
    $(nom_search).text($(this).val());//id del producto
    
    var nom_sugg = "#" + $(this).parent().parent().prop('id');
    $(nom_sugg).hide();
    
    $.ajax({
        url: "../producto/traer/" + idProd,
        dataType: 'json',
        headers: {
            'token':token
        },
        success: function (respuesta) {
            var producto = respuesta.producto[0];
            //si ya habia un producto cargado en esa posicion lo sobreescribo
            if(listProd[cantLista-1] == null)
            {
                listProd.push(producto);
            }
            else
            {
                listProd[cantLista-1] = producto;
            }
            var nom_total = "#total" + cantLista;
            var nom_cant = "#cantidad" + cantLista;
            $(nom_total).val(respuesta.producto[0].pvp * $(nom_cant).val());
            //console.log(respuesta);
            calculoTotal();
            //agregar validacion de maximo y minimo stock
            var cantidad = respuesta.stock[0].stock;
            $(nom_cant).keyup(function(){
                cantidad = parseInt(cantidad);
                nom_cantidad = $(nom_cant).val();
                nom_cantidad = parseInt(nom_cantidad);
                if(nom_cantidad < 1){
                    $('#msjAlert').text("Ingrese una cantidad dentro del stock permitido.");
                    $('#msjAlert').show();
                    $(nom_cant).val(1);
                }
                else if(nom_cantidad > cantidad){
                    $('#msjAlert').text("Ingrese una cantidad dentro del stock permitido.");
                    $('#msjAlert').show();
                    $(nom_cant).val(cantidad);
                }
                else{
                  $('#msjAlert').hide();
                }
            });
        },
        error: function (xhr, status) {
            alert(status + " " + xhr.status + " " + xhr.statusText);
            errores(xhr.status);
        }
    });

}
    
function calculoPrecio()
{
    var cantP = $(this).val();
    if($(this).attr('id').length == 9)
    {
        var id = $(this).attr('id').substr(-1,1);
    }
    else
    {   
        var id = $(this).attr('id').substr(-2,2);
    }
    var nom_total = "#total" + id;
    $(nom_total).val($(listProd)[id - 1].pvp * cantP);
    calculoTotal();
}

function calculoTotal()
{
    var total = 0;
    for (let i = 1; i <= listProd.length; i++) {
        var nom_total = '#total' + i;
        var num = $(nom_total).val();
        //quito coma si existe
        num = num.replace(",", ".");
        num = parseFloat(num);
        total += num;
    }
    //console.log(total);
    $('#montoTotal').text(total);
}

function agregarFila()
{
    var flag = false;
    var rows = $('#filasNuevas').children().each(function(){
        var col = $(this).children()[1];
        if($(col).find('input').val() == "")
        {
            flag = true;
        }
    });
    if(flag == false && cantLista == listProd.length)
    {        
        cantLista++;
        var texto = "<div class='row'>\
        <div class='col-lg-1 col-btn'>\
        <button id='btnAgregarP"+ cantLista +"' class='btn btn-primary btn-mas fas fa-plus btnAgregarP' title='Agregar fila'></button>\
        </div>\
        <div class='col-lg-5 col-input-prod'>\
        <div class='ProdSearch'>\
        <input class='form-control search-box' type='text' id='search-box"+ cantLista +"' placeholder='Ingrese nombre de producto...' />\
        <div id='suggesstion-box"+ cantLista +"' class='form-control suggesstion-box'></div></div>\
        </div>\
        <div class='col-lg-6 col-input-prod'>\
        <div class='btn-group'>\
        <input type='number' class='form-control anc_alt cantidad' name='cantidad' id='cantidad"+ cantLista +"'>\
        <div class='input-group-prepend'><span class='input-group-text alt80 marg-l'>$</span></div>\
        <input id='total"+ cantLista +"' type='text' class='form-control anc_alt total'>\
        <div class='dlk-radio btn-group'>\
        <label id='ingreso"+ cantLista +"' class='btn btn-success btn-ie alt80' title='Ingreso'>\
        <input name='ingreso"+ cantLista +"' class='form-control' type='radio' value='1'>\
        <i class='fas fa-angle-up glyphicon glyphicon-ok'></i>\
        </label>\
        <label id='egreso"+ cantLista +"' class='btn btn-danger btn-ie no-seleccionado alt80' title='Egreso/Extraccion'>\
        <input name='egreso"+ cantLista +"' class='form-control' type='radio' value='2' defaultchecked='checked'>\
        <i class='fas fa-angle-down glyphicon glyphicon-remove'></i>\
        </label>\
        </div>\
        <button id='trash"+ cantLista +"' class='btn btn-outline-danger fas fa-trash alt80' title='Borrar'></button>\
        </div>\
        </div>\
        </div>";
        
        $('#filasNuevas').append(texto);
        
        $(".search-box").keyup(traerProductos);
        $('.cantidad').val(1);
        $('.cantidad').change(calculoPrecio);
        var nom_btnAgregar = "#btnAgregarP"+ cantLista;
        $(nom_btnAgregar).click(agregarFila);
        var nom_trash = "#trash" + cantLista;
        $(nom_trash).click(eliminar);
        var nom_total = "#total" + cantLista;
        $(nom_total).change(calculoTotal);
        calculoTotal();
        //botones ingreso/egreso
        var nom_ing = '#ingreso' + cantLista;
        var nom_eg = '#egreso' + cantLista;
        $(nom_ing).click(SetIngreso);
        $(nom_eg).click(SetEgreso);
    }
    else
    {
        //console.log("Rellenar las filas anteriores...");
        //$('#msjAlert').
        $('#msjAlert').show();
        $('#msjAlert').fadeOut(5400);
    }
}

function eliminar() 
{
    if(listProd.length != 0)
    {
        var p = $(this).parents()[2];
        //console.log($(p).attr('id'));
        if($(p).attr('id') != "row-principal")
        {
            $(this).parents()[2].remove();
            var id = $(this).attr('id').substr(-1,1);
            listProd.splice(id-1, 1);
        }
        else
        {
            //limpio el search y el total
            var parent = $(this).parents()[2];
            //console.log($(parent).find('input'));
            var search = $(parent).find('input')[0];
            $(search).val("");
            var total = $(parent).find('input')[2];
            $(total).val("");
            var cant = $(parent).find('input')[1];
            $(cant).val(1);
        }
    }
    calculoTotal();
}

function cargaVenta()
{
    if(listProd.length != 0)
    {
        var fecha = $('#fecha').val();
        //dar vuelta fecha
        fecha = formatoFecha(fecha);
        var hora = new Date();
        hora = hora.getHours()+":"+hora.getMinutes()+":"+hora.getSeconds(); 
        var datetime = fecha + " " + hora;
        //console.log(datetime);
        
        var parametros = {
            'fecha': datetime
        };
        
        for (let i = 1; i <= listProd.length; i++) {
            parametros["id_producto" + i] = listProd[i-1].id;
            parametros["cantidad" + i] = $('#cantidad' + i).val();
            parametros["precio" + i] = $('#total' + i).val();
        }
        //console.log(parametros);
        $.ajax({
            url: "../venta/generar/",
            type: 'POST',
            data: parametros,
            headers: {
                'token':token
            },
            success: function (respuesta) {
                console.log(respuesta);
                $('#msjAlert').text("Venta generada con exito!");
                $('#msjAlert').show();
                $('#msjAlert').fadeOut(5400);
                listProd = [];
                console.log(listProd);
                limpiarCampos();
                
            },
            error: function (xhr, status) {
                alert(status + " " + xhr.status + " " + xhr.statusText);
                errores(xhr.status);
            }
        });
    }
    else
    {
        $('#msjAlert').text("Se debe cargar por lo menos un producto...");
        $('#msjAlert').show();
        $('#msjAlert').fadeOut(5400);
    }
}

function formatoFecha(texto)
{
    return texto.replace(/^(\d{2})-(\d{2})-(\d{4})$/g,'$3-$2-$1');
}

function limpiarCampos()
{
    $('.cantidad').val(1);
    $('.search-box').val("");
    $('.total').val("");
}

function SetIngreso()
{
    var n = $(this).prop('id');
    n = n.replace("ingreso","");
    
    $('#egreso' + n).addClass('no-seleccionado');
    $(this).removeClass('no-seleccionado');
    
    var numTotal = $('#total' + n).val();
    numTotal = numTotal.replace("-", "");
    $('#total' + n).val(numTotal);
    calculoTotal();
}

function SetEgreso()
{
    var n = $(this).prop('id');
    n = n.replace("egreso","");

    $('#ingreso' + n).addClass('no-seleccionado');
    $(this).removeClass('no-seleccionado');
    
    var numTotal = $('#total' + n).val();
    numTotal = numTotal.replace("-", "");
    numTotal = "-" + numTotal;
    $('#total' + n).val(numTotal);
    calculoTotal();
}


