<?php 
include_once 'usuarioPDO.php';
class Usuario
{
	public $id;
	public $nombre;
	public $clave;

	public function __construct($nom = null, $pass = null)
	{
		if(func_num_args() != 0)
		{
			$this->nombre = $nom;
			$this->clave = $pass;
		}
	}

	public static function verificarCrearToken($ArrayDeParametros)
	{
		if (isset($ArrayDeParametros['nombre']) != null && isset($ArrayDeParametros['clave']) != null) {
			
			$datos = array('nombre' => $ArrayDeParametros['nombre'], 'clave' => $ArrayDeParametros['clave']);
	        //verificar en bd
	        $employee = new Usuario($datos['nombre'], $datos['clave']);
	        $response = $employee->VerificarUsuario(); 
	        if($response == false)
	        {
	        	$nueva = new stdclass();
				$nueva->respuesta = "El usuario no existe.";
				$nueva->bool = false;
	        	$newResponse = json_encode($nueva, 200);
	        }
	        else
	        {  
	          	$token = AutentificadorJWT::CrearToken($response); 
	          	$newResponse = json_encode($token, 200); 
	        }
		}
		else
		{
			$nueva = new stdclass();
			$nueva->respuesta = "Parametros incorrectos o faltantes.";
			$nueva->bool = false;
        	$newResponse = json_encode($nueva, 200);
		}
        return $newResponse;
	}

	public function VerificarUsuario()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select nombre from usuarios where nombre = :nombreUsuario AND clave = :clave");
        $consulta->bindValue(':nombreUsuario', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
		$consulta->execute();			
		$employee = $consulta->fetchObject('usuario'); //nombre de la clase
        if($employee != NULL)
        {
            $nueva = $employee;
        }
        else
        {
            $nueva = false;
        }
        return $nueva;
	}

	public static function CrearUsuario($request, $response) 
	{
		$parametros = $request->getParsedBody();

		if(isset($parametros['nombre']) != null && isset($parametros['clave']) != null)
		{
			$employee = new Usuario($parametros['nombre'], $parametros['clave']);
			if (usuarioPDO::InsertarUsuarioBD($employee) != null) {
				$retorno = $response->withJson("Usuario creado", 200);
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

	public static function BajaUsuario($request, $response, $args)
	{
		$id = $args['id'];
		$respuesta = new stdclass();
		if(usuarioPDO::BorrarUsuarioBD($id) > 0) 
		{	
			$respuesta->resultado = "Baja exitosa";
		}
		else
		{
	        $respuesta->resultado = "No existe el id";
		}
		$nueva = $response->withJson($respuesta, 200);
		return $nueva;
	}	

	public static function ModificarUsuario($request, $response, $args)
	{
		$id = $args['id'];
		$param = $request->getParsedBody();
		if($id != null)
		{
			//traigo usuario
			$employee = usuarioPDO::traerUsuario($id);

			if ($employee != null) {
				//modifico atributos del usuario
				if (isset($param['nombre'])) {
					$employee->nombre = $param['nombre'];
				}
				if (isset($param['clave'])) {
					$employee->clave = $param['clave'];
				}
				//guardo
				$respuesta = new stdclass();
				if(usuarioPDO::ModificarUsuarioBD($employee))
				{
					//$nueva = $response->withJson($employee, 200);
					$respuesta->resultado = "Usuario modificado correctamente";
					$nueva = $response->withJson($respuesta, 200);
				}
				else
				{
					throw new Exception("Error al insertar en base de datos", 500);
				}
			}
			else
			{
				$nueva = new stdclass();
	        	$nueva->respuesta = "No existe el usuario";
	        	$nueva = $response->withJson($nueva, 200);
			}
		}
		else
		{
			$nueva = new stdclass();
	       	$nueva->respuesta = "Se necesita un id";
	        $nueva = $response->withJson($nueva, 200);
		}
		return $nueva;
	}

	public static function traerDatos($request, $response)
	{
		if($request->getHeader('token') != null)
		{		
			$token = $request->getHeader('token')[0];
			$data = AutentificadorJWT::ObtenerData($token);
			$nueva = $response->withJson($data, 200);
		}
		else
		{
			$nueva = new stdclass();
			$nueva->respuesta = "No existe el identificador de usuario";
			$nueva->bool = false;
	    	$nueva = $response->withJson($nueva, 200);
		}
		return $nueva;
	}

	public static function traerTodos($request, $response)
	{
		$nueva = new stdclass();
		$respuesta = usuarioPDO::traerTodos();
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

}


?>