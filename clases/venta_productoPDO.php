<?php 
class venta_productoPDO
{
	public static function traerTodos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from ventas_productos");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Venta_Producto");
	}

	public static function traerTodosConID($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from ventas_productos WHERE id_venta = '$id'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Venta_Producto");
	}

	public static function traerUno($id_venta, $id_producto)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from ventas_productos WHERE id = '$id_venta' AND id_producto = '$id_producto'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Venta_Producto");
	}

	public static function eliminar($id_venta, $id_producto)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE from ventas_productos WHERE id_venta = '$id_venta' AND id_producto = '$id_producto'");
		$consulta->execute();
		return $consulta->rowCount();
	}

	public static function modificar($ventap)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("
			UPDATE ventas_productos 
            SET cantidad = '$ventap->cantidad',
            precio = '$ventap->precio'
			WHERE id_venta = '$ventap->id_venta' AND id_producto = '$ventap->id_producto'");
		return $consulta->execute();
	}

	public static function insertar($venta)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("
        	INSERT into ventas_productos (id_venta, id_producto, cantidad, precio) 
        	VALUES('$venta->id_venta', '$venta->id_producto', '$venta->cantidad', '$venta->precio')");
		$consulta->execute();	
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}


}

?>