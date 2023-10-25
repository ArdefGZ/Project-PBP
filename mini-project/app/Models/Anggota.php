<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Status;

class Anggota extends Model
{
    public $timestamps = false;
    protected $table = 'anggota';
    protected $primaryKey = 'noktp';
    protected $fillable = ['noktp', 'nama', 'password', 'alamat', 'kota', 'email', 'no_telp', 'file_ktp', 'idstatus'];
    public $incrementing = false;

    public function status()
    {
        return $this->belongsTo(Status::class, 'idstatus', 'id');
    }
    use HasFactory;
}
