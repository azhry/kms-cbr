<?php 

class Login extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$id_pengguna	= $this->session->userdata('id_pengguna');
	    $nip 			= $this->session->userdata('nip');
	    $id_role		= $this->session->userdata('id_role');
		if (isset($id_pengguna, $nip, $id_role))
		{
			switch ($id_role) 
			{
				case 1:
					redirect('kasubbid');
					break;

				case 2:
					redirect('pakar');
					break;

				case 3:
					redirect('unit');
					break;

				case 4:
					redirect('admin');
					break;

			}

		}
	}

	public function index()
	{
		if ($this->POST('login-submit'))
		{
			$this->load->model('Pengguna_m');
			$pengguna = Pengguna_m::where('nip', $this->POST('nip'))
							->where('password', md5($this->POST('password')))
							->first();
			if (!isset($pengguna)) 
			{
				$this->flashmsg('Email atau password salah','danger');
			}
			else
			{
				$this->session->set_userdata([
					'id_pengguna'	=> $pengguna->id_pengguna,
					'nip'			=> $pengguna->nip,
					'id_role'		=> $pengguna->id_role
				]);
			}

			redirect('login');
		}
		$this->data['title']  = 'Login';
		$this->load->view('login', $this->data);
	}
}