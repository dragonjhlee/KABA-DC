<?php //Posting Details
global $wpdb;
$sql = "SELECT id, JobTitle, JobBody, ContactEmail FROM ".$wpdb->prefix."eco_career_openings WHERE id =".$_REQUEST['jobid'];
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	$jobid = $row['id'];
	$contactemail = $row['ContactEmail'];
    $jobtitle = $row['JobTitle'];
    $jobbody = $row['JobBody'];
}
	echo '<h3>'.$jobtitle.'</h3>';
	echo $jobbody.'<br />';
	if ($contactemail != ''){
	echo '<a href="'.get_option('eco-career-application-page').'?jobid='.$_REQUEST['jobid'].'">Click here to send us your resume.</a>';
	}
?>