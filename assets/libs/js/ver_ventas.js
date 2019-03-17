$(document).ready(function(){
    $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        autoPick: true,
        format: 'dd-mm-yyyy',
        zIndex: 2048,
    });

    var fecha_ini = $('#fecha_inicio').val();
    var fecha_fin = $('#fecha_fin').val();
    
    //dar vuelta fecha
    fecha_ini = formatoFecha(fecha_ini);
    fecha_fin = formatoFecha(fecha_fin);
    
    cargaVentas(fecha_ini, fecha_fin);

    $('#btnBuscarVentas').click(function(){
        fecha_ini = $('#fecha_inicio').val();
        fecha_fin = $('#fecha_fin').val();
        fecha_ini = formatoFecha(fecha_ini);
        fecha_fin = formatoFecha(fecha_fin);
        cargaVentas(fecha_ini, fecha_fin);
    });
});

function cargaVentas(fecha_inicio, fecha_fin)
{
    var fecha_in = new Date(fecha_inicio);
    var fecha_fn = new Date(fecha_fin);

    if(fecha_in <= fecha_fn)
    {
        $.ajax({
            url: "../venta/ver/" + fecha_inicio + "/" + fecha_fin,
            dataType: 'json',
            headers: {
                'token':token
            },
            success: function (respuesta) {
                console.log(respuesta);
                if(respuesta.length > 1)
                {
                    var texto = "";
                    for (let i = 0; i < respuesta.length; i++) {
                        var n = i + 1;
                        texto += "<tr><th scope='row'><h5 class='mb-0'><button id='btnUno"+ n +"' class='btn btn-link collapsed' data-toggle='collapse' data-target='#collapseUno"+ n +"' aria-expanded='false' aria-controls='collapseUno"+ n +"'><span class='fas fa-angle-down mr-3'></span>";
                        texto += respuesta[i].fecha;
                        texto += "</button></h5><div id='collapseUno"+ n +"' class='collapse' aria-labelledby='headingEleven' data-parent='#accordion4'><div class='card-body'>";
                        texto += respuesta[i].nombre;
                        texto += "</div></div></th><td><span class='fas fa-dollar-sign mr-3'></span>" + respuesta[i].precio * respuesta[i].cantidad + "</td></tr>";
                    }
                    $('#tbodyVentas').html(texto);
                }
                else
                {
                    $('#msjAlert').text(respuesta.respuesta);
                    $('#msjAlert').show();
                    $('#msjAlert').fadeOut(5400);
                    $('#tbodyVentas').html("<th scope='row'><h5>" + respuesta.respuesta + "</h5></th>");
                }
            },
            error: function (xhr, status) {
                alert(status + " " + xhr.status + " " + xhr.statusText);
                //errores(xhr.status);
            }
        });
    }
    else
    {
        console.log("La fecha de inicio debe ser menor a la fecha final");
    }
}

function formatoFecha(texto)
{
    return texto.replace(/^(\d{2})-(\d{2})-(\d{4})$/g,'$3-$2-$1');
}
