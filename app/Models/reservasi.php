<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class reservasi extends Model
{
    use HasFactory;
    protected $guarded = ['id_reservasi'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
