<?php

namespace Azuos\Schema;

class Goal extends \Azuos\Database\Schema
{
   protected $table = 'goal';

   public function create()
   {
      $this->table($this->table);
      $this->id();
      $this->enum('type', ['aposta', 'oficial']);
      $this->int('team_id')->foreignKey('team')->onDeleteSetNull();
      $this->int('game_id')->foreignKey('game')->onDeleteSetNull();
      $this->int('player_id')->foreignKey('player')->onDeleteSetNull();
      $this->int('gambler_id')->foreignKey('gambler')->onDeleteSetNull();
      $this->runCreate();
   }

   public function factory()
   {
      (new \Azuos\Database\Database)->table($this->table)->insert([

      ]);
   }
}