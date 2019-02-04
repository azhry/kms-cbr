<?php 

class Kasubbid extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'kasubbid';
        $this->data['id_role']  = $this->session->userdata('id_role');
        if (!isset($this->data['id_role']) or $this->data['id_role'] != 1)
        {
          $this->session->sess_destroy();
          redirect('login');
        }
        $this->data['id_pengguna']  = $this->session->userdata('id_pengguna');
        $this->data['nip']          = $this->session->userdata('nip');
        $this->load->model('Pengguna_m');
		$this->data['data_pengguna']	= Pengguna_m::find($this->data['id_pengguna']);
	}

	public function index()
	{
		$this->load->model('Pengguna_m');
		$this->load->model('Pengetahuan_tacit_m');
		$this->load->model('Pengetahuan_eksplisit_m');
		$this->load->model('Masalah_m');
		$this->data['pengguna']					= Pengguna_m::get();
		$this->data['pengetahuan_tacit']		= Pengetahuan_tacit_m::get();
		$this->data['pengetahuan_eksplisit']	= Pengetahuan_eksplisit_m::get();
		$this->data['masalah']					= Masalah_m::get();
		$this->data['title']					= 'Dashboard';
		$this->data['content']					= 'dashboard';
		$this->template($this->data, $this->module);
	}

	public function profile()
	{
		if ($this->POST('submit'))
		{
			$this->data['data_pengguna']->nama = $this->POST('nama');
			$this->data['data_pengguna']->jenis_kelamin = $this->POST('jenis_kelamin');
			$this->data['data_pengguna']->tempat_lahir = $this->POST('tempat_lahir');
			$this->data['data_pengguna']->tanggal_lahir = $this->POST('tanggal_lahir');

			$password = $this->POST('password');
			if (!empty($password))
			{
				$rpassword = $this->POST('rpassword');
				if ($password != $rpassword)
				{
					$this->flashmsg('Password harus sama dengan konfirmasi password', 'danger');
					redirect('kasubbid/profile');
				}

				$this->data['data_pengguna']->password = md5($password);
			}

			$this->data['data_pengguna']->save();
			$this->upload($this->data['data_pengguna']->id_pengguna . '.jpg', 'assets/foto', 'foto');

			$this->flashmsg('Data successfully saved');
			redirect('kasubbid/profile');
		}

		$this->data['title']	= 'Profile';
		$this->data['content']	= 'profile';
		$this->template($this->data, $this->module);
	}

	public function problem_solving()
	{
		$this->load->model('Gejala_m');
		$this->data['gejala'] 	= Gejala_m::get();

		if ($this->POST('submit'))
		{
			require_once APPPATH . 'libraries/cbr/CaseBasedReasoning.php';
			$cbr = new CaseBasedReasoning($this->data['gejala']);
			$this->load->model('Masalah_m');
			$this->data['masalah'] = Masalah_m::with('solusi')->get();
			$cbr->fit2($this->data['masalah']);
			$this->data['solusi'] = $cbr->rank($this->POST('gejala'));
		}

		$this->data['title']	= 'Problem Solving';
		$this->data['content']	= 'problem_solving';
		$this->template($this->data, $this->module);
	}

	public function pengetahuan_tacit()
    {
        $this->data['id_tacit'] = $this->uri->segment(3);
        $this->load->model('Pengetahuan_tacit_m');
        if (isset($this->data['id_tacit']))
        {
            $data = Pengetahuan_tacit_m::find($this->data['id_tacit']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('kasubbid/pengetahuan_tacit');
        }

        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::get();
        $this->data['title'] = 'Pengetahuan Tacit';
        $this->data['content'] = 'pengetahuan_tacit';
        $this->template($this->data, $this->module);
    }

    public function validasi_tacit()
    {
        $this->load->model('Pengetahuan_tacit_m');
        if ($this->POST('validate'))
        {
        	$data = Pengetahuan_tacit_m::find($this->POST('id'));
        	$data->status = $data->status == 'Pending' ? 'Valid' : 'Pending';
        	$data->save();
        	echo json_encode(['status' => $data->status]);
        	exit;
        }
        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::get();
        $this->data['title'] = 'Validasi Tacit';
        $this->data['content'] = 'validasi_tacit';
        $this->template($this->data, $this->module);
    }

    public function detail_pengetahuan_tacit()
    {
        $this->data['id_tacit'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_tacit']));

        $this->load->model('Pengetahuan_tacit_m');
        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::with('komentar', 'pengguna')
        									->find($this->data['id_tacit']);
        $this->check_allowance(!isset($this->data['pengetahuan_tacit']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {
        	$komentar = new Komentar_tacit_m();
        	$komentar->id_tacit = $this->data['id_tacit'];
        	$komentar->id_pengguna = $this->data['id_pengguna'];
        	$komentar->komentar = $this->POST('komentar');
        	$komentar->save();

        	$this->flashmsg('Comment successfully added');
            redirect('kasubbid/detail_pengetahuan_tacit/' . $this->data['id_tacit']);

        }

        $this->load->helper('timeago');
        $this->data['title'] = 'Detail Pengetahuan Tacit';
        $this->data['content'] = 'detail_pengetahuan_tacit';
        $this->template($this->data, $this->module);
    }

    public function add_pengetahuan_tacit()
    {
        $this->load->model('Pengetahuan_tacit_m');
        if ($this->POST('submit'))
        {
            $pengetahuan_tacit = new Pengetahuan_tacit_m();
            $pengetahuan_tacit->id_kategori = $this->POST('id_kategori');
            $pengetahuan_tacit->id_pengguna = $this->data['id_pengguna'];
            $pengetahuan_tacit->judul = $this->POST('judul');
            $pengetahuan_tacit->isi = $this->POST('isi');
            $pengetahuan_tacit->save();
            $this->flashmsg('Data successfully added');
            redirect('kasubbid/add_pengetahuan_tacit');
        }

        $this->load->model('Kategori_m');
        $this->data['kategori'] = Kategori_m::get();
        $this->data['title'] = 'Add Pengetahuan Tacit';
        $this->data['content'] = 'add_pengetahuan_tacit';
        $this->template($this->data, $this->module);
    }

    public function edit_pengetahuan_tacit()
    {
        $this->data['id_tacit'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_tacit']));

        $this->load->model('Pengetahuan_tacit_m');
        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::find($this->data['id_tacit']);
        $this->check_allowance(!isset($this->data['pengetahuan_tacit']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {
            $this->data['pengetahuan_tacit']->id_kategori = $this->POST('id_kategori');
            $this->data['pengetahuan_tacit']->judul = $this->POST('judul');
            $this->data['pengetahuan_tacit']->isi = $this->POST('isi');
            $this->data['pengetahuan_tacit']->save();
            $this->flashmsg('Data successfully edited');
            redirect('kasubbid/edit_pengetahuan_tacit/' . $this->data['id_tacit']);
        }

        $this->load->model('Kategori_m');
        $this->data['kategori'] = Kategori_m::get();
        $this->data['title'] = 'Edit Pengetahuan Tacit';
        $this->data['content'] = 'edit_pengetahuan_tacit';
        $this->template($this->data, $this->module);
    }

	public function pengetahuan_eksplisit()
    {
        $this->data['id_eksplisit'] = $this->uri->segment(3);
        $this->load->model('Pengetahuan_eksplisit_m');
        if (isset($this->data['id_eksplisit']))
        {
            $data = Pengetahuan_eksplisit_m::find($this->data['id_eksplisit']);
            @unlink(FCPATH . 'assets/lampiran/' . $data->lampiran);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('kasubbid/pengetahuan_eksplisit');
        }

        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::get();
        $this->data['title'] = 'Pengetahuan Eksplisit';
        $this->data['content'] = 'pengetahuan_eksplisit';
        $this->template($this->data, $this->module);
    }

    public function validasi_eksplisit()
    {
        $this->load->model('Pengetahuan_eksplisit_m');
        if ($this->POST('validate'))
        {
        	$data = Pengetahuan_eksplisit_m::find($this->POST('id'));
        	$data->status = $data->status == 'Pending' ? 'Valid' : 'Pending';
        	$data->save();
        	echo json_encode(['status' => $data->status]);
        	exit;
        }
        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::get();
        $this->data['title'] = 'Pengetahuan Eksplisit';
        $this->data['content'] = 'validasi_eksplisit';
        $this->template($this->data, $this->module);
    }

    public function detail_pengetahuan_eksplisit()
    {
        $this->data['id_eksplisit'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_eksplisit']));

        $this->load->model('Pengetahuan_eksplisit_m');
        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::with('komentar', 'pengguna')
        										->find($this->data['id_eksplisit']);
        $this->check_allowance(!isset($this->data['pengetahuan_eksplisit']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {
        	$komentar = new Komentar_eksplisit_m();
        	$komentar->id_eksplisit = $this->data['id_eksplisit'];
        	$komentar->id_pengguna = $this->data['id_pengguna'];
        	$komentar->komentar = $this->POST('komentar');
        	$komentar->save();

        	$this->flashmsg('Comment successfully added');
            redirect('kasubbid/detail_pengetahuan_eksplisit/' . $this->data['id_eksplisit']);

        }

        $this->load->helper('timeago');
        $this->data['title'] = 'Detail Pengetahuan Eksplisit';
        $this->data['content'] = 'detail_pengetahuan_eksplisit';
        $this->template($this->data, $this->module);
    }

    public function add_pengetahuan_eksplisit()
    {
        $this->load->model('Pengetahuan_eksplisit_m');
        if ($this->POST('submit'))
        {
            $pengetahuan_eksplisit = new Pengetahuan_eksplisit_m();
            $pengetahuan_eksplisit->id_kategori = $this->POST('id_kategori');
            $pengetahuan_eksplisit->id_pengguna = $this->data['id_pengguna'];
            $pengetahuan_eksplisit->judul = $this->POST('judul');
            $pengetahuan_eksplisit->keterangan = $this->POST('keterangan');
            $pengetahuan_eksplisit->referensi = $this->POST('referensi');
            $pengetahuan_eksplisit->lampiran = $_FILES['lampiran']['name'];
            $pengetahuan_eksplisit->save();

            $this->upload($_FILES['lampiran']['name'], 'assets/lampiran', 'lampiran');

            $this->flashmsg('Data successfully added');
            redirect('kasubbid/add_pengetahuan_eksplisit');
        }

        $this->load->model('Kategori_m');
        $this->data['kategori'] = Kategori_m::get();
        $this->data['title'] = 'Add Pengetahuan Eksplisit';
        $this->data['content'] = 'add_pengetahuan_eksplisit';
        $this->template($this->data, $this->module);
    }

    public function edit_pengetahuan_eksplisit()
    {
        $this->data['id_eksplisit'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_eksplisit']));

        $this->load->model('Pengetahuan_eksplisit_m');
        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::find($this->data['id_eksplisit']);
        $this->check_allowance(!isset($this->data['pengetahuan_eksplisit']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {
        	$this->upload($_FILES['lampiran']['name'], 'assets/lampiran', 'lampiran');
        	if (isset($_FILES['lampiran']) && !empty($_FILES['lampiran']['name']))
        	{
        		$this->data['pengetahuan_eksplisit']->lampiran = $_FILES['lampiran']['name'];
        	}

            $this->data['pengetahuan_eksplisit']->id_kategori = $this->POST('id_kategori');
            $this->data['pengetahuan_eksplisit']->id_pengguna = $this->POST('id_pengguna');
            $this->data['pengetahuan_eksplisit']->judul = $this->POST('judul');
            $this->data['pengetahuan_eksplisit']->keterangan = $this->POST('keterangan');
            $this->data['pengetahuan_eksplisit']->referensi = $this->POST('referensi');
            $this->data['pengetahuan_eksplisit']->save();

            $this->flashmsg('Data successfully edited');
            redirect('kasubbid/edit_pengetahuan_eksplisit/' . $this->data['id_eksplisit']);
        }

        $this->load->model('Kategori_m');
        $this->data['kategori'] = Kategori_m::get();
        $this->data['title'] = 'Edit Pengetahuan Eksplisit';
        $this->data['content'] = 'edit_pengetahuan_eksplisit';
        $this->template($this->data, $this->module);
    }

    public function bagian()
    {
        $this->data['id_bagian'] = $this->uri->segment(3);
        $this->load->model('Bagian_m');
        if (isset($this->data['id_bagian']))
        {
            $data = Bagian_m::find($this->data['id_bagian']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('kasubbid/bagian');
        }

        $this->data['bagian'] = Bagian_m::get();
        $this->data['title'] = 'Bagian';
        $this->data['content'] = 'bagian';
        $this->template($this->data, $this->module);
    }

    public function add_bagian()
    {
        $this->load->model('Bagian_m');
        if ($this->POST('submit'))
        {
            $bagian = new Bagian_m();
            $bagian->bagian = $this->POST('bagian');
            $bagian->deskripsi = $this->POST('deskripsi');
            $bagian->save();
            $this->flashmsg('Data successfully added');
            redirect('kasubbid/add_bagian');
        }

        $this->data['title'] = 'Add Bagian';
        $this->data['content'] = 'add_bagian';
        $this->template($this->data, $this->module);
    }

    public function edit_bagian()
    {
        $this->data['id_bagian'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_bagian']));

        $this->load->model('Bagian_m');
        $this->data['bagian'] = Bagian_m::find($this->data['id_bagian']);
        $this->check_allowance(!isset($this->data['bagian']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {
            $this->data['bagian']->bagian = $this->POST('bagian');
            $this->data['bagian']->deskripsi = $this->POST('deskripsi');
            $this->data['bagian']->save();
            $this->flashmsg('Data successfully edited');
            redirect('kasubbid/edit_bagian/' . $this->data['id_bagian']);
        }

        $this->data['title'] = 'Edit Bagian';
        $this->data['content'] = 'edit_bagian';
        $this->template($this->data, $this->module);
    }

    public function gejala()
    {
        $this->data['id_gejala'] = $this->uri->segment(3);
        $this->load->model('Gejala_m');
        if (isset($this->data['id_gejala']))
        {
            $data = Gejala_m::find($this->data['id_gejala']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('kasubbid/gejala');
        }

        $this->data['gejala'] = Gejala_m::get();
        $this->data['title'] = 'Gejala';
        $this->data['content'] = 'gejala';
        $this->template($this->data, $this->module);
    }

    public function add_gejala()
    {
        $this->load->model('Gejala_m');
        if ($this->POST('submit'))
        {
            $gejala = new Gejala_m();
            $gejala->gejala = $this->POST('gejala');
            $gejala->representasi = $this->POST('representasi');
            $gejala->save();
            $this->flashmsg('Data successfully added');
            redirect('kasubbid/add_gejala');
        }

        $this->data['title'] = 'Add Gejala';
        $this->data['content'] = 'add_gejala';
        $this->template($this->data, $this->module);
    }

    public function edit_gejala()
    {
        $this->data['id_gejala'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_gejala']));

        $this->load->model('Gejala_m');
        $this->data['gejala'] = Gejala_m::find($this->data['id_gejala']);
        $this->check_allowance(!isset($this->data['gejala']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {
            $this->data['gejala']->gejala = $this->POST('gejala');
            $this->data['gejala']->representasi = $this->POST('representasi');
            $this->data['gejala']->save();
            $this->flashmsg('Data successfully edited');
            redirect('kasubbid/edit_gejala/' . $this->data['id_gejala']);
        }

        $this->data['title'] = 'Edit Gejala';
        $this->data['content'] = 'edit_gejala';
        $this->template($this->data, $this->module);
    }

	public function reward()
    {
        $this->data['id_reward'] = $this->uri->segment(3);
        $this->load->model('Reward_m');
        if (isset($this->data['id_reward']))
        {
            $data = Reward_m::find($this->data['id_reward']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('kasubbid/reward');
        }

        $this->data['reward'] = Reward_m::get();
        $this->data['title'] = 'Reward';
        $this->data['content'] = 'reward';
        $this->template($this->data, $this->module);
    }

    public function detail_reward()
    {
        $this->data['id_reward'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_reward']));

        $this->load->model('Reward_m');
        $this->data['reward'] = Reward_m::with('penerima')->find($this->data['id_reward']);
        $this->check_allowance(!isset($this->data['reward']), ['Data not found', 'danger']);
        $this->data['title'] = 'Detail Reward';
        $this->data['content'] = 'detail_reward';
        $this->template($this->data, $this->module);
    }

    public function add_reward()
    {
        $this->load->model('Reward_m');
        if ($this->POST('submit'))
        {
            $reward = new Reward_m();
            $reward->reward = $this->POST('reward');
            $reward->poin = $this->POST('poin');
            $reward->keterangan = $this->POST('keterangan');
            $reward->save();
            $this->flashmsg('Data successfully added');
            redirect('kasubbid/add_reward');
        }

        $this->data['title'] = 'Add Reward';
        $this->data['content'] = 'add_reward';
        $this->template($this->data, $this->module);
    }

    public function edit_reward()
    {
        $this->data['id_reward'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_reward']));

        $this->load->model('Reward_m');
        $this->data['reward'] = Reward_m::find($this->data['id_reward']);
        $this->check_allowance(!isset($this->data['reward']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {
            $this->data['reward']->reward = $this->POST('reward');
            $this->data['reward']->poin = $this->POST('poin');
            $this->data['reward']->keterangan = $this->POST('keterangan');
            $this->data['reward']->save();
            $this->flashmsg('Data successfully edited');
            redirect('kasubbid/edit_reward/' . $this->data['id_reward']);
        }

        $this->data['title'] = 'Edit Reward';
        $this->data['content'] = 'edit_reward';
        $this->template($this->data, $this->module);
    }

	public function pengguna()
    {
        $this->data['id_pengguna'] = $this->uri->segment(3);
        $this->load->model('Pengguna_m');
        if (isset($this->data['id_pengguna']))
        {
            $data = Pengguna_m::find($this->data['id_pengguna']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('kasubbid/pengguna');
        }

        $this->data['pengguna'] = Pengguna_m::get();
        $this->data['title'] = 'Pengguna';
        $this->data['content'] = 'pengguna';
        $this->template($this->data, $this->module);
    }

    public function detail_pengguna()
    {
        $this->data['id_pengguna'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_pengguna']));

        $this->load->model('Pengguna_m');
        $this->data['pengguna'] = Pengguna_m::with(['tacit', 'eksplisit', 'tacit_tervalidasi', 'eksplisit_tervalidasi'])
        							->find($this->data['id_pengguna']);
        $this->check_allowance(!isset($this->data['pengguna']), ['Data not found', 'danger']);
        $this->data['title'] = 'Detail Pengguna';
        $this->data['content'] = 'detail_pengguna';
        $this->template($this->data, $this->module);
    }

    public function add_pengguna()
    {
        $this->load->model('Pengguna_m');
        if ($this->POST('submit'))
        {
        	$password = $this->POST('password');
        	$rpassword = $this->POST('rpassword');
        	if ($password != $rpassword)
        	{
        		$this->flashmsg('Password harus sama dengan konfirmasi password', 'warning');
        		redirect('kasubbid/add-pengguna');
        	}

            $pengguna = new Pengguna_m();
            $pengguna->nip = $this->POST('nip');
            $pengguna->id_role = $this->POST('id_role');
            $pengguna->nama = $this->POST('nama');
            $pengguna->jenis_kelamin = $this->POST('jenis_kelamin');
            $pengguna->tempat_lahir = $this->POST('tempat_lahir');
            $pengguna->tanggal_lahir = $this->POST('tanggal_lahir');
            $pengguna->password = md5($password);
            $pengguna->save();
            $this->flashmsg('Data successfully added');
            redirect('kasubbid/add_pengguna');
        }

        $this->load->model('Role_m');
        $this->data['role'] = Role_m::get();
        $this->data['title'] = 'Add Pengguna';
        $this->data['content'] = 'add_pengguna';
        $this->template($this->data, $this->module);
    }

    public function edit_pengguna()
    {
        $this->data['id_pengguna'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_pengguna']));

        $this->load->model('Pengguna_m');
        $this->data['pengguna'] = Pengguna_m::find($this->data['id_pengguna']);
        $this->check_allowance(!isset($this->data['pengguna']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {
            $this->data['pengguna']->nip = $this->POST('nip');
            $this->data['pengguna']->id_role = $this->POST('id_role');
            $this->data['pengguna']->nama = $this->POST('nama');
            $this->data['pengguna']->jenis_kelamin = $this->POST('jenis_kelamin');
            $this->data['pengguna']->tempat_lahir = $this->POST('tempat_lahir');
            $this->data['pengguna']->tanggal_lahir = $this->POST('tanggal_lahir');
            $this->data['pengguna']->save();
            $this->flashmsg('Data successfully edited');
            redirect('kasubbid/edit_pengguna/' . $this->data['id_pengguna']);
        }

        $this->load->model('Role_m');
        $this->data['role'] = Role_m::get();
        $this->data['title'] = 'Edit Pengguna';
        $this->data['content'] = 'edit_pengguna';
        $this->template($this->data, $this->module);
    }

	public function masalah()
    {
        $this->data['id_masalah'] = $this->uri->segment(3);
        $this->load->model('Masalah_m');
        if (isset($this->data['id_masalah']))
        {
            $data = Masalah_m::find($this->data['id_masalah']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('kasubbid/masalah');
        }

        $this->data['masalah'] = Masalah_m::get();
        $this->data['title'] = 'Masalah';
        $this->data['content'] = 'masalah';
        $this->template($this->data, $this->module);
    }

    public function add_masalah()
    {
        $this->load->model('Masalah_m');
        if ($this->POST('submit'))
        {
            $masalah = new Masalah_m();
            $masalah->id_bagian = $this->POST('id_bagian');
            $masalah->judul = $this->POST('judul');
            $masalah->save();

            $this->load->model('Gejala_masalah_m');
            $gejala = [];
            foreach ($this->POST('id_gejala') as $id_gejala)
            {
            	$gejala []= [
            		'id_masalah'	=> $masalah->id_masalah,
            		'id_gejala'		=> $id_gejala
            	];
            }
            Gejala_masalah_m::insert($gejala);

            $this->load->model('Solusi_m');
            $solusi = [];
            foreach ($this->POST('solusi') as $s)
            {
            	$solusi []= [
            		'id_masalah'	=> $masalah->id_masalah,
            		'solusi'		=> $s
            	];
            }
            Solusi_m::insert($solusi);

            $this->flashmsg('Data successfully added');
            redirect('kasubbid/add_masalah');
        }

        $this->load->model('Gejala_m');
        $this->data['gejala'] = Gejala_m::get();

        $this->load->model('Bagian_m');
        $this->data['bagian'] = Bagian_m::get();

        $this->data['title'] = 'Add Masalah';
        $this->data['content'] = 'add_masalah';
        $this->template($this->data, $this->module);
    }

    public function edit_masalah()
    {
        $this->data['id_masalah'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_masalah']));

        $this->load->model('Masalah_m');
        $this->data['masalah'] = Masalah_m::find($this->data['id_masalah']);
        $this->check_allowance(!isset($this->data['masalah']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {
            $this->data['masalah']->id_bagian = $this->POST('id_bagian');
            $this->data['masalah']->judul = $this->POST('judul');
            $this->data['masalah']->save();

            $this->load->model('Gejala_masalah_m');
            $gejala = [];
            foreach ($this->POST('id_gejala') as $id_gejala)
            {
            	$gejala []= [
            		'id_masalah'	=> $this->data['masalah']->id_masalah,
            		'id_gejala'		=> $id_gejala
            	];
            }
            Gejala_masalah_m::where('id_masalah', $this->data['masalah']->id_masalah)
            					->delete();
            Gejala_masalah_m::insert($gejala);

            $this->load->model('Solusi_m');
            $solusi = [];
            foreach ($this->POST('solusi') as $s)
            {
            	$solusi []= [
            		'id_masalah'	=> $this->data['masalah']->id_masalah,
            		'solusi'		=> $s
            	];
            }
            Solusi_m::where('id_masalah', $this->data['masalah']->id_masalah)
            					->delete();
            Solusi_m::insert($solusi);

            $this->flashmsg('Data successfully edited');
            redirect('kasubbid/edit_masalah/' . $this->data['id_masalah']);
        }

        $this->load->model('Gejala_m');
        $this->data['gejala'] = Gejala_m::get();

        $this->load->model('Bagian_m');
        $this->data['bagian'] = Bagian_m::get();

        $this->data['title'] = 'Edit Masalah';
        $this->data['content'] = 'edit_masalah';
        $this->template($this->data, $this->module);
    }

	public function kategori()
    {
        $this->data['id_kategori'] = $this->uri->segment(3);
        $this->load->model('Kategori_m');
        if (isset($this->data['id_kategori']))
        {
            $data = Kategori_m::find($this->data['id_kategori']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('kasubbid/kategori');
        }

        $this->data['kategori'] = Kategori_m::get();
        $this->data['title'] = 'Kategori';
        $this->data['content'] = 'kategori';
        $this->template($this->data, $this->module);
    }

    public function add_kategori()
    {
        $this->load->model('Kategori_m');
        if ($this->POST('submit'))
        {
            $kategori = new Kategori_m();
            $kategori->kategori = $this->POST('kategori');
            $kategori->save();
            $this->flashmsg('Data successfully added');
            redirect('kasubbid/add_kategori');
        }

        $this->data['title'] = 'Add Kategori';
        $this->data['content'] = 'add_kategori';
        $this->template($this->data, $this->module);
    }

    public function edit_kategori()
    {
        $this->data['id_kategori'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_kategori']));

        $this->load->model('Kategori_m');
        $this->data['kategori'] = Kategori_m::find($this->data['id_kategori']);
        $this->check_allowance(!isset($this->data['kategori']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {
            $this->data['kategori']->kategori = $this->POST('kategori');
            $this->data['kategori']->save();
            $this->flashmsg('Data successfully edited');
            redirect('kasubbid/edit-kategori/' . $this->data['id_kategori']);
        }

        $this->data['title'] = 'Edit Kategori';
        $this->data['content'] = 'edit_kategori';
        $this->template($this->data, $this->module);
    }
}