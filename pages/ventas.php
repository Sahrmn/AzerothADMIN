<!-- jquery 3.3.1 -->
<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script>
    var jwt = localStorage.token;
    if(jwt == null)
    {
        location.href = "./403.html";
    }
    else
    {
        $.ajax({
        type: 'POST',
        url: "../verificarJWT/",
        dataType: 'json',
        headers: {
            'token':jwt
        },
        success: function (respuesta) {
            //console.log(respuesta);
            if(respuesta.respuesta == false)
            {
                location.href = "./403.html";
            }
        },
        error: function (xhr, status) {
            //errores(xhr.status);
            alert(status + " " + xhr.status + " " + xhr.statusText);
        }
        });
    }
</script>
<!doctype html>
<html lang="es">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/libs/css/mystyle.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="../assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">

    <title>Azeroth Administrador</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        
        <?php include_once "navbar.html" ?>

        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        
        <?php include_once "menu.html" ?>

        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Ventas</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <!--<li class="breadcrumb-item"><a class="breadcrumb-link">Productos</a></li>-->
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">

                        <!-- DATEPICKER -->
                        
                        <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="docs-datepicker">
                                <div class="input-group">
                                    <input id="fecha" data-toggle="datepicker" readonly type="text" class="docs-date input-date-picker-from form-control" name="date" placeholder="Fecha...">
                                    <div class="input-group-append">
                                        <button class="btn btn-light active docs-datepicker-trigger" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        </div>
                        <!-- FIN DATEPICKER -->

                            <h5 class="card-header">Carga de Ventas</h5>
                            <div class="card-body">
                                
                                <div id="msj" class="alert alert-success no-mostrar" role="alert">
                                    Producto eliminado correctamente!
                                </div>

                                <div id="msjAlert" class="alert alert-warning no-mostrar" role="alert">
                                    Rellenar filas antes de agregar otra...
                                </div> 

                            <div class="row" id="row-principal">
                                <div class="col-lg-1 col-btn">
                                    <button id="btnAgregarP1" class="btn btn-primary btn-mas fas fa-plus btnAgregarP" title="Agregar fila"></button>
                                </div>
                                <div class="col-lg-5 col-input-prod">
                                    <div class="ProdSearch">
                                        <input class="form-control search-box" type="text" id="search-box1" placeholder="Ingrese nombre de producto..." />
                                        <div id="suggesstion-box1" class="form-control suggesstion-box"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-input-prod">
                                    <div class="btn-group">
                                        <input type="number" class="form-control anc_alt cantidad" name="cantidad" id="cantidad1">
                                        <div class="input-group-prepend"><span class="input-group-text alt80 marg-l">$</span></div>
                                            <input id="total1" type="text" class="form-control anc_alt total">
                                        <div class="dlk-radio btn-group">
                                            <label id="ingreso1" class="btn btn-success btn-ie alt80" title="Ingreso">
                                                <input class="form-control" type="radio" value="1">
                                                <i name="ingreso1" class="fas fa-angle-up glyphicon glyphicon-ok"></i>
                                            </label>
                                            <label id="egreso1" class="btn btn-danger btn-ie no-seleccionado alt80" title="Egreso/Extraccion">
                                                <input name="egreso1" class="form-control" type="radio" value="2" defaultchecked="checked">
                                                <i class="fas fa-angle-down glyphicon glyphicon-remove"></i>
                                            </label>
                                        </div>
                                        <button id="trash1" class="btn btn-outline-danger fas fa-trash alt80" title="Borrar"></button>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="filasNuevas"></div>

                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-5"></div>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <h1 class="text-primary">Total</h1>
                                        <span class="h2 text-primary">$</span>
                                        <h1 id="montoTotal" class="mb-1 text-primary">0</h1>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <a id="btnCargarVenta" href="#" class="btn btn-primary btn-block">Cargar Venta</a>

                            </div>

                                <!-- Modal -->
                                <div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Productos</h5>
                                                <a class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Esta seguro que quiere eliminar el producto?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                                <a id="btnEliminar" href="#" class="btn btn-primary">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin Modal -->

                                <!-- MODAL PARA MODIFICAR STOCK -->
                                <!-- Modal -->
                                <div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Carga Stock</h5>
                                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                            <h5 id="nombreProducto">Nombre del producto</h5>
                                            <div class="row">
                                            <!-- ============================================================== -->
                                            <!-- basic table -->
                                            <!-- ============================================================== -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="card-body">
                                                    <table class="table" id="tabla-listado-stock">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Id</th>
                                                                <th scope="col">Cantidad</th>
                                                                <th scope="col">Fecha</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-agregar">
                                                <p>Agregar:</p>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="number" name="numberStock" id="inputStock" class="form-control">
                                            </div>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                            <a id="guardarStock" href="#" class="btn btn-primary">Save changes</a>
                                        </div>
                                    </div>
                                    </div>
                                </div> 
                                <!-- FIN MODAL STOCK -->

                                 
                                <!-- MODAL DATOS PRODUCTOS -->
                                <div class="modal fade" id="datosProductos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Productos</h5>
                                                <a class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                            
                                            <!-- inicio cuerpo -->

                                            <div class="container">
                                            <form id="validationform" data-parsley-validate="" novalidate="">
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Nombre</label>
                                                    <div class="col-12 col-sm-8 col-lg-8">
                                                        <input id="nombre" type="text" required="" placeholder="Ingrese un nombre para el producto..." class="form-control">
                                                    </div>
                                                </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Descripcion</label>
                                                        <div class="col-12 col-sm-8 col-lg-8">
                                                        <textarea id="descripcion" placeholder="Ingrese una breve descripcion del producto..." required="" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Precio Compra</label>
                                                    <div class="col-12 col-sm-8 col-lg-8">
                                                        <input id="precio-compra" type="number" data-parsley-pattern="^[0-9]*\.[0-9]{2}$" required placeholder="Ingrese el precio de venta del proveedor..." class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Precio Venta(PVP)</label>
                                                    <div class="col-12 col-sm-8 col-lg-8">
                                                        <input id="precio-venta" type="number" data-parsley-pattern="^[0-9]*\.[0-9]{2}$" required placeholder="Ingrese el precio de venta al publico..." class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Proveedor</label>
                                                    <div class="col-12 col-sm-8 col-lg-8">
                                                        <select class="form-control" id="input-select-proveedor">
                                                            <option>Opcion 1</option>
                                                            <option>Opcion 2</option>
                                                        </select>
                                                    </div>            
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Propietarios</label>
                                                    <div id="checkbox-propietario" class="col">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"><span class="custom-control-label">Opcion 1</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input check-select"><span class="custom-control-label">Opcion 2</span>
                                                        </label>
                                                    </div>
                                                </div>   
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Categoria</label>
                                                    <div class="col-12 col-sm-8 col-lg-8">
                                                        <select class="form-control" id="input-select-categoria">
                                                            <option>Opcion 1</option>
                                                            <option>Opcion 2</option>
                                                        </select>
                                                    </div>            
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Stock</label>
                                                    <div class="col-12 col-sm-8 col-lg-8">
                                                        <input id="stock" type="number" data-parsley-pattern="^[0-9]*\.[0-9]{2}$" required placeholder="Ingrese el stock actual..." class="form-control">
                                                    </div>
                                                </div>
                                                
                                            </form>
                                            </div>

                                            <!-- fin cuerpo -->

                                            </div>
                                            <div class="modal-footer">
                                                <button id="modificar" type="submit" class="btn btn-space btn-primary">Modificar</button>
                                                <button id="cargar" type="submit" class="btn btn-space btn-primary">Cargar</button>
                                                <button id="btnCancelar" class="btn btn-space btn-secondary">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin Modal -->


                                <div class="table-responsive">
                                    <table id="tabla-productos" class="table table-hover table-bordered first">
                                    
                                    <div class="row">
                                        <div class="col-lg-5"></div>
                                        <div class="col-lg-2">
                                            <div id="info"></div>
                                        </div>
                                        <div class="col-lg-5"></div>
                                    </div>    
                                        
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end basic table  -->
                    <!-- ============================================================== -->
                </div>
                
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            
            <?php include_once "footer.html" ?>

            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- bootstap bundle js -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="../assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="../assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="../assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="../assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="../assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="../assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="../assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="../assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="../assets/libs/js/dashboard-ecommerce.js"></script>
    <!-- My Script -->
    <script src="../assets/libs/js/myscript.js"></script>
    <script src="../assets/libs/js/ventas.js"></script>
    <!-- Datepicker -->
    <link href="https://fengyuanchen.github.io/datepicker/css/datepicker.css" rel="stylesheet"/>
    <script src="https://fengyuanchen.github.io/datepicker/js/datepicker.js"></script>
    <script src="../node_modules/@chenfengyuan/datepicker/i18n/datepicker.es-ES.js"></script>

    

</body>
 
</html>