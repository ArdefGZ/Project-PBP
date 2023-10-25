<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Anggota;
use App\Models\Petugas;
use App\Models\Transaction;

class Peminjaman extends Model
{
    public $timestamps = false;
    protected $table = 'peminjaman';
    protected $primaryKey = 'idtransaksi';
    protected $fillable = ['noktp', 'tgl_peminjaman', 'denda', 'idpetugas'];
    public $incrementing = false;

    public function anggota(){
        return $this->belongsTo(Anggota::class, 'noktp', 'noktp');
    }

    public function admin(){
        return $this->belongsTo(Petugas::class, 'idpetugas', 'idpetugas');
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'idtransaksi', 'idtransaksi');
    }
    use HasFactory;
}
