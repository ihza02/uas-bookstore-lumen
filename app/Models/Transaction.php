<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = array('user_id', 'book_id', 'total_harga');

    // untuk melakukan update field created_at dan updated_at secara otomatis
    public $timestamps = true;

    public function user () {
        return $this->belongsTo(User::class);
    }
}

?>