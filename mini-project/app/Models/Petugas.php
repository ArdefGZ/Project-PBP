<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    public $timestamps = false;
    protected $table = 'petugas';
    protected $primaryKey = 'idpetugas';
    protected $fillable = ['nama', 'email', 'password'];
    public $incrementing = false;
    use HasFactory;
}
