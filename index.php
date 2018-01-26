<?php
//Autoload
$loader = require 'vendor/autoload.php';

//Instantianing the object
$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

//Listing all cars
$app->get('/cars/', function() use ($app){
	(new \controllers\Car($app))->list();
});

//get a car
$app->get('/cars/:id', function($id) use ($app){
	(new \controllers\Car($app))->get($id);
});

//create new car
$app->post('/cars/', function() use ($app){
	(new \controllers\Car($app))->add();
});

//edit a car
$app->put('/cars/:id', function($id) use ($app){
	(new \controllers\Car($app))->edit($id);
});

//delete a car
$app->delete('/cars/:id', function($id) use ($app){
	(new \controllers\Car($app))->delete($id);
});

//Run application
$app->run();
