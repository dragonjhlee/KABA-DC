<?php
global $wpdb;
	$sql = "SELECT id, JobTitle, JobBody, PostingCity, PostingState FROM ".$wpdb->prefix."eco_career_openings ORDER BY id DESC";
     $result = mysql_query($sql) or die (mysql_error());
     echo '<table style="margin-left:10px;border:1px solid #ccc;padding:1px;">';
     echo '	<tr style="background:#E6E6E6;">';
     echo '		<th style="width:400px;padding:10px;text-align:center;">Position</th>';
     echo '		<th style="width:60px;padding:10px;text-align:center;">State</th>';
     echo '		<th style="padding:10px;text-align:center;">City/Town</th>';
     echo '		<th style="padding:10px;text-align:center;">Details</th>';
     echo '	</tr>';
     while ($row = mysql_fetch_array($result)) {
    $jobid = $row['id'];
    $jobtitle = $row['JobTitle'];
    $jobbody = $row['JobBody'];
    $state = $row['PostingState'];
    $city = $row['PostingCity'];    
	echo '	<tr class="yellow">';    
    echo '		<td style="padding:8px;border-left:1px solid #ccc;border-bottom:1px solid #ccc;">'.$jobtitle.'</td>';
    echo '		<td style="text-align:center;border-left:1px solid #ccc;border-bottom:1px solid #ccc;">'.$state.'</td>';
    echo '		<td style="text-align:center;border-left:1px solid #ccc;border-bottom:1px solid #ccc;">'.$city.'</td>';
    echo '		<td style="width:120px;padding-left:20px;border-left:1px solid #ccc;border-bottom:1px solid #ccc;"><a href="'.get_option('eco-career-details-page').'?jobid='.$jobid.'">VIEW DETAILS</a></td>';
    echo '	</tr>';
    //$row_count++;
    }
    echo '</table>';
