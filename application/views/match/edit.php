<form method="post" action="/q8soccer/match/update" enctype="multipart/form-data">
    <?php
        $this->load->view('match/_form',
            array('data'=> $data,'is_edit'=>true));
    ?>
</form>