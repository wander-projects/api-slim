<?php
//Autoload
$loader = require 'vendor/autoload.php';

//Instanciando objeto
$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

//Listando todas
$app->get('/cars/', function() use ($app){
	(new \controllers\Car($app))->lista();
});

//get pessoa
$app->get('/cars/:id', function($id) use ($app){
	(new \controllers\Car($app))->get($id);
});

//nova pessoa
$app->post('/cars/', function() use ($app){
	(new \controllers\Car($app))->nova();
});

//edita pessoa
$app->put('/cars/:id', function($id) use ($app){
	(new \controllers\Car($app))->editar($id);
});

//apaga pessoa
$app->delete('/cars/:id', function($id) use ($app){
	(new \controllers\Car($app))->excluir($id);
});

//Rodando aplicação
$app->run();
