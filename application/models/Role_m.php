<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Role_m extends Eloquent
{
    protected $table        = 'role';
    protected $primaryKey   = 'id_role';

}
