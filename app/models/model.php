<?php

class Model extends BaseModel{
    public $id, $name;

    public function __construct($attributes){
    parent::__construct($attributes);
  }
  public static function all(){
    $models = array();
    $rows = DB::query('SELECT * FROM Model');

    foreach($rows as $row){
      $models[] = new Model(array(
        'id' => $row['id'],
        'name' => $row['name']
      ));
    }

    return $models;
  }

  public static function find($id){
    $rows = DB::query('SELECT * FROM Model WHERE id = :id LIMIT 1', array('id' => $id));

    if(count($rows) > 0){
      $row = $rows[0];

      $model = new Model(array(
        'id' => $row['id'],
        'name' => $row['name']
      ));

      return $model;
    }

    return null;
  }

    public static function create($model) {
    $rows = DB::query('INSERT INTO Model (name) VALUES (:name) RETURNING id', $model);
    return $rows[0]['id'];
  }
}