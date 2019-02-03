<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller
{

    public function bagian()
    {
        $this->data['id_bagian'] = $this->uri->segment(3);
        $this->load->model('Bagian_m');
        if (isset($this->data['id_bagian']))
        {
            $data = Bagian_m::find($this->data['id_bagian']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('test/bagian');
        }

        $this->data['bagian'] = Bagian_m::get();
        $this->data['title'] = 'Bagian';
        $this->data['content'] = 'bagian';
        $this->template($this->data, $this->module);
    }

    public function detail_bagian()
    {
        $this->data['id_bagian'] = $this->uri->segment(3);
        $this->check_allowance(!isset($this->data['id_bagian']));

        $this->load->model('Bagian_m');
        $this->data['bagian'] = Bagian_m::find($this->data['id_bagian']);
        $this->check_allowance(!isset($this->data['bagian']), ['Data not found', 'danger']);
        $this->data['title'] = 'Detail Bagian';
        $this->data['content'] = 'detail_bagian';
        $this->template($this->data, $this->module);
    }

    public function add_bagian()
    {
        $this->load->model('Bagian_m');
        if ($this->POST('submit'))
        {
            $bagian = new Bagian_m();
            $bagian->id_bagian = $this->POST('id_bagian');
            $bagian->bagian = $this->POST('bagian');
            $bagian->deskripsi = $this->POST('deskripsi');
            $bagian->created_at = $this->POST('created_at');
            $bagian->updated_at = $this->POST('updated_at');
            $bagian->save();
            $this->flashmsg('Data successfully added');
            redirect('test/add_bagian');
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
            $this->data['bagian']->id_bagian = $this->POST('id_bagian');
            $this->data['bagian']->bagian = $this->POST('bagian');
            $this->data['bagian']->deskripsi = $this->POST('deskripsi');
            $this->data['bagian']->created_at = $this->POST('created_at');
            $this->data['bagian']->updated_at = $this->POST('updated_at');
            $this->data['bagian']->save();
            $this->flashmsg('Data successfully edited');
            redirect('test/edit_bagian/' . $this->data['id_bagian']);
        }

        $this->data['title'] = 'Edit Bagian';
        $this->data['content'] = 'edit_bagian';
        $this->template($this->data, $this->module);
    }

}
