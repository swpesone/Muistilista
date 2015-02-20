<?php
class Person extends BaseModel{
    
    public $id, $username, $password, $password_again;

    public function __construct($attributes){
    parent::__construct($attributes);

    $this->validators = array('validate_username', 'validate_password', 'validate_password_again');
  }

  public static function all(){
    $persons = array();
    $rows = DB::query('SELECT * FROM Person');

    foreach($rows as $row){
      $persons[] = new Person(array(
        'id' => $row['id'],
        'username' => $row['username'],
       	'password' => $row['password']
      ));
    }

    return $persons;
  }

  public static function find($id){
    $rows = DB::query('SELECT * FROM Person WHERE id = :id LIMIT 1', array('id' => $id));

    if(count($rows) > 0){
      $row = $rows[0];

      $person = new Person(array(
        'id' => $row['id'],
        'username' => $row['username'],
        'password' => $row['password']
      ));

      return $person;
    }

    return null;
  }

  public static function create($person){
    $rows = DB::query('INSERT INTO Person (username, password) VALUES (:username, :password) RETURNING id', $person);
    return $rows[0]['id'];
  }

  public static function authenticate($username, $password){
    $rows = DB::query('SELECT * FROM Person WHERE username = :username AND password = :password', array('username' => $username, 'password' => $password));
    
      if(count($rows) > 0){
      $row = $rows[0];

      $person = new Person(array(
        'id' => $row['id'],
        'username' => $row['username'],
        'password' => $row['password']
      ));

      return $person;
    }
    return false;
  }

  public function validate_username(){
  $errors = array();

  if($this->username == '' || $this->username == null){
    $errors[] = 'Käyttäjätunnus ei saa olla tyhjä!';
  }
  if(strlen($this->username) < 3){
    $errors[] = 'Käyttäjätunnuksen pituuden tulee olla vähintään kolme merkkiä';
  }

  return $errors;
}

public function validate_password(){
  $errors = array();

  if($this->password == '' || $this->password == null){
    $errors[] = 'Salasana ei saa olla tyhjä!';
  }
  if(strlen($this->password) < 3){
    $errors[] = 'Salasanan pituuden tulee olla vähintään kolme merkkiä';
  }

  return $errors;
}

public function validate_password_again(){
  $errors = array();

  if(!$this->password_again == $this->password){
    $errors[] = 'Salasana ei täsmää';
  }

  return $errors;
}
}