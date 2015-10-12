<?php

/**
 * survey_answer database class
 */
Class Survey_answer extends CI_Model
{

    /**
     * insert in database
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        return $this->db->insert('survey_answer',$data);
    }

    /**
     * get new id to be inserted in database
     * @return int
     */
    public function get_new_id()
    {
        $query = "select MAX(id) as id from survey_answer";
        $res = $this->db->query($query);
        $res->result_array();
        $last_id = ($res->result()[0]->id)+1;
        return $last_id;
    }

    /**
     * get survey_answer by given id
     * @param $id
     * @return mixed
     */
    public function get_survey_answer($id)
    {

        $this->db->where('survey_id',$id);
        $query=$this->db->get('survey_answer');
        return $query->result_array();

    }

    /**
     * update survey_answer Info in database
     * @param $data
     * @return 0 OR 1
     */
    public function update($data)
    {
        $this->db->where('id',$data['id']);
        return $this->db->update('survey_answer',$data);
    }


    /**
     * delete survey_answer from database
     * @param $id
     * @return 0 OR 1
     */
    public function delete($id)
    {
        $this->db->where('id',$id);
        return $this->db->delete('survey_answer');
    }
    public function delete_by_survey_id($id)
    {
        $this->db->where('survey_id',$id);
        return $this->db->delete('survey_answer');
    }
    /**
     * Pagination in Admin site
     * @param $limit
     * @param $start
     * @return mixed
     */
    public function get_survey_answer_list($limit, $start)
    {
        $sql = 'select id, 	survey_id, answer
                from survey_answer limit ' . $start . ', ' . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_all_survey_answers()
    {
        $sql = 'select  id,survey_id, answer
                from survey_answer';
        $query = $this->db->query($sql);
        return $query->result();
    }
}
?>