<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = array('nama_toko', 'alamat');

    // untuk melakukan update field created_at dan updated_at secara otomatis
    public $timestamps = true;
}

?>