<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require './composer/vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/AutentificadorJWT.php';
require_once './clases/usuario.php';
require_once './clases/producto.php';
require_once './clases/categoria.php';
require_once './clases/proveedor.php';
require_once './clases/stock.php';
require_once './clases/venta_producto.php';
require_once './clases/venta.php';
require_once './middleware/MWusuarios.php';
require_once './middleware/MWLog.php';


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(["settings" => $config]);


// nombre, clave
$app->post('/login/', function (Request $request, Response $response) {
  $ArrayDeParametros = $request->getParsedBody();
  return Usuario::verificarCrearToken($ArrayDeParametros); //nombre, clave
});

$app->post('/verificarJWT/', function (Request $request, Response $response) {
  return MWusuarios::verificarJWT($request, $response);
});

$app->group('/producto', function(){
  /* nombre, descripcion, precio_compra, pvp, id_proveedor, id_usuario1 ... id_usuario2, id_categoria */
  $this->post('/', \Producto::class . ':InsertarProducto');

  //id
  $this->get('/baja/{id}', \Producto::class . ':BajaProducto');

  //id, [nombre, descripcion, precio_compra, pvp, id_proveedor, id_usuario1 ... id_usuario2, id_categoria]
  $this->post('/modificar/{id}', \Producto::class . ':ModificarProducto');
  
  $this->get('/traerTodos/', \Producto::class . ':traerTodos');
  $this->get('/traer/{id}', \Producto::class . ':traerUno');
  $this->get('/traerInfo/{id}', \Producto::class . ':traerInfoUno');//traigo info de un prod sin ids
  $this->get('/buscar/{cadena}', \Producto::class . ':Busqueda');
  
  //recordar hacer: si el precio de compra cambia, hacer un log o parecido para registrarlo
});


$app->group('/categoria', function(){
  //nombre, descripcion
  $this->post('/', \Categoria::class . ':InsertarCategoria');

  //id
  $this->get('/baja/{id}', \Categoria::class . ':BajaCategoria');

  //id, [nombre, descripcion]
  $this->post('/modificar/{id}', \Categoria::class . ':ModificarCategoria');

  $this->get('/traerTodos/', \Categoria::class . ':traerTodos');
  $this->get('/traer/{id}', \Categoria::class . ':traerUno');
});


$app->group('/proveedor', function(){
  //nombre, mail, descripcion
  $this->post('/', \Proveedor::class . ':InsertarProveedor');

  //id
  $this->get('/baja/{id}', \Proveedor::class . ':BajaProveedor');

  //id, [nombre, mail, descripcion]
  $this->post('/modificar/{id}', \Proveedor::class . ':ModificarProveedor');

  $this->get('/traerTodos/', \Proveedor::class . ':traerTodos');
  $this->get('/traer/{id}', \Proveedor::class . ':traerUno');
});


$app->group('/usuario', function(){
  //nombre, clave
  $this->post('/', \Usuario::class . ':CrearUsuario'); 

  //id
  $this->get('/baja/{id}', \Usuario::class . ':BajaUsuario');

  //id, [nombre, clave]
  $this->post('/modificar/{id}', \Usuario::class . ':ModificarUsuario');

  //header->token
  $this->post('/traerDatos', \Usuario::class . ':traerDatos');

  $this->get('/traerTodos/', \Usuario::class . ':traerTodos');
});


$app->group('/venta', function(){
  //fecha, id_producto1... id_producto2..., cantidad1, cantidad2... , precio1, precio2....
  $this->post('/generar/', \Venta::class . ':GenerarVenta'); 

  //id
  $this->get('/baja/{id}', \Venta::class . ':EliminarVenta');
  //$this->post('/modificar/{id}', \Venta::class . ':ModificarVenta');//revisar periodos de modificacion y usuarios con privilegios
  $this->get('/ver/{fecha_ini}/{fecha_fin}', \Venta::class . ':TraerVentas');
});


$app->group('/stock', function(){
  //get: id_producto --- post: cantidad
  $this->post('/carga/{id}', \Stock::class . ':CargaStock');
  $this->get('/mostrar/', \Stock::class . ':MostrarStock');
  $this->get('/mostrar/{id}', \Stock::class . ':MostrarUno');
});


$app->add(\MWusuarios::class . ':AccesoUsuarioRegistrado');

$app->add(\MWLog::class . ':LogActividades');

$app->run();