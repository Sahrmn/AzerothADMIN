<?php 
class proveedorPDO
{
	public static function traerTodos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from proveedores");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "proveedor");
	}

	public static function traerUno($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from proveedores WHERE id = '$id'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "proveedor");
	}

	public static function eliminar($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE from proveedores WHERE id = '$id'");
		$consulta->execute();
		return $consulta->rowCount();
	}

	public static function modificar($proveedor)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("
			UPDATE proveedores 
			SET nombre = '$proveedor->nombre',
			mail = '$proveedor->mail',
			descripcion = '$proveedor->descripcion'
			WHERE id = '$proveedor->id'");
		return $consulta->execute();
	}

	public static function insertar($proveedor)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("
        	INSERT into proveedores (nombre, mail, descripcion) 
        	VALUES('$proveedor->nombre', '$proveedor->mail', '$proveedor->descripcion')");
		$consulta->execute();	
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}


}

?>