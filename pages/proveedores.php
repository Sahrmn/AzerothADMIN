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
                                <h2 class="pageheader-title">Listado de Proveedores </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a class="breadcrumb-link">Proveedores</a></li>
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
                                    Proveedor eliminado correctamente!
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

                                <!-- Modal -->
                                <div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Proveedor</h5>
                                                <a class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Esta seguro que quiere eliminar este proveedor?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                                <a id="btnEliminar" href="#" class="btn btn-primary">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin Modal -->

                                 
                                <!-- MODAL DATOS CATEGORIA -->
                                <div class="modal fade" id="datosProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Proveedor</h5>
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
                                                        <input id="nombre" type="text" required="" placeholder="Ingrese un nombre..." class="form-control">
                                                    </div>
                                                </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Descripcion</label>
                                                        <div class="col-12 col-sm-8 col-lg-8">
                                                        <textarea id="descripcion" placeholder="Ingrese una breve descripcion..." required="" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Email</label>
                                                    <div class="col-12 col-sm-8 col-lg-8">
                                                        <input id="email" type="email" required placeholder="name@example.com" class="form-control">
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
                                    <table id="tabla-proveedores" class="table table-hover table-bordered first">
                                        
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
    <script src="../assets/libs/js/proveedor.js"></script>
</body>
 
</html>