<?php 
include_once 'proveedorPDO.php';

class Proveedor
{
	public $nombre;
	public $mail;
	public $descripcion;

	public function __construct($nombre = null, $email = null, $descripcion = null)
	{
		if (func_num_args() != 0) {
			$this->nombre = $nombre;
			$this->mail = $email;
			$this->descripcion = $descripcion;
		}
	}

	public function InsertarProveedor($request, $response)
	{
		$parametros = $request->getParsedBody();
		
		if(isset($parametros['nombre']) != null && isset($parametros['mail']) != null && isset($parametros['descripcion']) != null)
		{
			$proveedor = new Proveedor($parametros['nombre'], $parametros['mail'], $parametros['descripcion']);
			if (proveedorPDO::insertar($proveedor) != null) {
				$retorno = $response->withJson("Proveedor creado", 200);
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

	public function BajaProveedor($request, $response, $args)
	{
		$id = $args['id'];
		$respuesta = new stdclass();
		if(proveedorPDO::eliminar($id) > 0) 
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

	public function ModificarProveedor($request, $response, $args)
	{
		$id = $args['id'];
		$param = $request->getParsedBody();
		if($id != null)
		{
			//traigo elemento
			$proveedor = proveedorPDO::traerUno($id);
			$proveedor = $proveedor[0];

			if ($proveedor != null) {
				//modifico atributos
				if (isset($param['nombre'])) {
					$proveedor->nombre = $param['nombre'];
				}
				if (isset($param['mail'])) {
					$proveedor->mail = $param['mail'];
				}
				if (isset($param['descripcion'])) {
					$proveedor->descripcion = $param['descripcion'];
				}
				//guardo
				$respuesta = new stdclass();
				if(proveedorPDO::modificar($proveedor))
				{
					//$nueva = $response->withJson($proveedor, 200);
					$respuesta->resultado = "Proveedor modificado correctamente";
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
	        	$nueva->respuesta = "No existe el elemento";
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
		$respuesta = proveedorPDO::traerTodos();
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
			$respuesta = proveedorPDO::traerUno($args['id']);
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