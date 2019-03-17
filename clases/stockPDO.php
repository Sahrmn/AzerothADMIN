<?php 
class stockPDO
{
	public static function traerTodos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT productos.id, productos.nombre, SUM(stock.cantidad) AS 'total' FROM `stock` INNER JOIN productos ON productos.id = stock.id_producto GROUP BY productos.id");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Stock");
	}

	public static function traerTodosTodos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM stock");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Stock");
	}

	public static function traerUno($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT stock.id, stock.cantidad, stock.fecha, productos.nombre FROM `stock` INNER JOIN productos ON stock.id_producto = productos.id WHERE id_producto = '$id'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Stock");
	}

	public static function traerStockUno($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT SUM(stock.cantidad) AS 'stock' FROM `stock` WHERE id_producto = '$id'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Stock");
	}

	public static function eliminar($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE from stock WHERE id = '$id'");
		$consulta->execute();
		return $consulta->rowCount();
	}

	public static function modificar($id, $cant, $cantRestada)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("
			UPDATE stock 
			SET cantidad = $cant
			WHERE id_producto = $id AND cantidad = $cantRestada");
		return $consulta->execute();
	}
		
	public static function insertar($stock)
	{
		$fecha = date("Y-m-d H:i:s");
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("
		INSERT into stock (id_producto, cantidad, fecha) 
		VALUES('$stock->id_producto','$stock->cantidad', '$fecha')");
		$consulta->execute();	
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
		
		
}
	
?>
	