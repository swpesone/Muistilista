<?php

class ModelController extends BaseController{
	
	public static function index() {
		$models = Model::all();

		self::render_view('model/index.html', array('models' => $models));
	}

	public static function show($id){
    	$model = Model::find($id);

    	self::render_view('model/show.html', array('model' => $model));
  }

    public static function create(){
    self::check_logged_in();
    
		self::render_view('model/new.html');
  }

   public static function store(){
    $params = $_POST;

    $attributes = array(
      'name' => $params['name']
    );

    $model = new Model($attributes);
    $errors = $model->errors();

    if(count($errors) == 0){
      $id = Model::create($attributes);

      self::redirect_to('/model', array('message' => 'Kenkätyyppi on lisätty listallesi!'));
    }else{
      self::redirect_to('/model/new', array('errors' => $errors, 'attributes' => $attributes));
    }
  }

public static function edit($id){
    self::check_logged_in();

    $model = Model::find($id);

    self::render_view('model/edit.html', array('attributes' => $model));
  }

    public static function update($id){
    self::check_logged_in();

    $params = $_POST;

    $attributes = array(
      'id' => $id,
      'name' => $params['name']
    );

    $model = new Model($attributes);
    $errors = $model->errors();

    if(count($errors) > 0){
      self::render_view('model/edit.html', array('errors' => $errors, 'attributes' => $attributes));
    }else{
      Model::update($id, $attributes);

      self::redirect_to('/model', array('message' => 'Kenkätyyppiä on muokattu onnistuneesti!'));
    }    
  }

    public static function destroy($id){
    self::check_logged_in();
      
    Model::destroy($id);

    self::redirect_to('/model', array('message' => 'Kenkätyyppi on poistettu onnistuneesti!'));
  }

}