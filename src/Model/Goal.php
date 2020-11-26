<?php

namespace Azuos\Model;

class Goal extends Model
{
   public $id;
   public $type;
   public $country_id = '(class) Country';
   public $team_id = '(class) Team';
   public $game_id = '(class) Game';
   public $player_id = '(class) Player';
   public $gambler_id = '(class) Gambler';

}