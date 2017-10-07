<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function createDatabase(){

        $user = auth()->user();

        $dbName = env('DB_DATABASE','').'_tenant_'.$user->id;

        try {

            \Artisan::call('make:database', ['name' => $dbName]);
            
            $user->mysql_database = $dbName;
            $user->mysql_host = env('DB_HOST', '127.0.0.1');
            $user->mysql_username = env('DB_USERNAME', '');
            $user->mysql_password = env('DB_PASSWORD', '');
            $user->save();

            return redirect()->route('migratedb');

        } catch (\Exception $e) {
            return redirect()->back()->withStatus('danger')->withMessage('Database creation failed');
        }

    }

    public function migrateDatabase(){

        try {

            \Artisan::call('migrate:fresh', ['--database' => 'tenant','--path' => 'database/migrations/tenants']);
            \Artisan::call('db:seed', ['--class' => 'TenantDatabaseSeeder']);

            return redirect()->back()->withStatus('success')->withMessage('Database migrated successfully');
            
        } catch (\Exception $e) {
            return redirect()->back()->withStatus('danger')->withMessage('Database migration failed');
        }

    }
}
