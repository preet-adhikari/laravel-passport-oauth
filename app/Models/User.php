<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Select the right client for the user
    public function createTokenForClients($client_id)
    {

        $client = Client::findOrFail($client_id);
        if($client) 
        {
            if(Auth::user()->id == $client->user_id)
            {
                $user = Auth::user();
                // $token = uniqid();
                // dd($token);
                return $user->createToken("Access Token");
                // return Passport::token()->create([
                //     'user_id' => $user->id,
                //     'client_id' => $client->id,
                //     'name' => "Access Token",
                //     'scopes' => []
                // ]);

            }

        }
    }
}
