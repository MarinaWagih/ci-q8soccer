<?php

/**
 * prediction database class
 */
Class prediction extends CI_Model
{

    /**
     * insert in database
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        return $this->db->insert('prediction',$data);
    }

    /**
     * get new id to be inserted in database
     * @return int
     */
    public function get_new_id()
    {
        $query = "select MAX(id) as id from prediction";
        $res = $this->db->query($query);
        $res->result_array();
        $last_id = ($res->result()[0]->id)+1;
        return $last_id;
    }

    /**
     * get prediction by given id
     * @param $id
     * @return mixed
     */
    public function get_prediction($id)
    {

        $this->db->where('id',$id);
        $query=$this->db->get('prediction');
        return $query->result_array();

    }

    /**
     * update prediction Info in database
     * @param $data
     * @return 0 OR 1
     */
    public function update($data)
    {
        $this->db->where('id',$data['id']);
        return $this->db->update('prediction',$data);
    }


    /**
     * delete prediction from database
     * @param $id
     * @return 0 OR 1
     */
    public function delete($id)
    {
        $this->db->where('id',$id);
        return $this->db->delete('prediction');
    }

    /**
     * Pagination in Admin site
     * @param $limit
     * @param $start
     * @return mixed
     */
    public function get_prediction_list($limit, $start)
    {
        $sql = 'select id ,  user_id ,  match_id ,
                       team1_score ,  team2_score ,  team1_result ,
                       team2_result ,  date
                from prediction limit ' . $start . ', ' . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_prediction_by_user_id_and_match_id($match_id,$user_id)
    {
        $this->db->where(array('match_id'=>$match_id,'user_id'=>$user_id));
        $query=$this->db->get('prediction');
        return $query->result_array();
    }
}
?>