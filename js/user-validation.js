/**
 * Created by marina on 9/28/15.
 */

$(document).ready(function () {
    var flag=false;
    function sendUserNameCheck(){
        //username/unique?name=
        //alert('keypress');
        $.get('/q8soccer/username/unique?name='+$('#userName').val(),
            function(data)
            {
                var result=$.parseJSON(data);
                if(result=='true')
                {
                    $('#userNameError').html('');
                    flag=false;
                }
                else{
                    $('#userNameError').html('Error, this user name is exist');
                    flag=true;
                }
               // alert(result)
                //alert();
            });
    }
    function sendMailCheck(){
        //email/unique?email=
        //alert('keypress');
        $.get('/q8soccer/email/unique?email='+$('#Email').val(),
            function(data)
            {
                var result=$.parseJSON(data);
                if(result=='true')
                {
                    $('#emailError').html('');
                    flag=false;

                }
                else{
                    $('#emailError').html('Error, this email is exist');
                    flag=true;
                }
               // alert(result)
                //alert();
            });
    }
    function passwordCheck(){
      var password=$('#password').val();
      var confirm_password=$('#confirm_password').val();

        if(password.length < 8)
        {
            $('#passwordError').html('Short password');
            flag=true;
        }
        else
        {
            $('#passwordError').html('');
            flag=false;
        }

        if(password!= confirm_password)
        {
            $('#passwordConfirmError').html('Not Matching');
            flag=true;
        }
        else
        {
            $('#passwordConfirmError').html('');
            flag=false;
        }
    }
    $('#userName').keyup(function(){
       sendUserNameCheck()
   });

    $('#userName').blur(function(){
       sendUserNameCheck()
   });

    $('#Email').keyup(function(){
        sendMailCheck()
   });

    $('#Email').blur(function(){
        sendMailCheck()
   });

    $('#password').keyup(function()
    {

        passwordCheck()
    });
    $('#password').blur(function()
    {
        passwordCheck()
    });
    $('#confirm_password').keyup(function()
    {

        passwordCheck()
    });
    $('#confirm_password').blur(function()
    {
        passwordCheck()
    });
    $("form").submit(function (e) {
        if(flag)
        {
            e.preventDefault();
            $('#msg').html('<b>Error,</b> please fix Errors before submit');
        }
    });


});