<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\Petugas;

class Transaction extends Model
{
    public $timestamps = false;
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'idtransaksi';
    protected $fillable = ['idbuku', 'tgl_kembali', 'denda', 'idpetugas'];
    public $incrementing = false;

    public function book(){
        return $this->belongsTo(Book::class, 'idbuku', 'idbuku');
    }

    public function admin(){
        return $this->belongsTo(Petugas::class, 'idpetugas', 'idpetugas');
    }
    use HasFactory;
}
