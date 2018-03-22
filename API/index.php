<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once "usuarios.php";
require 'vendor/autoload.php';
require 'AutentificadorJWT.php';

$app = new \Slim\App(['settings' => ['determineRouteBeforeAppMiddleware' => true,'displayErrorDetails' => true,'addContentLengthHeader' => false]]);

$app->add(function (Request $request, Response $response, $next) {
    $response = $next($request, $response);
    return $response
            //->withHeader('Access-Control-Allow-Origin', '*')//servidor
			->withHeader('Access-Control-Allow-Origin', 'http://localhost:8100')//local
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->post('/usuarios/verificarUsuario', function (Request $request, Response $response){  
	return $response->withJson(usuarios::VerificarUsuario($request->getParam('mail'), $request->getParam('password')));
});

  
/**
   * @api {any} /Crear/  Crear
   * @apiVersion 0.1.0
   * @apiName Crear 
   * @apiGroup TOKEN
   * @apiDescription  Crea el token a partir de los datos del usuario y variables internas declaradas 
   *
   * @apiParam {array_string} data  Contiene el mail,rol,nombre,apellido,id,cuenta y dni del usuario logueado
   *
   * @apiExample Como usarlo:
   *JS	this.WebserviceService.CrearToken(array).then(data => {
   *PHP 	AutentificadorJWT::CrearToken($datos); 
*/
$app->post('/crearToken', function (Request $request, Response $response) {
	
	$mail = $request->getParam('mail');	
	$idrol = $request->getParam('idrol');
	$nombre = $request->getParam('nombre');
	$apellido = $request->getParam('apellido');	
	$idusuario = $request->getParam('idusuario');	
	$cuenta = $request->getParam('cuenta');	
	$dni = $request->getParam('dni');	
	
    $datos = array('mail' => $mail,'idrol' => $idrol, 'nombre' => $nombre,'apellido' => $apellido,'idusuario'=>$idusuario,'cuenta'=>$cuenta,'dni'=>$dni);    
    
    $token= AutentificadorJWT::CrearToken($datos); 
	//$payload=AutentificadorJWT::ObtenerPayload($token);
    $newResponse = $response->withJson($token, 200); 
    return $newResponse;
});
/**
   * @api {any} /Verificar/  Verificar
   * @apiVersion 0.1.0
   * @apiName Verificar 
   * @apiGroup TOKEN
   * @apiDescription  Verifica que el token ingresado sea valido
   *
   * @apiParam {string} token  Posee el token del usuario
   *
   * @apiExample Como usarlo:
   *JS	this.WebserviceService.VerificarToken(token).then(data => {
   *PHP 	AutentificadorJWT::verificarToken($token);
*/ 
$app->post('/verificarToken', function (Request $request, Response $response) {
		
	$token = $request->getParam('token');		            		
	 $esValido=false;
      try 
      {
        AutentificadorJWT::verificarToken($token);
        $esValido=true;      
      }
      catch (Exception $e) {      
        //guardar en un log
				$esValido=false;
        //echo $e;
      }  
	  $esValido =$response->withJson($esValido, 200); 
      return $esValido;
});  
/**
   * @api {any} /PayLoad/  PayLoad
   * @apiVersion 0.1.0
   * @apiName PayLoad 
   * @apiGroup TOKEN
   * @apiDescription  Decodifica el token y devuelve los datos del mismo
   *
   * @apiParam {string} token  Posee el token del usuario
   *
   * @apiExample Como usarlo:
   *JS	this.WebserviceService.PayLoad(token).then(data => {
   *PHP 	AutentificadorJWT::ObtenerPayload($token);
*/ 
$app->post('/payLoad', function (Request $request, Response $response) {
	
	$token = $request->getParam('token');		          
	$payload=AutentificadorJWT::ObtenerPayload($token);
  $newResponse = $response->withJson($payload, 200); 
  return $newResponse;
});
$app->run();
?>
