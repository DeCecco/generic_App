<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once "usuarios.php";
require 'vendor/autoload.php';

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
$app->run();
?>
