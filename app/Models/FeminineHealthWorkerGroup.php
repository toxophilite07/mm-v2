<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeminineHealthWorkerGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function feminine() {
        return $this->belongsTo(User::class, 'feminine_id');
    }
}
