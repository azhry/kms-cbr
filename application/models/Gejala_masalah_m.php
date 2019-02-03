<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Gejala_masalah_m extends Eloquent
{
    protected $table        = 'gejala_masalah';
    protected $primaryKey   = 'id';
    protected $fillable		= ['id_masalah', 'id_gejala'];

    public function gejala()
    {
    	require_once __DIR__ . '/Gejala_m.php';
        return $this->hasOne('Gejala_m', 'id_gejala', 'id_gejala');
    }
}
