<?php

/**
 * user_survey_answer database class
 */
Class User_survey_answer extends CI_Model
{

    /**
     * insert in database
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        return $this->db->insert('user_survey_answer',$data);
    }

    /**
     * get user_survey_answer by given id
     * @param $answer_id
     * @return mixed
     */
    public function get_user_survey_answer_by_answer_id($answer_id)
    {
        $this->db->where(array('survey_answer_id'=>$answer_id));
        $query=$this->db->get('user_survey_answer');
        return $query->result_array();
    }

    /**
     * update user_survey_answer Info in database
     * @param $data
     * @return 0 OR 1
     */
    public function update($data)
    {
        $this->db->where('user_id',$data['id']);
        return $this->db->update('user_survey_answer',$data);
    }


    /**
     * delete user_survey_answer from database
     * @param $id
     * @return 0 OR 1
     */
    public function delete($id)
    {
        $this->db->where('id',$id);
        return $this->db->delete('user_survey_answer');
    }

    /**
     * Pagination in Admin site
     * @param $limit
     * @param $start
     * @return mixed
     */
    public function get_user_survey_answer_list($limit, $start)
    {
        $sql = 'select	user_id, survey_answer_id
                from user_survey_answer limit ' . $start . ', ' . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_all_user_survey_answers()
    {
        $sql = 'select  user_id, survey_answer_id
                from user_survey_answer';
        $query = $this->db->query($sql);
        return $query->result();
    }
}
?>