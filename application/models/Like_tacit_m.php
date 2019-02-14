<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Like_tacit_m extends Eloquent
{
    protected $table        = 'like_tacit';
    protected $primaryKey   = 'id_tacit';

    public function tacit()
    {
    	require_once __DIR__ . '/Pengetahuan_tacit_m.php';
        return $this->belongsTo('Pengetahuan_tacit_m', 'id_tacit', 'id_tacit');
    }
}
