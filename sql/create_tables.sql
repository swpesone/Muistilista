-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Person(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  name varchar(50) NOT NULL,
  password varchar(50) NOT NULL
);

CREATE TABLE Model(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL
);

CREATE TABLE Shoe(
  id SERIAL PRIMARY KEY,
  person_id INTEGER REFERENCES Person(id), -- Viiteavain Person-tauluun
  brand varchar(50) NOT NULL,
  name varchar(50) NOT NULL,
  model_id INTEGER REFERENCES Model(id),
  description varchar(400)
);

CREATE TABLE Shoe_Model(
  shoe_id INTEGER REFERENCES Shoe(id),
  model_id INTEGER REFERENCES Model(id)
);  




