<?php

namespace Azuos\Schema;

class Gambler extends \Azuos\Database\SchemaBase
{
   protected $table = 'gambler';

   public function create()
   {
      $schema = new \Azuos\Database\Schema();
      $schema->table($this->table);
      $schema->id();
      $schema->string('name', 50);
      $schema->string('user', 20);
      $schema->string('token');
      $schema->timestamp('access_time')->defaultCurrent();
      $schema->create();
   }

   public function factory()
   {
      (new \Azuos\Database\Database)->table($this->table)->insert([
         'id' => 1,
         'name' => 'Gambler master', 
         'user' => 'master', 
         'token' => hash_token('master')
      ]);
   }
}