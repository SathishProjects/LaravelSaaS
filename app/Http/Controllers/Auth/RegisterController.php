<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Support\TenantConnector;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, TenantConnector;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function createDatabase(){

        $user = User::find(1);

        $dbName = 'tenant_'.$user->name;

        try {

            \Artisan::call('make:database', ['name' => $dbName]);
            
            $user->mysql_database = $dbName;
            $user->mysql_host = env('DB_HOST', '127.0.0.1');
            $user->mysql_username = env('DB_USERNAME', '');
            $user->mysql_password = env('DB_PASSWORD', '');
            $user->save();

            echo ('Success - '.$dbName);
            dd(\Artisan::output());

        } catch (\Exception $e) {
            dd('error');
        }

    }

    public function migrateDatabase(){

        try {

            \Artisan::call('migrate:fresh', ['--database' => 'tenant','--path' => 'database/migrations/tenants']);
            \Artisan::call('db:seed', ['--class' => 'TenantDatabaseSeeder']);

            echo ('migrations done successfully');
            dd(\Artisan::output());
            
        } catch (\Exception $e) {
            dd('error');
        }

    }
}
