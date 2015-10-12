<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TeamController extends CI_Controller
{


    /**
     *Call before any function to:
     * 1. Load Models Needed
     */
    protected $layout;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Team', 'team');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->layout = 'admin_layout';
    }

    /**
     *go to /q8soccer/application/config/route.php
     * you will found a line :
     *    $route['team']='TeamController';
     * this means you can change how the team see urls
     * but wont know the name of the real controller
     *or the method
     * same thing for the rest of function in here
     */
    public function index()
    {
        $this->load->library('pagination');
        $url = 'TeamController/index';
        $total_rows = $this->db->count_all('team');
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
        $data['teams'] = $this->team->get_team_list($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();

        $view = array('content' => 'team/all', 'data' => $data);
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
        $data['name'] = '';
        $data['flag'] = '';
        $data['script']='team-validation.js';
        $view = array('content' => 'team/add', 'data' => $data);
        $this->load->view($this->layout, $view);

    }

    /**
     * 1.save the team in db
     * 2.UploadImg
     * 3.send Approval email
     * @Request POST
     * @return redirect to index() here
     *
     */
    public function store()
    {

        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[team.name]');
        if ($this->form_validation->run() == FALSE) {
            $data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
            $data['flag'] = '';
            $data['script']='team-validation.js';
            $view = array('content' => 'team/add', 'data' => $data);
            $this->load->view($this->layout, $view);
        } else {
            $id = $this->team->get_new_id();
            $data['id'] = $id;
            $data['name'] = $_POST['name'];
            ////////// Upload img////////////
            $this->load->library('Upload_Img', 'upload_img');
            $data['flag'] = $this->upload_img->upload($data['id'], $_FILES, 'images/flag');
            /////////// Save in DB //////////
            $this->team->add($data);
            redirect('team', 'location');
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
        $data = $this->team->get_team($id);
        $view = array('content' => 'team/edit', 'data' => $data[0]);
        $this->load->view($this->layout, $view);
    }

    /**
     * 1.save updated team in db
     * 2.UploadImg if new one uploaded
     * @Request POST
     * @return redirect to index() here
     *
     */
    public function update()
    {
        $id = $_POST['id'];
        $data = $this->team->get_team($id);
        $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $view = array('content' => 'team/edit', 'data' => $data[0]);
            $this->load->view($this->layout, $view);
        } else {

            $data[0]['name'] = $_POST['name'];

            ////////// Upload img////////////
            if (!empty($_FILES['image']['name'])) {
                unlink('images/flag/' . $data[0]['image']);
                $this->load->library('Upload_Img', 'upload_img');
                $data[0]['flag'] = $this->upload_img->upload($data['id'], $_FILES, 'images/flag');
            }
            /////////// Save in DB //////////
            $this->team->update($data[0]);
            redirect('team', 'location');
        }
    }

    /**
     *Delete team by id
     * @Request GET
     * @return redirect to index() here
     */
    public function delete()
    {
        $id = $_GET['id'];
        $data = $this->team->get_team($id);
        if (!empty($data[0])) {
            if (file_exists(base_url() . '/images/flag/' . $data[0]['image']) && $data[0]['image'] !== 'default.png') {
                unlink('images/flag/' . $data[0]['image']);
            }
            $data = $this->team->delete($id);
        }
        redirect('team');
    }

    /**
     * Team Page
     * @Request GET
     * @return View
     */
    public function show()
    {
        $id = $_GET['id'];
        $data = $this->team->get_team($id);

        $view = array('content' => 'team/show', 'data' => $data[0]);
        $this->load->view($this->layout, $view);

    }

    /**
     *UI validation to check that the Team Name is unique
     */
    public function is_team_name_valid()
    {
        //get_team_by_user_name($name)
        $name=$_GET['name'];
        $data=$this->team->get_team_by_user_name($name);
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
