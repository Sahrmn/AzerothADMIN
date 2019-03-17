<?php 

class usuarioPDO
{
	public static function traerTodos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select id, nombre from usuarios");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
	}

	public static function InsertarUsuarioBD($employee)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into usuarios (nombre, clave) VALUES('$employee->nombre','$employee->clave')");
		$consulta->execute();	
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}

	public static function BorrarUsuarioBD($id)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
			DELETE 
			from usuarios 				
			WHERE id = :id");	
		$consulta->bindValue(':id',$id, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
	}

	public static function ModificarUsuarioBD($user)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
			UPDATE usuarios 
			set nombre = '$user->nombre',
			clave = '$user->clave'
			WHERE id = '$user->id'");
		return $consulta->execute();
	}	

	public static function traerUsuario($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	    $consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios where id = :id");
	    $consulta->bindValue(':id', $id, PDO::PARAM_INT);
	    $consulta->execute();			
		return $consulta->fetchObject('usuario'); 
	}
}


?>