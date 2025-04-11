<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOtp extends Model
{
    protected $table = 'user_otps';


    protected $fillable = [
        'user_id',
        'otp_code',
        'expired_at'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
