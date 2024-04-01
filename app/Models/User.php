<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
   protected $table = 'users';
   protected $primaryKey = 'id';
   protected $allowedFields = ['name','username','email','password','picture','bio'];

   public function getUserByUsername($type,$username)
   {
       // Example query to retrieve a user by username
       return $this->where($type, $username)->first();
   }



}
