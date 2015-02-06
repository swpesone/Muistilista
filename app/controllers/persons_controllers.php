<?php

class PersonController extends BaseController{
  public static function login(){
      self::render_view('login.html');
  }

  public static function handle_login(){
    $params = $_POST;

    $person = Person::authenticate($params['username'], $params['password']);

    if(!$person){
      self::redirect_to('/login', array('error' => 'Väärä käyttäjätunnus tai salasana!'));
    }else{
      $_SESSION['person'] = $person->id;

      self::redirect_to('/', array('message' => 'Tervetuloa takaisin' . $person->username . '!'));
    }
  }
}