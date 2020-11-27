<?php

namespace Azuos\Schema;

class Country extends \Azuos\Database\Schema
{
   protected $table = 'country';

   public function create()
   {
      $this->table($this->table);
      $this->id();
      $this->string('name', 50);
      $this->runCreate();
   }

   public function factory()
   {
      (new \Azuos\Database\Database)->table($this->table)->insert(
         ['id' => 1,'name' => 'Alemanha'],
         ['id' => 2,'name' => 'Argentina'],
         ['id' => 3,'name' => 'Bolívia'],
         ['id' => 4,'name' => 'Chile'],
         ['id' => 5,'name' => 'China'],
         ['id' => 6,'name' => 'Colômbia'],
         ['id' => 7,'name' => 'Costa do Marfim'],
         ['id' => 8,'name' => 'Costa Rica'],
         ['id' => 9,'name' => 'Croácia'],
         ['id' => 10,'name' => 'Egipto'],
         ['id' => 11,'name' => 'Equador'],
         ['id' => 12,'name' => 'Gana'],
         ['id' => 13,'name' => 'Portugal'],
         ['id' => 14,'name' => 'Reino Unido'],
         ['id' => 15,'name' => 'Rússia'],
         ['id' => 16,'name' => 'Uruguai'],
         ['id' => 17,'name' => 'Ucrânia'],
         ['id' => 18,'name' => 'Venezuela'],
         ['id' => 19,'name' => 'África do Sul'],
         ['id' => 20,'name' => 'Angola'],
         ['id' => 21,'name' => 'Austrália'],
         ['id' => 22,'name' => 'Áustria'],
         ['id' => 23,'name' => 'Bélgica'],
         ['id' => 24,'name' => 'Brasil'],
         ['id' => 25,'name' => 'Bulgária'],
         ['id' => 26,'name' => 'Camarões'],
         ['id' => 27,'name' => 'Espanha'],
         ['id' => 28,'name' => 'Canadá'],
         ['id' => 29,'name' => 'Dinamarca'],
         ['id' => 30,'name' => 'Eslováquia'],
         ['id' => 31,'name' => 'Eslovénia'],
         ['id' => 32,'name' => 'Espanha'],
         ['id' => 33,'name' => 'Estados Unidos da América'],
         ['id' => 34,'name' => 'Finlândia'],
         ['id' => 35,'name' => 'França'],
         ['id' => 36,'name' => 'Grécia'],
         ['id' => 37,'name' => 'Holanda'],
         ['id' => 38,'name' => 'Hungria'],
         ['id' => 39,'name' => 'Irlanda'],
         ['id' => 40,'name' => 'Islândia'],
         ['id' => 41,'name' => 'Itália'],
         ['id' => 42,'name' => 'Luxemburgo'],
         ['id' => 43,'name' => 'Noruega'],
         ['id' => 44,'name' => 'Polónia'],
         ['id' => 45,'name' => 'República Checa'],
         ['id' => 46,'name' => 'Suécia'],
         ['id' => 47,'name' => 'Suíça'],
         ['id' => 48,'name' => 'Turquia'],
         ['id' => 49,'name' => 'Inglaterra']
      );
   }

}