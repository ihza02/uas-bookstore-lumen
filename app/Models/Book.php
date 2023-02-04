<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = array('shop_id', 'user_id','judul', 'pengarang', 'penerbit', 'genre', 'deskripsi', 'tahun_terbit', 'stok', 'harga');

    public $timestamps = true;
    
    /** ==== Realationship ==== */
    public function user () {
        return $this->belongsTo('App\Models\User');
    }
}

?>