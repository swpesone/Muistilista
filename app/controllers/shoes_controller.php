<?php

class ShoeController extends BaseController{
   public static function index(){
    // Haetaan kaikki kengät tietokannasta
    $shoes = Shoe::all();
    // Renderöidään views/shoe kansiossa sijaitseva tiedosto index.html muuttujan $shoes datalla
    self::render_view('shoe/index.html', array('shoes' => $shoes));
  }

  public static function store(){
    // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
    $params = $_POST;

    // Luon uuden kengän käyttäjän syöttämien tietojen perusteella kutsumalla Shoe mallini create metodia
    $id = Shoe::create(array(
      'brand' => $params['brand'],
      'name' => $params['name'],
      'description' => $params['description']     
    ));

    // Ohjataan käyttäjä kengän esittelysivulle
    self::redirect_to('/shoe/' . $id, array('message' => 'Kenkä on lisätty listallesi!'));
  }

  public static function create(){
    self::render_view('shoe/new.html');
  }

  public static function show($id){
    $shoe = Shoe::find($id);
    self::render_view('shoe/show.html', array('shoe' => $shoe));
  }
}  