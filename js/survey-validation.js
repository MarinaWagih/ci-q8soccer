 /**
 * Created by marina on 10/8/15.
**/
$(document).ready(function () {
    var answers=[];
    var i=0;
    var flag=false;
    $('#Add_answer').click(function(){
                       // alert('in');
                var input='<div class="form-group" id="'+i+'" >' +
                           '<label> Answer' +
                           '</label>'+
                           '<input name="answers[]" class="form-control Answer" ' +
                          'type="text">';
                    input+='<span ' +
                           'class="glyphicon glyphicon-remove" id="x-'
                           +i+'"></span>'
                            +'</div>';

                $('#answers').append(input);
                $('.Answer').blur(function(){
                   // var data=$(this).val();
                   //answers.push(data);
                   //var str_answer=answers.join(',');
                   //console.log(str_answer);

                });
                $('#x-'+i).click(function(){
                    var id=$(this).attr('id').split('-')[1];
                    //alert(id);
                    //delete  answers[id];
                    //answers.splice(id);
                    $('#'+id).remove();
                    $(this).remove();
                    //var str_answer=answers.join(',');
                    //console.log(str_answer);
                });
        i++;

        });
    //
    $('.delete').click(function(){
        var id=$(this).attr('id').split('-')[1];
        //alert(id);
        //delete  answers[id];
        //answers.splice(id);
        $('#'+id).remove();
        $(this).remove();
        //var str_answer=answers.join(',');
        //console.log(str_answer);
    });
    //Answer
    $('#submit').click(function(){
        $(".Answer").each(function() {
            answers.push($(this).val());
        });
        if(answers.length>0)
        {
            flag=false;
        }
        else
        {
           flag=true;
        }
        $("form").submit(function (e)
        {

            if(flag)
            {
                e.preventDefault();
                $('#msg').append('<br><b>Error,</b> please fix Errors before submit');
                $('#msg').append('<br>No answers for survey');

            }

        });
    });

});
