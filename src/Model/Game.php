<?php

namespace Azuos\Model;

class Game extends Model
{
   public $id;
   public $place;
   public $type;
   public $home_team_score;
   public $guest_team_score;
   public $home_team_id = '(class) Team';
   public $guest_team_id = '(class) Team';
   public $gambler_id = '(class) Gambler';
   public $goals_players_ids;
}