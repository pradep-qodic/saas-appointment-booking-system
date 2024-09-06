$(document).ready(function(){
    $('[rel=sharepopover]').click(function(){
        $v=$(this).attr("helperId");
        setTimeout(function(){$("#event_id").val($v);$("#fbShare").attr("eID",$v);}, 300);
    });
});



