<?php
//use Category;

Class Mail
{
  public function  send($to,$message,$sub)
  {

          $config = Array(
              'protocol' => 'smtp',
              'smtp_host' => 'ssl://mail.bazaarq8.com',
              'smtp_port' => 465,
              'smtp_user' => 'no-reply@bazaarq8.com', // change it to yours
              'smtp_pass' => 'no-reply2006', // change it to yours
              'mailtype' => 'html',
              'charset' => 'iso-8859-1',
              'wordwrap' => TRUE
          );
      $CI =& get_instance();

      $CI->load->library('email', $config);
      $CI->email->set_newline("\r\n");
      $CI->email->from('no-reply@bazaarq8.com');
      $CI->email->to($to);
      $CI->email->subject($sub);
      $CI->email->message($message);
      if ($CI->email->send()) {
        return 'Email sent.';
      } else {
          return $CI->email->print_debugger();
      }

  }

}
?>
