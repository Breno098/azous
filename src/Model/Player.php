<?php

namespace Azous\Model;

class Player extends Model
{
   protected $table = 'player';
   protected $attributes = [
      'id', 'name', 'team_id', 'country_id'
   ];
}
