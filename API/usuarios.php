<?php

require_once"accesoDatos.php";

class Usuarios
{
	/*
	public $idUsuario;
	public $idRol;
	public $email;
 	public $password;
	

	//CONSTRUCTOR
	public function __construct($idRol, $idUsuario, $email, $password, $dni,$legajo){
		$this->idRol = $idRol;
		$this->idUsuario = $idUsuario;
		$this->email = $email;
		$this->password = $password;
	
	}*/
	public static function VerificarUsuario($mail,$password){
		$sql = 'SELECT * FROM usuarios WHERE mail = :mail and contraseña = :password';
        $consulta = AccesoDatos::ObtenerObjetoAccesoDatos()->ObtenerConsulta($sql);
		$consulta->bindParam(':mail', $mail);
		$consulta->bindParam(':password', $password);

	    $consulta->execute();
	    return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
}