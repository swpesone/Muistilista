<?php

class PersonController extends BaseController{
  public static function login(){
      self::render_view('login.html');
  }

  public static function handle_login(){
    $params = $_POST;

    $person = Person::authenticate($params['username'], $params['password']);

    if(!$person){
      self::redirect_to('/login', array('errors' => 'Väärä käyttäjätunnus tai salasana!'));
    }else{
      $_SESSION['person'] = $person->id;

      self::redirect_to('/', array('message' => 'Tervetuloa takaisin, ' . $person->username . '!'));
    }
  }

  public static function logout(){
    $_SESSION['person'] = null;

    self::redirect_to('/login', array('message' => 'Olet kirjautunut ulos!'));
  }

  public static function register(){
      self::render_view('register.html');
  }

  public static function store(){
    $params = $_POST;

    $attributes = array(
      'username' => $params['username'],
      'password' => $params['password'],
      'password_again' => $params['password-again']
    );

    $person = new Person($attributes);
    $errors = $person->errors();

    if(count($errors) == 0){
      Person::create($attributes);
      self::redirect_to('/login', array('message' => 'Tervetuloa käyttäjäksi!'));
    }else{
      self::render_view('/register.html', array('errors' => $errors, 'attributes' => $attributes));
    } 
  }
}