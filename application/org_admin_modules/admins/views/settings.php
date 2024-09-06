<script>
  $(function () {
    $('#myTab a:first').tab('show')
  })
</script>
<style>
.tab-pane {

    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    border-radius: 0px 0px 5px 5px;
    padding: 10px;
}
.nav-tabs {
    margin-bottom: 0;
}
</style>
<div id="settings-page" class="span12">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
		<li role="presentation" class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
		<li role="presentation"><a href="#business-logic" role="tab" data-toggle="tab">Business Hours</a></li>
    </ul>
    <div class="tab-content">
		<div role="tabpanel" class="tab-pane fade in active" id="general">
			<input type="hidden" value="<?php echo base_url($this->schedular_auth->makeBaseURL()); ?>" id="base_url"/>
				<div class="row">
					<div class="span7">
						<div class="alert alert-warning alert-dismissible" role="alert" id="generalError" style="display:none;">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<strong>Errors !!!</strong> <span id="generalEMsg"></span>
						</div>
						<div class="alert alert-success alert-dismissible" role="alert" id="generalSuccess" style="display:none;">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<strong>Success !!!</strong> <span id="generalSMsg"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<fieldset class="span7">
						<form role="form" id="frmGeneral">
							<legend>
								<?php echo "Organization Information"; ?>
							</legend>
						  <div class="form-group">
							<label for="org_title">Organization Title *</label>
							<input type="text" class="form-control" name="org_title" id="org_title" value="<?php if(isset($orgTitle) && $orgTitle)echo $orgTitle; ?>" placeholder="Organization Name">
							<input type="hidden" name="org_id" value="<?php if(isset($orgID) && $orgID)echo $orgID; ?>">
						  </div>
						  <div class="form-group">
							<label for="orgurl">Organization URL *</label>
							<input type="text" class="form-control" name="org_url" id="orgurl" value="<?php if(isset($orgURL) && $orgURL)echo $orgURL;?>" disabled placeholder="Organization URL">
						  </div>
						  <div class="form-group">
							<label for="orgPhoneNumber">Organization Phone Number </label>
							<input type="text" class="form-control" name="orgPhoneNumber" id="orgPhoneNumber" value="<?php if(isset($org_phone) && $org_phone)echo $org_phone;?>" placeholder="Organization Phone Number">
						  </div>
						  <div class="form-group">
							<label for="orgEmail">Organization Email </label>
							<input type="text" class="form-control" name="orgEmail" id="orgEmail" value="<?php if(isset($org_email) && $org_email)echo $org_email;?>" placeholder="Organization Email">
						  </div>
						  <button type="button" class="btn btn-primary" id="orgInfo">Save Changes</button>
					  </form>
					</fieldset>
					<fieldset class="span4">
						 <div class="form-group">
							<label for="orglogo">Organization Logo</label>
							<input type="hidden" id="pageName" value="organization"/>
							<input type="hidden" id="pageId" value="<?php if(isset($orgID) && $orgID)echo $orgID; ?>">
							<?php echo Modules::run('upload'); ?>
						 </div>
					</fieldset>
				</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="business-logic">
			<div class="row">
				<form>
					<fieldset class="span10">
						<legend>
							<?php echo "Business Hours"; ?>
							<button type="button" class="save-settings btn btn-primary  btn-xs" id="businessLogic">
								Save
							</button>
						</legend>
								<div class="alert alert-warning alert-dismissible" role="alert" id="businessError" style="display:none;">
										<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<strong>Errors !!!</strong> <span id="businessEMsg"></span>
								</div>
								<div class="alert alert-success alert-dismissible" role="alert" id="businessSuccess" style="display:none;">
										<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<strong>Success !!!</strong> <span id="businessSMsg"></span>
								</div>
								<span class="help-block">
									Mark below the days and hours that your Organization will accept appointments.Applicants will not be able to book appointments by themselves in non working periods. This working plan will be the default for every new applicants.
								</span>
								
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Day</th>
											<th>Start</th>
											<th>End</th>
											<th>Appointment Gap</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="monday" />Monday</label></td>
											<td class="working-plan"><input type="text" class="form-control" id="monday-start"/></td>
											<td class="working-plan"><input type="text" class="form-control" id="monday-end"/></td>
											<td><input type="text" class="form-control" id="monday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
										</tr>
										<tr>
											<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="tuesday" />Tuesday</label></td>
											<td class="working-plan"><input type="text" class="form-control" id="tuesday-start"/></td>
											<td class="working-plan"><input type="text" class="form-control" id="tuesday-end"/></td>
											<td><input type="text" class="form-control" id="tuesday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
										</tr>
										<tr>
											<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="wednesday" />Wednesday</label></td>
											<td class="working-plan"><input type="text" class="form-control" id="wednesday-start"/></td>
											<td class="working-plan"><input type="text" class="form-control" id="wednesday-end"/></td>
											<td><input type="text" class="form-control" id="wednesday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
										</tr>
										<tr>
											<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="thursday" />Thursday</label></td>
											<td class="working-plan"><input type="text" class="form-control" id="thursday-start"/></td>
											<td class="working-plan"><input type="text" class="form-control" id="thursday-end"/></td>
											<td><input type="text" class="form-control" id="thursday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
										</tr>
										<tr>
											<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="friday" />Friday</label></td>
											<td class="working-plan"><input type="text" class="form-control" id="friday-start"/></td>
											<td class="working-plan"><input type="text" class="form-control" id="friday-end"/></td>
											<td><input type="text" class="form-control" id="friday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
										</tr>
										<tr>
											<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="saturday" />Saturday</label></td>
											<td class="working-plan"><input type="text" class="form-control" id="saturday-start"/></td>
											<td class="working-plan"><input type="text" class="form-control" id="saturday-end"/></td>
											<td><input type="text" class="form-control" id="saturday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
										</tr>
										<tr>
											<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="sunday" />Sunday</label></td>
											<td class="working-plan"><input type="text" class="form-control" id="sunday-start"/></td>
											<td class="working-plan"><input type="text" class="form-control" id="sunday-end"/></td>
											<td><input type="text" class="form-control" id="sunday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
										</tr>
									</tbody>
								</table>
								
								<br>
								
								<!--<h4>Book Advance Timeout</h4>
								<span class="help-block">
									Define the timeout (in minutes) before the Applicant can book appointments with the Organization. 
								</span>
								
								<label for="book-advance-timeout">Timeout (Minutes)</label>
								<input type="text" class="form-control" id="book-advance-timeout" data-field="book_advance_timeout" />-->
					</fieldset>
				</form>
			</div>
		</div>
    </div>
</div>
<link href='<?php echo base_url1().'admins/assets/css/jquery-ui.min.css'; ?>' rel='stylesheet' />
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/jquery-ui.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/jquery-ui-timepicker-addon.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/jquery.jeditable.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/settings_js.js'; ?>"></script>