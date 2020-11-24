<?php

namespace Azous\Schema;

class Team extends \Azous\Database\SchemaBase
{
   protected $table = 'team';

   public function create()
   {
      $schema = new \Azous\Database\Schema();
      $schema->table($this->table);
      $schema->id();
      $schema->string('name', 50);
      $schema->int('id_country')->foreignKey('country', 'id')->onDeleteSetNull();
      $schema->create();
   }

   public function factory()
   {
      (new \Azous\Database\Database)->table($this->table)->insert([
         'id' => 1,
         'name' => 'Real Madrid', 
         'id_country' => 32
      ], [
         'id' => 2,
         'name' => 'Barcelona', 
         'id_country' => 32
      ], [
         'id' => 3,
         'name' => 'Juventus', 
         'id_country' => 41
      ], [
         'id' => 4,
         'name' => 'Bayern Munchen', 
         'id_country' => 1
      ], [
         'id' => 5,
         'name' => 'Manchester City', 
         'id_country' => 49
      ], [
         'id' => 6,
         'name' => 'Paris Saint-Germain', 
         'id_country' => 35
      ]);
   }
}