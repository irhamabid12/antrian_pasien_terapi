<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaJadwalOperasionalM extends Model
{
    use HasFactory;

    protected $table = 'kuota_jadwal_operasional';
    protected $primaryKey = 'jadwal_id';
    
    public $timestamps = false;
}
