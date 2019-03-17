<?php 
class ventaPDO
{
	public static function traerTodos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from ventas");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "venta");
	}

	public static function traerUno($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from ventas WHERE id = '$id'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "venta");
	}

	public static function traerPorFechas($fecha_ini, $fecha_fin)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT ventas.id, ventas.fecha, productos.nombre, ventas_productos.cantidad, ventas_productos.precio
		FROM `ventas` 
		INNER JOIN `ventas_productos` ON ventas_productos.id_venta = ventas.id
		INNER JOIN `productos` ON productos.id = ventas_productos.id_producto
		WHERE date(fecha) BETWEEN '$fecha_ini' AND '$fecha_fin' ORDER BY fecha DESC");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "venta");
	}

	public static function eliminar($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE from ventas WHERE id = '$id'");
		$consulta->execute();
		return $consulta->rowCount();
	}

	public static function modificar($venta)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("
			UPDATE ventas 
			SET fecha = '$venta->fecha'
			WHERE id = '$venta->id'");
		return $consulta->execute();
	}

	public static function insertar($venta)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("
        	INSERT into ventas (fecha) 
			VALUES('$venta->fecha')");
		//$consulta->bindValue(':fecha', $fecha , PDO::PARAM_STR);
		$consulta->execute();	
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}


}

?>