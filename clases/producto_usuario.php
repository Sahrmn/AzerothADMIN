<?php 
include_once 'producto_usuarioPDO.php';

class Producto_Usuario
{
	public $id;
	public $id_producto;
    public $id_usuario;
    

	public function __construct($id_producto = null, $id_usuario = null)
	{
		if(func_num_args() != 0)
		{
			$this->id_producto = $id_producto;
			$this->id_usuario = $id_usuario;
		}
	}

	
}

?>