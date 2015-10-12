<h1>form</h1>
<span class="alert-danger" id="msg">
    <?php echo validation_errors();?>
</span>
<div class="form-group">
    <label>user name</label>
    <input type="text" name="username" class="form-control"
           placeholder="user name" required id="userName"
           value="<?php echo $data['user_name'];?>">
    <span class="alert-danger" id='userNameError'></span>
</div>
<div class="form-group">
    <label >Email address</label>
    <input type="email" name="email" class="form-control"
           placeholder="Email" required id="Email"
           value="<?php echo $data['email'];?>">
    <span class="alert-danger" id='emailError'></span>
</div>
<?php
if(!isset($is_edit))
{
   ?>
    <div class="form-group">
        <label >password</label>
        <input type="password" name="password" id="password" class="form-control"
               placeholder="password at least 8 characters" required>
        <span class="alert-danger" id='passwordError'></span>
    </div>
    <div class="form-group">
        <label >confirm password</label>
        <input type="password" id="confirm_password" class="form-control"
               placeholder="password at least 8 characters" name="confirm_password">
        <span class="alert-danger" id='passwordConfirmError'></span>
    </div>
<?php
}else
{
    ?>
    <input type="hidden" name="id"
           class="form-control" value="<?php echo $data['id'];?>" >
<?php
}
?>

<div class="form-group">
    <label >image</label>
    <input type="file" name="image">
</div>
<button type="submit" class="btn btn-default" id="submit">Submit</button>
