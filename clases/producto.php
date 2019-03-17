<?php 
include_once 'productoPDO.php';
include_once 'producto_usuarioPDO.php';

class Producto
{
	public $id;
	public $nombre;	
	public $descripcion;
	public $precio_compra;
	public $pvp;
	public $id_proveedor;
	public $id_categoria;


	public function __construct($nom = null, $descripcion = null, $precioc = null, $pvp = null, $id_proveedor = null, $id_categoria = null)
	{
		if(func_num_args() != 0)
		{
			$this->nombre = $nom;
			$this->descripcion = $descripcion;
			$this->precio_compra = $precioc;
			$this->pvp = $pvp;
			$this->id_proveedor = $id_proveedor;
			$this->id_categoria = $id_categoria;
		}
	}

	public static function InsertarProducto($request, $response)
	{
		$newResponse = new stdclass();
		$nueva = new stdclass();
		$param = $request->getParsedBody();
		if(isset($param['nombre']) != null && isset($param['descripcion']) != null && isset($param['precio_compra']) != null && isset($param['pvp']) != null && isset($param['id_proveedor']) != null && isset($param['id_usuario1']) != null && isset($param['id_categoria']) != null && isset($param['stock']) != null)
		{
			//veo cuantos usuarios hay ingresados 
			$num = 1;
			while($num)
			{
				$usuario = "id_usuario" . $num;
				if(isset($param[$usuario]))
					$num++;
				else
					break;
			}
			
			$prod = new Producto($param['nombre'], $param['descripcion'], $param['precio_compra'], $param['pvp'], $param['id_proveedor'], $param['id_categoria']);
			//guardo en bd
			$ultimoId = productoPDO::insertar($prod);
			if($ultimoId > 0)
			{
				for ($i=1; $i < $num; $i++) { 
					if(producto_usuarioPDO::insertar($ultimoId, $param['id_usuario' . $i]) <= 0)
					{
						$nueva->respuesta = "Ocurrio un error al insertar en la base de datos.";
						$newResponse = $response->withJson($nueva, 200);
						break;
					}
				}
				$stock = new Stock();
				$stock->id_producto = $ultimoId;
				$stock->cantidad = $param['stock'];
				if(stockPDO::insertar($stock) <= 0)
				{
					$nueva->respuesta = "Ocurrio un error al insertar en la base de datos.";
					$newResponse = $response->withJson($nueva, 200);
				}
				else
				{
					$nueva->respuesta = "Producto agregado";
					$newResponse = $response->withJson($nueva, 200);
				}
			}
			else
			{
				$nueva->respuesta = "Ocurrio un error al insertar en la base de datos.";
				$newResponse = $response->withJson($nueva, 200);
			}
		}
		else
		{
        	$nueva->respuesta = "Faltan parametros o son incorrectos.";
        	$newResponse = $response->withJson($nueva, 200);
		}
		return $newResponse;
	}

	public static function BajaProducto($request, $response, $args)
	{
		$nueva = new stdclass();
		if (isset($args['id']) != null) {
			$id_producto = $args['id'];
			if (productoPDO::eliminar($id_producto) > 0) 
			{
				if(stockPDO::eliminar($id_producto) > 0)
				{
					if(producto_usuarioPDO::eliminar($id_producto) > 0)
					{
						$nueva->respuesta = "Producto eliminado.";
						$newResponse = $response->withJson($nueva, 200);		
					}
				}
			}
			else
			{
				throw new Exception("Ocurrio un error.", 500);
			}
		}
		else
		{
			$nueva->respuesta = "Id necesario.";
        	$newResponse = $response->withJson($nueva, 200);
		}
		return $newResponse;
	}

