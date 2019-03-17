<?php 
include_once 'ventaPDO.php';

class Venta
{
	public $id;
	public $fecha;

	public function __construct($fecha = null)
	{
		if (func_num_args() != 0) {
			$this->fecha = $fecha;
		}
	}

	public static function GenerarVenta($request, $response) 
	{
		$parametros = $request->getParsedBody();

		if(isset($parametros['fecha']) != null && isset($parametros['id_producto1']) != null && isset($parametros['cantidad1']) != null && isset($parametros['precio1']) != null)
		{
			$venta = new Venta($parametros['fecha']);
			$idVenta = ventaPDO::insertar($venta);
			if ($idVenta != null) {
				
				//veo cuantos productos hay ingresados 
				$num = 1;
				while($num)
				{
					$prod = "id_producto" . $num;
					$cant = "cantidad" . $num;
					$prec = "precio" . $num;
					if(isset($parametros[$prod]) && isset($parametros[$cant])&& isset($parametros[$prec]))
						$num++;
					else
						break;
						//$num = -1;
				}
				//guardo productos
				for ($i=1; $i < $num; $i++) { 
					$id = $parametros["id_producto" . $i];
					$cant = $parametros["cantidad" . $i];
					$prec = $parametros["precio" . $i];
					Venta_Producto::GenerarVentaProducto($idVenta, $id, $cant, $prec);
				}

				$retorno = $response->withJson("Venta generada", 200);
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


	public static function EliminarVenta($request, $response, $args)
	{
		$id_venta = $args['id'];
		$respuesta = new stdclass();
		if(venta_producto::EliminarProductos($id_venta) == true)
		{
			if(ventaPDO::eliminar($id) > 0) 
			{	
				$respuesta->resultado = "Baja exitosa";
			}
			else
			{
				$respuesta->resultado = "Ocurrio un error al eliminar";
			}
		}
		else
		{
			$respuesta->resultado = "Ocurrio un error al eliminar";
		}
		$nueva = $response->withJson($respuesta, 200);
		return $nueva;
	}	
	
	
	public static function ModificarVenta($request, $response, $args)
	{
		$id_venta = $args['id'];
		$param = $request->getParsedBody();
		if($id_venta != null)
		{
			$venta = ventaPDO::traerUno($id_venta);
			
			if ($venta != null) {
				$venta = $venta[0];
				//modifico atributos 
				if (isset($param['fecha'])) {
					$venta->fecha = $param['fecha'];
				}
				//guardo
				$respuesta = new stdclass();
				if(ventaPDO::modificar($venta) > 0)
				{
					$listado = venta_productoPDO::traerTodosConID($id_venta);
					if($listado != null)
					{
						for ($i=0; $i < count($listado); $i++) { 
							venta_producto::ModificarVentaProducto($listado[$i], $param);
						}
					}

					//$nueva = $response->withJson($employee, 200);
					$respuesta->resultado = "Venta modificada correctamente";
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
	        	$nueva->respuesta = "No existe";
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

	public static function TraerVentas($request, $response, $args)
	{
		$nueva = new stdclass();
		if(isset($args['fecha_ini']) != null && isset($args['fecha_fin']) != null)
		{
			$fecha_inicial = $args['fecha_ini'];
			$fecha_final = $args['fecha_fin'];
			
			if($fecha_inicial < $fecha_final)
			{	
				$respuesta = ventaPDO::traerPorFechas($fecha_inicial, $fecha_final);
				
				if(count($respuesta) != 0)
				{
					$nueva = $response->withJson($respuesta, 200);
				}
				else
				{
					$nueva->respuesta = "No se encontraron ventas";
	        		$nueva = $response->withJson($nueva, 200);		
				}
			}
			else
			{
				$nueva->respuesta = "La fecha inicial debe ser anterior a la fecha final";
	        	$nueva = $response->withJson($nueva, 200);
			}
		}
		else
		{
	       	$nueva->respuesta = "Se necesitan dos fechas";
	        $nueva = $response->withJson($nueva, 200);
		}
		return $nueva;
	}


}


?>