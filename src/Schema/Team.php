<?php

namespace Azuos\Schema;

class Team extends \Azuos\Database\Schema
{
   protected $table = 'team';

   public function create()
   {
      $this->table($this->table);
      $this->id();
      $this->string('name', 50);
      $this->int('country_id')->foreignKey('country', 'id')->onDeleteSetNull();
      $this->runCreate();
   }

   public function factory()
   {
      (new \Azuos\Database\Database)->table($this->table)->insert([
         'id' => 1,
         'name' => 'Real Madrid', 
         'country_id' => 32
      ], [
         'id' => 2,
         'name' => 'Barcelona', 
         'country_id' => 32
      ], [
         'id' => 3,
         'name' => 'Juventus', 
         'country_id' => 41
      ], [
         'id' => 4,
         'name' => 'Bayern Munchen', 
         'country_id' => 1
      ], [
         'id' => 5,
         'name' => 'Manchester City', 
         'country_id' => 49
      ], [
         'id' => 6,
         'name' => 'Paris Saint-Germain', 
         'country_id' => 35
      ]);
   }
}