<?php

require_once"accesoDatos.php";


class Alumno
{
	public $idAlumno;
	public $idUsuario;
	public $nombre;
 	public $apellido;
	public $dni;
	public $legajo;

	//CONSTRUCTOR
	public function __construct($idAlumno, $idUsuario, $nombre, $apellido, $dni,$legajo){
		$this->idAlumno = $idAlumno;
		$this->idUsuario = $idUsuario;
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->dni = $dni;
		$this->legajo = $legajo;
	}

	//OBTENCION DE TODOS LAS PERSONAS DE LA BASE DE DATOS
	public static function TraerTodosLosAlumnos(){
		$sql = 'SELECT * FROM personas';
        $consulta = AccesoDatos::ObtenerObjetoAccesoDatos()->ObtenerConsulta($sql);
	    $consulta->execute();			
		return $consulta->fetchAll();	
	}
	//ELIMINACION DE UNA PERSONA DE LA BASE DE DATOS
	public static function BorrarPersona($idUsuario){	
		$sql = 'DELETE FROM personas WHERE id = :id';
		$consulta = AccesoDatos::ObtenerObjetoAccesoDatos()->ObtenerConsulta($sql);
		$consulta->bindValue(':id', $id);		
		$consulta->execute();
	}
	//CREACION DEL PERSONA EN LA BASE DE DATOS
	public static function InsertarPersona($persona){
		//VERIFICACION DE EXISTENCIA DEL USUARIO
		if (Persona::ObtenerPersona($persona) != NULL) {
			return false;//EL USUARIO YA EXISTIA PREVIAMENTE EN LA BASE DE DATOS
		}
		else{
			//CREACION DEL USUARIO EN LA BASE DE DATOS
			$sql = 'INSERT INTO personas (nombre, apellido, dni, sexo, password) VALUES (:nombre, :apellido, :dni, :sexo, :password)';
			$consulta = AccesoDatos::ObtenerObjetoAccesoDatos()->ObtenerConsulta($sql);
			$consulta->bindValue(':nombre', $persona->nombre);
			$consulta->bindValue(':apellido', $persona->apellido);
			$consulta->bindValue(':dni', $persona->dni);
			$consulta->bindValue(':sexo', $persona->sexo);
			$consulta->bindValue(':password', $persona->password);
			$consulta->execute();
			return true;//ALTA EXITOSA
		}
	}
	//OBTENCION DE UN USUARIO
	public static function ObtenerPersona($persona){
		$sql = 'SELECT * FROM personas WHERE dni = :dni';
        $consulta = AccesoDatos::ObtenerObjetoAccesoDatos()->ObtenerConsulta($sql);
		$consulta->bindParam(':dni', $persona->dni);
	    $consulta->execute();
	    return $consulta->fetch(PDO::FETCH_ASSOC);
	}


	public static function TraerAlumnosSegunMateria($idMateria){
		$sql =
			'SELECT a.*
			FROM alumnos AS a, alumnos_materias AS am
			WHERE am.idAlumno = a.idAlumno
				AND am.idMateria = :idMateria
			ORDER BY a.apellido, a.nombre';
        $consulta = AccesoDatos::ObtenerObjetoAccesoDatos()->ObtenerConsulta($sql);
		$consulta->bindValue(':idMateria', $idMateria, PDO::PARAM_INT);	
	    $consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_ASSOC);	
	}

}