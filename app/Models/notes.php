<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class notes extends Model
{
    use HasFactory;

    protected $fillable = [
        'Title',
        'Note_content',
        'user_id',
    ];

    public function User()
    {
        return $this->belongsTo(user::class);
    }
}
