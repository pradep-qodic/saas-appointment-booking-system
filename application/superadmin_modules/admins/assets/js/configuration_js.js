$(document).ready(function() {
	loadBookingPages();
	customerSettings();
	$("#bookingPageLinks").on("change","input:checkbox",function(){
		hideInstruction();
	});
	$("#sidebarBookingPages").on("click",".bookingPage",function(){
		$(".bookingPage").removeClass("active");
		$(this).addClass('active');
		loadConfiguration($(this).attr('data-id'));
	});
	$("#sidebarMasterBookingPages").on("click",".masterBookingPage",function(){
		$(".masterBookingPage").removeClass("active");
		$(this).addClass('active');
		loadMasterBookingConfiguration($(this).attr('data-id'));
	});
	$("#btnAddBookingPage").click(function(){
		addBookingPage();
	});
	$("#btnAddMasterBookingPage").click(function(){
		addMasterBookingPage();
	});
	$("#btnBookingPageDetails").click(function(){
		saveBookingPageDetails();
	});
	$("#btnMasterBookingPageDetails").click(function(){
		saveMasterBookingPageDetails();
	});
	$("#btnMasterBookingPagesetup").click(function(){
		saveMasterBookingPageSetup();
	});
	$("#btnLocation").click(function(){
		saveLocation();
	});
	$("#btnBooking").click(function(){
		saveBooking();
	});
	$("#btnUsernotification").click(function(){
		saveUserNotifications();
	});
	$("#btnCustomernotification").click(function(){
		saveApplicantNotifications();
	});
	$('#collapseBooking').on('shown.bs.collapse', function () {
		$("#btnBooking").fadeIn();
		$("#iconBooking").removeClass("fa-plus-circle");
		$("#iconBooking").addClass("fa-minus-circle");
	});
	$('#collapseBooking').on('hidden.bs.collapse', function () {
		$("#btnBooking").fadeOut();
		$("#iconBooking").removeClass("fa-minus-circle");
		$("#iconBooking").addClass("fa-plus-circle");
	});
	$('#collapseAvailability').on('shown.bs.collapse', function () {
		$("#btnAvailability").fadeIn();
		$("#iconAvailability").removeClass("fa-plus-circle");
		$("#iconAvailability").addClass("fa-minus-circle");
	});
	$('#collapseAvailability').on('hidden.bs.collapse', function () {
		$("#btnAvailability").fadeOut();
		$("#iconAvailability").removeClass("fa-minus-circle");
		$("#iconAvailability").addClass("fa-plus-circle");
	});
	$('#collapseLocation').on('shown.bs.collapse', function () {
		$("#btnLocation").fadeIn();
		$("#iconLocation").removeClass("fa-plus-circle");
		$("#iconLocation").addClass("fa-minus-circle");
	});
	$('#collapseLocation').on('hidden.bs.collapse', function () {
		$("#btnLocation").fadeOut();
		$("#iconLocation").removeClass("fa-minus-circle");
		$("#iconLocation").addClass("fa-plus-circle");
	});
	$('#collapseUserNotification').on('shown.bs.collapse', function () {
		$("#btnUsernotification").fadeIn();
		$("#iconUsernotification").removeClass("fa-plus-circle");
		$("#iconUsernotification").addClass("fa-minus-circle");
	});
	$('#collapseUserNotification').on('hidden.bs.collapse', function () {
		$("#btnUsernotification").fadeOut();
		$("#iconUsernotification").removeClass("fa-minus-circle");
		$("#iconUsernotification").addClass("fa-plus-circle");
	});
	$('#collapseCustomerNotification').on('shown.bs.collapse', function () {
		$("#btnCustomernotification").fadeIn();
		$("#iconCustomernotification").removeClass("fa-plus-circle");
		$("#iconCustomernotification").addClass("fa-minus-circle");
	});
	$('#collapseCustomerNotification').on('hidden.bs.collapse', function () {
		$("#btnCustomernotification").fadeOut();
		$("#iconCustomernotification").removeClass("fa-minus-circle");
		$("#iconCustomernotification").addClass("fa-plus-circle");
	});
	$('#collapseBookingPageDetails').on('shown.bs.collapse', function () {
		$("#btnBookingPageDetails").fadeIn();
		$("#iconBookingPageDetails").removeClass("fa-plus-circle");
		$("#iconBookingPageDetails").addClass("fa-minus-circle");
	});
	$('#collapseBookingPageDetails').on('hidden.bs.collapse', function () {
		$("#btnBookingPageDetails").fadeOut();
		$("#iconBookingPageDetails").removeClass("fa-minus-circle");
		$("#iconBookingPageDetails").addClass("fa-plus-circle");
	});
	/* master booking page */
	$('#collapseMasterBookingPageSetup').on('shown.bs.collapse', function () {
		$("#btnMasterBookingPagesetup").fadeIn();
		$("#iconMasterBookingPageSetup").removeClass("fa-plus-circle");
		$("#iconMasterBookingPageSetup").addClass("fa-minus-circle");
	});
	$('#collapseMasterBookingPageSetup').on('hidden.bs.collapse', function () {
		$("#btnMasterBookingPagesetup").fadeOut();
		$("#iconMasterBookingPageSetup").removeClass("fa-minus-circle");
		$("#iconMasterBookingPageSetup").addClass("fa-plus-circle");
	});
	$('#collapseMasterBookingPageDetails').on('shown.bs.collapse', function () {
		$("#btnMasterBookingPageDetails").fadeIn();
		$("#iconMasterBookingPageDetails").removeClass("fa-plus-circle");
		$("#iconMasterBookingPageDetails").addClass("fa-minus-circle");
	});
	$('#collapseMasterBookingPageDetails').on('hidden.bs.collapse', function () {
		$("#btnMasterBookingPageDetails").fadeOut();
		$("#iconMasterBookingPageDetails").removeClass("fa-minus-circle");
		$("#iconMasterBookingPageDetails").addClass("fa-plus-circle");
	});
	/* end */
	$("#savePlan").click(function(){
		createPlan();
	});
	$("#rightCol").on("click","#btnLinkStatus",function(){
		saveLinkStatus($(this).attr('data-val'));
	});
	$("#rightCol").on("click","#btnMasterLinkStatus",function(){
		saveMasterLinkStatus($(this).attr('data-val'));
	});
	$("#dlPlan").click(function(){
		deleteWorkingPlan($(this).attr('data'));
	});
	$("#dlPage").click(function(){
		deleteBookingPage($(this).attr('data'));
	});
	$("#dlMasterPage").click(function(){
		deleteMasterBookingPage($(this).attr('data'));
	});
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

	$("#btnAvailability").click(function(){
		saveWorkingPlans(getSettings());
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
	$('#workingDate').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
	$('#startTime').timepicker({
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
	 $('#endTime').timepicker({
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
	 $("#WorkingPlanCancel").click(function(){
		clearWorkingPlans();
	});
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  var current=$("#current_url").val()+"#dateSpecificTab";
	  var currentMasterBooking=$("#current_url").val()+"#manageMasterBookingPages";
	  var currentBooking=$("#current_url").val()+"#manageBookingPages";
	  if(e.target==current){
		$("#btnAvailability").prop("disabled",true);
		availability($("#resource_id").val());
	  }else if(e.target==currentMasterBooking){
		$("#containerRow").hide();
		$("#bookingLoader").fadeIn();
		setTimeout(function(){
			$("#bookingLoader").fadeOut();
			$("#containerRow").fadeIn();
		}, 500);
		$("#newBookingPage").fadeOut();
			$("#newMasterBookingPage").fadeIn();
			$("#sidebarBookingPages").fadeOut();
			$("#sidebarMasterBookingPages").fadeIn();
			loadMasterBookingPages();
	  }else if(e.target==currentBooking){
		$("#containerRow").hide();
		$("#bookingLoader").fadeIn();
		setTimeout(function(){
			$("#bookingLoader").fadeOut();
			$("#containerRow").fadeIn();
		}, 500);
		$("#newBookingPage").fadeIn();
		$("#newMasterBookingPage").fadeOut();
		$("#sidebarBookingPages").fadeIn();
		$("#sidebarMasterBookingPages").fadeOut();
	  }else{
		$("#btnAvailability").prop("disabled",false);
	  }
	});
	/* holiday */
	$('#startdate').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
	$('#enddate').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
	$("#startdate").tooltip({
        container:'body',
        trigger: 'hover focus',
        title:'Click To Select Date',
        placement:'top'
    });
	$("#enddate").tooltip({
        container:'body',
        trigger: 'hover focus',
        title:'Click To Select Date',
        placement:'top'
    });
	$("#btnAddHoliday").click(function(){
		addHoliDay();
	});
	$("#btnUpdateHoliday").click(function(){
		updateHoliDay();
	});
	$("#btnCancelHoliday").click(function(){
		clearHoliday();
	});
	/*$('.date.schedular').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
	$(".input-group.date").tooltip({
        container:'body',
        trigger: 'hover focus',
        title:'Click To Select Date',
        placement:'top'
    });*/
	$("#dlHoliday").click(function(){
		deleteHoliday($(this).attr('data'));
	});
	
	/* holiday end */
});
function clearWorkingPlans(){
		$("#WorkingPlanCancel").fadeOut('fast');
		$("#WorkingPlanDelete").fadeOut('fast');
		$("#savePlan").fadeIn();
		$("#workingDate").val("");
		$("#startTime").val("");
		$("#endTime").val("");
		$("#workingDate").prop("readonly",false);
}
/* booking Pages */
function loadConfiguration(BookingID){
	//$("#rightCol").hide();
	//$("#bookingLoader").fadeIn();
	//setTimeout(function(){$("#bookingLoader").fadeOut();$("#rightCol").fadeIn();}, 1000);
	$("#resource_id").val(BookingID);
	$("#pID").val(BookingID);
	$("#uID").val(BookingID);
	$("#pageId").val(BookingID);
	$("#pageIdLocation").val(BookingID);
	$("#WorkingPlanCancel").click();
	$("#dlPage").attr("data",BookingID);
	$("#hpageId").val(BookingID);
	loadWorkingPlans(BookingID);
	loadPageHoliDays(BookingID);
	loadBookingPagedetails(BookingID);
	loadUserNotifications(BookingID);
	loadApplicantNotifications(BookingID);
	availability(BookingID);
}
function deleteBookingPage(id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{pageId:id},
        url: url+"/deleteBookingPage",
        success: function(data){
            if(data.status=="success"){
                $('#deleteBookingPageModel').modal('hide');
				loadBookingPages();
            }
			if(data.status=="error"){
                $('#deleteBookingPageModel').modal('hide');
			}
        }
    });
}
function loadBookingPages() {
	$.ajax({
		url: $("#base_url").val()+'/loadResources',
		type:"get",
		data:{},
		success: function(data) {
			resources=data.data.resources;
			$("#sidebarBookingPages").html("");
			$("#bookingPageLinks").html("");
			if(resources.length>0){
				$("#noBookingPages").fadeOut();
				$("#manageBookingPagesTab").fadeIn();
				for(var i=0;i<resources.length;i++){
					if(i==0){
						 $("#sidebarBookingPages").append('<li id="booking_page_'+resources[i].org_user_id+'" data-id="'+resources[i].org_user_id+'" class="bookingPage active" onClick="loadConfiguration('+resources[i].org_user_id+');"><a href="javascript:void(0);">'+resources[i].name+'</a></li>');
					}else{
						$("#sidebarBookingPages").append('<li id="booking_page_'+resources[i].org_user_id+'" data-id="'+resources[i].org_user_id+'" class="bookingPage" onClick="loadConfiguration('+resources[i].org_user_id+');"><a href="javascript:void(0);">'+resources[i].name+'</a></li>');
					}
				}
			}else{
				$("#noBookingPages").fadeIn();
				$("#manageBookingPagesTab").fadeOut();
			}
			var selectedBookingPage = $('#sidebarBookingPages .bookingPage.active').attr('data-id');
			loadConfiguration(selectedBookingPage);
		}
	});
}
function addBookingPage() {
	var d = $("#frmBookingPage").serializeArray();
	$.ajax({
		url: $("#base_url").val()+'/addBookingPage',
		type:"post",
		data:d,
		success: function(data) {
			if(data.status=="success"){
                $("#sMsg").html(data.message);
                $('#ajaxSuccess').fadeIn().delay(3000).fadeOut(function(){loadBookingPages();$("#bookingPageModal").modal('hide');});
				$("#bookingPage").val("");
            }
			if(data.status=="error"){
                $("#eMsg").html(data.message);
                $('#ajaxError').fadeIn().delay(3000).fadeOut();
			}
		}
	});
}
/* booking Pages End */ 
/* Master booking Pages */ 
function loadMasterBookingPages() {
	$.ajax({
		url: $("#base_url").val()+'/loadMasterBookingPages',
		type:"get",
		data:{},
		success: function(data) {
			masterBookingPages=data.data.masterBPages;
			$("#sidebarMasterBookingPages").html("");
			if(masterBookingPages.length>0){
				$("#noMasterBookingPages").fadeOut();
				$("#manageMasterBookingPagesTab").fadeIn();
				for(var i=0;i<masterBookingPages.length;i++){
					if(i==0){
						 $("#sidebarMasterBookingPages").append('<li id="masterbooking_page_'+masterBookingPages[i].inspectionTypeId+'" data-id="'+masterBookingPages[i].inspectionTypeId+'" class="masterBookingPage active" onClick="loadMasterBookingConfiguration('+masterBookingPages[i].inspectionTypeId+');"><a href="javascript:void(0);">'+masterBookingPages[i].typeName+'</a></li>');
					}else{
						$("#sidebarMasterBookingPages").append('<li id="masterbooking_page_'+masterBookingPages[i].inspectionTypeId+'" data-id="'+masterBookingPages[i].inspectionTypeId+'" class="masterBookingPage" onClick="loadMasterBookingConfiguration('+masterBookingPages[i].inspectionTypeId+');"><a href="javascript:void(0);">'+masterBookingPages[i].typeName+'</a></li>');
					}
					
				}
			}else{
				$("#noMasterBookingPages").fadeIn();
				$("#manageMasterBookingPagesTab").fadeOut();
			}
			var selectedMasterBookingPage = $('#sidebarMasterBookingPages .masterBookingPage.active').attr('data-id');
			loadMasterBookingConfiguration(selectedMasterBookingPage);
		}
	});
}
function addMasterBookingPage() {
	var d = $("#frmMasterBookingPage").serializeArray();
	$.ajax({
		url: $("#base_url").val()+'/addMasterBookingPage',
		type:"post",
		data:d,
		success: function(data) {
			if(data.status=="success"){
                $("#sMMsg").html(data.message);
                $('#ajaxMSuccess').fadeIn().delay(3000).fadeOut(function(){loadMasterBookingPages();$("#masterBookingPageModal").modal('hide');});
				$("#masterBookingPage").val("");
            }
			if(data.status=="error"){
                $("#eMMsg").html(data.message);
                $('#ajaxMError').fadeIn().delay(3000).fadeOut();
			}
		}
	});
}
function loadMasterBookingPageLinks(id) {
	$.ajax({
		url: $("#base_url").val()+'/loadMasterBookingPagePages',
		type:"post",
		data:{pageId:id},
		success: function(data) {
			if(data.status=="success"){
				pagesLink=data.data.pageInfo;
				$("#bookingPageLinks").html("");
				if(pagesLink.length>0){
					for(var i=0;i<pagesLink.length;i++){
						if(pagesLink[i].checked==0){
							$("#bookingPageLinks").append('<tr><td><input type="checkbox" value="'+pagesLink[i].pageId+'" id="masterBookingPageLink_'+pagesLink[i].pageId+'"><label style="display: inline;font-weight: normal ;" for="masterBookingPageLink_'+pagesLink[i].pageId+'"> '+data.data.url+pagesLink[i].booking_url+'</label></td><td> '+pagesLink[i].name+'</td></tr>');
						}else{
							$("#bookingPageLinks").append('<tr><td><input type="checkbox" value="'+pagesLink[i].pageId+'" checked id="masterBookingPageLink_'+pagesLink[i].pageId+'"><label style="display: inline;font-weight: normal;" for="masterBookingPageLink_'+pagesLink[i].pageId+'"> '+data.data.url+pagesLink[i].booking_url+'</label></td><td> '+pagesLink[i].name+'</td></tr>');
						}
					}
				}else{
					$("#bookingPageLinks").html("<tr colspan=2><td>No Data Found.</td></tr>");
				}
				hideInstruction();
            }
		}
	});
}
function hideInstruction(){
	var saveChecked={};
	saveChecked.isChecked=[];
	$("#bookingPageLinks input:checkbox").each(function(){
		var $this = $(this);
		if($this.is(":checked")){
			saveChecked.isChecked.push($this.val());
		}
	});
	if(saveChecked.isChecked.length>1){
		$("#selectionInstructionDiv").fadeIn();
	}else{
		$("#masterPageInstruction").val("");
		$("#selectionInstructionDiv").fadeOut();
	}
}
function saveMasterBookingPageSetup() {
	var masterPageId=$("#masterPage_id").val();
	var pagelbl=$("#masterBookingPageLabel").val();
	var pageInst=$("#masterPageInstruction").val();
	var saveChecked={};
	saveChecked.isChecked=[];
	saveChecked.isNotChecked=[];
	$("#bookingPageLinks input:checkbox").each(function(){
		var $this = $(this);
		if($this.is(":checked")){
			saveChecked.isChecked.push($this.val());
		}else{
			saveChecked.isNotChecked.push($this.val());
		}
	});
	$.ajax({
        type:"post",
        data:{pageId:masterPageId,pagelabel:pagelbl,pageInstruction:pageInst,checkedIds:saveChecked.isChecked,unCheckedIds:saveChecked.isNotChecked},
        url: $("#base_url").val()+"/saveMasterBookingPageSetup",
        success: function(data){
            if(data.status=="success"){
                $("#masterPageSMsg").html(data.message);
                $('#masterPageSuccess').fadeIn().delay(3000).fadeOut(function(){loadMasterBookingPages();$("#masterBookingPageModal").modal('hide');});
            }
			if(data.status=="error"){
                $("#masterPageEMsg").html(data.message);
                $('#masterPageError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function loadMasterBookingConfiguration(BookingID){
	$("#masterPage_id").val(BookingID);
	$("#mPageId").val(BookingID);
	$("#dlMasterPage").attr("data",BookingID);
	loadMasterBookingPageLinks(BookingID);
	loadMasterBookingPagedetails(BookingID);
}
function deleteMasterBookingPage(id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{pageId:id},
        url: url+"/deleteMasterBookingPage",
        success: function(data){
            if(data.status=="success"){
                $('#deleteMasterBookingPageModel').modal('hide');
				loadMasterBookingPages();
            }
			if(data.status=="error"){
                $('#deleteMasterBookingPageModel').modal('hide');
			}
        }
    });
}
/* master booking page details*/
function saveMasterBookingPageDetails(){
	var url=$("#base_url").val();
	var d=$("#masterBookingPagefrm").serializeArray();
	$.ajax({
        type:"post",
        data:d,
        url: url+"/saveMasterBookingPage",
        success: function(data){
            if(data.status=="success"){
                $("#masterPageDetailsSMsg").html(data.message);
				loadMasterBookingPages();
                $('#masterPageDetailsSuccess').fadeIn().delay(3000).fadeOut();
            }
			if(data.status=="error"){
				$("#masterPageDetailsEMsg").html(data.message);
                $('#masterPageDetailsError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function loadMasterBookingPagedetails(id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{pageId:id},
        url: url+"/loadMasterBookingPageDetails",
        success: function(data){
            if(data.status=="success"){
				$("#masterPageId").val(data.data.pageInfo[0].inspectionTypeId);
                $("#masterBookingPageName").val(data.data.pageInfo[0].typeName);
				$("#masterPagePhone").val(data.data.pageInfo[0].phone);
				$("#masterPageEmail").val(data.data.pageInfo[0].email);
				$("#masterPageWelcomeMsg").val(data.data.pageInfo[0].pageInfo);
				$("#masterPageInstruction").val(data.data.pageInfo[0].instruction);
				$("#masterBookingPageLabel").val(data.data.pageInfo[0].bookingPageLabel);
				$("#mBookingPageHeading").html(data.data.pageInfo[0].booking_url);
				if(data.data.imagePath){
					$("#LogoMasterImage").html('<img src="'+data.data.imagePath+'" title="Master Booking Page Logo" />');
				}else{
					$("#LogoMasterImage").html('');
				}
				var btn="Disable";
				var statusVal=0;
				if(data.data.applicantLinkStatus=="Disabled"){
					$("#linkMasterError").fadeIn();
					stsMSG="People who click the Master booking page link will only see the page details below. Please make any desired changes and save. ";
					$("#linkMasterEMsg").html(stsMSG);
					btn="Enable";
					statusVal=1;
				}else{
					$("#linkMasterError").fadeOut();
					$("#linkMasterEMsg").html("");
				}
                $("#applicantMasterLink").html('<h3>Customer Link</h3><h4><a href="'+data.data.applicantLink+'" target="_blank">'+data.data.applicantLink+'</a></h4>');
				$("#applicantMasterLink").append('<button class="btn btn-primary" data-val="'+statusVal+'" id="btnMasterLinkStatus">'+btn+'</button> &nbsp;&nbsp;('+data.data.applicantLinkStatus+')');
            }
        }
    });
}
function saveMasterLinkStatus(sts){
	var id=$("#masterPage_id").val();
	$.ajax({
		url: $("#base_url").val()+'/saveMasterApplicantStatus',
		type:"post",
		data:{pageId:id,status:sts},
		success: function(data) {
			if(data.status=="success"){
				var btn="Disable";
				var statusVal=0;
				if(data.data.applicantLinkStatus=="Disabled"){
					$("#linkMasterError").fadeIn();
					stsMSG="People who click the Master booking page link will only see the page details below. Please make any desired changes and save. ";
					$("#linkMasterEMsg").html(stsMSG);
					btn="Enable";
					statusVal=1;
				}else{
					$("#linkMasterError").fadeOut();
					$("#linkMasterEMsg").html("");
				}
                $("#applicantMasterLink").html('<h3>Customer Link</h3><h4><a href="'+data.data.applicantLink+'" target="_blank">'+data.data.applicantLink+'</a></h4>');
				$("#applicantMasterLink").append('<button class="btn btn-primary" data-val="'+statusVal+'" id="btnMasterLinkStatus">'+btn+'</button> &nbsp;&nbsp;('+data.data.applicantLinkStatus+')');
            }
		}
	});
}
/* master booking page details end */
/* Master booking Pages End */
function availability(id){
	$('#dateSpecificCalendar').fullCalendar('destroy');
	loadUserWorkingPlans(id);
}
function saveLinkStatus(sts){
	var id=$("#resource_id").val();
	$.ajax({
		url: $("#base_url").val()+'/saveApplicantStatus',
		type:"post",
		data:{pageId:id,status:sts},
		success: function(data) {
			if(data.status=="success"){
				var btn="Disable";
				var statusVal=0;
				if(data.data.applicantLinkStatus=="Disabled"){
					$("#linkError").fadeIn();
					stsMSG="People who click the Booking page link will only see the page details below. In the Master booking page, no information about this page will be available. You will receive no bookings from this Booking page.";
					$("#linkEMsg").html(stsMSG);
					btn="Enable";
					statusVal=1;
					disableAllSave();
				}else{
					$("#linkError").fadeOut();
					$("#linkEMsg").html("");
					enableAllSave();
				}
                $("#applicantLink").html('<h3>Customer Link</h3><h4><a href="'+data.data.applicantLink+'" target="_blank">'+data.data.applicantLink+'</a></h4>');
				$("#applicantLink").append('<button class="btn btn-primary" data-val="'+statusVal+'" id="btnLinkStatus">'+btn+'</button> &nbsp;&nbsp;('+data.data.applicantLinkStatus+')');
            }
		}
	});
}
function disableAllSave(){
	$("#btnBooking").prop("disabled",true);
	$("#btnAvailability").prop("disabled",true);
	$("#savePlan").prop("disabled",true);
	$("#btnLocation").prop("disabled",true);
	$("#btnUsernotification").prop("disabled",true);
	$("#btnCustomernotification").prop("disabled",true);
}
function enableAllSave(){
	$("#btnBooking").prop("disabled",false);
	$("#btnAvailability").prop("disabled",false);
	$("#savePlan").prop("disabled",false);
	$("#btnLocation").prop("disabled",false);
	$("#btnUsernotification").prop("disabled",false);
	$("#btnCustomernotification").prop("disabled",false);
}
/* weekly-recurring */
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
function loadWorkingPlans(id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{resourceId:id},
        url: url+"/loadWorkingPlans",
        success: function(data){
			setupWorkingPlan($.parseJSON(data.data.slots));
        }
    });
}
function getSettings(){
	var settings = [];
    
    // Availability
    settings.push({
        'name': 'org_working_plans',
        'value': JSON.stringify(getWorkingPlan())
    });
    
    /*settings.push({
        'name': 'book_advance_timeout',
        'value': $('#book-advance-timeout').val()
    });*/
    return settings;
}
function saveWorkingPlans(set){
	var url=$("#base_url").val();
	var rid=$("#resource_id").val();
	$.ajax({
        type:"post",
        data:{settings:JSON.stringify(set),resourceId:rid},
        url: url+"/saveWorkingPlans",
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
        if (workingDay !== null) {
            $('#' + index).prop('checked', true);
            $('#' + index + '-start').val(workingDay.start);
            $('#' + index + '-end').val(workingDay.end);
			$('#' + index + '-gap').val(workingDay.time_slots);
			$('#' + index + '-start').prop('disabled', false);
            $('#' + index + '-end').prop('disabled', false);
			$('#' + index + '-gap').prop('disabled', false);
        } else {
            $('#' + index).prop('checked', false);
			$('#' + index + '-start').val("");
            $('#' + index + '-end').val("");
			$('#' + index + '-gap').val("");
            $('#' + index + '-start').prop('disabled', true);
            $('#' + index + '-end').prop('disabled', true);
			$('#' + index + '-gap').prop('disabled', true);
        }
    });
}
function loadTimeSlots(DATE){
	$.ajax({
        type:"post",
        data:{selected_date:DATE},
        url: $("#current_url").val()+'/loadTimeSlots',
        success: function(data){
			$("#orgslots").html("");
			if(data.data.slots.length==0){
				$("#orgslots").html("No Slots Available.");
				return;
			}
			for(var i=0;i<data.data.slots.length;i++){
				$("#orgslots").append("<label><input type='radio' value='"+data.data.slots[i]+"' name='slt'>&nbsp;&nbsp;"+data.data.slots[i]+"&nbsp;&nbsp;</label>");
			}
        }
    });
}
/* weekly-recurring end */
/* date-specific */
function loadUserWorkingPlan(dt,id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{'planDate':dt,'user_id':id},
        url: url+"/loadResourceWorkingPlan",
        success: function(data){
            if(data.status=="success"){
				$("#WorkingPlanCancel").fadeIn();
				$("#WorkingPlanDelete").fadeIn();
				$("#WorkingPlanDelete").attr("data-id",data.data.planInfo.date);
				$("#workingDate").val(data.data.planInfo.date);
				$("#workingDate").prop("readonly",true);
				$("#startTime").val(data.data.planInfo.start);
				$("#endTime").val(data.data.planInfo.end);
            }
			if(data.status=="error"){
                
			}
        }
    });
}
function loadUserWorkingPlans(id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{'user_id':id},
		async:false,
        url: url+"/loadResourceWorkingPlans",
        success: function(data){
            if(data.status=="success"){
				dateSpecificCal(data.data.userWorkingPlans);
            }
        }
    });
}
function createPlan(){
	var d = $("#frmPlan").serializeArray();
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:d,
        url: url+"/createResourceWorkingPlan",
        success: function(data){
            if(data.status=="success"){
                $("#planSMsg").html(data.message);
				$("#workingDate").val("");
				$("#startTime").val("");
				$("#endTime").val("");
                $('#planSuccess').fadeIn().delay(3000).fadeOut();
				$('#dateSpecificCalendar').fullCalendar('destroy');
				availability($("#resource_id").val());
            }
			if(data.status=="error"){
                $("#planEMsg").html(data.message);
                $('#planError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function displayDeleteWorkingPlan(){
	$('#deleteWorkingPlanModel').modal('show');
	$("#dlPlan").attr("data",$("#WorkingPlanDelete").attr("data-id"));
}
function deleteWorkingPlan(dt){
	var url=$("#base_url").val();
	var uid=$("#uID").val();
	$.ajax({
        type:"post",
        data:{workingDate:dt,uID:uid},
        url: url+"/deleteResourceWorkingPlan",
        success: function(data){
            if(data.status=="success"){
                $('#deleteWorkingPlanModel').modal('hide');
				$('#dateSpecificCalendar').fullCalendar('destroy');
				$('#WorkingPlanCancel').click();
				availability($("#resource_id").val());
            }
			if(data.status=="error"){
                $('#deleteWorkingPlanModel').modal('hide');
				$("#planEMsg").html(data.message);
                $('#planError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
calendarEventClick = function(event, jsEvent, view) {
		var startDT=new Date(event.start);
		var d = startDT.getDate();
		var m = startDT.getMonth();
		var y = startDT.getFullYear();
		loadUserWorkingPlan(y+"-"+(m+1)+"-"+d,$("#resource_id").val());
}
function dateSpecificCal(workingPlan){
	clearWorkingPlans();
	$('#dateSpecificCalendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		height:500,
		firstDay:1,
		editable:true,
		eventClick: calendarEventClick,
		eventSources: [
        // your event source
		{
			events: workingPlan,
            color: 'green',     // an option!
            textColor: 'white' // an option!
        }
    ]
	});
}
/* date-specific end */
/* booking page details*/
function saveBookingPageDetails(){
	var url=$("#base_url").val();
	var d=$("#bookingPagefrm").serializeArray();
	$.ajax({
        type:"post",
        data:d,
        url: url+"/saveBookingPage",
        success: function(data){
            if(data.status=="success"){
                $("#pageSMsg").html(data.message);
				loadBookingPages();
                $('#pageSuccess').fadeIn().delay(3000).fadeOut();
            }
			if(data.status=="error"){
				$("#pageEMsg").html(data.message);
                $('#pageError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function loadBookingPagedetails(id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{pageId:id},
        url: url+"/loadBookingPageDetails",
        success: function(data){
            if(data.status=="success"){
                $("#bookingPageName").val(data.data.pageInfo[0].name);
				$("#pagePhone").val(data.data.pageInfo[0].mobileNo);
				$("#pageEmail").val(data.data.pageInfo[0].email);
				$("#pageWelcomeMsg").val(data.data.pageInfo[0].pageInfo);
				$("#location").val(data.data.pageInfo[0].location);
				$("#bookingPageHeading").html(data.data.pageInfo[0].booking_url);
				if(data.data.imagePath){
					$("#LogoImage").html('<img src="'+data.data.imagePath+'" title="Booking Page Logo" />');
				}else{
					$("#LogoImage").html('');
				}
				var btn="Disable";
				var statusVal=0;
				if(data.data.applicantLinkStatus=="Disabled"){
					$("#linkError").fadeIn();
					stsMSG="People who click the Booking page link will only see the page details below. In the Master booking page, no information about this page will be available. You will receive no bookings from this Booking page.";
					$("#linkEMsg").html(stsMSG);
					btn="Enable";
					statusVal=1;
					disableAllSave();
				}else{
					$("#linkError").fadeOut();
					$("#linkEMsg").html("");
					enableAllSave();
				}
				if(data.data.pageInfo[0].isAutomaticBooking==0){
					$("#bookingApproval").prop("checked",true);
				}else{
					$("#bookingAuto").prop("checked",true);
				}
                $("#applicantLink").html('<h3>Customer Link</h3><h4><a href="'+data.data.applicantLink+'" target="_blank">'+data.data.applicantLink+'</a></h4>');
				$("#applicantLink").append('<button class="btn btn-primary" data-val="'+statusVal+'" id="btnLinkStatus">'+btn+'</button> &nbsp;&nbsp;('+data.data.applicantLinkStatus+')');
            }
        }
    });
}

/* booking page details end */
/* user notifications */
function loadUserNotifications(id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{pageId:id},
        url: url+"/loadUserNotifications",
        success: function(data){
            if(data.status=="success"){
                $("#uName").html(data.data.userNotifications.userName);
				var noOnBooking=data.data.userNotifications.notify_on_booking;
				var noOnBookingRequest=data.data.userNotifications.notify_on_booking_request;
				var noOnCancel=data.data.userNotifications.notify_on_cancellations;
				var ccOnRem=data.data.userNotifications.cc_on_applicant_reminders;
				var ccOnFollowEmail=data.data.userNotifications.cc_on_followup_emails;
				$("#no_on_booking").val(noOnBooking);
				$("#no_on_booking_req").val(noOnBooking);
				$("#no_on_cancel").val(noOnBooking);
				$("#cc_on_cus_rem").val(noOnBooking);
				$("#cc_on_follow_email").val(noOnBooking);
				if(noOnBooking==1){
					$("#no_on_booking").attr("checked","checked");
				}
				if(noOnBookingRequest==1){
					$("#no_on_booking_req").attr("checked","checked");
				}
				if(noOnCancel==1){
					$("#no_on_cancel").attr("checked","checked");
				}
				if(ccOnRem==1){
					$("#cc_on_cus_rem").attr("checked","checked");
				}
				if(ccOnFollowEmail==1){
					$("#cc_on_follow_email").attr("checked","checked");
				}
            }
        }
    });
}
function saveUserNotifications(){
	var url=$("#base_url").val();
	var onBooking;
	var onRequest;
	var oncancel;
	var ccOnRem;
	var ccOnEmail;
	if($("#no_on_booking").prop('checked') == true)onBooking=1; else onBooking=0;
	if($("#no_on_booking_req").prop('checked') == true)onRequest=1;else onRequest=0;
	if($("#no_on_cancel").prop('checked') == true)oncancel=1;else oncancel=0;
	if($("#cc_on_cus_rem").prop('checked') == true)ccOnRem=1;else ccOnRem=0;
	if($("#cc_on_follow_email").prop('checked') == true)ccOnEmail=1;else ccOnEmail=0;
	$.ajax({
        type:"post",
        data:{no_on_booking:onBooking,no_on_booking_req:onRequest,no_on_cancel:oncancel,cc_on_cus_rem:ccOnRem,cc_on_follow_email:ccOnEmail},
        url: url+"/saveUserNotifications",
        success: function(data){
            if(data.status=="success"){
                $("#userNSMsg").html(data.message);
                $('#userNSuccess').fadeIn().delay(3000).fadeOut();
            }
			if(data.status=="error"){
				$("#userNEMsg").html(data.message);
                $('#userNError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
/* user notification end */
/* applicant notification*/
function loadApplicantNotifications(id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{pageId:id},
        url: url+"/loadApplicantNotifications",
        success: function(data){
            if(data.status=="success"){
                $("#reminderNote").val(data.data.applicantNotifications.reminderNote);
				$("#followEmailNote").val(data.data.applicantNotifications.followupEmailNote);
				if(data.data.applicantNotifications.followupEmailVal){
					$("#followReminderVal").val(data.data.applicantNotifications.followupEmailVal);
					$("#checkFollowup").prop("checked",true);
				}else{
					$("#checkFollowup").prop("checked",false);
					$("#followReminderVal").prop("disabled",true);
				}
				var reminderVal=data.data.applicantNotifications.reminderVal;
				var rem0,rem1,rem2;
				if(reminderVal && reminderVal[0]){
					rem0=reminderVal[0];
					$("#reminderVal0").val(rem0);
					$("#checkReminder0").prop("checked",true);
				}else{
					rem0="";
				}
				if(reminderVal && reminderVal[1]){
					rem1=reminderVal[1];
					$("#reminderVal1").val(rem1);
					$("#checkReminder1").prop("checked",true);
				}else{
					rem1="";
				}
				if(reminderVal && reminderVal[2]){
					rem2=reminderVal[2];
					$("#reminderVal2").val(rem2);
					$("#checkReminder2").prop("checked",true);
				}else{
					rem2="";
				}
				
            }
        }
    });
}
function saveApplicantNotifications(){
	var url=$("#base_url").val();
	var resId=$("#resource_id").val();
	var remVal=[];
	var rem1,rem2,rem3;
	rem1=$("#reminderVal0").val();
	rem2=$("#reminderVal1").val();
	rem3=$("#reminderVal2").val();
	remVal.push(rem1,rem2,rem3);
	var remNote=$("#reminderNote").val();
	var followNote=$("#followEmailNote").val();
	var followVal=$("#followReminderVal").val();
	$.ajax({
        type:"post",
        data:{bookingPageId:resId,reminderVal:remVal,reminderNote:remNote,followupEmailVal:followVal,followupEmailNote:followNote},
        url: url+"/saveApplicantNotifications",
        success: function(data){
            if(data.status=="success"){
                $("#CusNSMsg").html(data.message);
                $('#CusNSuccess').fadeIn().delay(3000).fadeOut();
            }
			if(data.status=="error"){
				$("#CusNEMsg").html(data.message);
                $('#CusNError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function customerSettings(){
	$("#checkReminder0").on('change',  function() {
		if($(this).prop('checked') == false){
			$("#reminderVal0").prop("disabled", "disabled");
			$("#reminderVal0").val("none");
		}else{
			$("#reminderVal0").prop("disabled", false);
		}
    });
	$("#checkReminder1").on('change',  function() {
		if($(this).prop('checked') == false){
			$("#reminderVal1").prop("disabled", "disabled");
			$("#reminderVal1").val("none");
		}else{
			$("#reminderVal1").prop("disabled", false);
		}
    });
	$("#checkReminder2").on('change',  function() {
		if($(this).prop('checked') == false){
			$("#followReminderVal").prop("disabled", "disabled");
			$("#followReminderVal").val("none");
		}else{
			$("#followReminderVal").prop("disabled", false);
		}
    });
	$("#checkFollowup").on('change',  function() {
		if($(this).prop('checked') == false){
			$("#reminderVal2").prop("disabled", "disabled");
			$("#reminderVal2").val("none");
		}else{
			$("#reminderVal2").prop("disabled", false);
		}
    });
	var boxes = $("#checkReminder0, #checkReminder1,#checkReminder2");
		boxes.on('change',  function() {
		   var disabled = boxes.filter(':checked').length>0;
		   if(disabled){
				$("#reminderNote").prop("disabled", false);
			}else{
				$("#reminderNote").val("");	
				$("#reminderNote").prop("disabled", true);			
			}
    });
	var boxes1 = $("#checkFollowup");
		boxes1.on('change',  function() {
		   var disabled = boxes1.filter(':checked').length>0;
		   if(disabled){
				$("#followEmailNote").prop("disabled", false);
			}else{
				$("#followEmailNote").val("");
				$("#followEmailNote").prop("disabled", true);	
			}
    });
}
/* applicant notification end */
/* location */
function saveLocation(){
	var url=$("#base_url").val();
	var d=$("#location_frm").serializeArray();
	$.ajax({
        type:"post",
        data:d,
        url: url+"/saveLocation",
        success: function(data){
            if(data.status=="success"){
                $("#locationSMsg").html(data.message);
                $('#locationSuccess').fadeIn().delay(3000).fadeOut();
            }
			if(data.status=="error"){
				$("#locationEMsg").html(data.message);
                $('#locationError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
/* location end */
/* Booking */
function saveBooking(){
	var url=$("#base_url").val();
	var id=$("#resource_id").val();
	var bookingVal=$("input[name=bookingAuto]:checked").val();
	$.ajax({
        type:"post",
        data:{pageId:id,bookingAuto:bookingVal},
        url: url+"/saveBookingAuto",
        success: function(data){
            if(data.status=="success"){
                $("#bookingSMsg").html(data.message);
                $('#bookingSuccess').fadeIn().delay(3000).fadeOut();
            }
			if(data.status=="error"){
				$("#bookingEMsg").html(data.message);
                $('#bookingError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
/* Booking end */
/* holiday func */
function addHoliDay(){
	var d = $("#frmHoliDay").serializeArray();
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:d,
        url: url+'/addHoliday',
        success: function(data){
            if(data.status=="success"){
                $("#HolidaySMsg").html(data.message);
                $('#HolidaySuccess').fadeIn().delay(3000).fadeOut();
				var pageID=$("#resource_id").val();
				loadPageHoliDays(pageID);
				clearHoliday();
            }
			if(data.status=="error"){
                $("#HolidayEMsg").html(data.message);
                $('#HolidayError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function loadPageHoliDays(pageID){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{pageId:pageID},
        url: url+'/loadPageHolidays',
        success: function(data){
			$("#holiData").html("");
            if(data.status=="success"){
               var holidays=data.data.holidays;
			   if(holidays.length>0){
					for(var i=0;i<holidays.length;i++){
						$("#holiData").append('<tr><td>'+(i+1)+'</td><td><a href="javascript:void(0);" onClick="displayUpdateHoliday('+holidays[i].id+');">'+holidays[i].title+'</td><td>'+holidays[i].startdate+'</td><td>'+holidays[i].enddate+'</td><td><a href="javascript:void(0);" onClick="displayUpdateHoliday('+holidays[i].id+');"><i class="fa fa-pencil"></i></a></td><td><a href="javascript:void(0);" onClick="displayDeleteHoliday('+holidays[i].id+');"><i class="fa fa-times"></i></a></td></tr>');
					}
			   }else{
				$("#holiData").html('<td colspan=5><h3 class="text-center">There is No Holidays Found.</h3></td>');
			   }
            }
			if(data.status=="error"){
               
			}
        }
    });
}
function updateHoliDay(){
	var d = $("#frmHoliDay").serializeArray();
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:d,
        url: url+'/updateHoliday',
        success: function(data){
            if(data.status=="success"){
                $("#HolidaySMsg").html(data.message);
                var pageID=$("#resource_id").val();
				$('#HolidaySuccess').fadeIn().delay(3000).fadeOut();
				loadPageHoliDays(pageID);
				clearHoliday();
            }
			if(data.status=="error"){
                $("#HolidayEMsg").html(data.message);
                $('#HolidayError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function displayDeleteHoliday(id){
	$('#deleteHolidayModel').modal('show');
	$("#dlHoliday").attr("data",id);
}
function displayUpdateHoliday(id){
	$("#hId").val(id);
	loadHoli(id);
	$("#btnAddHoliday").fadeOut();
	$("#btnUpdateHoliday").fadeIn();
}
function loadHoli(ID){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{hId:ID},
        url: url+'/loadHoliday',
        success: function(data){
            if(data.status=="success"){
				var holidayData=data.data.holiday;
                if(holidayData.length>0){
					$("#title").val(holidayData[0].title);
					$("#startdate").val(holidayData[0].start);
					$("#enddate").val(holidayData[0].end);
				}
            }
			if(data.status=="error"){
                $("#HolidayEMsg").html(data.message);
                $('#HolidayError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function deleteHoliday(ID){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{hId:ID},
        url: url+'/deleteHoliday',
        success: function(data){
            if(data.status=="success"){
				$("#deleteHolidayModel").modal('hide');
                var pageID=$("#resource_id").val();
				loadPageHoliDays(pageID);
            }
			if(data.status=="error"){
                $("#errorMSG").html(data.message);
                $('#error').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function clearHoliday(){
	$("#hId").val("");
	$("#btnUpdateHoliday").fadeOut();
	$("#btnAddHoliday").fadeIn();
	$("#title").val("");
	$("#startdate").val("");
	$("#enddate").val("");
}
/* holiday func end*/