<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $table = 'residents';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'phone_num', 'plate_num', 'entry_time', 'status'];
}
