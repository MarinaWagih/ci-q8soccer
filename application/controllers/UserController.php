<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {


    /**
     *Call before any function to:
     * 1. Load Models Needed
     */
    protected $layout;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User','user');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->layout='admin_layout';
    }

    /**
     *go to /q8soccer/application/config/route.php
     * you will found a line :
     *    $route['user']='UserControl';
     * this means you can change how the user see urls
     * but wont know the name of the real controller
     *or the method
     * same thing for the rest of function in here
     */
    public function index()
	{
        $this->load->library('pagination');
        $url='UserController/index';
        $total_rows=$this->db->count_all('user');
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
        $data['users'] = $this->user->get_user_list($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();

        $view = array('content' => 'user/all', 'data' => $data);
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
        $data['user_name']='';
        $data['email']='';
        $data['script']='user-validation.js';
        $view = array('content' => 'user/add', 'data' => $data);
        $this->load->view($this->layout, $view);

    }

    /**
     * 1.save the user in db
     * 2.UploadImg
     * 3.send Approval email
     * @Request POST
     * @return redirect to index() here
     *
     */
    public function store()
    {


        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.user_name]');
        $this->form_validation->set_rules('password', 'Password', 'required|is_unique[users.email]');
        $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

        if ($this->form_validation->run() == FALSE)
        {

            $data['user_name']=isset($_POST['username'])?$_POST['username']:'';
            $data['email']=isset($_POST['email'])?$_POST['email']:'';
            $data['script']='user-validation.js';
            $view = array('content' => 'user/add', 'data' => $data);
            $this->load->view($this->layout, $view);
        }
        else
        {

            $id= $this->user->get_new_id();
            //var_dump($id);
            $data['id']=$id;
            $data['user_name']=$_POST['username'];
            $data['email']=$_POST['email'];
            $data['password']=MD5($_POST['password']);
            $data['type']='normal';
            $data['active']='0';
            ////////// Upload img////////////
            $this->load->library('Upload_Img','upload_img');
            $data['image'] =$this->upload_img->upload($data['id'],$_FILES,'images/profile');
            /////////// Save in DB //////////
//        $this->load->model('user');
            $this->user->add($data);
            ///////// approve Mail//////////
            $this->load->library('Mail','mail');
//        var_dump($_POST);
            $message = "<h1>dear ".$data['user_name'].",</h1> "  .
                "<div> we would like to welcome you in our web site to activate
             your account please visit this link
             : <a href='http://".$_SERVER['SERVER_NAME'].'/'.base_url()."/activate?id=" . $id."'>click here</a>".
                "</div>";
            $email=$data['email'];
            $sub='activate your account !';
            $this->load->library('mail');
            $this->mail->send($email,$message,$sub);
            redirect('user', 'location');
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

        $data=$this->user->get_user($id);
        $data[0]['password']='';

        $view = array('content' => 'user/edit', 'data' => $data[0]);
        $this->load->view($this->layout, $view);
    }

    /**
     * 1.save updated user in db
     * 2.UploadImg if new one uploaded
     * @Request POST
     * @return redirect to index() here
     *
     */
    public function update()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $id=$_POST['id'];
        if ($this->form_validation->run() == FALSE)
        {
            $data=$this->user->get_user($id);
            $data[0]['password']='';
            $view = array('content' => 'user/edit', 'data' => $data[0]);
            $this->load->view($this->layout, $view);
        }
        else
        {
            $data=$this->user->get_user($id);
            $data[0]['user_name']=$_POST['username'];
            $data[0]['email']=$_POST['email'];
            ////////// Upload img////////////
            if(!empty($_FILES['image']['name']))
            {
                unlink('images/profile/'.$data[0]['image']);
                $this->load->library('Upload_Img', 'upload_img');
                $data[0]['image'] = $this->upload_img->upload($data['id'], $_FILES, 'images/profile');

            }
            /////////// Save in DB //////////
//        $this->load->model('user');
            $this->user->update($data[0]);
            redirect('user', 'location');
        }


    }

    /**
     *Delete user by id
     * @Request GET
     * @return redirect to index() here
     */
    public function delete()
    {
        $id= $_GET['id'];
        $data=$this->user->get_user($id);
        if(!empty($data[0])) {
            if (file_exists(base_url() . '/images/profile/' . $data[0]['image']) && $data[0]['image'] !== 'default.png') {
                unlink('images/profile/' . $data[0]['image']);
            }
            $data = $this->user->delete($id);
        }
       redirect('user');
    }

    /**
     * confirm that the e-mail is valid
     * @Request GET
     * @return View
     *
     */
    public function activate()
    {
        $id= $_GET['id'];
        $this->user->activate($id);
        redirect('user', 'location');
    }

    /**
     *profile
     * @Request GET
     * @return View
     */
    public function show()
    {
        $id= $_GET['id'];
        $data=$this->user->get_user($id);

        $view = array('content' => 'user/show', 'data' => $data[0]);
        $this->load->view($this->layout,$view);

    }

    /**
     * check if the name Unique
     * the sended name is NOT in the db
     *for user validation in UI
     *
     */
    public function is_userName_Valid()
    {
        $name=$_GET['name'];
        $data=$this->user->get_user_by_user_name($name);
        if(empty($data))
        {
         echo json_encode('true');
        }
        else
        {
            echo json_encode('false');
        }
    }

    /**
     * check if the E-mail Unique
     * the sended mail is NOT in the db
     *for user validation in UI
     *
     */
    public function is_email_Valid()
    {
        $name=$_GET['email'];
        $data=$this->user->get_user_by_user_email($name);
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
