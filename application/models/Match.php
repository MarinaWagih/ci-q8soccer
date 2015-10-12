<?php

/**
 * match database class
 */
Class Match extends CI_Model
{

    /**
     * insert in database
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        return $this->db->insert('match',$data);
    }

    /**
     * get new id to be inserted in database
     * @return int
     */
    public function get_new_id()
    {
        $query = 'MAX(id) as id';
        $this->db->select($query);
        $res=$this->db->get('match');
        $res->result_array();
        $last_id = ($res->result()[0]->id)+1;
        return $last_id;
    }

    /**
     * get match by given id
     * @param $id
     * @return mixed
     */
    public function get_match($id)
    {

        $this->db->where('id',$id);
        $query=$this->db->get('match');
        return $query->result_array();

    }

    /**
     * update match Info in database
     * @param $data
     * @return 0 OR 1
     */
    public function update($data)
    {
        $this->db->where('id',$data['id']);
        return $this->db->update('match',$data);
    }


    /**
     * delete match from database
     * @param $id
     * @return 0 OR 1
     */
    public function delete($id)
    {
        $this->db->where('id',$id);
        return $this->db->delete('match');
    }

    /**
     * Pagination in Admin site
     * @param $limit
     * @param $start
     * @return mixed
     */
    public function get_match_list($limit, $start)
    {
        $sql = 'id, team1, team2, date, team1_score, team2_score,
                team1_result,team2_result';
        $query = $this->db->select($sql);
        $query= $this->db->limit($limit,$start);
        $query=$this->db->get('match');
        return $query->result();
    }

}
?>