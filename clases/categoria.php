<?php 
include_once 'categoriaPDO.php';

class Categoria
{
	public $nombre;
	public $descripcion;

	public function __construct($nombre = null, $descripcion = null)
	{
		if (func_num_args() != 0) {
			$this->nombre = $nombre;
			$this->descripcion = $descripcion;
		}
	}

	public function InsertarCategoria($request, $response)
	{
		$parametros = $request->getParsedBody();

		if(isset($parametros['nombre']) != null && isset($parametros['descripcion']) != null)
		{
			$categoria = new Categoria($parametros['nombre'], $parametros['descripcion']);
			if (categoriaPDO::insertar($categoria) != null) {
				$retorno = $response->withJson("Categoria creada", 200);
			}
			else
			{
	        	throw new Exception("Error al insertar en base de datos", 500);
			}
		}	
		else
		{
			$nueva = new stdclass();
	       	$nueva->respuesta = "Parametros incorrectos o faltantes";
	        $retorno = $response->withJson($nueva, 200);
		}
		return $retorno;
	}

	public function BajaCategoria($request, $response, $args)
	{
		$id = $args['id'];
		$respuesta = new stdclass();
		if(categoriaPDO::eliminar($id) > 0) 
		{	
			$respuesta->resultado = "Baja exitosa";
		}
		else
		{
	        $respuesta->resultado = "No existe el id";
		}
		$nueva = $response->withJson($respuesta, 200);
		return $nueva;
	}

	public function ModificarCategoria($request, $response, $args)
	{
		$id = $args['id'];
		$param = $request->getParsedBody();
		if($id != null)
		{
			//traigo categoria
			$categoria = categoriaPDO::traerUno($id);
			if ($categoria != null) {
				$categoria = $categoria[0];
				//modifico atributos
				if (isset($param['nombre'])) {
					$categoria->nombre = $param['nombre'];
				}
				if (isset($param['descripcion'])) {
					$categoria->descripcion = $param['descripcion'];
				}
				//guardo
				$respuesta = new stdclass();
				if(categoriaPDO::modificar($categoria))
				{
					//$nueva = $response->withJson($categoria, 200);
					$respuesta->resultado = "Categoria modificada correctamente";
					$nueva = $response->withJson($respuesta, 200);
				}
				else
				{
					throw new Exception("Error al insertar en base de datos", 500);
				}
			}
			else
			{
				$nueva = new stdclass();
	        	$nueva->respuesta = "No existe la categoria";
	        	$nueva = $response->withJson($nueva, 200);
			}
		}
		else
		{
			$nueva = new stdclass();
	       	$nueva->respuesta = "Se necesita un id";
	        $nueva = $response->withJson($nueva, 200);
		}
		return $nueva;
	}

	public static function traerTodos($request, $response)
	{
		$nueva = new stdclass();
		$respuesta = categoriaPDO::traerTodos();
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
			$respuesta = categoriaPDO::traerUno($args['id']);
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
			$nueva->respuesta = "Se necesita un id";
			$nueva = $response->withJson($nueva, 200);
		}
		return $nueva;
	}
}


?>