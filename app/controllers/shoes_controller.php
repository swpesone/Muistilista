<?php

class ShoeController extends BaseController{
   public static function index(){
    // Haetaan kaikki kengät tietokannasta
    $shoes = Shoe::all();
    // Renderöidään views/shoe kansiossa sijaitseva tiedosto index.html muuttujan $shoes datalla
    self::render_view('shoe/index.html', array('shoes' => $shoes));
  }

  public static function store(){
    $params = $_POST;

    $attributes = array(
      'brand' => $params['brand'],
      'name' => $params['name'],
      'description' => $params['description']
    );

    $shoe = new Shoe($attributes);
    $errors = $shoe->errors();

    if(count($errors) == 0) {
      //Kenkä on validi
      $id = Shoe::create($attributes);
      // Ohjataan käyttäjä kengän esittelysivulle
      self::redirect_to('/shoe/' . $id, array('message' => 'Kenkä on lisätty listallesi!'));          
    }else{
      //Kengässä on jotain vikaa
      self::render_view('shoe/new.html', array('errors' => $errors, 'attributes' => $attributes));
    }    
  }

  public static function create(){
    self::render_view('shoe/new.html');
  }

  public static function show($id){
    $shoe = Shoe::find($id);
    self::render_view('shoe/show.html', array('shoe' => $shoe));
  }
  //kengän muokkaaminen (lomakkeen esittäminen)
  public static function edit($id){
    $shoe = Shoe::find($id);

    self::render_view('shoe/edit.html', array('attributes' => $shoe));
  }
  //kengän muokkaaminen (lomakkeen käsittely)
  public static function update($id){
    $params = $_POST;

    $attributes = array(
      'brand' => $params['brand'],
      'name' => $params['name'],
      'description' => $params['description']
    );

    $shoe = new Shoe($attributes);
    $errors = $shoe->errors();

    if(count($errors) > 0){
      self::render_view('shoe/edit.html', array('errors' => $errors, 'attributes' => $attributes));
    }else{
      Shoe::update($id, $attributes);

      self::redirect_to('/shoe/' . $id, array('message' => 'Kenkää on muokattu onnistuneesti!'));
    }    
  }
  // Kengän poistaminen
  public static function destroy($id){
    Shoe::destroy($id);

    self::redirect_to('/shoe', array('message' => 'Kenkä on poistettu onnistuneesti!'));
  }
}  