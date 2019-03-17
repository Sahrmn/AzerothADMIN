<?php

require_once "./clases/AutentificadorJWT.php";

class MWusuarios
{
	public function AccesoUsuarioRegistrado($request, $response, $next) {
         
		$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->respuesta = "";

		//tomo el token del header
		if($request->getHeader('token') != null)
		{	
			AutentificadorJWT::VerificarToken($request->getHeader('token'));	
			$nueva = $next($request, $response);
		}
		else
		{
			if($request->isPost())
			{
				$path = $request->getUri()->getPath();
				$path = explode('/', $path);
				
				//solo si se quiere logear, pasa
				if ($request->getUri()->getPath() == 'login/') {
					
					$nueva = $next($request, $response);		
				}
				else
				{
					$objDelaRespuesta->respuesta = "Solo usuarios registrados";
					$nueva = $response->withJson($objDelaRespuesta, 403);
				}

			}
			else
			{
				$objDelaRespuesta->respuesta = "Solo usuarios registrados";
				$nueva = $response->withJson($objDelaRespuesta, 403);
			}
		}
		return $nueva;
	}

	public static function verificarJWT($request, $response)
	{
		$objDelaRespuesta = new stdClass();
		if($request->getHeader('token') != null)
		{		
			AutentificadorJWT::VerificarToken($request->getHeader('token'));
			$objDelaRespuesta->respuesta = true;
			$nueva = $response->withJson($objDelaRespuesta, 200);
		}
		else
		{	
			$objDelaRespuesta->respuesta = false;
			$nueva = $response->withJson($objDelaRespuesta, 403);
		}
		return $nueva;
	}

}