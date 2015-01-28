<?php

class Shoe extends BaseModel{
    //attribuutit
    public $id, $person_id, $brand, $name, $model_id, $description;
    //konstruktori
    public function __construct($attributes){
    parent::__construct($attributes);
  }

  public static function all(){
    $shoes = array();
    // Kutsutaan luokan DB staattista metodia query
    $rows = DB::query('SELECT * FROM Shoe');

    // Käydään kyselyn tuottamat rivit läpi
    foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      $shoes[] = new Shoe(array(
        'id' => $row['id'],
        'person_id' => $row['person_id'],
        'brand' => $row['brand'],
        'name' => $row['name'],
        'model_id' => $row['model_id'],
        'description' => $row['description']        
      ));
    }

    return $shoes;
  }
//metodi, joka hakee tietokannasta tietyllä id:llä varustetun kengän:
  public static function find($id){
    $rows = DB::query('SELECT * FROM Shoe WHERE id = :id LIMIT 1', array('id' => $id));

    if(count($rows) > 0){
      $row = $rows[0];

      $shoe = new Shoe(array(
        'id' => $row['id'],
        'person_id' => $row['person_id'],
        'brand' => $row['brand'],
        'name' => $row['name'],
        'model_id' => $row['model_id'],
        'description' => $row['description']
      ));

      return $shoe;
    }

    return null;
  }

  public static function create($shoe) {
    $rows = DB::query('INSERT INTO Shoe (brand, name, description) VALUES (:brand, :name, :description) RETURNING id', $shoe);
    return $rows[0]['id'];
  }
}