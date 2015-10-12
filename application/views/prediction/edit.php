<form method="post" action="/q8soccer/prediction/update" enctype="multipart/form-data">
    <?php
        $this->load->view('prediction/_form',
            array('data'=> $data,'is_edit'=>true));
    ?>
</form>