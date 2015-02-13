<?php

class Shoe extends BaseModel{
    //attribuutit
    public $id, $person_id, $brand, $name, $description, $models;
    //konstruktori
    public function __construct($attributes){
    parent::__construct($attributes);

     $this->validators = array('validate_brand', 'validate_name', 'validate_description');
  }

  public static function all($person_id){
    
    $shoes = array();
    // Kutsutaan luokan DB staattista metodia query
    $rows = DB::query('SELECT Shoe.id, Shoe.person_id, Shoe.brand, Shoe.name, Shoe.description FROM Shoe WHERE Shoe.person_id = :person_id', array('person_id' => $person_id));

    // Käydään kyselyn tuottamat rivit läpi
    foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      $shoes[] = new Shoe(array(
        'id' => $row['id'],
        'person_id' => $row['person_id'],
        'brand' => $row['brand'],
        'name' => $row['name'],
        'description' => $row['description']
      ));
    }

    return $shoes;
  }
//metodi, joka hakee tietokannasta tietyllä id:llä varustetun kengän:
  public static function find($id){
    $rows = DB::query('SELECT Shoe.id, Shoe.brand, Shoe.name, Shoe.description, Model.id as "model_id", Model.name as "model_name" FROM Shoe LEFT JOIN Shoe_Model ON Shoe_Model.shoe_id = Shoe.id LEFT JOIN Model ON Model.id = Shoe_Model.model_id WHERE Shoe.id = :id', array('id' => $id));

    if(count($rows) > 0){
      $row = $rows[0];

      $shoe = new Shoe(array(
        'id' => $row['id'],
        'brand' => $row['brand'],
        'name' => $row['name'],
        'models' => array(),
        'description' => $row['description']
      ));

      foreach($rows as $r){
        $shoe->models[] = new Model(array('id' => $r['model_id'], 'name' => $r['model_name']));
       // $shoe['models'][] = new Model(array('id' => $r['model_id'], 'name' => $r['model_name']));
      }

      return $shoe;
    }

    return null;
  }

  public static function create($shoe){
    $model_id = $shoe['model_id'];
    unset($shoe['model_id']);
    $rows = DB::query('INSERT INTO Shoe (brand, name, description, person_id) VALUES (:brand, :name, :description, :person_id) RETURNING id', $shoe);
    $id = $rows[0]['id'];
    DB::query('INSERT INTO Shoe_Model (model_id, shoe_id) VALUES (:model, :shoe)', array('shoe' => $id, 'model' => $model_id)); 

    return $id;
  }

  public static function destroy($id){
    DB::query('DELETE FROM Shoe WHERE id = :id', array('id' => $id));
  }

  public static function update($id, $attributes){
    $brand = $attributes['brand'];
    $name = $attributes['name'];
    $description = $attributes['description'];

    DB::query('UPDATE Shoe SET brand = :brand, name = :name, description = :description WHERE id = :id', array('id' => $id, 'brand' => $brand, 'name' => $name, 'description' => $description));
  }

  public function validate_brand(){
    $errors = array();

    if($this->brand == '' || $this->brand == null){
    $errors[] = 'Merkin nimi ei saa olla tyhjä!';
    }
    if(strlen($this->brand) < 3){
    $errors[] = 'Merkin nimen pituuden tulee olla vähintään kolme merkkiä';
  }

  return $errors;
}

  public function validate_name(){
  $errors = array();

  if($this->name == '' || $this->name == null){
    $errors[] = 'Mallin nimi ei saa olla tyhjä!';
  }
  if(strlen($this->name) < 3){
    $errors[] = 'Mallin nimen pituuden tulee olla vähintään kolme merkkiä';
  }

  return $errors;
}

  public function validate_description(){
  $errors = array();

  if($this->description == '' || $this->description == null){
    $errors[] = 'Kuvaus ei saa olla tyhjä!';
  }
  if(strlen($this->name) < 3){
    $errors[] = 'Kuvauksen pituuden tulee olla vähintään kolme merkkiä';
  }

  return $errors;
}

}