<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SurveyController extends CI_Controller
{


    /**
     *Call before any function to:
     * 1. Load Models Needed
     */
    protected $layout;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Survey', 'survey');
        $this->load->model('User', 'user');
        $this->load->model('Survey_answer', 'survey_answer');
        $this->load->model('User_survey_answer', 'user_survey_answer');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->layout = 'admin_layout';
    }

    /**
     *go to /q8soccer/application/config/route.php
     * you will found a line :
     *    $route['survey']='surveyController';
     * this means you can change how the survey see urls
     * but wont know the name of the real controller
     *or the method
     * same thing for the rest of function in here
     */
    public function index()
    {
        $this->load->library('pagination');
        $url = 'surveyController/index';
        $total_rows = $this->db->count_all('survey');
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
        $data['surveys'] = $this->survey->get_survey_list($config["per_page"], $data['page']);
        foreach($data['surveys'] as $survey)
        {
            $survey->user_data=$this->user->get_user_by_id($survey->user_id);
            $survey->answers=$this->survey_answer->get_survey_answer($survey->id);
            for($i=0;$i<count($survey->answers);$i++)
            {
//                echo $survey->answers[$i]['id'];
                $survey->answers[$i]['answered_users']=$this->user_survey_answer
                    ->get_user_survey_answer_by_answer_id($survey->answers[$i]['id']);
//                var_dump($survey->answers[$i]['answered_users']);
            }

        }
//        echo '<pre>';
//        var_dump($data['surveys']);exit;
        $data['pagination'] = $this->pagination->create_links();

        $view = array('content' => 'survey/all', 'data' => $data);
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
        $data['question'] = '';
        $data['answers'] = implode(',',[]);
        $data['script']='survey-validation.js';
        $view = array('content' => 'survey/add', 'data' => $data);
        $this->load->view($this->layout, $view);

    }

    /**
     * 1.save the survey in db
     * 2.save the survey_answers in db
     * @Request POST
     * @return redirect to index() here
     *
     */
    public function store()
    {

        $this->form_validation->set_rules('question', 'Question', 'required|is_unique[survey.question]');
        if ($this->form_validation->run() == FALSE) {
            $data['name'] = isset($_POST['question']) ? $_POST['question'] : '';
            $data['script']='survey-validation.js';
            $view = array('content' => 'survey/add', 'data' => $data);
            $this->load->view($this->layout, $view);
        } else {
            $id = $this->survey->get_new_id();
            $data['id'] = $id;
            $data['question'] = $_POST['question'];
            $data['user_id'] = '1';
            $data['date'] = date('Y-m-d');;
            /////////// Save in DB //////////
            $this->survey->add($data);
            ////////////Save Answers////////
            $ans=$_POST['answers'];
//            $answers=explode(',',$ans);
//            var_dump($_POST);
//            exit;
            for($i=0;$i<count($ans);$i++)
            {
                $answer_data['answer']=$ans[$i];
                $answer_data['survey_id']=$id;
                $this->survey_answer->add($answer_data);
            }
            redirect('survey', 'location');
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
        $data = $this->survey->get_survey($id)[0];
//        var_dump($data);
//        exit;
        $data['user_data']=$this->user->get_user_by_id($data['user_id']);
        $data['answers']=$this->survey_answer->get_survey_answer($data['id']);
        $data['script']='survey-validation.js';
        for($i=0;$i<count($data['answers']);$i++)
        {
//                echo $survey->answers[$i]['id'];
            $data['answers'][$i]['answered_users']=$this->user_survey_answer
                ->get_user_survey_answer_by_answer_id( $data['answers'][$i]['id']);
//                var_dump($survey->answers[$i]['answered_users']);
        }
        $view = array('content' => 'survey/edit', 'data' => $data);
        $this->load->view($this->layout, $view);
    }

    /**
     * 1.save updated survey in db
     * 2.UploadImg if new one uploaded
     * @Request POST
     * @return redirect to index() here
     *
     */
    public function update()
    {
        $id = $_POST['id'];
        $data = $this->survey->get_survey($id)[0];
        $this->form_validation->set_rules('question', 'Question', 'required');
        if ($this->form_validation->run() == FALSE) {

            $data['user_data']=$this->user->get_user_by_id($data['user_id']);
            $data['answers']=$this->survey_answer->get_survey_answer($data['id']);
            $data['script']='survey-validation.js';
            for($i=0;$i<count($data['answers']);$i++)
            {
                $data['answers'][$i]['answered_users']=$this->user_survey_answer
                    ->get_user_survey_answer_by_answer_id( $data['answers'][$i]['id']);
            }
            $view = array('content' => 'survey/edit', 'data' => $data);
            $this->load->view($this->layout, $view);
        }
        else {

            $data['id'] = $id;
            $data['question'] = $_POST['question'];
            $data['user_id'] = '1';
            $data['date'] = date('Y-m-d');
            /////////// Save in DB //////////
            $this->survey->update($data[0]);
            ////////delete old answers///////
            $this->survey_answer->delete_by_survey_id($id);
            ///////save new answers//////////
            $ans=$_POST['answers'];
            for($i=0;$i<count($ans);$i++)
            {
                $answer_data['answer']=$ans[$i];
                $answer_data['survey_id']=$id;
                $this->survey_answer->add($answer_data);
            }
            redirect('survey', 'location');
        }
    }

    /**
     *Delete survey by id
     * @Request GET
     * @return redirect to index() here
     */
    public function delete()
    {
        $id = $_GET['id'];
        $data = $this->survey->get_survey($id);
        if (!empty($data[0])) {

            $data = $this->survey->delete($id);
        }
        redirect('survey');
    }

    /**
     * survey Page
     * @Request GET
     * @return View
     */
    public function show()
    {
        $id = $_GET['id'];
        $data = $this->survey->get_survey($id)[0];
//        var_dump($data);
//        exit;
        $data['user_data']=$this->user->get_user_by_id($data['user_id']);
        $data['answers']=$this->survey_answer->get_survey_answer($data['id']);
        $data['script']='survey-validation.js';
        for($i=0;$i<count($data['answers']);$i++)
        {
//                echo $survey->answers[$i]['id'];
            $data['answers'][$i]['answered_users']=$this->user_survey_answer
                ->get_user_survey_answer_by_answer_id( $data['answers'][$i]['id']);
//                var_dump($survey->answers[$i]['answered_users']);
        }
        $view = array('content' => 'survey/show', 'data' => $data);
        $this->load->view($this->layout, $view);

    }

    /**
     *UI validation to check that the survey Name is unique
     */
    public function is_survey_name_valid()
    {
        //get_survey_by_user_name($name)
        $name=$_GET['name'];
        $data=$this->survey->get_survey_by_user_name($name);
        if(empty($data))
        {
            echo json_encode('true');
        }
        else
        {
            echo json_encode('false');
        }
    }

}
