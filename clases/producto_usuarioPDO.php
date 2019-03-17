<?php 
require_once 'producto_usuario.php';

class producto_usuarioPDO
{
	public static function traerProductos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from productos_usuarios");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto_Usuario");
	}

	public static function traerUno($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from productos_usuarios WHERE id = '$id'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto_Usuario");
	}

	public static function traerUsuarios($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id_usuario FROM productos_usuarios WHERE id_producto = '$id'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto_Usuario");
	}

	public static function traerNombresUsuarios($id)//id_producto
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT usuarios.nombre 
		FROM productos_usuarios 
		INNER JOIN usuarios ON usuarios.id = productos_usuarios.id_usuario
		WHERE productos_usuarios.id_producto = '$id'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto_Usuario");
	}

	public static function eliminar($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE from productos_usuarios WHERE id = '$id'");
		$consulta->execute();
		return $consulta->rowCount();
	}

	public static function eliminarDeProducto($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE from productos_usuarios WHERE id_producto = '$id'");
		$consulta->execute();
		return $consulta->rowCount();
	}

	public static function insertar($id_producto, $id_usuario)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("
        	INSERT into productos_usuarios (id_producto, id_usuario) 
        	VALUES('$id_producto','$id_usuario')");
		$consulta->execute();	
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
}



?>