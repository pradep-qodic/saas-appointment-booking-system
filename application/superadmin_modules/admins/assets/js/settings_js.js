$(document).ready(function() {
	$('.working-plan input[type="text"]').timepicker({
            'timeFormat': 'HH:mm',
            
            currentText: "Now",
            closeText:"Close",
            timeOnlyTitle: "Select Time (24-Hour)",
            timeText: "Time",
            hourText: "Hour",
            minuteText: "Minutes",
            
            'onSelect': function(datetime, inst) {
                // Start time must be earlier than end time. 
                var start = Date.parse($(this).parent().parent().find('.work-start').val());
                var end = Date.parse($(this).parent().parent().find('.work-end').val());

                if (start > end) {
                    $(this).parent().parent().find('.work-end').val(start.addHours(1).toString('HH:mm'));
                }
            }
     });
	
	$("#orgInfo").click(function(){
		updateOrganization();
	});
	$("#businessLogic").click(function(){
		saveWorkingPlans(getSettings());
	});
	$("#gotoAppointment").click(function(){
		var gotourl=$("orgurl").val();
		
	});
	$('.working-plan input[type="checkbox"]').click(function() {
        var id = $(this).attr('id');

        if ($(this).prop('checked') == true) {
            $('#' + id + '-start').prop('disabled', false).val('09:00');
            $('#' + id + '-end').prop('disabled', false).val('18:00');
			$('#' + id + '-gap').prop('disabled', false).val('30');
        } else {
            $('#' + id + '-start').prop('disabled', true).val('');
            $('#' + id + '-end').prop('disabled', true).val('');
			$('#' + id + '-gap').prop('disabled', true).val('');
        }
    });
	loadWorkingPlans();
	loadLogo();
});

function updateOrganization(){
	var d = $("#frmGeneral").serializeArray();
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:d,
        url: url+"/updateOrganization",
        success: function(data){
            if(data.status=="success"){
                $("#generalSMsg").html(data.message);
                $('#generalSuccess').fadeIn().delay(3000).fadeOut();
            }
			if(data.status=="error"){
                $("#generalEMsg").html(data.message);
                $('#generalError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}

function loadLogo(){
	var pId=$("#pageId").val();
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{id:pId},
        url: url+"/loadOrganizationLogo",
        success: function(data){
            if(data.status=="success"){
                $("#LogoImage").html('<img src="'+data.path+'" title="Organization Logo" />');
            }
			
        }
    });
}
function getWorkingPlan(){
	var workingPlan = {};
    $('.working-plan input[type="checkbox"]').each(function() {
        var id = $(this).attr('id');
        if ($(this).prop('checked') == true) {
            workingPlan[id] = {};
            workingPlan[id].start = $('#' + id + '-start').val();
            workingPlan[id].end = $('#' + id + '-end').val();
            workingPlan[id].time_slots = $('#' + id + '-gap').val();
        } else {
            workingPlan[id] = null;
        }
    });
    
    return workingPlan;
}
function loadWorkingPlans(){
	var url=$("#base_url").val();
	$.ajax({
        type:"get",
        data:{},
        url: url+"/loadOrgWorkingPlans",
        success: function(data){
			if(data.status=="success")
				setupWorkingPlan($.parseJSON(data.data.slots));
        }
    });
}
function getSettings(){
	var settings = [];
    
    // Business Logic Tab
    settings.push({
        'name': 'org_working_plans',
        'value': JSON.stringify(getWorkingPlan())
    });
   /* 
    settings.push({
        'name': 'book_advance_timeout',
        'value': $('#book-advance-timeout').val()
    });*/
    return settings;
}
function saveWorkingPlans(set){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{settings:JSON.stringify(set)},
        url: url+"/saveOrgWorkingPlans",
        success: function(data){
			if(data.status=="success"){
                $("#businessSMsg").html(data.message);
                $('#businessSuccess').fadeIn().delay(3000).fadeOut();
				setupWorkingPlan($.parseJSON(data.data.slots));
            }
			if(data.status=="error"){
                $("#businessEMsg").html(data.message);
                $('#businessError').fadeIn().delay(3000).fadeOut();
			}
			
        }
    });
}
function setupWorkingPlan(workingPlan){	
	$.each(workingPlan, function(index, workingDay) {
		console.log(workingDay);
        if (workingDay != null) {
            $('#' + index).prop('checked', true);
            $('#' + index + '-start').val(workingDay.start);
            $('#' + index + '-end').val(workingDay.end);
			$('#' + index + '-gap').val(workingDay.time_slots);
        } else {
            $('#' + index).prop('checked', false);
            $('#' + index + '-start').prop('disabled', true);
            $('#' + index + '-end').prop('disabled', true);
			$('#' + index + '-gap').prop('disabled', true);
        }
    });
}
