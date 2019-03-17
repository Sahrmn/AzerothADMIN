<?php 
include_once 'stockPDO.php';

class Stock
{
	public $id;
    public $id_producto;
    public $cantidad;
    public $fecha;

	public function __construct($id_producto = null, $cantidad = null, $fecha = null)
	{
		if (func_num_args() != 0) {
            $this->id_producto = $id_producto;
            $this->cantidad = $cantidad;
            $this->fecha = $fecha;
		}
	}

	public function CargaStock($request, $response, $args)
	{
        $id_producto = $args['id'];
		$parametros = $request->getParsedBody();
		if($id_producto != null && isset($parametros['cantidad']) != null)
		{
			$carga = new Stock();
			$carga->id_producto = $id_producto;
			$carga->cantidad = $parametros['cantidad'];
			$insert = stockPDO::insertar($carga);
			if ($insert != null) {
				$retorno = $response->withJson("Stock actualizado", 200);
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

	public function actualizacion($id_producto, $cantidad)//disminucion de stock
	{
		$respuesta = new stdClass();
        $lista = stockPDO::traerTodosTodos();
        $flag = false;
        foreach ($lista as $e) {
			if ($e->id_producto == $id_producto && $e->cantidad > 0) {
				
				$cantidadAnterior = $e->cantidad;
				$cant = $e->cantidad - $cantidad;
                if(stockPDO::modificar($id_producto, $cant, $cantidadAnterior) != null)
                {
					$flag = true;
					break;
                }
            }
		}
		
        //si no encuentra id muestra un mensaje
        if(!$flag)
        {
            $respuesta->resultado = "No existe el id";
        }
        else
        {	
			$respuesta = true;
		}
		
		//$nueva = $response->withJson($respuesta, 200);
		//return $nueva;
		return $respuesta;
	}

	public static function MostrarStock($request, $response)
	{
		$nueva = new stdclass();
		$respuesta = stockPDO::traerTodos();
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

	public static function MostrarUno($request, $response, $args)
	{
		$id_producto = $args['id'];
		$nueva = new stdclass();
		$respuesta = stockPDO::traerUno($id_producto);
		if($respuesta != null)
		{
			$nueva = $response->withJson($respuesta, 200);
		}
		else
		{
	       	$nueva->respuesta = "Ocurrio un error";
			$nueva->bool = false;
			$nueva = $response->withJson($nueva, 200);
		}
		return $nueva;
	}
}


?>