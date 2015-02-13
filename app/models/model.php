<?php

class Model extends BaseModel{
    public $id, $name;

    public function __construct($attributes){
    parent::__construct($attributes);

    $this->validators = array('validate_name');
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

  public static function update($id, $attributes){
    $name = $attributes['name'];

    DB::query('UPDATE Model SET name = :name WHERE id = :id', array('id' => $id, 'name' => $name));
  }

  public static function destroy($id){
    DB::query('DELETE FROM Model WHERE id = :id', array('id' => $id));
  }

  public function validate_name(){
  $errors = array();

  if($this->name == '' || $this->name == null){
    $errors[] = 'Kenkätyypin nimi ei saa olla tyhjä!';
  }
  if(strlen($this->name) < 3){
    $errors[] = 'Kenkätyypin nimen pituuden tulee olla vähintään kolme merkkiä';
  }

  return $errors;
}
}