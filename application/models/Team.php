<?php

/**
 * team database class
 */
Class Team extends CI_Model
{

    /**
     * insert in database
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        return $this->db->insert('team',$data);
    }

    /**
     * get new id to be inserted in database
     * @return int
     */
    public function get_new_id()
    {
        $query = "select MAX(id) as id from team";
        $res = $this->db->query($query);
        $res->result_array();
        $last_id = ($res->result()[0]->id)+1;
        return $last_id;
    }

    /**
     * get team by given id
     * @param $id
     * @return mixed
     */
    public function get_team($id)
    {

        $this->db->where('id',$id);
        $query=$this->db->get('team');
        return $query->result_array();

    }

    /**
     * update team Info in database
     * @param $data
     * @return 0 OR 1
     */
    public function update($data)
    {
        $this->db->where('id',$data['id']);
        return $this->db->update('team',$data);
    }


    /**
     * delete team from database
     * @param $id
     * @return 0 OR 1
     */
    public function delete($id)
    {
        $this->db->where('id',$id);
        return $this->db->delete('team');
    }

    /**
     * Pagination in Admin site
     * @param $limit
     * @param $start
     * @return mixed
     */
    public function get_team_list($limit, $start)
    {
        $sql = 'select id, name, flag
                from team limit ' . $start . ', ' . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_all_teams()
    {
        $sql = 'select id, name, flag
                from team';
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_team_by_user_name($name)
    {
        $this->db->where('name',$name);
        $query=$this->db->get('team');
        return $query->result_array();
    }
}
?>