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
                                <h2 class="pageheader-title">Listado de Productos </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a class="breadcrumb-link">Productos</a></li>
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
                            <h5 class="card-header">Seleccione...</h5>
                            <div class="card-body">
                                
                                <div id="msj" class="alert alert-success no-mostrar" role="alert">
                                    Producto eliminado correctamente!
                                </div>

                                <!--  <div id="msjStockVacio" class="alert alert-warning" role="alert">
                                    El producto no tiene cargado ningun stock.
                                </div> -->

                            <div class="row">
                                <div class="col-lg-2">
                                    <button id="btnAgregar" class="btn btn-primary">+ Agregar</button>
                                </div>
                                <div class="col-lg-10">
                                    <div id="custom-search" class="top-search-bar busqueda">
                                        <div class="row">
                                            <div class="col-lg-12 search">
                                                <input id="busqueda" class="form-control" type="text" placeholder="Search..">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!-- Modal PARA MOSTRAR INFO PRODUCTO -->
                                <div class="modal fade" id="mostrarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Productos</h5>
                                                <a class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table muestra">
                                                        <tbody>
                                                            <tr>
                                                                <td>Nombre: </td><td id="tdNombre">Nombre de prueba</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Descripcion: </td><td id="tdDescripcion">Descripcion de prueba</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Precio Compra: </td><td id="tdPC">100000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Precio Venta: </td><td id="tdPVP">100000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Proveedor: </td><td id="tdProveedor">Proveedor de prueba</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Propietarios: </td><td id="tdPropietarios">Propietario de prueba</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Categoria: </td><td id="tdCategoria">Categoria de prueba</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Stock: </td><td id="tdStock">00</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                               <!-- <a id="btnEliminar" href="#" class="btn btn-primary">Eliminar</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin Modal -->

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
                                                <!--<div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Stock</label>
                                                    <div class="col-12 col-sm-8 col-lg-8">
                                                        <input id="stock" type="number" data-parsley-pattern="^[0-9]*\.[0-9]{2}$" required placeholder="Ingrese el stock actual..." class="form-control">
                                                    </div>
                                                </div>-->
                                                
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
    <script src="../assets/libs/js/producto.js"></script>
</body>
 
</html>