/**
 * Created by marina on 9/29/15.
 */
$(document).ready(function () {
    var flag=false;
    function TeamsNotTheSameCheck() {
        var team1=$('#team1').val();
        var team2=$('#team2').val();
        if(team1==team2)
        {
            $('#msg').html("the team can't play against itself");
            flag=true;
        }
        else
        {
            $('#msg').html("");
            flag=false;
        }
    }

    $('#team1').change(function(){TeamsNotTheSameCheck()});
    $('#team2').change(function(){TeamsNotTheSameCheck()});
    $("form").submit(function (e) {
        TeamsNotTheSameCheck()
        if(flag)
        {
            e.preventDefault();
            $('#msg').append('<br><b>Error,</b> please fix Errors before submit');
        }
    });
});