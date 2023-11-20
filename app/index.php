<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr7Middlewares\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require_once './middlewares/CheckBartenderMiddleware.php';
require_once './middlewares/CheckCerveceroMiddleware.php';
require_once './middlewares/CheckCocineroMiddleware.php';
require_once './middlewares/CheckMozoMiddleware.php';
require_once './middlewares/CheckSocioMiddleware.php';
require_once './middlewares/CheckTokenMiddleware.php';

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';

require_once './controllers/AutenticadorController.php';
require_once './controllers/EncuestaController.php';
require_once './controllers/LogController.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/ProductoPedidoController.php';
require_once './controllers/UsuarioController.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add Slim routing middleware
$app->addRoutingMiddleware();

// Add parse body
$app->addBodyParsingMiddleware();

$app->setBasePath('/comanda/app');

// Routes

$app->post('/login', \AutenticadorController::class . ':CrearTokenLogin');

$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->post('/alta', \UsuarioController::class . ':CargarUno')->add(new CheckSocioMiddleware());
  $group->get('/traerUsuarios', \UsuarioController::class . ':TraerTodos');
  $group->get('/traerUsuarioPorId/{id}', \UsuarioController::class . ':TraerUno');
  $group->put('/modificarUsuario', \UsuarioController::class . ':ModificarUno')->add(new CheckSocioMiddleware());
  $group->put('/borrarUsuario/{id}', \UsuarioController::class . ':BorrarUno')->add(new CheckSocioMiddleware());
  $group->post('/exportarArchivoCSV', \UsuarioController::class . ':ExportarUsuariosEnCSV')->add(new CheckSocioMiddleware());
  $group->post('/importarArchivoCSV', \UsuarioController::class . ':ImportarUsuariosDesdeCSV')->add(new CheckSocioMiddleware());
})->add(new CheckTokenMiddleware());


$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->post('/altaProducto', \ProductoController::class . ':CargarUno')->add(new CheckSocioMiddleware());
  $group->get('/traerProductos', \ProductoController::class . ':TraerTodos');
  $group->get('/traerProductoPorId/{id}', \ProductoController::class . ':TraerUno');
  $group->put('/modificarProducto', \ProductoController::class . ':ModificarUno')->add(new CheckSocioMiddleware());
  $group->delete('/borrarProducto/{id}', \ProductoController::class . ':BorrarUno')->add(new CheckSocioMiddleware());
})->add(new CheckTokenMiddleware());

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->post('/altaMesa', \MesaController::class . ':CargarUno');
  $group->get('/traerMesas', \MesaController::class . ':TraerTodos');
  $group->get('/traerMesaPorId/{id}', \MesaController::class . ':TraerUno');
  $group->put('/modificarMesa', \MesaController::class . ':ModificarUno')->add(new CheckSocioMiddleware());
  $group->delete('/borrarMesa/{id}', \MesaController::class . ':BorrarUno');
  $group->get('/Informes/InformeDeEstadoDeMesas', \MesaController::class . ':EmitirInformeDeEstadoDeMesas')->add(new CheckSocioMiddleware());
  $group->put('/ServirMesa', \MesaController::class . ':ServirMesa')->add(new CheckMozoMiddleware());
  $group->get('/CobrarMesa/{id}', \MesaController::class . ':CobrarMesa')->add(new CheckMozoMiddleware());
  $group->put('/CerrarMesa/{id}',  \MesaController::class . ':CerrarMesa')->add(new CheckSocioMiddleware());
})->add(new CheckTokenMiddleware());

