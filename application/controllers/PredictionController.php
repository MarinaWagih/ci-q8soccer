<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PredictionController extends CI_Controller
{


    /**
     *Call before any function to:
     * 1. Load Models Needed
     */
    protected $layout;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Prediction', 'prediction');
        $this->load->model('Match','match');
        $this->load->model('Team', 'team');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->layout = 'admin_layout';
    }

    /**
     *go to /q8soccer/application/config/route.php
     * you will found a line :
     *    $route['prediction']='PredictionController';
     * this means you can change how the prediction see urls
     * but wont know the name of the real controller
     *or the method
     * same thing for the rest of function in here
     */
    public function index()
    {
        $this->load->library('pagination');
        $url = 'PredictionController/index';
        $total_rows = $this->db->count_all('prediction');
        $config['base_url'] = site_url($url);
        $config['total_rows'] = $total_rows;
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
        $data['predictions'] = $this->prediction->get_prediction_list($config["per_page"], $data['page']);
        foreach($data['predictions'] as $prediction)
        {
            $prediction->match= $this->match->get_match($prediction->match_id)[0];
            $prediction->team1_data=$this->team->get_team($prediction->match['team1'])[0];
            $prediction->team2_data=$this->team->get_team($prediction->match['team2'])[0];

        }
        $data['pagination'] = $this->pagination->create_links();

        $view = array('content' => 'prediction/all', 'data' => $data);
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

        $match_id=$_GET['id'];
        $data['user_id'] = '1';
        $data['match_id'] = $match_id;
        $data['team1_score'] = '';
        $data['team2_score'] = '';
        $data['team1_result'] = '';
        $data['team2_result'] = '';
        $data['match_data']= $this->match->get_match($match_id)[0];
        $data['team1_data']=$this->team->get_team($data['match_data']['team1'])[0];
        $data['team2_data']=$this->team->get_team($data['match_data']['team2'])[0];
//        $data['date']=date('Y-m-d');
        $data['script']='prediction-validation.js';
//        var_dump($data);
//        exit;
        $view = array('content' => 'prediction/add', 'data' => $data);
        $this->load->view($this->layout, $view);

    }

    /**
     * 1.save the prediction in db
     * 2.UploadImg
     * 3.send Approval email
     * @Request POST
     * @return redirect to index() here
     *
     */
    public function store()
    {

        $this->form_validation->set_rules('team1_score', 'team1_score', 'required');
        $this->form_validation->set_rules('team2_score', 'team2_score', 'required');
        $this->form_validation->set_rules('match_id', 'match_id', 'required');
        $id = $this->prediction->get_new_id();
        $data['id'] = $id;
        $data['user_id'] = '1';
        $data['date']=date('Y-m-d');
        $match_id=$_POST['match_id'];
        $data['match_id'] = isset($_POST['match_id']) ? $_POST['match_id'] : '';
        $data['team1_score'] = isset($_POST['team1_score']) ? $_POST['team1_score'] : '';
        $data['team2_score'] = isset($_POST['team2_score']) ? $_POST['team2_score'] : '';
        $data['team1_result'] = isset($_POST['team1_result']) ? $_POST['team1_result'] : 'tie';
        $data['team2_result'] = isset($_POST['team2_result']) ? $_POST['team2_result'] : 'tie';
        if ($this->form_validation->run() == FALSE) {

            $data['match']= $this->match->get_match($match_id)[0];
            $data['team1_data']=$this->team->get_team($data['match']['team1'])[0];
            $data['team2_data']=$this->team->get_team($data['match']['team2'])[0];

            $data['script']='prediction-validation.js';
            $view = array('content' => 'prediction/add', 'data' => $data);
            $this->load->view($this->layout, $view);
        } else {

            /////////// Save in DB //////////
            $this->prediction->add($data);
            redirect('prediction', 'location');
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
        $id = $_GET['id'];
        $data = $this->prediction->get_prediction($id)[0];
        $data['match']= $this->match->get_match($data['match_id'])[0];
        $data['team1_data']=$this->team->get_team($data['match']['team1'])[0];
        $data['team2_data']=$this->team->get_team($data['match']['team2'])[0];

        $view = array('content' => 'prediction/edit', 'data' => $data);
        $this->load->view($this->layout, $view);
    }

    /**
     * 1.save updated prediction in db
     * 2.UploadImg if new one uploaded
     * @Request POST
     * @return redirect to index() here
     *
     */
    public function update()
    {
        $this->form_validation->set_rules('team1_score', 'team1_score', 'required');
        $this->form_validation->set_rules('team2_score', 'team2_score', 'required');
        $this->form_validation->set_rules('match_id', 'match_id', 'required');

        $id = $_POST['id'];
        $data = $this->prediction->get_prediction($id);
        $data[0]['date']=date('Y-m-d');
        $data[0]['user_id'] = '1';
        $data[0]['match_id'] = isset($_POST['match_id']) ? $_POST['match_id'] : '';
        $data[0]['team1_score'] = isset($_POST['team1_score']) ? $_POST['team1_score'] : '';
        $data[0]['team2_score'] = isset($_POST['team2_score']) ? $_POST['team2_score'] : '';
        $data[0]['team1_result'] = isset($_POST['team1_result']) ? $_POST['team1_result'] : 'tie';
        $data[0]['team2_result'] = isset($_POST['team2_result']) ? $_POST['team2_result'] : 'tie';


        if ($this->form_validation->run() == FALSE) {
            $data[0]['match']= $this->match->get_match($data[0]['match_id'])[0];
            $data[0]['team1_data']=$this->team->get_team($data[0]['match']['team1'])[0];
            $data[0]['team2_data']=$this->team->get_team($data[0]['match']['team2'])[0];
            $view = array('content' => 'prediction/edit', 'data' => $data[0]);
            $this->load->view($this->layout, $view);
        } else {

            /////////// Save in DB //////////
            $this->prediction->update($data[0]);
            redirect('prediction', 'location');
        }
    }

    /**
     *Delete prediction by id
     * @Request GET
     * @return redirect to index() here
     */
    public function delete()
    {
        $id = $_GET['id'];
        $data = $this->prediction->get_prediction($id);
        if (!empty($data[0])) {

            $data = $this->prediction->delete($id);
        }
        redirect('prediction');
    }

    /**
     * prediction Page
     * @Request GET
     * @return View
     */
    public function show()
    {
        $id = $_GET['id'];
        $data = $this->prediction->get_prediction($id);
        $view = array('content' => 'prediction/show', 'data' => $data[0]);
        $this->load->view($this->layout, $view);

    }

    /**
     *UI validation to check that the prediction Name is unique
     */
    public function is_prediction_valid()
    {
        //get_prediction_by_user_name($name)
        $name=$_GET['match_id'];
        $user_id='';
        $data=$this->prediction->get_prediction_by_user_id_and_match_id($name,$user_id);
        if(empty($data))
        {
            echo json_encode(null);
        }
        else
        {
            echo json_encode($data);
        }
    }

}
