<?php

  class HelloWorldController extends BaseController{

    public static function index(){
   	  echo 'Tämä on etusivuuu!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä	
      //self::render_view('helloworld.html');
      $shoes = Shoe::all();
    // Tämä tulostaa muuttujan arvon mukavassa muodossa
      print_r($shoes);
    }

    public static function shoe_list(){
      self::render_view('suunnitelmat/shoe_list.html');
    }

  public static function shoe_show(){
      self::render_view('suunnitelmat/shoe_show.html');
    }

    public static function shoe_edit(){
      self::render_view('suunnitelmat/shoe_edit.html');
    }

  public static function login(){
      self::render_view('suunnitelmat/login.html');
    }
  }
