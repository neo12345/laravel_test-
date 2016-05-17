<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmailLogin extends Model
{
    protected $fillable = [
        'email',
        'token',
    ];
    
    public function user()
    {
        return $this->hasOne(\App\Admin::class, 'email', 'email');
    }
    
    public static function createForUser($email)
    {
        return self::create([
            'email' => $email,
            'token' => str_random(20),
        ]);
    }
    
    public static function validFromToken($token)
    {
        return self::where('token', $token)
            ->where('created_at', '>', Carbon::parse('-15 minutes'))
            ->firstOrFail();
    }
}
