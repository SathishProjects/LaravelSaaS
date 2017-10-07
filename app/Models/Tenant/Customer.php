<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

   protected $connection = 'tenant';

   protected $table = 'customers';
}