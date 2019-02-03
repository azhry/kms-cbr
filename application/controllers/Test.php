<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller
{

    public function pengetahuan_eksplisit()
    {
        $this->data['id_eksplisit'] = $this->uri->segment(3);
        $this->load->model('Pengetahuan_eksplisit_m');
        if (isset($this->data['id_eksplisit']))
        {
            $data = Pengetahuan_eksplisit_m::find($this->data['id_eksplisit']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('test/pengetahuan_eksplisit');
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
        $this->data['pengetahuan_eksplisit'] = Pengetahuan_eksplisit_m::find($this->data['id_eksplisit']);
        $this->check_allowance(!isset($pengetahuan_eksplisit), ['Data not found', 'danger']);
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
            $pengetahuan_eksplisit->id_eksplisit = $this->POST('id_eksplisit');
            $pengetahuan_eksplisit->id_kategori = $this->POST('id_kategori');
            $pengetahuan_eksplisit->id_pengguna = $this->POST('id_pengguna');
            $pengetahuan_eksplisit->judul = $this->POST('judul');
            $pengetahuan_eksplisit->keterangan = $this->POST('keterangan');
            $pengetahuan_eksplisit->referensi = $this->POST('referensi');
            $pengetahuan_eksplisit->lampiran = $this->POST('lampiran');
            $pengetahuan_eksplisit->status = $this->POST('status');
            $pengetahuan_eksplisit->created_at = $this->POST('created_at');
            $pengetahuan_eksplisit->updated_at = $this->POST('updated_at');
            $pengetahuan_eksplisit->save();
            $this->flashmsg('Data successfully added');
            redirect('test/add_pengetahuan_eksplisit');
        }

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
            $this->data['pengetahuan_eksplisit']->id_eksplisit = $this->POST('id_eksplisit');
            $this->data['pengetahuan_eksplisit']->id_kategori = $this->POST('id_kategori');
            $this->data['pengetahuan_eksplisit']->id_pengguna = $this->POST('id_pengguna');
            $this->data['pengetahuan_eksplisit']->judul = $this->POST('judul');
            $this->data['pengetahuan_eksplisit']->keterangan = $this->POST('keterangan');
            $this->data['pengetahuan_eksplisit']->referensi = $this->POST('referensi');
            $this->data['pengetahuan_eksplisit']->lampiran = $this->POST('lampiran');
            $this->data['pengetahuan_eksplisit']->status = $this->POST('status');
            $this->data['pengetahuan_eksplisit']->created_at = $this->POST('created_at');
            $this->data['pengetahuan_eksplisit']->updated_at = $this->POST('updated_at');
            $this->data['pengetahuan_eksplisit']->save();
            $this->flashmsg('Data successfully edited');
            redirect('test/edit_pengetahuan_eksplisit/' . $this->data['id_eksplisit']);
        }

        $this->data['title'] = 'Edit Pengetahuan Eksplisit';
        $this->data['content'] = 'edit_pengetahuan_eksplisit';
        $this->template($this->data, $this->module);
    }

}
