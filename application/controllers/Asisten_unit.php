<?php 

class Asisten_unit extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'asisten_unit';
        $this->data['id_role']  = $this->session->userdata('id_role');
        if (!isset($this->data['id_role']) or $this->data['id_role'] != 5)
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
					redirect('asisten_unit/profile');
				}

				$this->data['data_pengguna']->password = md5($password);
			}

			$this->data['data_pengguna']->save();
			$this->upload($this->data['data_pengguna']->id_pengguna . '.jpg', 'assets/foto', 'foto');

			$this->flashmsg('Data successfully saved');
			redirect('asisten_unit/profile');
		}

        $this->load->model('Pengetahuan_tacit_m');
        $this->load->model('Pengetahuan_eksplisit_m');
        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::where('id_pengguna', $this->data['id_pengguna'])->get();
        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::where('id_pengguna', $this->data['id_pengguna'])->get();
		$this->data['title']	= 'Profile';
		$this->data['content']	= 'profile';
		$this->template($this->data, $this->module);
	}

	public function problem_solving()
	{
		$this->load->model('Gejala_m');
		$this->data['gejala'] 	= Gejala_m::where('status', 'Verified')
                                    ->get();

		if ($this->POST('submit'))
		{
			require_once APPPATH . 'libraries/cbr/CaseBasedReasoning.php';
			$cbr = new CaseBasedReasoning($this->data['gejala']);
			$this->load->model('Masalah_m');
			$this->data['masalah'] = Masalah_m::with('solusi')->get();
			$cbr->fit2($this->data['masalah']);
			$this->data['solusi'] = $cbr->rank($this->POST('gejala'));
		}

        if ($this->POST('request'))
        {
            $gejala = new Gejala_m();
            $gejala->gejala = $this->POST('gejala');
            $gejala->save();

            $this->flashmsg('Data gejala berhasil diminta. Gejala akan dikonfirmasi oleh pakar terlebih dahulu.');
            redirect('asisten_unit/problem-solving');
        }

        if ($this->POST('search'))
        {
            $query = $this->POST('query');
            $this->load->model('Masalah_m');
            $this->data['masalah'] = Masalah_m::with('gejala', 'gejala.gejala', 'solusi')
                                    ->get();
            $masalah = [];
            foreach ($this->data['masalah'] as $row)
            {
                foreach ($row['gejala'] as $g)
                {
                    if (strpos(strtolower($g['gejala']['gejala']), strtolower($query)) !== false) 
                    {
                        $masalah []= $row;
                        break;
                    }
                }
            }
            $this->data['masalah'] = $masalah;
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
            redirect('asisten_unit/masalah');
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
            $masalah->id_asisten_unit = $this->POST('id_asisten_unit');
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
            redirect('asisten_unit/add_masalah');
        }

        $this->load->model('Gejala_m');
        $this->data['gejala'] = Gejala_m::get();

        $this->load->model('asisten_unit_m');
        $this->data['asisten_unit'] = asisten_unit_m::get();

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
            $this->data['masalah']->id_asisten_unit = $this->POST('id_asisten_unit');
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
            redirect('asisten_unit/edit_masalah/' . $this->data['id_masalah']);
        }

        $this->load->model('Gejala_m');
        $this->data['gejala'] = Gejala_m::get();

        $this->load->model('asisten_unit_m');
        $this->data['asisten_unit'] = asisten_unit_m::get();

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
            redirect('asisten_unit/pengetahuan_tacit');
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
        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::with('komentar', 'pengguna', 'tag', 'tag.pengguna')
        									->find($this->data['id_tacit']);
        $this->check_allowance(!isset($this->data['pengetahuan_tacit']), ['Data not found', 'danger']);

        if ($this->POST('submit'))
        {
        	$komentar = new Komentar_tacit_m();
        	$komentar->id_tacit    = $this->data['id_tacit'];
        	$komentar->id_pengguna = $this->data['id_pengguna'];
        	$komentar->komentar    = $this->POST('komentar');
        	$komentar->save();

        	$this->flashmsg('Comment successfully added');
            redirect('asisten_unit/detail_pengetahuan_tacit/' . $this->data['id_tacit']);

        }

        if ($this->POST('submit_tag'))
        {
            $this->load->model('Notifikasi_m');
            Tag_tacit_m::where('id_tacit', $this->data['id_tacit'])->delete();
            $tags = explode(',', $this->POST('tags'));
            $tagData = [];
            $notifikasi = [];
            foreach ($tags as $tag)
            {
                $pengguna = Pengguna_m::where('nama', $tag)->first();
                if (isset($pengguna))
                {
                    $tagData []= [
                        'id_tacit'      => $this->data['id_tacit'],
                        'id_pengguna'   => $pengguna->id_pengguna
                    ];

                    $notifikasi []= [
                        'id_pengguna'       => $pengguna->id_pengguna,
                        'id_pengetahuan'    => $this->data['id_tacit'],
                        'jenis'             => 'Tag Tacit',
                        'deskripsi'         => ''
                    ];
                }
            }
            Tag_tacit_m::insert($tagData);
            Notifikasi_m::insert($notifikasi);
            $this->flashmsg('Data tag berhasil ditambah');
            redirect('asisten_unit/detail_pengetahuan_tacit/' . $this->data['id_tacit']);
        }

        $this->load->helper('timeago');
        $this->data['pengguna'] = Pengguna_m::get();
        $this->data['title']    = 'Detail Pengetahuan Tacit';
        $this->data['content']  = 'detail_pengetahuan_tacit';
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
            redirect('asisten_unit/add_pengetahuan_tacit');
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
            redirect('asisten_unit/edit_pengetahuan_tacit/' . $this->data['id_tacit']);
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
            redirect('asisten_unit/pengetahuan_eksplisit');
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
        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::with('komentar', 'pengguna', 'tag', 'tag.pengguna')
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
            redirect('asisten_unit/detail-pengetahuan-eksplisit/' . $this->data['id_eksplisit']);
        }

        if ($this->POST('submit_tag'))
        {
            $this->load->model('Notifikasi_m');
            Tag_eksplisit_m::where('id_eksplisit', $this->data['id_eksplisit'])->delete();
            $tags = explode(',', $this->POST('tags'));
            $tagData = [];
            $notifikasi = [];
            foreach ($tags as $tag)
            {
                $pengguna = Pengguna_m::where('nama', $tag)->first();
                if (isset($pengguna))
                {
                    $tagData []= [
                        'id_eksplisit'      => $this->data['id_eksplisit'],
                        'id_pengguna'   => $pengguna->id_pengguna
                    ];

                    $notifikasi []= [
                        'id_pengguna'       => $pengguna->id_pengguna,
                        'id_pengetahuan'    => $this->data['id_eksplisit'],
                        'jenis'             => 'Tag Eksplisit',
                        'deskripsi'         => ''
                    ];
                }
            }
            Tag_eksplisit_m::insert($tagData);
            Notifikasi_m::insert($notifikasi);
            $this->flashmsg('Data tag berhasil ditambah');
            redirect('asisten_unit/detail-pengetahuan-eksplisit/' . $this->data['id_eksplisit']);
        }

        $this->load->helper('timeago');
        $this->data['pengguna'] = Pengguna_m::get();
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
            redirect('asisten_unit/add_pengetahuan_eksplisit');
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
            redirect('asisten_unit/edit_pengetahuan_eksplisit/' . $this->data['id_eksplisit']);
        }

        $this->load->model('Kategori_m');
        $this->data['kategori'] = Kategori_m::get();
        $this->data['title'] = 'Edit Pengetahuan Eksplisit';
        $this->data['content'] = 'edit_pengetahuan_eksplisit';
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

    public function claim_reward()
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
            redirect('asisten_unit/claim_reward');
        }

        $this->data['reward'] = Reward_m::get();
        $this->data['title'] = 'Claim Reward';
        $this->data['content'] = 'claim_reward';
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
            redirect('asisten-unit/reward');
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
            redirect('asisten-unit/add_reward');
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
            redirect('asisten-unit/edit_reward/' . $this->data['id_reward']);
        }

        $this->data['title'] = 'Edit Reward';
        $this->data['content'] = 'edit_reward';
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
                    'solusi'        => $s,
                    'status'        => 'Pending'
                ];
            }
            Solusi_m::where('id_masalah', $this->data['masalah']->id_masalah)
                                ->delete();
            Solusi_m::insert($solusi);

            $this->flashmsg('Data successfully edited');
            redirect('asisten_unit/ubah-solusi/' . $this->data['id_masalah']);
        }

        $this->data['title']    = 'Ubah Solusi';
        $this->data['content']  = 'ubah_solusi';
        $this->template($this->data, $this->module);
    }

    public function like_tacit()
    {
        $this->load->model('Pengetahuan_tacit_m');
        $this->data['pengetahuan_tacit'] = Pengetahuan_tacit_m::with(['like' => function($query) {
                                                $query->where('id_pengguna', $this->data['id_pengguna']);
                                            }])
                                            ->where('status', 'Valid')
                                            ->get();
        $this->data['title'] = 'Pengetahuan Tacit Yg Disukai';
        $this->data['content'] = 'like_tacit';
        $this->template($this->data, $this->module);
    }

    public function like_eksplisit()
    {
        $this->load->model('Pengetahuan_eksplisit_m');
        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::with(['like' => function($query) {
                                                $query->where('id_pengguna', $this->data['id_pengguna']);
                                            }])
                                            ->where('status', 'Valid')
                                            ->get();
        $this->data['title'] = 'Pengetahuan Eksplisit Yg Disukai';
        $this->data['content'] = 'like_eksplisit';
        $this->template($this->data, $this->module);
    }
}