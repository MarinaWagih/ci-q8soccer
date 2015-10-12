<?php

/**
 * survey database class
 */
Class Survey extends CI_Model
{

    /**
     * insert in database
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        return $this->db->insert('survey',$data);
    }

    /**
     * get new id to be inserted in database
     * @return int
     */
    public function get_new_id()
    {
        $query = "select MAX(id) as id from survey";
        $res = $this->db->query($query);
        $res->result_array();
        $last_id = ($res->result()[0]->id)+1;
        return $last_id;
    }

    /**
     * get survey by given id
     * @param $id
     * @return mixed
     */
    public function get_survey($id)
    {

        $this->db->where('id',$id);
        $query=$this->db->get('survey');
        return $query->result_array();

    }

    /**
     * update survey Info in database
     * @param $data
     * @return 0 OR 1
     */
    public function update($data)
    {
        $this->db->where('id',$data['id']);
        return $this->db->update('survey',$data);
    }


    /**
     * delete survey from database
     * @param $id
     * @return 0 OR 1
     */
    public function delete($id)
    {
        $this->db->where('id',$id);
        return $this->db->delete('survey');
    }

    /**
     * Pagination in Admin site
     * @param $limit
     * @param $start
     * @return mixed
     */
    public function get_survey_list($limit, $start)
    {
        $sql = 'select id, question, user_id,date
                from survey limit ' . $start . ', ' . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_all_surveys()
    {
        $sql = 'select id, question, user_id,date
                from survey';
        $query = $this->db->query($sql);
        return $query->result();
    }

}
?>