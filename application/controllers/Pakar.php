<?php 

class Pakar extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'pakar';
        $this->data['id_role']  = $this->session->userdata('id_role');
        if (!isset($this->data['id_role']) or $this->data['id_role'] != 2)
        {
          $this->session->sess_destroy();
          redirect('login');
        }
        $this->data['id_pengguna']  = $this->session->userdata('id_pengguna');
        $this->data['nip']          = $this->session->userdata('nip');
        $this->load->model('Pengguna_m');
		$this->data['data_pengguna']	= Pengguna_m::find($this->data['id_pengguna']);

        $this->load->model('Notifikasi_m');
        $this->data['notifikasi']   = Notifikasi_m::orderBy('created_at', 'DESC')
                                        ->where('id_pengguna', $this->data['id_pengguna'])
                                        ->get();
        $this->data['u_notifikasi'] = Notifikasi_m::where('dilihat', 0)
                                        ->where('id_pengguna', $this->data['id_pengguna'])
                                        ->get();
        Notifikasi_m::where('id_pengguna', $this->data['id_pengguna'])->update(['dilihat' => 1]);
        $this->load->helper('timeago');
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
					redirect('pakar/profile');
				}

				$this->data['data_pengguna']->password = md5($password);
			}

			$this->data['data_pengguna']->save();
			$this->upload($this->data['data_pengguna']->id_pengguna . '.jpg', 'assets/foto', 'foto');

			$this->flashmsg('Data successfully saved');
			redirect('pakar/profile');
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

	public function gejala()
    {
        $this->data['id_gejala'] = $this->uri->segment(3);
        $this->load->model('Gejala_m');
        if (isset($this->data['id_gejala']))
        {
            $data = Gejala_m::find($this->data['id_gejala']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('pakar/gejala');
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
            $gejala->status = 'Verified';
            $gejala->save();
            $this->flashmsg('Data successfully added');
            redirect('pakar/add_gejala');
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
            $this->data['gejala']->status = $this->POST('status');
            $this->data['gejala']->save();
            $this->flashmsg('Data successfully edited');
            redirect('pakar/edit_gejala/' . $this->data['id_gejala']);
        }

        $this->data['title'] = 'Edit Gejala';
        $this->data['content'] = 'edit_gejala';
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
            redirect('pakar/masalah');
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
            redirect('pakar/add_masalah');
        }

        $this->load->model('Gejala_m');
        $this->data['gejala'] = Gejala_m::get();

        $this->load->model('Unit_m');
        $this->data['unit'] = Unit_m::get();

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
            $this->data['masalah']->id_unit = $this->POST('id_unit');
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
            redirect('pakar/edit_masalah/' . $this->data['id_masalah']);
        }

        $this->load->model('Gejala_m');
        $this->data['gejala'] = Gejala_m::get();

        $this->load->model('Unit_m');
        $this->data['unit'] = Unit_m::get();

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
            redirect('pakar/pengetahuan_tacit');
        }

        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::with('like', 'komentar')
                                            ->where('id_pengguna', $this->data['id_pengguna'])
                                            ->get();
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
            redirect('pakar/detail_pengetahuan_tacit/' . $this->data['id_tacit']);

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
            redirect('pakar/add_pengetahuan_tacit');
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
            redirect('pakar/edit_pengetahuan_tacit/' . $this->data['id_tacit']);
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
            redirect('pakar/pengetahuan_eksplisit');
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
            redirect('pakar/detail_pengetahuan_eksplisit/' . $this->data['id_eksplisit']);

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
            redirect('pakar/add_pengetahuan_eksplisit');
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
            redirect('pakar/edit_pengetahuan_eksplisit/' . $this->data['id_eksplisit']);
        }

        $this->load->model('Kategori_m');
        $this->data['kategori'] = Kategori_m::get();
        $this->data['title'] = 'Edit Pengetahuan Eksplisit';
        $this->data['content'] = 'edit_pengetahuan_eksplisit';
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

            $pengguna = Pengguna_m::find($data->id_pengguna);
            switch ($data->status)
            {
                case 'Valid':
                    $pengguna->poin += 25;
                    $this->load->model('Notifikasi_m');
                    $notifikasi = new Notifikasi_m();
                    $notifikasi->id_pengguna    = $data->id_pengguna;
                    $notifikasi->id_pengetahuan = $this->POST('id');
                    $notifikasi->jenis          = 'Tacit';
                    $notifikasi->deskripsi      = '';
                    $notifikasi->save();
                    break;

                case 'Pending':
                    $pengguna->poin -= 25;
                    break;
            }
            $pengguna->save();

            echo json_encode(['status' => $data->status]);
            exit;
        }
        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::get();
        $this->data['title'] = 'Validasi Tacit';
        $this->data['content'] = 'validasi_tacit';
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

            $pengguna = Pengguna_m::find($data->id_pengguna);
            switch ($data->status)
            {
                case 'Valid':
                    $pengguna->poin += 25;
                    $this->load->model('Notifikasi_m');
                    $notifikasi = new Notifikasi_m();
                    $notifikasi->id_pengguna    = $data->id_pengguna;
                    $notifikasi->id_pengetahuan = $this->POST('id');
                    $notifikasi->jenis          = 'Eksplisit';
                    $notifikasi->deskripsi      = '';
                    $notifikasi->save();
                    break;

                case 'Pending':
                    $pengguna->poin -= 25;
                    break;
            }
            $pengguna->save();

            echo json_encode(['status' => $data->status]);
            exit;
        }
        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::get();
        $this->data['title'] = 'Pengetahuan Eksplisit';
        $this->data['content'] = 'validasi_eksplisit';
        $this->template($this->data, $this->module);
    }

    public function share_tacit()
    {
        if ($this->POST('like'))
        {
            $this->load->model('Like_tacit_m');
            $like = Like_tacit_m::where('id_tacit', $this->POST('id_tacit'))
                    ->where('id_pengguna', $this->data['id_pengguna'])
                    ->first();

            if (isset($like))
            {
                $like->delete();
                $data = ['response' => 'unlike'];
            }
            else
            {
                $like = new Like_tacit_m();
                $like->id_tacit     = $this->POST('id_tacit');
                $like->id_pengguna  = $this->data['id_pengguna'];
                $like->save();
                $data = ['response' => 'like'];
            }

            echo json_encode($data);
            exit;
        }

        $this->load->model('Pengetahuan_tacit_m');
        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::with('like', 'komentar')
                                            ->where('status', 'Valid')
                                            ->get();
        $this->data['title'] = 'Pengetahuan Tacit';
        $this->data['content'] = 'share_tacit';
        $this->template($this->data, $this->module);
    }

    public function share_eksplisit()
    {
        if ($this->POST('like'))
        {
            $this->load->model('Like_eksplisit_m');
            $like = Like_eksplisit_m::where('id_eksplisit', $this->POST('id_eksplisit'))
                    ->where('id_pengguna', $this->data['id_pengguna'])
                    ->first();
                    
            if (isset($like))
            {
                $like->delete();
                $data = ['response' => 'unlike'];
            }
            else
            {
                $like = new Like_eksplisit_m();
                $like->id_eksplisit = $this->POST('id_eksplisit');
                $like->id_pengguna  = $this->data['id_pengguna'];
                $like->save();
                $data = ['response' => 'like'];
            }

            echo json_encode($data);
            exit;
        }

        $this->load->model('Pengetahuan_eksplisit_m');
        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::with('like', 'komentar')
                                            ->where('status', 'Valid')
                                            ->get();
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
            redirect('pakar/reward');
        }

        $this->data['reward'] = Reward_m::get();
        $this->data['title'] = 'Reward';
        $this->data['content'] = 'reward';
        $this->template($this->data, $this->module);
    }

    public function my_reward()
    {
        $this->load->model('Penerima_reward_m');
        $this->data['reward'] = Penerima_reward_m::with('reward')
                                ->where('id_pengguna', $this->data['id_pengguna'])
                                ->get();
        $this->data['title'] = 'My Reward';
        $this->data['content'] = 'my_reward';
        $this->template($this->data, $this->module);
    }

    public function data_revise()
    {
        $this->load->model('Masalah_m');

        $this->data['masalah'] = Masalah_m::get();
        $this->data['title'] = 'Data Revise';
        $this->data['content'] = 'data_revise';
        $this->template($this->data, $this->module);
    }

    public function ubah_solusi()
    {
        $this->data['id_masalah'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_masalah']));

        $this->load->model('Masalah_m');
        $this->data['masalah'] = Masalah_m::find($this->data['id_masalah']);
        $this->check_allowance(!isset($this->data['masalah']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {

            $this->load->model('Solusi_m');
            $solusi = [];
            foreach ($this->POST('solusi') as $s)
            {
                $solusi []= [
                    'id_masalah'    => $this->data['masalah']->id_masalah,
                    'solusi'        => $s
                ];
            }
            Solusi_m::where('id_masalah', $this->data['masalah']->id_masalah)
                                ->delete();
            Solusi_m::insert($solusi);

            $this->flashmsg('Data successfully edited');
            redirect('pakar/ubah-solusi/' . $this->data['id_masalah']);
        }

        $this->data['title']    = 'Ubah Solusi';
        $this->data['content']  = 'ubah_solusi';
        $this->template($this->data, $this->module);
    }

    public function cari_pengetahuan()
    {
        $this->data['search']   = $this->POST('search');
        if (!isset($this->data['search']) or empty($this->data['search']))
        {
            $this->flashmsg('Anda harus memasukkan kata kunci pencarian', 'warning');
            redirect('pakar');
        }

        $this->data['query']    = $this->POST('query');
        $this->load->model('Pengetahuan_tacit_m');
        $this->load->model('Pengetahuan_eksplisit_m');

        $this->data['pengetahuan_tacit']        = Pengetahuan_tacit_m::
                                                    where('judul', 'like', '%' . $this->data['query'] . '%')
                                                    ->orWhere('isi', 'like', '%' . $this->data['query'] . '%')
                                                    ->get();
        $this->data['pengetahuan_eksplisit']    = Pengetahuan_eksplisit_m::
                                                    where('judul', 'like', '%' . $this->data['query'] . '%')
                                                    ->orWhere('keterangan', 'like', '%' . $this->data['query'] . '%')
                                                    ->orWhere('referensi', 'like', '%' . $this->data['query'] . '%')
                                                    ->get();
        $this->data['title']    = 'Cari Pengetahuan';
        $this->data['content']  = 'cari_pengetahuan';
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
            redirect('pakar/pengguna');
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
                redirect('pakar/add-pengguna');
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
            redirect('pakar/add_pengguna');
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
            redirect('pakar/edit_pengguna/' . $this->data['id_pengguna']);
        }

        $this->load->model('Role_m');
        $this->data['role'] = Role_m::get();
        $this->data['title'] = 'Edit Pengguna';
        $this->data['content'] = 'edit_pengguna';
        $this->template($this->data, $this->module);
    }
}