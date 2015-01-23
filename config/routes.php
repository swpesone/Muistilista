<?php

  $app->get('/', function() {
    HelloWorldController::index();
  });

  $app->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});
    $app->get('/shoe', function() {
  HelloWorldController::shoe_list();
});

$app->get('/shoe/1', function() {
  HelloWorldController::shoe_show();
});

$app->get('/shoe/2', function() {
  HelloWorldController::shoe_edit();
});

$app->get('/login', function() {
  HelloWorldController::login();

  });
