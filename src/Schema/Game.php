<?php

namespace Azuos\Schema;

class Game extends \Azuos\Database\Schema
{
   protected $table = 'game';

   public function create()
   {
      $this->table($this->table);
      $this->id();
      $this->string('place');
      $this->enum('type', ['aposta', 'oficial']);
      $this->int('home_team_score');
      $this->int('guest_team_score');
      $this->int('home_team_id')->foreignKey('team')->onDeleteSetNull();
      $this->int('guest_team_id')->foreignKey('team')->onDeleteSetNull();
      $this->int('gambler_id')->foreignKey('gambler')->onDeleteSetNull();
      $this->string('goals_players_ids');
      $this->runCreate();
   }

   public function factory()
   {
      (new \Azuos\Database\Database)->table($this->table)->insert([
         'id' => 1,
         'place' => 'Santiago Bernabéu',
         'type' => 'oficial',
         'home_team_score' => 1,
         'guest_team_score' => 0,
         'home_team_id' => 1,
         'guest_team_id' => 2,
         'gambler_id' => null,
         'goals_players_ids' => '5'
      ], [
         'id' => 2,
         'place' => 'Santiago Bernabéu',
         'type' => 'aposta',
         'home_team_score' => 1,
         'guest_team_score' => 0,
         'home_team_id' => 1,
         'guest_team_id' => 2,
         'gambler_id' => 1,
         'goals_players_ids' => '5'
      ]);
   }
}