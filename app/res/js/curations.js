$(document).ready(function(){
// updating the view with notifications using ajax
    function load_unseen_notification()
    {
        $.ajax({
            url:"../../../DiaGenKri/public/visualisation/curationsUpdate",
            method:"POST",
            dataType:"json",
            success:function(data)
            {
                if(Number(data[0]) > 0)
                {
                    $('.count').html(data[0]);
                }
            }
        });
    }

    load_unseen_notification();

    setInterval(function(){
        load_unseen_notification();
    }, 10000);
});

