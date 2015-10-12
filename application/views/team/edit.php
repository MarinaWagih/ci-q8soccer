<form method="post" action="/q8soccer/team/update" enctype="multipart/form-data">
    <?php
        $this->load->view('team/_form',
            array('data'=> $data,'is_edit'=>true));
    ?>
</form>