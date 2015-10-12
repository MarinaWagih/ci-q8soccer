<h1>form</h1>
<span class="alert-danger" id="msg">
    <?php echo validation_errors();?>
</span>
<div class="form-group">
    <label>Question</label>
    <input type="text" name="question" class="form-control"
           placeholder="question" required id="question"
           value="<?php echo $data['question'];?>">
    <span class="alert-danger" id='questionError'></span>
</div>
<button type="button" class="btn btn-success" id="Add_answer">Add answers</button>
<div id="answers">

</div>
<br>
<?php
if(isset($is_edit))
{
?>

    <input type="hidden" name="id"
           class="form-control" value="<?php echo $data['id'];?>" >
<?php
    for($i=0;$i< count( $data['answers']);$i++)
    {
        $input='<div class="form-group" id="'.$data['answers'][$i]['id'].'" >' .
            '<label> Answer'.
            '</label>'.
            '<input name="answers[]" class="form-control Answer" ' .
            'type="text" value="'.$data['answers'][$i]['answer'].'">';
        $input.='<span ' .
            'class="glyphicon glyphicon-remove delete" id="x-'
            .$data['answers'][$i]['id'].'"></span>'
            .'</div>';
        echo $input;
    }
}
?>
<!--<input type="hidden" name="answers"-->
<!--       class="form-control" value="" id="answers">-->
<button type="submit" class="btn btn-default" id="submit">Submit</button>