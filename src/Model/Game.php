<?php

namespace Azous\Schema;

class Game extends SchemaBase
{
   protected $table = 'game';

   public function create()
   {
      $schema = new \Azous\Database\Schema();
      $schema->table($this->table);
      $schema->id();
      $schema->string('place');
      $schema->enum('type', ['aposta', 'oficial']);
      $schema->int('home_team_score');
      $schema->int('guest_team_score');
      $schema->int('home_team_id')->foreignKey('team')->onDeleteSetNull();
      $schema->int('guest_team_id')->foreignKey('team')->onDeleteSetNull();
      $schema->int('gambler_id')->foreignKey('gambler')->onDeleteSetNull();
      $schema->string('goals_players_ids');
      $schema->create();
   }

   public function factory()
   {
      (new \Azous\Database\Database)->table($this->table)->insert([
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