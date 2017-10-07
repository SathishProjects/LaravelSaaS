<?php

namespace App\Support;

use App\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait TenantConnector {
   
   /**
    * Switch the Tenant connection to a different user.
    * @param User $user
    * @return void
    * @throws
    */
   public function reconnect(User $user) {     
      // Erase the tenant connection, thus making Laravel get the default values all over again.
      DB::purge('tenant');
      
      // Make sure to use the database name we want to establish a connection.
      Config::set('database.connections.tenant.host', $user->mysql_host);
      Config::set('database.connections.tenant.database', $user->mysql_database);
      Config::set('database.connections.tenant.username', $user->mysql_username);
      Config::set('database.connections.tenant.password', $user->mysql_password);
      
      // Rearrange the connection data
      DB::reconnect('tenant');
      
      // Ping the database. This will throw an exception in case the database does not exists or the connection fails
      Schema::connection('tenant')->getConnection()->reconnect();
   }
   
}