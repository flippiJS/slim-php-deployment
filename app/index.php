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

require_once './db/AccesoDatos.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/LogController.php';

require_once './middlewares/BartenderMw.php';
require_once './middlewares/CerveceroMw.php';
require_once './middlewares/CocineroMw.php';
require_once './middlewares/MozoMw.php';
require_once './middlewares/SocioMw.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

$app->setBasePath('/comanda/app');


// Routes

$app->group('/log', function (RouteCollectorProxy $group) {
  $group->post('/logging',  \LogController::class . ':CargarUno');  
});


$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->post('/alta', \UsuarioController::class . ':CargarUno');
  $group->get('/traerUsuarios', \UsuarioController::class . ':TraerTodos');
});

$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->post('/altaProducto', \ProductoController::class . ':CargarUno');
  $group->get('/traerProductos', \ProductoController::class . ':TraerTodos');
});

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->post('/altaMesa', \MesaController::class . ':CargarUno');
  $group->get('/traerMesas', \MesaController::class . ':TraerTodos'); 
});

$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->post('/altaPedido', \PedidoController::class . ':CargarUno');
  $group->get('/traerPedidos', \PedidoController::class . ':TraerTodos'); 
});


$app->run();