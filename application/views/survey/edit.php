<form method="post" action="/q8soccer/survey/update" enctype="multipart/form-data">
    <?php
        $this->load->view('survey/_form',
            array('data'=> $data,'is_edit'=>true));
    ?>
</form>