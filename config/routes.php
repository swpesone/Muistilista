<?php
$app->get('/', function() {
  // Etusivu (kenkien listaussivu)	
  ShoeController::index();
});

$app->get('/hiekkalaatikko', function() {
  HelloWorldController::sandbox();
});

$app->get('/shoe', function() {
  // Kenkien listaussivu 
  ShoeController::index();
});

$app->post('/shoe', function(){
  ShoeController::store();
});

$app->get('/shoe/new', function(){
  // Kengän lisäyslomakkeen näyttäminen	
  ShoeController::create();	
});

$app->get('/shoe/:id/edit', function($id){
  // Kengän muokkauslomakkeen esittäminen
  ShoeController::edit($id);
});

$app->get('/shoe/:id', function($id) {
  // Kengän esittelysivu
  ShoeController::show($id);
});

$app->post('/shoe/:id/edit', function($id){
  // Kengän muokkaaminen
  ShoeController::update($id);
});

$app->post('/shoe/:id/destroy', function($id){
  // Kengän poisto
  ShoeController::destroy($id);
});

$app->get('/login', function(){
  // Kirjautumislomakkeen esittäminen
  PersonController::login();
});

$app->post('/login', function(){
  // Kirjautumisen käsittely
  PersonController::handle_login();
});
