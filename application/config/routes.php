<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
require_once( BASEPATH .'database/DB'. EXT );
$db =& DB();
$query = $db->get('organizations');

$result = $query->result();
foreach($result as $row)
{
    $query1 = $db->get('users');
    $where = "(isSuperAdmin=0 and status=1 and IsDeleted=0)";
    $db->where($where);
    $result1 = $query1->result();
    foreach($result1 as $row1)
    {
        $route[ $row->org_url."/".$row1->booking_url."/loadholidaysData"] = 'applicant/loadholidaysData';
        $route[ $row->org_url."/".$row1->booking_url."/createAppointment"] = 'applicant/createAppointment';
        $route[ $row->org_url."/".$row1->booking_url."/createAppointmentMaster"] = 'applicant/createAppointmentMaster';
        $route[ $row->org_url."/".$row1->booking_url."/updateAppointment"] = 'applicant/updateAppointment';
        $route[ $row->org_url."/".$row1->booking_url."/loadAppointments"] = 'applicant/loadAppointments';
        $route[ $row->org_url."/".$row1->booking_url."/loadAppointmentTypes"] = 'applicant/loadAppointmentTypes';
        $route[ $row->org_url."/".$row1->booking_url."/loadAppointmentTypes"] = 'appointments/loadAppointmentTypes';
        $route[ $row->org_url."/".$row1->booking_url."/loadsessionAppData"] = 'applicant/loadsessionAppData';
        $route[ $row->org_url."/".$row1->booking_url."/loadResourceWorkingPlans"] = 'users/loadUserWorkingPlans';
        $route[ $row->org_url."/".$row1->booking_url."/setTimeZone"] = 'applicant/setTimeZone';
        $route[ $row->org_url."/".$row1->booking_url."/getTime"] = 'applicant/getTime';

        //$route[ $row->org_url] = 'applicant';
        $route[ $row->org_url."/".$row1->booking_url] = 'applicant';
        $route[ $row->org_url."/".$row1->booking_url."/:any"] = 'applicant';
        $route[ $row->org_url."/".$row1->booking_url."/loadTimeSlots"] = 'applicant/loadTimeSlots';
        $route[ $row->org_url."/".$row1->booking_url."/loadTimeSlotsMaster"] = 'applicant/loadTimeSlotsMaster';
        $route[ $row->org_url."/".$row1->booking_url."/loadweekoffs"] = 'applicant/loadweekoffs';
        $route[ $row->org_url."/".$row1->booking_url."/loadUsersNotWorkingDays"] = 'applicant/loadUsersNotWorkingDays';
        $route[ $row->org_url."/".$row1->booking_url."/loadPageNotWorkingDays"] = 'applicant/loadPageNotWorkingDays';
    }
    $query2 = $db->query("SELECT * FROM inspection_type");
    $result2 = $query2->result();
    foreach($result2 as $row2)
    {

        $route[ $row->org_url."/".$row2->booking_url."/loadholidaysData"] = 'applicant/loadholidaysData';
        $route[ $row->org_url."/".$row2->booking_url."/createAppointment"] = 'applicant/createAppointment';
        $route[ $row->org_url."/".$row2->booking_url."/createAppointmentMaster"] = 'applicant/createAppointmentMaster';
        $route[ $row->org_url."/".$row2->booking_url."/updateAppointment"] = 'applicant/updateAppointment';
        $route[ $row->org_url."/".$row2->booking_url."/loadAppointments"] = 'applicant/loadAppointments';
        $route[ $row->org_url."/".$row2->booking_url."/loadAppointmentTypes"] = 'applicant/loadAppointmentTypes';
        $route[ $row->org_url."/".$row2->booking_url."/loadAppointmentTypes"] = 'appointments/loadAppointmentTypes';
        $route[ $row->org_url."/".$row2->booking_url."/loadsessionAppData"] = 'applicant/loadsessionAppData';
        $route[ $row->org_url."/".$row2->booking_url."/loadResourceWorkingPlans"] = 'users/loadUserWorkingPlans';
        $route[ $row->org_url."/".$row2->booking_url."/setTimeZone"] = 'applicant/setTimeZone';
        $route[ $row->org_url."/".$row2->booking_url."/getTime"] = 'applicant/getTime';
        //$route[ $row->org_url] = 'applicant';
        $route[ $row->org_url."/".$row2->booking_url] = 'applicant';
        $route[ $row->org_url."/".$row2->booking_url."/:any"] = 'applicant';
        $route[ $row->org_url."/".$row2->booking_url."/applicant"] = 'applicant';
        $route[ $row->org_url."/".$row2->booking_url."/loadTimeSlots"] = 'applicant/loadTimeSlots';
        $route[ $row->org_url."/".$row2->booking_url."/loadTimeSlotsMaster"] = 'applicant/loadTimeSlotsMaster';
        $route[ $row->org_url."/".$row2->booking_url."/loadweekoffs"] = 'applicant/loadweekoffs';
        $route[ $row->org_url."/".$row2->booking_url."/loadUsersNotWorkingDays"] = 'applicant/loadUsersNotWorkingDays';
        $route[ $row->org_url."/".$row2->booking_url."/loadPageNotWorkingDays"] = 'applicant/loadPageNotWorkingDays';

    }

    $route[ $row->org_url."/admin"] = 'admins/signin';
    $route[ $row->org_url."/logout"] = 'admins/logout';
    $route[ $row->org_url."/admin/dashboard"] = 'admins/dashboard';
    //$route[ $row->org_url ] = 'admins/dashboard';
    $route[ $row->org_url."/admin/signin"] = 'admins/signin';
    $route[ $row->org_url."/admin/signup"] = 'admins/signup';
    $route[ $row->org_url."/admin/logout"] = 'admins/logout';
    $route[ $row->org_url."/admin/account"] = 'admins/account';
    $route[ $row->org_url."/admin/pendingRequests"] = 'admins/pendingRequests';
    $route[ $row->org_url."/admin/approveRequest"] = 'admins/approveRequest';
    $route[ $row->org_url."/admin/resources"] = 'users';
    $route[ $row->org_url."/admin/users/(:any)"] = 'users/user/$1';
    $route[ $row->org_url."/admin/createResource"] = 'users/createUser';
    $route[ $row->org_url."/admin/manageHolidays"] = 'users/manageHolidays';
    $route[ $row->org_url."/admin/addHoliday"] = 'users/addHoliday';
    $route[ $row->org_url."/admin/loadHoliday"] = 'users/loadHoliday';
    $route[ $row->org_url."/admin/loadPageHolidays"] = 'users/loadPageHolidays';
    $route[ $row->org_url."/admin/updateHoliday"] = 'users/updateHoliday';
    $route[ $row->org_url."/admin/deleteHoliday"] = 'users/deleteHoliday';
    $route[ $row->org_url."/admin/loadHolidays"] = 'users/loadHolidays';
    $route[ $row->org_url."/admin/loadholidaysData"] = 'users/loadholidaysData';
    $route[ $row->org_url."/admin/loadUserData"] = 'users/loadUserData';
    $route[ $row->org_url."/admin/updateResource"] = 'users/updateResource';
    $route[ $row->org_url."/admin/updateUser"] = 'users/updateUser';
    $route[ $row->org_url."/admin/resourcePage"] = 'users/user';
    $route[ $row->org_url."/admin/deleteResource"] = 'users/deleteUser';
    $route[ $row->org_url."/admin/createResourceLeave"] = 'users/createUserLeave';
    $route[ $row->org_url."/admin/updateResourceLeave"] = 'users/updateUserLeave';
    $route[ $row->org_url."/admin/createResourceWorkingPlan"] = 'users/createUserWorkingPlan';
    $route[ $row->org_url."/admin/deleteResourceWorkingPlan"] = 'users/deleteUserWorkingPlan';
    $route[ $row->org_url."/admin/loadResourceWorkingPlan"] = 'users/loadUserWorkingPlan';
    $route[ $row->org_url."/admin/loadResourceWorkingPlans"] = 'users/loadUserWorkingPlans';
    $route[ $row->org_url."/admin/loadLeaves"] = 'users/loadLeaves';
    $route[ $row->org_url."/admin/loadLeave"] = 'users/loadLeave';
    $route[ $row->org_url."/admin/deleteLeave"] = 'users/deleteLeave';
    $route[ $row->org_url."/admin/settings"] = 'admins/settings';
    $route[ $row->org_url."/admin/changePassword"] = 'admins/changePassword';
    $route[ $row->org_url."/admin/loadWorkingPlans"] = 'admins/loadWorkingPlans';
    $route[ $row->org_url."/admin/loadOrgWorkingPlans"] = 'admins/loadOrgWorkingPlans';
    $route[ $row->org_url."/admin/saveWorkingPlans"] = 'admins/saveWorkingPlans';
    $route[ $row->org_url."/admin/saveOrgWorkingPlans"] = 'admins/saveOrgWorkingPlans';
    $route[ $row->org_url."/admin/updateOrganization"] = 'admins/updateOrganization';
    $route[ $row->org_url."/admin/manageCalendars"] = 'admins/manageCalendars';
    $route[ $row->org_url."/admin/loadResources"] = 'admins/loadResources';
    $route[ $row->org_url."/admin/manageInspectionTypes"] = 'inspection';
    //$route[ $row->org_url."/admin/createInspectionType"] = 'inspection/create';
    $route[ $row->org_url."/admin/addMasterBookingPage"] = 'inspection/addMasterBookingPage';
    $route[ $row->org_url."/admin/saveMasterBookingPageSetup"] = 'inspection/saveMasterBookingPageSetup';
    $route[ $row->org_url."/admin/deleteMasterBookingPage"] = 'inspection/delete';
    //$route[ $row->org_url."/admin/updateInspectionType"] = 'inspection/update';
    $route[ $row->org_url."/admin/saveMasterBookingPage"] = 'inspection/saveMasterBookingPage';
    $route[ $row->org_url."/admin/loadMasterBookingPageDetails"] = 'inspection/loadMasterBookingPageDetails';
    $route[ $row->org_url."/admin/saveMasterApplicantStatus"] = 'inspection/saveMasterApplicantStatus';
    //$route[ $row->org_url."/admin/deleteInspectionType"] = 'inspection/delete';
    //$route[ $row->org_url."/admin/loadInspTypes"] = 'inspection/loadInspTypes';
    $route[ $row->org_url."/admin/loadMasterBookingPages"] = 'inspection/loadMasterBookingPages';
    $route[ $row->org_url."/admin/loadAppointmentTypeUsers"] = 'inspection/loadAppointmentTypeUsers';
    $route[ $row->org_url."/admin/addAppointmentTypeUsers"] = 'inspection/addAppointmentTypeUsers';
    $route[ $row->org_url."/admin/deleteAppointmentTypeUsers"] = 'inspection/deleteAppointmentTypeUsers';
    $route[ $row->org_url."/admin/loadMoreAppointmentTypeUsers"] = 'inspection/loadMoreAppointmentTypeUsers';
    $route[ $row->org_url."/admin/appointments"] = 'appointments';
    $route[ $row->org_url."/admin/appointmentsLog"] = 'appointments/appointmentsLog';
    $route[ $row->org_url."/admin/configuration"] = 'admins/configuration';
    $route[ $row->org_url."/admin/addBookingPage"] = 'admins/addBookingPage';
    $route[ $row->org_url."/admin/saveBookingPage"] = 'admins/saveBookingPage';
    $route[ $row->org_url."/admin/deleteBookingPage"] = 'admins/deleteBookingPage';
    $route[ $row->org_url."/admin/loadBookingPageDetails"] = 'admins/loadBookingPageDetails';
    $route[ $row->org_url."/admin/loadMasterBookingPagePages"] = 'admins/loadMasterBookingPagePages';
    $route[ $row->org_url."/admin/loadUserNotifications"] = 'admins/loadUserNotifications';
    $route[ $row->org_url."/admin/loadApplicantNotifications"] = 'admins/loadApplicantNotifications';
    $route[ $row->org_url."/admin/saveUserNotifications"] = 'admins/saveUserNotifications';
    $route[ $row->org_url."/admin/saveApplicantNotifications"] = 'admins/saveApplicantNotifications';
    $route[ $row->org_url."/admin/loadApplicantLink"] = 'admins/loadApplicantLink';
    $route[ $row->org_url."/admin/saveApplicantStatus"] = 'admins/saveApplicantStatus';
    $route[ $row->org_url."/admin/saveLocation"] = 'admins/saveLocation';
    $route[ $row->org_url."/admin/saveBookingAuto"] = 'admins/saveBookingAuto';
    $route[ $row->org_url."/admin/loadAppointments"] = 'appointments/loadAppointments';
    $route[ $row->org_url."/admin/deleteAppointment"] = 'appointments/deleteAppointment';
    $route[ $row->org_url."/admin/markAsReadAppointments"] = 'appointments/markAsReadAppointments';
    $route[ $row->org_url."/admin/markAsReadAppointment"] = 'appointments/markAsReadAppointment';
    $route[ $row->org_url."/admin/userAppointmentPage"] = 'appointments/userAppointmentPage';
    $route[ $row->org_url."/admin/userAppPage"] = 'appointments/userAppPage';
    $route[ $row->org_url."/admin/loadAvailableUsers"] = 'appointments/loadAvailableUsers';
    $route[ $row->org_url."/admin/loadPageAvailableSlots"] = 'appointments/loadPageAvailableSlots';
    $route[ $row->org_url."/admin/allocateAppointment"] = 'appointments/allocateAppointment';
    $route[ $row->org_url."/admin/rejectAppointment"] = 'appointments/rejectAppointment';
    $route[ $row->org_url."/admin/getAppInfo"] = 'appointments/getAppInfo';

    $route[ $row->org_url."/admin/upload_file"] = 'upload/upload_file';
    $route[ $row->org_url."/admin/uploadMaster_file"] = 'upload/uploadMaster_file';
    $route[ $row->org_url."/admin/upload/files"] = 'upload/files';

    $route[ $row->org_url."/admin/upload"] = 'upload';
    $route[ $row->org_url."/admin/loadOrganizationLogo"] = 'upload/loadOrganizationLogo';
    $route[ $row->org_url."/admin/loadPageNotWorkingDays"] = 'admins/loadPageNotWorkingDays';
    $route[ $row->org_url."/admin/loadPageHolidaysData"] = 'admins/loadPageHolidaysData';
    $route[ $row->org_url."/admin/loadPageAppointments"] = 'appointments/loadPageAppointments';
    $route[ $row->org_url."/admin/loadOrganizationNotWorkingDays"] = 'admins/loadOrganizationNotWorkingDays';
    $route[ $row->org_url."/admin/appointmentInfo"] = 'admins/appointmentInfo';
    $route[ $row->org_url."/admin/getLinks"] = 'admins/getLinks';
    $route[ $row->org_url."/admin/loadActivities"] = 'admins/loadActivities';
    $route[ $row->org_url."/admin/loadTrash"] = 'admins/loadTrash';
    $route[ $row->org_url."/admin/appointmentTrashInfo"] = 'admins/appointmentTrashInfo';
    $route[ $row->org_url."/admin/duplicatePage"] = 'admins/duplicatePage';
    $route[ $row->org_url."/admin/sendRescheduleRequest"] = 'admins/sendRescheduleRequest';
    $route[ $row->org_url."/admin/recuring"] = 'admins/recuring';
    $route[ $row->org_url."/admin/sendRequestNewTime"] = 'admins/sendRequestNewTime';
    $route[ $row->org_url."/admin/getCalInfo"] = 'admins/getCalInfo';


}

$route["signin"] 	= 'admins/signin';
$route["signup"] 	= 'admins/signup';
$route["logout"] 	= 'admins/logout';
$route["dashboard"] = 'admins/dashboard';
$route["account"] = 'admins/account';

$route['default_controller'] = "welcome";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */