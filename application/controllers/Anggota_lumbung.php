<?php 

class Anggota_lumbung extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'anggota_lumbung';
        $this->data['id_role']  = $this->session->userdata('id_role');
        if (!isset($this->data['id_role']) or $this->data['id_role'] != 3)
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
		$this->load->model('Pengetahuan_tacit_m');
		$this->load->model('Pengetahuan_eksplisit_m');
		$this->data['pengetahuan_tacit']		= Pengetahuan_tacit_m::where('id_pengguna', $this->data['id_pengguna'])->get();
		$this->data['pengetahuan_eksplisit']	= Pengetahuan_eksplisit_m::where('id_pengguna', $this->data['id_pengguna'])->get();
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
					redirect('anggota-lumbung/profile');
				}

				$this->data['data_pengguna']->password = md5($password);
			}

			$this->data['data_pengguna']->save();
			$this->upload($this->data['data_pengguna']->id_pengguna . '.jpg', 'assets/foto', 'foto');

			$this->flashmsg('Data successfully saved');
			redirect('anggota-lumbung/profile');
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

	public function masalah()
    {
        $this->data['id_masalah'] = $this->uri->segment(3);
        $this->load->model('Masalah_m');
        if (isset($this->data['id_masalah']))
        {
            $data = Masalah_m::find($this->data['id_masalah']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('anggota-lumbung/masalah');
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
            redirect('anggota-lumbung/add_masalah');
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
            redirect('anggota-lumbung/edit_masalah/' . $this->data['id_masalah']);
        }

        $this->load->model('Gejala_m');
        $this->data['gejala'] = Gejala_m::get();

        $this->load->model('Bagian_m');
        $this->data['bagian'] = Bagian_m::get();

        $this->data['title'] = 'Edit Masalah';
        $this->data['content'] = 'edit_masalah';
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
            redirect('anggota-lumbung/pengetahuan_tacit');
        }

        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::where('id_pengguna', $this->data['id_pengguna'])->get();
        $this->data['title'] = 'Pengetahuan Tacit';
        $this->data['content'] = 'pengetahuan_tacit';
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
            redirect('anggota-lumbung/detail_pengetahuan_tacit/' . $this->data['id_tacit']);

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
            redirect('anggota-lumbung/add_pengetahuan_tacit');
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
            redirect('anggota-lumbung/edit_pengetahuan_tacit/' . $this->data['id_tacit']);
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
            redirect('anggota-lumbung/pengetahuan_eksplisit');
        }

        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::where('id_pengguna', $this->data['id_pengguna'])->get();
        $this->data['title'] = 'Pengetahuan Eksplisit';
        $this->data['content'] = 'pengetahuan_eksplisit';
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
            redirect('anggota-lumbung/detail_pengetahuan_eksplisit/' . $this->data['id_eksplisit']);

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
            redirect('anggota-lumbung/add_pengetahuan_eksplisit');
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
            redirect('anggota-lumbung/edit_pengetahuan_eksplisit/' . $this->data['id_eksplisit']);
        }

        $this->load->model('Kategori_m');
        $this->data['kategori'] = Kategori_m::get();
        $this->data['title'] = 'Edit Pengetahuan Eksplisit';
        $this->data['content'] = 'edit_pengetahuan_eksplisit';
        $this->template($this->data, $this->module);
    }

    public function share_tacit()
    {
        $this->load->model('Pengetahuan_tacit_m');
        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::where('status', 'Valid')->get();
        $this->data['title'] = 'Pengetahuan Tacit';
        $this->data['content'] = 'share_tacit';
        $this->template($this->data, $this->module);
    }

    public function share_eksplisit()
    {
        $this->load->model('Pengetahuan_eksplisit_m');
        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::where('status', 'Valid')->get();
        $this->data['title'] = 'Pengetahuan Eksplisit';
        $this->data['content'] = 'share_eksplisit';
        $this->template($this->data, $this->module);
    }

    public function reward()
    {
        $this->data['id_reward'] = $this->uri->segment(3);
        $this->load->model('Reward_m');
        if (isset($this->data['id_reward']))
        {
            $reward = Reward_m::find($this->data['id_reward']);
            if ($this->data['data_pengguna']->poin >= $reward->poin)
            {
            	$this->data['data_pengguna']->poin -= $reward->poin;
            	$this->data['data_pengguna']->save();

            	$this->load->model('Penerima_reward_m');
            	$data = new Penerima_reward_m();
            	$data->id_reward = $reward->id_reward;
            	$data->id_pengguna = $this->data['data_pengguna']->id_pengguna;
            	$data->save();

            	$this->flashmsg('Reward berhasil diambil');
            }
            else
            {
            	$this->flashmsg('Reward gagal diambil. Poin anda kurang.', 'danger');
            }
            redirect('anggota-lumbung/reward');
        }

        $this->data['reward'] = Reward_m::get();
        $this->data['title'] = 'Reward';
        $this->data['content'] = 'reward';
        $this->template($this->data, $this->module);
    }
}