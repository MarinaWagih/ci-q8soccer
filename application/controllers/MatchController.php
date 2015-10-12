<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MatchController extends CI_Controller {


    /**
     *Call before any function to:
     * 1. Load Models Needed
     */
    protected $layout;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Match','match');
        $this->load->model('Team', 'team');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->layout='admin_layout';
    }

    /**
     *go to /q8soccer/application/config/route.php
     * you will found a line :
     *    $route['match']='matchController';
     * this means you can change how the match see urls
     * but wont know the name of the real controller
     *or the method
     * same thing for the rest of function in here
     */
    public function index()
	{
        $this->load->library('pagination');
        $url='MatchController/index';
        $total_rows=$this->db->count_all('match');
        $config['base_url'] = site_url($url);
        $config['total_rows'] =$total_rows ;
        $config['per_page'] = "10";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        //call the model function to get the department data
        $data['matches'] = $this->match->get_match_list($config["per_page"], $data['page']);
        foreach($data['matches'] as $match)
        {
            $match->team1_data=$this->team->get_team($match->team1)[0];
            $match->team2_data=$this->team->get_team($match->team2)[0];
        }
        $data['pagination'] = $this->pagination->create_links();

        $view = array('content' => 'match/all', 'data' => $data);
        $this->load->view($this->layout, $view);
	}

    /**
     * show the registration form
     * @Request GET
     * @return View
     *
     */
    public function add()
    {
        $data['team1']='';
        $data['team2']='';
        $data['date']=date('Y-m-d');
        $data['team1_score']='';
        $data['team2_score']='';
        $data['team1_result']='';
        $data['team2_result']='';
        $data['script']='match-validation.js';

        $data['teams']=$this->team->get_all_teams();
        $view = array('content' => 'match/add', 'data' => $data);
        $this->load->view($this->layout, $view);

    }

    /**
     * 1.save the match in db
     * 2.UploadImg
     * 3.send Approval email
     * @Request POST
     * @return redirect to index() here
     *
     */
    public function store()
    {
        $this->form_validation->set_rules('team1', 'Team1', 'required');
        $this->form_validation->set_rules('team2', 'Team2', 'required');
        $this->form_validation->set_rules('date', 'date', 'required');
        $id= $this->match->get_new_id();
        $data['id']=$id;
        $data['team1']=isset($_POST['team1'])?$_POST['team1']:'';
        $data['team2']=isset($_POST['team2'])?$_POST['team2']:'';
        $data['date']=isset($_POST['date'])?$_POST['date']:date('Y-m-d');
        $data['team1_score']=isset($_POST['team1_score'])?$_POST['team1_score']:'';
        $data['team2_score']=isset($_POST['team2_score'])?$_POST['team2_score']:'';
        $data['team1_result']=isset($_POST['team1_result'])?$_POST['team1_result']:'';
        $data['team2_result']=isset($_POST['team2_result'])?$_POST['team2_result']:'';
        if($this->form_validation->run() == FALSE)
        {
            $data['script']='match-validation.js';
            $data['teams']=$this->team->get_all_teams();
            $view = array('content' => 'match/add', 'data' => $data);
            $this->load->view($this->layout, $view);
        }
        else
        {
            /////////// Save in DB //////////
            $this->match->add($data);
            redirect('match', 'location');
        }

    }

    /**
     * show the edit form
     * @Request GET
     * @return View
     *
     */
    public function edit()
    {
        $id=$_GET['id'];
        $data=$this->match->get_match($id);
        $data[0]['script']='match-validation.js';
        $data[0]['teams']=$this->team->get_all_teams();
        $view = array('content' => 'match/edit', 'data' => $data[0]);
        $this->load->view($this->layout, $view);
    }

    /**
     * 1.save updated match in db
     * 2.UploadImg if new one uploaded
     * @Request POST
     * @return redirect to index() here
     *
     */
    public function update()
    {
        $this->form_validation->set_rules('team1', 'Team1', 'required');
        $this->form_validation->set_rules('team2', 'Team2', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $id=$_POST['id'];
        $data=$this->match->get_match($id);
        $data[0]['team1']=isset($_POST['team1'])?$_POST['team1']:'';
        $data[0]['team2']=isset($_POST['team2'])?$_POST['team2']:'';
        $data[0]['date']=isset($_POST['date'])?$_POST['date']:'';
        $data[0]['team1_score']=isset($_POST['team1_score'])?$_POST['team1_score']:'';
        $data[0]['team2_score']=isset($_POST['team2_score'])?$_POST['team2_score']:'';
        $data[0]['team1_result']=isset($_POST['team1_result'])?$_POST['team1_result']:'';
        $data[0]['team2_result']=isset($_POST['team2_result'])?$_POST['team2_result']:'';
        if($this->form_validation->run() == FALSE)
        {
            $data=$this->match->get_match($id);
            $data[0]['teams']=$this->team->get_all_teams();
            $data[0]['script']='match-validation.js';
            $view = array('content' => 'match/edit', 'data' => $data[0]);
            $this->load->view($this->layout, $view);
        }
        else
        {
            /////////// Save in DB //////////
            $this->match->update($data[0]);
            redirect('match', 'location');
        }

    }

    /**
     *Delete match by id
     * @Request GET
     * @return Redirect to index() here
     */
    public function delete()
    {
        $id= $_GET['id'];
        $data=$this->match->get_match($id);
        if(!empty($data[0])) {

            $data = $this->match->delete($id);
        }
       redirect('match');
    }

    /**
     * match Page
     * @Request GET
     * @return View
     */
    public function show()
    {
        $id= $_GET['id'];
        $data=$this->match->get_match($id);
        $data[0]['team1_data']=$this->team->get_team($data[0]['team1'])[0];
        $data[0]['team2_data']=$this->team->get_team($data[0]['team2'])[0];
        $view = array('content' => 'match/show', 'data' => $data[0]);
        $this->load->view($this->layout,$view);

    }

}
