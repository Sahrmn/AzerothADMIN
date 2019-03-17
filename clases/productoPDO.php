<?php 
require_once 'productoPDO.php';

class productoPDO
{
	public static function traerTodos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT productos.id, productos.nombre, productos.descripcion, productos.precio_compra, productos.pvp, proveedores.nombre AS 'proveedor', categorias.nombre AS 'categoria', SUM(stock.cantidad) AS 'total' 
		FROM productos 
		INNER JOIN proveedores ON productos.id_proveedor = proveedores.id 
		INNER JOIN categorias ON productos.id_categoria = categorias.id 
		INNER JOIN stock ON productos.id = stock.id_producto GROUP BY productos.id");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "producto");
	}

	public static function traerUno($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM productos WHERE id = '$id'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "producto");
	}

	public static function traerInfoUno($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT productos.nombre, productos.descripcion, productos.precio_compra, productos.pvp, categorias.nombre AS 'categoria', proveedores.nombre AS 'proveedor' 
		FROM productos 
		INNER JOIN categorias ON productos.id_categoria = categorias.id 
		INNER JOIN proveedores ON productos.id_proveedor = proveedores.id 
		WHERE productos.id = '$id'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "producto");
	}

	public static function eliminar($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE from productos WHERE id = '$id'");
		$consulta->execute();
		return $consulta->rowCount();
	}

	public static function modificar($producto)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("
			UPDATE productos 
			SET nombre = '$producto->nombre',
			descripcion = '$producto->descripcion',
			precio_compra = '$producto->precio_compra',
			pvp = '$producto->pvp',
			id_proveedor = '$producto->id_proveedor',
			id_categoria = '$producto->id_categoria'
			WHERE id = '$producto->id'");
		return $consulta->execute();
	}

	public static function insertar($producto)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("
		INSERT into productos (nombre, descripcion, precio_compra, pvp, id_proveedor, id_categoria) 
		VALUES('$producto->nombre','$producto->descripcion', '$producto->precio_compra', '$producto->pvp', '$producto->id_proveedor', '$producto->id_categoria')");
		$consulta->execute();	
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
	
	public static function buscar($cadena)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM productos WHERE nombre LIKE '%$cadena%'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "producto");
	}


}



?>