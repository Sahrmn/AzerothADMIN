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

                            
                            <h5 class="card-header">Visualización de Ventas</h5>
                            <div class="card-body">
                                
                                <div id="msj" class="alert alert-success no-mostrar" role="alert">
                                    Producto eliminado correctamente!
                                </div>
                                
                                <div id="msjAlert" class="alert alert-warning no-mostrar" role="alert">
                                    No se encontraron ventas...
                                </div> 
                                
                                <!-- DATEPICKER  -->
                                
                                <div class="row">
                                <div class="col-lg-4">
                                    <div class="docs-datepicker">
                                        <div class="input-group">
                                            <input id="fecha_inicio" data-toggle="datepicker" readonly type="text" class="docs-date input-date-picker-from form-control" name="date" placeholder="Fecha...">
                                            <div class="input-group-append">
                                                <button class="btn btn-light active docs-datepicker-trigger" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                <div class="docs-datepicker">
                                        <div class="input-group">
                                            <input id="fecha_fin" data-toggle="datepicker" readonly type="text" class="docs-date input-date-picker-from form-control" name="date" placeholder="Fecha...">
                                            <div class="input-group-append">
                                                <button class="btn btn-light active docs-datepicker-trigger" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <button id="btnBuscarVentas" class="btn btn-primary">Buscar</button>
                                </div>
                                </div>
                                <!-- FIN DATEPICKER  -->

                                

                        <!-- ============================================================== -->
                        <!-- responsive table -->
                        <!-- ============================================================== -->
                        <div class="col-sm-12 col-12">
                            <div class="cont-table-v">
                                    <div class="table-responsive ">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="percent90">Fecha</th>
                                                    <th scope="col">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyVentas">
                                                <tr>
                                                    <!--<th scope="row">
                                                        <h5 class="mb-0">
                                                            <button id="btnUno" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseUno" aria-expanded="false" aria-controls="collapseUno">
                                                                <span class="fas fa-angle-down mr-3"></span>01/03/2019
                                                            </button>       
                                                        </h5>
                                                        <div id="collapseUno" class="collapse" aria-labelledby="headingEleven" data-parent="#accordion4">
                                                            <div class="card-body">
                                                            Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <td>250</td>-->
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end responsive table -->
                        <!-- ============================================================== -->




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
    <script src="../assets/libs/js/ver_ventas.js"></script>
    <!-- Datepicker -->
    <link href="https://fengyuanchen.github.io/datepicker/css/datepicker.css" rel="stylesheet"/>
    <script src="https://fengyuanchen.github.io/datepicker/js/datepicker.js"></script>
    <script src="../node_modules/@chenfengyuan/datepicker/i18n/datepicker.es-ES.js"></script>

    

</body>
 
</html>