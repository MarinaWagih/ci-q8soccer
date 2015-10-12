<h1>form</h1>
<span class="alert-danger" id="msg">
    <?php echo validation_errors();?>
</span>
<input type="hidden" name="team1_result"
       class="form-control" value="<?php echo $data['team1_result'];?>" >
<input type="hidden" name="team2_result"
       class="form-control" value="<?php echo $data['team2_result'];?>" >
<input type="hidden" name="match_id"
       class="form-control" value="<?php echo $data['match_id'];?>" >
<div class="form-group">

    <label><?php echo $data["team1_data"]['name'] ?> score</label>
    <input type="number" name="team1_score"
           class="form-control"
           value="<?php echo $data['team1_score'];?>">
</div>
<div class="form-group">
    <label><?php echo $data["team2_data"]['name'] ?> score</label>
    <input type="number" name="team2_score"
           class="form-control"
           value="<?php echo $data['team2_score'];?>">
</div>
<?php
if(isset($is_edit))
{
   ?>

    <input type="hidden" name="id"
           class="form-control" value="<?php echo $data['id'];?>" >
<?php
}
?>
<button type="submit" class="btn btn-default" id="submit">Submit</button>