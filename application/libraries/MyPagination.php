<?php
//use Category;

Class MyPagination
{
  public function paginating($url,$total_rows)
  {
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

      $CI =& get_instance();
      $CI->pagination->initialize($config);
      $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

  }

}
?>