	public static function ModificarProducto($request, $response, $args)
	{
		$param = $request->getParsedBody();
		$newResponse = new stdClass();
		$nueva = new stdClass();
		if (isset($args['id']) != null) {
			$prod = productoPDO::traerUno($args['id']);
			if ($prod != null) {
				$product = $prod[0];
				if (isset($param['nombre'])) {
					$product->nombre = $param['nombre'];
				}
				if (isset($param['descripcion'])) {
					$product->descripcion = $param['descripcion'];
				}
				if (isset($param['precio_compra'])) {
					$product->precio_compra = $param['precio_compra'];
				}
				if (isset($param['pvp'])) {
					$product->pvp = $param['pvp'];	
				}
				if (isset($param['id_proveedor'])) {
					$product->id_proveedor = $param['id_proveedor'];
				}
				if (isset($param['id_categoria'])) {
					$product->id_categoria = $param['id_categoria'];
				}

				//actualizacion de usuarios
				//veo cuantos usuarios hay ingresados 
				$num = 1;
				while($num)
				{
					$usuario = "id_usuario" . $num;
					if(isset($param[$usuario]))
						$num++;
					else
						break;
				}
				//elimino los usuarios actuales del producto
				if(producto_usuarioPDO::eliminarDeProducto($args['id']) > 0)
				{
					//cargo los nuevo usuarios del producto
					for ($i=1; $i < $num; $i++) { 
						if(producto_usuarioPDO::insertar($args['id'], $param['id_usuario' . $i]) <= 0)
						{
							$nueva->respuesta = "Ocurrio un error al insertar en la base de datos.";
							$newResponse = $response->withJson($nueva, 200);
							break;
						}
					}
				}
				else
				{
					throw new Exception("Ocurrio un error", 500);
				}

				//guardo
				if (productoPDO::modificar($product) != null) {
					$nueva->respuesta = "Producto modificado.";
        			$newResponse = $response->withJson($nueva, 200);	
				}
				else
				{
					throw new Exception("Ocurrio un error", 500);
				}
			}
			else
			{
				$nueva->respuesta = "No existe el producto.";
        		$newResponse = $response->withJson($nueva, 200);		
			}
		}
		else
		{
			$nueva->respuesta = "Id necesario.";
        	$newResponse = $response->withJson($nueva, 200);
		}
		return $newResponse;
	}

	public static function traerTodos($request, $response)
	{
		$nueva = new stdclass();
		$respuesta = productoPDO::traerTodos();
		if($respuesta != null)
		{
			$nueva = $response->withJson($respuesta, 200);
		}
		else
		{
	       	$nueva->respuesta = "Ocurrio un error";
	        $nueva = $response->withJson($nueva, 200);
		}
		return $nueva;
	}
	
	public static function traerUno($request, $response, $args)
	{
		$nueva = new stdclass();
		$param = $request->getParsedBody();

		if (isset($args['id']) != null) 
		{
			$respuesta = productoPDO::traerUno($args['id']);
			if($respuesta != null)
			{
				$usuarios = producto_usuarioPDO::traerUsuarios($args['id']);
				if($usuarios != null)
				{
					$stock = stockPDO::traerStockUno($args['id']);
					if($stock != null)
					{
						$retorno = new stdClass();
						$retorno->propietarios = $usuarios;
						$retorno->producto = $respuesta;
						$retorno->stock = $stock;
						$nueva = $response->withJson($retorno, 200);
					}
				}
			}
			else
			{
				$nueva->respuesta = "Ocurrio un error";
				$nueva = $response->withJson($nueva, 200);
			}
		}
		else
		{
			$nueva->respuesta = "Se necesita un id";
			$nueva = $response->withJson($nueva, 200);
		}
		return $nueva;
	}

	public static function Busqueda($request, $response, $args)
	{
		$nueva = new stdclass();
		if (isset($args['cadena']) != null) 
		{
			$respuesta = productoPDO::buscar($args['cadena']);
			if($respuesta != null)
			{
				$nueva = $response->withJson($respuesta, 200);
			}
			else
			{
				$nueva->respuesta = "Ocurrio un error";
				$nueva = $response->withJson($nueva, 200);
			}
		}
		else
		{
			$nueva->respuesta = "Se necesita el ingreso de una cadena";
			$nueva = $response->withJson($nueva, 200);
		}
		return $nueva;
	}

	public static function traerInfoUno($request, $response, $args)
	{
		$nueva = new stdclass();
		$param = $request->getParsedBody();

		if (isset($args['id']) != null) 
		{
			$respuesta = productoPDO::traerInfoUno($args['id']);
			if($respuesta != null)
			{
				$usuarios = producto_usuarioPDO::traerNombresUsuarios($args['id']);
				if($usuarios != null)
				{
					$stock = stockPDO::traerStockUno($args['id']);
					if($stock != null)
					{
						$retorno = new stdClass();
						$retorno->propietarios = $usuarios;
						$retorno->producto = $respuesta;
						$retorno->stock = $stock;
						$nueva = $response->withJson($retorno, 200);
					}
				}
			}
			else
			{
				$nueva->respuesta = "Ocurrio un error";
				$nueva = $response->withJson($nueva, 200);
			}
		}
		else
		{
			$nueva->respuesta = "Se necesita un id";
			$nueva = $response->withJson($nueva, 200);
		}
		return $nueva;
	}
	
}

?>