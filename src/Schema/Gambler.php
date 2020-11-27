<?php

namespace Azuos\Schema;

class Gambler extends \Azuos\Database\Schema
{
   protected $table = 'gambler';

   public function create()
   {
      $this->table($this->table);
      $this->id();
      $this->string('name', 50);
      $this->string('user', 20);
      $this->string('token');
      $this->timestamp('access_time')->defaultCurrent();
      $this->runCreate();
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