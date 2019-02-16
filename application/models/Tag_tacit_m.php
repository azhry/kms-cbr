<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Tag_tacit_m extends Eloquent
{
    protected $table        = 'tag_tacit';
    protected $primaryKey   = 'id_tag';
    protected $fillable     = ['id_tacit', 'id_pengguna'];

    public function tacit()
    {
    	require_once __DIR__ . '/Pengetahuan_tacit_m.php';
        return $this->belongsTo('Pengetahuan_tacit_m', 'id_tacit', 'id_tacit');
    }

    public function pengguna()
    {
    	require_once __DIR__ . '/Pengguna_m.php';
        return $this->hasOne('Pengguna_m', 'id_pengguna', 'id_pengguna');
    }
}
