<?php 
include_once 'venta_productoPDO.php';
class Venta_Producto
{
	public $id_venta;
	public $id_producto;
	public $cantidad;
	public $precio;

	public function __construct($id_venta = null, $id_producto = null, $cant = null, $precio = null)
	{
		if(func_num_args() != 0)
		{
			$this->id_venta = $id_venta;
			$this->id_producto = $id_producto;
			$this->cantidad = $cant;
			$this->precio = $precio;
		}
	}

	public static function GenerarVentaProducto($id_venta, $id_producto, $cantidad, $precio) 
	{
		if(isset($id_venta) != null && isset($id_producto) != null && isset($cantidad) != null && isset($precio) != null)
		{
			$vp = new Venta_Producto($id_venta, $id_producto, $cantidad, $precio);
			$ultimoAgregado = venta_productoPDO::insertar($vp);
			//modifico el stock
			//$stock = stock::actualizacion($id_producto, $cantidad);
			
			if($ultimoAgregado == NULL /*|| $stock != true*/)
			{
				throw new Exception("Error al insertar en base de datos", 500);
			}
		}
	}

	public static function EliminarProductos($id_venta)
	{
		$listado = venta_productoPDO::traerTodosConID($id_venta);

		foreach ($listado as $element) {
			if (venta_productoPDO::eliminar($element->id_venta, $element->id_producto) <= 0) {
				throw new Exception("Error al insertar en base de datos", 500);
			}
		}
		return true;
	}	
	
	
	public static function ModificarVentaProducto($ventap, $param)
	{
		if($ventap['id_venta'] != null && $ventap['id_producto'] != null)
		{
				//modifico atributos
				if ($param['precio'] != 0) {
					$ventap->precio = $param['precio'];
				}
				if($param['cantidad'] != null)
				{
					if ($param['cantidad'] == 0) {
						//eliminar producto de la venta
						if(venta_productoPDO::eliminar($id_venta, $id_producto) <= 0)
						{
							throw new Exception("Error al eliminar de base de datos", 500);		
						}
					}
					else
					{
						$ventap->cantidad = $param['cantidad'];
					}
				}
				
				//guardo
				$respuesta = new stdclass();
				if(venta_productoPDO::modificar($ventap) <= 0)
				{
					throw new Exception("Error al insertar en base de datos", 500);
				}
		}
		else
		{
			throw new Exception("Se necesita un id", 500);
		}
		return $nueva;
	}



}


?>