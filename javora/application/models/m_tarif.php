<?php
class m_tarif extends CI_Model
{
    function get()
    {
        $this->db->select('*');
        $query = $this->db->get('tbl_tarif');
        $data = $query->result_object();
        $query->free_result();
        return $data;
    }
    function getFilter()
    {
        $asal = '5103050009';
        $tujuan = $this->input->get('tujuan');
        $this->db->select('*');
        $this->db->where('asal', $asal);
        $this->db->where('tujuan', $tujuan);
        $query = $this->db->get('tbl_tarif');
        $data = $query->result_object();
        $query->free_result();
        return $data;
    }
    function getInfo()
    {
        $this->db->select('id,date_created,content');
        $this->db->where('type', 2);
        $query = $this->db->get('news_info');
        $data = $query->result_object();
        $query->free_result();
        return $data;
    }

    function getAll()
    {
        $this->db->select('id,date_created,author,title,content');
        $query = $this->db->get('news_info');
        $data = $query->result_object();
        $query->free_result();
        return $data;
    }

    function insert()
    {
        $title = $this->input->post('title');
        $content = $this->input->post('content');
        $type = $this->input->post('type');
        if ($type == 1) {
            $data = array(
                'author' => $_SESSION['username'],
                'title' => $title,
                'content' => $content,
                'type' => $type,
                'date_created' => date("Y-m-d")
            );
        } else {
            $data = array(
                'content' => $content,
                'type' => $type,
                'date_created' => date("Y-m-d")
            );
        }

        if ($this->db->insert('news_info', $data)) {
            return true;
        } else {
            return false;
        }
    }

    function update()
    {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $content = $this->input->post('content');
        $type = $this->input->post('type');
        if ($type == 1) {
            $data = array(
                'author' => $_SESSION['username'],
                'title' => $title,
                'content' => $content,
                'type' => $type,
                'date_created' => date("Y-m-d")
            );
        } else {
            $data = array(
                'content' => $content,
                'type' => $type,
                'date_created' => date("Y-m-d")
            );
        }
        $this->db->where('id', $id);
        if ($this->db->update('news_info', $data)) {
            return true;
        } else {
            return false;
        }
    }

    function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        if ($this->db->delete('news_info')) {
            return true;
        } else {
            return false;
        }
    }

    function count()
    {
        return $this->db->count_all_results('news_info');
    }
}
