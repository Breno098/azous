<?php

namespace Azous\Schema;

class User extends \Azous\Database\SchemaBase
{
   protected $table = 'user';

   public function create()
   {
      $schema = new \Azous\Database\Schema();
      $schema->table($this->table);
      $schema->id();
      $schema->string('name', 50);
      $schema->timestamp('access_time')->defaultCurrent();
      $schema->createOrReplace();
   }

   public function factory()
   {
      (new \Azous\Database\Database)->table($this->table)->insert(
         ['name' => 'Master']
      );
   }
}