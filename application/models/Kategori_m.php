<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Kategori_m extends Eloquent
{
    protected $table        = 'kategori';
    protected $primaryKey   = 'id_kategori';

}
