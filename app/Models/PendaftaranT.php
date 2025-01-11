<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranT extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'pendaftaran_id';

    public $timestamps = false;

    public function pasienlain() {
        return $this->hasMany(PendaftaranT::class, 'pasien_parent_id', 'pendaftaran_id');
    }
}
