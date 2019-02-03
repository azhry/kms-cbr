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
	}

	public function index()
	{

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

	public function reward()
	{
		
	}

	public function tambah_reward()
	{
		
	}

	public function pengguna()
	{
		
	}

	public function tambah_pengguna()
	{
		
	}

	public function edit_pengguna()
	{
		
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