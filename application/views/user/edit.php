<form method="post" action="/q8soccer/user/update" enctype="multipart/form-data">
    <?php
        $this->load->view('user/_form',
            array('data'=> $data,'is_edit'=>true));
    ?>
</form>