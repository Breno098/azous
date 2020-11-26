<?php

namespace Azuos\Schema;

class Goal extends \Azuos\Database\SchemaBase
{
   protected $table = 'goal';

   public function create()
   {
      $schema = new \Azuos\Database\Schema();
      $schema->table($this->table);
      $schema->id();
      $schema->enum('type', ['aposta', 'oficial']);
      $schema->int('team_id')->foreignKey('team')->onDeleteSetNull();
      $schema->int('game_id')->foreignKey('game')->onDeleteSetNull();
      $schema->int('player_id')->foreignKey('player')->onDeleteSetNull();
      $schema->int('gambler_id')->foreignKey('gambler')->onDeleteSetNull();
      $schema->create();
   }

   public function factory()
   {
      (new \Azuos\Database\Database)->table($this->table)->insert([

      ]);
   }
}