$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->post('/altaPedido', \PedidoController::class . ':CargarUno')->add(new CheckMozoMiddleware());
  $group->post('/tomarFotoPosterior', \PedidoController::class . ':tomarFotoPosterior')->add(new CheckMozoMiddleware());
  $group->get('/traerPedidos', \PedidoController::class . ':TraerTodos');
  $group->get('/InformeDePedidosYDemoras',  \PedidoController::class . ':EmitirInformeDePedidosYDemoras')->add(new CheckSocioMiddleware());
  $group->put('/modificarPedido/{id}', \PedidoController::class . ':ModificarUno');
  $group->delete('/borrarPedido/{id}', \PedidoController::class . ':BorrarUno');
  $group->get('/InformeListosParaServirTodos', \PedidoController::class . ':EmitirInformeListosParaServirTodos')->add(new CheckMozoMiddleware());
  $group->get('/InformeMejoresComentarios', \EncuestaController::class . ':EmitirInformeMejoresComentarios')->add(new CheckSocioMiddleware());
  $group->get('/InformeMesaMasUsada', \PedidoController::class . ':EmitirInformeMesaMasUsada')->add(new CheckSocioMiddleware());
  $group->get('/InformePedidosNoATiempo', \PedidoController::class . ':EmitirInformePedidosNoATiempo')->add(new CheckSocioMiddleware());
  $group->get('/InformeMesasPorFacturacion', \PedidoController::class . ':EmitirInformeMesasPorFacturacion')->add(new CheckSocioMiddleware());
  $group->get('/InformeFacturadoEntreFechas', \PedidoController::class . ':EmitirInformeFacturadoEntreFechas')->add(new CheckSocioMiddleware());
  $group->get('/InformePedidosCancelados', \PedidoController::class . ':EmitirInformePedidosCancelados')->add(new CheckSocioMiddleware());
  $group->get('/InformeMesaMenosUsada', \PedidoController::class . ':EmitirInformeMesaMenosUsada')->add(new CheckSocioMiddleware());
  $group->get('/InformeMesasMayorFacturacion', \PedidoController::class . ':EmitirInformeMesasFacturacionAcumulada')->add(new CheckSocioMiddleware());
  $group->get('/InformeMesasMenorFacturacion', \PedidoController::class . ':EmitirInformeMesasFacturacionAcumulada')->add(new CheckSocioMiddleware());
  $group->get('/InformePeoresComentarios', \EncuestaController::class . ':EmitirInformePeoresComentarios')->add(new CheckSocioMiddleware());
})->add(new CheckTokenMiddleware());

$app->group('/ProductoPedido', function (RouteCollectorProxy $group) {
  $group->get('/InformePendientesBartender',  \ProductoPedidoController::class . ':EmitirInformePendientesPorPerfil')->add(new CheckBartenderMiddleware());
  $group->get('/InformePendientesCervecero',  \ProductoPedidoController::class . ':EmitirInformePendientesPorPerfil')->add(new CheckCerveceroMiddleware());
  $group->get('/InformePendientesCocinero',  \ProductoPedidoController::class . ':EmitirInformePendientesPorPerfil')->add(new CheckCocineroMiddleware());
  $group->put('/TomaDePedidoBartender',  \ProductoPedidoController::class . ':TomaDePedidoPorPerfil')->add(new CheckBartenderMiddleware());
  $group->put('/TomaDePedidoCervecero',  \ProductoPedidoController::class . ':TomaDePedidoPorPerfil')->add(new CheckCerveceroMiddleware());  
  $group->put('/TomaDePedidoCocinero',  \ProductoPedidoController::class . ':TomaDePedidoPorPerfil')->add(new CheckCocineroMiddleware());    
  $group->put('/TerminarPedidoBartender', \ProductoPedidoController::class . ':TerminarPedidoPorPerfil')->add(new CheckBartenderMiddleware());
  $group->put('/TerminarPedidoCervecero', \ProductoPedidoController::class . ':TerminarPedidoPorPerfil')->add(new CheckCerveceroMiddleware());
  $group->put('/TerminarPedidoCocinero', \ProductoPedidoController::class . ':TerminarPedidoPorPerfil')->add(new CheckCocineroMiddleware());
  $group->get('/InformeListosParaServirBartender',  \ProductoPedidoController::class . ':EmitirInformeListosParaServirPorPerfil')->add(new CheckBartenderMiddleware());
  $group->get('/InformeListosParaServirCervecero',  \ProductoPedidoController::class . ':EmitirInformeListosParaServirPorPerfil')->add(new CheckCerveceroMiddleware());
  $group->get('/InformeListosParaServirCocinero', \ProductoPedidoController::class . ':EmitirInformeListosParaServirPorPerfil')->add(new CheckCocineroMiddleware());
  $group->get('/InformeProdOrdenadoPorCantVenta', \ProductoPedidoController::class . ':EmitirInformeProdOrdenadoPorCantVenta')->add(new CheckSocioMiddleware());  
})->add(new CheckTokenMiddleware());

$app->group('/Cliente', function (RouteCollectorProxy $group) {
  $group->post('/CompletarEncuesta',  \EncuestaController::class . ':CargarUno');   
});

$app->group('/Log', function (RouteCollectorProxy $group) {
  $group->get('/InformeOperacionesPorSector',  \LogController::class . ':EmitirInformeOperacionesPorSector')->add(new CheckSocioMiddleware());  
  $group->get('/InformeOperacionesPorEmpleadoPorSector',  \LogController::class . ':EmitirInformeOperacionesPorEmpleadoPorSector')->add(new CheckSocioMiddleware());
  $group->get('/InformeDeLoginPorEmpleado/{idEmpleado}', \LogController::class . ':EmitirInformeDeLoginPorEmpleado')->add(new CheckSocioMiddleware());
  $group->get('/InformeOperacionesPorEmpleado/{idEmpleado}', \LogController::class . ':EmitirInformeOperacionesPorEmpleado')->add(new CheckSocioMiddleware());      
})->add(new CheckTokenMiddleware());

$app->run();

?>