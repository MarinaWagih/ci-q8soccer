/**
 * Created by marina on 9/29/15.
 */
$(document).ready(function () {
    var flag=false;
    function sendNameCheck(){
        //username/unique?name=
        //alert('keypress');
        $.get('/q8soccer/team_name/unique?name='+$('#name').val(),
            function(data)
            {
                var result=$.parseJSON(data);

                if(result=='true')
                {
                    $('#nameError').html('');
                    flag=false;
                }
                else{
                    $('#nameError').html('Error, this user name is exist');
                    flag=true;
                }
                // alert(result)
                //alert();
            });
    }
    $('#name').keyup(function(){
        sendNameCheck()
    });

    $('#name').blur(function(){
        sendNameCheck()
    });
    $("form").submit(function (e) {
        if(flag)
        {
            e.preventDefault();
            $('#msg').html('<b>Error,</b> please fix Errors before submit');
        }
    });
});