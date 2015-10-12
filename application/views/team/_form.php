<h1>form</h1>
<span class="alert-danger" id="msg">
    <?php echo validation_errors();?>
</span>
<div class="form-group">
    <label>name</label>
    <input type="text" name="name" class="form-control"
           placeholder="name" required id="name"
           value="<?php echo $data['name'];?>">
    <span class="alert-danger" id='nameError'></span>
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
<div class="form-group">
    <label >image</label>
    <input type="file" name="image" class="form-control">
</div>
<button type="submit" class="btn btn-default" id="submit">Submit</button>