	<div class="pull-right">
		<button class="btn btn-primary" data-toggle="modal" data-target="#HolidayModel">
		  Add Holiday
		</button>
	</div>
	<div class="row">
		<div class="span12">
			<table class="table">
				<thead>
					<tr>
						<th>Sr.No</th>
						<th>Title</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Status</th>
						<th>Created On</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($holidays) && $holidays && count($holidays)>0):
						foreach($holidays as $index=>$holi): ?>
						<tr>
							<td><?php echo ($index+1); ?></td>
							<td><a href="javascript:void(0);" onClick="displayUpdateHoliday(<?php echo $holi->id; ?>);"><?php echo $holi->title; ?></a></td>
							<td><?php echo $holi->startdate; ?></td>
							<td><?php echo $holi->enddate; ?></td>
							<td><?php echo ($holi->status==1)?"Active":"Inactive"; ?></td>
							<td><?php echo $holi->createdOn; ?></td>
							<td><a href="javascript:void(0);" onClick="displayUpdateHoliday(<?php echo $holi->id; ?>);"><i class="fa fa-pencil"></i></a></td>
							<td><a href="javascript:void(0);" onClick="displayDeleteHoliday(<?php echo $holi->id; ?>);"><i class="fa fa-times"></i></a></td>
						</tr>
					<?php endforeach;?>
					<?php else:?>
							<tr>
								<td colspan=6><h3 class="text-center">There is No Holidays Found.</h3></td>	
							</tr>
					<?php endif; ?>
				</tbody>
			</table>
			
		</div>
	</div>

<!-- Modal Holiday-->
<div class="modal fade" id="HolidayModel" tabindex="-1" role="dialog" aria-labelledby="myHolidayLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myHolidayLabel">Add Holiday</h4>
      </div>
      <div class="modal-body">
			<div class="alert alert-warning alert-dismissible" role="alert" id="HolidayError" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Errors !!!</strong> <span id="HolidayEMsg"></span>
			</div>
			<div class="alert alert-success alert-dismissible" role="alert" id="HolidaySuccess" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Success !!!</strong> <span id="HolidaySMsg"></span>
			</div>
			<!-- BEGIN FORM-->
			<form role="form" method="post" id="frmHoliDay">
			  <div class="form-group">
				<label for="title">Holiday Title</label>
				<input type="text" class="form-control" name="title" id="title" placeholder="Title">
				<input type="hidden" name="org_id" value="<?php echo $org_id; ?>">
				<input type="hidden" name="hId" id="hId">
			  </div>
			  <div class="form-group">
				<label for="startdate">Start Date</label>
				<div class="input-group date schedular">
				  <input type="text" name="startdate" id="startdate" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
				</div>
			  </div>
			  <div class="form-group">
				<label for="enddate">End Date</label>
				<div class="input-group date schedular">
				  <input type="text" name="enddate" id="enddate" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
				</div>
			  </div>
						  
			  <button type="button" id="btnAddHoliday" class="btn btn-primary">Submit</button>
			  <button type="button" id="btnUpdateHoliday" class="btn btn-primary" style="display:none;">Update</button>
			  <button type="button" id="btnCancelHoliday" class="btn btn-primary" data-dismiss="modal">Cancel</button>
			</form>
			<!-- END FORM-->
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteHolidayModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Holiday</h4>
      </div>
      <div class="modal-body">
			<div class="alert alert-warning alert-dismissible" role="alert" id="error" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Errors !!!</strong> <span id="errorMSG"></span>
			</div>
					Are You Sure ? You Want To Delete This Holiday.
      </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="dlHoliday">Delete</button>
      </div>
    </div>
  </div>
</div>
<link href='<?php echo base_url1().'users/assets/css/datepicker3.css'; ?>' rel='stylesheet' />
<script type="text/javascript" src="<?php echo base_url1().'users/assets/js/bootstrap-datepicker.js'; ?>"></script>
<script>
$(document).ready(function() {
	$("#btnAddHoliday").click(function(){
		addHoliDay();
	});
	$("#btnUpdateHoliday").click(function(){
		updateHoliDay();
	});
	$("#btnCancelHoliday").click(function(){
		$("#hId").val("");
	});
	$('.date.schedular').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
	$(".input-group.date").tooltip({
        container:'body',
        trigger: 'hover focus',
        title:'Click To Select Date',
        placement:'top'
    });
	$('#HolidayModel').on('hidden.bs.modal', function (e) {
		$("#hId").val("");
		$("#myHolidayLabel").html("Add Holiday");
		$("#btnUpdateHoliday").fadeOut();
		$("#btnAddHoliday").fadeIn();
		$("#title").val("");
		$("#startdate").val("");
		$("#enddate").val("");
    });
	$("#dlHoliday").click(function(){
		deleteHoliday($(this).attr('data'));
	});
});

function addHoliDay(){
	var d = $("#frmHoliDay").serializeArray();
	$.ajax({
        type:"post",
        data:d,
        url: '<?php echo base_url($this->schedular_auth->makeBaseURL("addHoliday")); ?>',
        success: function(data){
            if(data.status=="success"){
                $("#HolidaySMsg").html(data.message);
                $('#HolidaySuccess').fadeIn().delay(3000).fadeOut(function(){location.reload();});
            }
			if(data.status=="error"){
                $("#HolidayEMsg").html(data.message);
                $('#HolidayError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function updateHoliDay(){
	var d = $("#frmHoliDay").serializeArray();
	$.ajax({
        type:"post",
        data:d,
        url: '<?php echo base_url($this->schedular_auth->makeBaseURL("updateHoliday")); ?>',
        success: function(data){
            if(data.status=="success"){
                $("#HolidaySMsg").html(data.message);
                $('#HolidaySuccess').fadeIn().delay(3000).fadeOut(function(){location.reload();});
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
	$("#myHolidayLabel").html("Update Holiday");
	$("#btnAddHoliday").fadeOut();
	$("#btnUpdateHoliday").fadeIn();
	$('#HolidayModel').modal('show');
}
function loadHoli(ID){
	$.ajax({
        type:"post",
        data:{hId:ID},
        url: '<?php echo base_url($this->schedular_auth->makeBaseURL("loadHoliday")); ?>',
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
	$.ajax({
        type:"post",
        data:{hId:ID},
        url: '<?php echo base_url($this->schedular_auth->makeBaseURL("deleteHoliday")); ?>',
        success: function(data){
            if(data.status=="success"){
                location.reload();
            }
			if(data.status=="error"){
                $("#errorMSG").html(data.message);
                $('#error').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
</script>