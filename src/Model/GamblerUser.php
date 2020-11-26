<?php

namespace Azuos\Model;

class GamblerUser extends Model
{
   public $id;
   public $name;
   public $user;
   public $access_time;
   public $token;

   protected function table()
   {
      return 'gambler';
   }
}