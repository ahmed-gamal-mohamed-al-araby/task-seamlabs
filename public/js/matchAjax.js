$(document).ready(function () {
    $('#tour').change(function(){
        var tour = $(this).val();
        $.ajax({
            url: "/GetGwalat/" + tour ,
            dataType: 'html',
            type: 'get',
            success: function (data) {
                $('#gawalatCon').show();
                $('#gwalat').html(data);
            }
        });
    });

    $('#classif').change(function(){
        var classif = $(this).val();
        $.ajax({
            url: "/GetClubs/" + classif ,
            dataType: 'html',
            type: 'get',
            success: function (data) {
                $('#home_clubs').html(data);
                $('#away_clubs').html(data);
            }
        });
    });

    $('#classif').change(function(){
        var classif = $(this).val();
        $.ajax({
            url: "/GetTours/" + classif ,
            dataType: 'html',
            type: 'get',
            success: function (data) {

                $('#tour_cont').show();
                $('#gawalatCon').hide();

                $('#tour').html(data);
            }
        });
    });

    $('#gwalat').change(function(){
        var classif = $(this).val();
        $.ajax({
            url: "" ,
            dataType: 'html',
            type: 'get',
            success: function (data) {

                $('#home_club_cont').show();
                $('#away_club_cont').show();
                // $('#tour').html(data);
            }
        });
    });
 
});