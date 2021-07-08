<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'status', 'message', 'dateTime', 'comment', 'user_id'];

    /**
     * использую в правилах валидаций
     */
    const ACTIVE = 'active';
    const RESOLVED = 'resolved';
    public static $types = [self::ACTIVE, self::RESOLVED];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
