<?php 
class categoriaPDO
{
	public static function traerTodos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from categorias");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "categoria");
	}

	public static function traerUno($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from categorias WHERE id = '$id'");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "categoria");
	}

	public static function eliminar($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE from categorias WHERE id = '$id'");
		$consulta->execute();
		return $consulta->rowCount();
	}

	public static function modificar($cat)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("
			UPDATE categorias 
			SET nombre = '$cat->nombre',
			descripcion = '$cat->descripcion'
			WHERE id = '$cat->id'");
		return $consulta->execute();
	}

	public static function insertar($cat)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("
        	INSERT into categorias (nombre, descripcion) 
        	VALUES('$cat->nombre','$cat->descripcion')");
		$consulta->execute();	
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}


}

?>