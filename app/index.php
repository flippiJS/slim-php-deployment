<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;


require __DIR__ . '/../vendor/autoload.php';

include './controllers/productoController.php';
include './controllers/pedidoController.php';
include './controllers/encuestaController.php';
include './controllers/empleadoController.php';
include './controllers/mesaController.php';
include './controllers/ProductoPedidoController.php';


// Instantiate App
$app = AppFactory::create();

$app->setBasePath("/slim-php-deployment/app");

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->group('/productos', function (RouteCollectorProxy $group) 
{
    $group->get('[/]', \ProductoController::class . ':TraerTodos');
    //$group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \ProductoController::class . ':Insertar');
});

$app->group('/empleados', function (RouteCollectorProxy $group) 
{
    $group->get('[/]', \EmpleadoController::class . ':TraerTodos');
    //$group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \EmpleadoController::class . ':Insertar');
});

$app->group('/pedidos', function (RouteCollectorProxy $group) 
{
    $group->get('[/]', \PedidoController::class . ':TraerTodos');
    //$group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \PedidoController::class . ':Insertar');
});

$app->group('/mesas', function (RouteCollectorProxy $group) 
{
    $group->get('[/]', \MesaController::class . ':TraerTodos');
    //$group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \MesaController::class . ':Insertar');
});

$app->group('/encuestas', function (RouteCollectorProxy $group) 
{
    $group->get('[/]', \EncuestaController::class . ':TraerTodos');
    //$group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \EncuestaController::class . ':Insertar');
});

$app->group('/productopedido', function (RouteCollectorProxy $group) 
{
    $group->get('[/]', \ProductoPedidoController::class . ':TraerTodos');
    //$group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \ProductoPedidoController::class . ':Insertar');
});

$app->run();

?>