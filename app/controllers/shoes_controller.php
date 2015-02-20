<?php

class ShoeController extends BaseController{
   public static function index(){

    self::check_logged_in();
    $person = self::get_user_logged_in();
    $person_id = $person->id;
    // Haetaan kaikki kengät tietokannasta
    $shoes = Shoe::all($person_id);
    // Renderöidään views/shoe kansiossa sijaitseva tiedosto index.html muuttujan $shoes datalla
    self::render_view('shoe/index.html', array('shoes' => $shoes));
  }

  public static function store(){
    self::check_logged_in();
    $params = $_POST;
    $person = self::get_user_logged_in();
    $person_id = $person->id;

    if(!key_exists('model_id', $params)){
      $params['model_id'] = null;
    }

    $attributes = array(
      'person_id' => $person_id,
      'models' => $params['model_id'],
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
      $models = Model::all();
      self::render_view('shoe/new.html', array('errors' => $errors, 'attributes' => $attributes, 'models' => $models));
    }    
  }

  public static function create(){
    self::check_logged_in();
    $models = Model::all();
    self::render_view('shoe/new.html', array('models' => $models));
  }

  public static function show($id){
    self::check_logged_in();
    $shoe = Shoe::find($id);
    self::render_view('shoe/show.html', array('shoe' => $shoe));
  }
  //kengän muokkaaminen (lomakkeen esittäminen)
  public static function edit($id){
    self::check_logged_in();
    $shoe = Shoe::find($id);
    $models = Model::all();

    self::render_view('shoe/edit.html', array('attributes' => $shoe, 'models' => $models));
  }
  //kengän muokkaaminen (lomakkeen käsittely)
  public static function update($id){
    self::check_logged_in();
    $params = $_POST;

    $attributes = array(
      'id' => $id,
      'brand' => $params['brand'],
      'models' => $params['model_id'],
      'name' => $params['name'],
      'description' => $params['description']
    );

    $shoe = new Shoe($attributes);
    $errors = $shoe->errors();

    if(count($errors) > 0){
      $models = Model::all();
      self::render_view('shoe/edit.html', array('errors' => $errors, 'attributes' => $attributes, 'models' => $models));
    }else{
      Shoe::update($id, $attributes);

      self::redirect_to('/shoe/' . $id, array('message' => 'Kenkää on muokattu onnistuneesti!'));
    }    
  }
  // Kengän poistaminen
  public static function destroy($id){
    self::check_logged_in();
    Shoe::destroy($id);

    self::redirect_to('/shoe', array('message' => 'Kenkä on poistettu onnistuneesti!'));
  }
}  