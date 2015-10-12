<?php //var_dump($data['teams']); exit;?>
<h1>form</h1>
<span class="alert-danger" id="msg">
    <?php echo validation_errors();?>
</span>
<div class="form-group">
    <label>Team 1</label>
    <select name="team1" id="team1" class="form-control" required>
        <?php
        foreach($data['teams'] as $team)
        {
            $selected= $data['team1']==$team->id?'selected':'';
            echo "<option $selected value='".$team->id.
                "' style='background-image:url(/q8soccer/images/flag".$team->flag.");'>".
                $team->name.
                "</option>";
        }
        ?>
    </select>

</div>
<div class="form-group">
    <label>Team 2</label>
    <select name="team2" id="team2" class="form-control" required>
        <?php
        foreach($data['teams'] as $team)
        {
            $selected= $data['team2']==$team->id?'selected':'';
            echo "<option $selected value='".$team->id.
                "' style='background-image:url(/q8soccer/images/flag".$team->flag.");'>".
                $team->name.
                "</option>";
        }
        ?>
    </select>

</div>
<div class="form-group">
    <label>Date</label>
    <input type="date" name="date" class="form-control"
           required
           value="<?php echo $data['date'];?>">
</div>
<?php
if(isset($is_edit))
{
   ?>

    <input type="hidden" name="id"
           class="form-control" value="<?php echo $data['id'];?>" >
    <input type="hidden" name="team1_result"
           class="form-control" value="<?php echo $data['team1_result'];?>" >
    <input type="hidden" name="team2_result"
           class="form-control" value="<?php echo $data['team2_result'];?>" >
    <div class="form-group">
        <label>Team1 score</label>
        <input type="number" name="team1_score"
               class="form-control"
               value="<?php echo $data['team1_score'];?>">
    </div>
    <div class="form-group">
        <label>Team2 score</label>
        <input type="number" name="team2_score"
               class="form-control"
               value="<?php echo $data['team2_score'];?>">
    </div>
<?php
}
?>

<button type="submit" class="btn btn-default" id="submit">Submit</button>

