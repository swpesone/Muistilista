<?php
//etusivu = kenkien listaussivu
$app->get('/', function() {
  ShoeController::index();
});

$app->get('/hiekkalaatikko', function() {
  HelloWorldController::sandbox();
});
//kenkien listaussivu 
$app->get('/shoe', function() {
  ShoeController::index();
});

$app->post('/shoe', function(){
  ShoeController::store();
});
// Kengän lisäyslomakkeen näyttäminen
$app->get('/shoe/new', function(){
  ShoeController::create();	
});

//kengän esittelysivu
$app->get('/shoe/:id', function($id) {
  ShoeController::show($id);
});


$app->get('/shoe/2', function() {
  HelloWorldController::shoe_edit();
});

$app->get('/login', function() {
  HelloWorldController::login();

});
