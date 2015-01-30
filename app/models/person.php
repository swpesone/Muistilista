<?php
class Person extends BaseModel{
    
    public $id, $name, $password;

    public function __construct($attributes){
    parent::__construct($attributes);
  }

  public static function all(){
    $persons = array();
    $rows = DB::query('SELECT * FROM Person');

    foreach($rows as $row){
      $persons[] = new Person(array(
        'id' => $row['id'],
        'name' => $row['name'],
       	'password' => $row['password']
      ));
    }

    return $shoes;
  }

  public static function find($id){
    $rows = DB::query('SELECT * FROM Person WHERE id = :id LIMIT 1', array('id' => $id));

    if(count($rows) > 0){
      $row = $rows[0];

      $person = new Person(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'password' => $row['password']
      ));

      return $person;
    }

    return null;
  }
}