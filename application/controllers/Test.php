<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller
{

    public function reward()
    {
        $this->data['id_reward'] = $this->uri->segment(3);
        $this->load->model('Reward_m');
        if (isset($this->data['id_reward']))
        {
            $data = Reward_m::find($this->data['id_reward']);
            $data->delete();
            $this->flashmsg('Data successfully deleted');
            redirect('test/reward');
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
        $this->data['reward'] = Reward_m::find($this->data['id_reward']);
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
            $reward->id_reward = $this->POST('id_reward');
            $reward->id_pengguna = $this->POST('id_pengguna');
            $reward->reward = $this->POST('reward');
            $reward->poin = $this->POST('poin');
            $reward->keterangan = $this->POST('keterangan');
            $reward->created_at = $this->POST('created_at');
            $reward->updated_at = $this->POST('updated_at');
            $reward->save();
            $this->flashmsg('Data successfully added');
            redirect('test/add_reward');
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
            $this->data['reward']->id_reward = $this->POST('id_reward');
            $this->data['reward']->id_pengguna = $this->POST('id_pengguna');
            $this->data['reward']->reward = $this->POST('reward');
            $this->data['reward']->poin = $this->POST('poin');
            $this->data['reward']->keterangan = $this->POST('keterangan');
            $this->data['reward']->created_at = $this->POST('created_at');
            $this->data['reward']->updated_at = $this->POST('updated_at');
            $this->data['reward']->save();
            $this->flashmsg('Data successfully edited');
            redirect('test/edit_reward/' . $this->data['id_reward']);
        }

        $this->data['title'] = 'Edit Reward';
        $this->data['content'] = 'edit_reward';
        $this->template($this->data, $this->module);
    }

}
