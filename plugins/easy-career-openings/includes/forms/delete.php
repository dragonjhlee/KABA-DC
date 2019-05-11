<?php //DELETE
function eco_getCareerPostName($ecojobid){
	global $wpdb;
	$postsql = "SELECT id, JobTitle FROM ".$wpdb->prefix."eco_career_openings WHERE id = ".$ecojobid;
	$postresult = $wpdb->get_results($postsql);
	return $postresult;

}

function eco_deleteCareerPosting($ecojobid){
	global $wpdb;
	$eco_delete = $wpdb->query( $wpdb->prepare (
		"
			DELETE FROM ".$wpdb->prefix."eco_career_openings WHERE id = %d
		", $ecojobid
		));
	$ecodeleteresult = $wpdb->query($eco_delete);
	return $ecodeleteresult;
}
if (isset($_POST['submit'])) {
	eco_deleteCareerPosting($_POST['jobid']); ?>
	<div style="width:900px;padding:15px;">
	<div id="delete" class="postbox">
		<h3><span>Delete a Career Opening</span></h3>
		<div class="inside">
		<p>You have successfully deleted the posting.</p>
		<p>Click <a href="admin.php?page=eco-plugin">Here</a> to go back to the current jobs list</p>
		</div>
	</div>
</div>
<?php 
	

} else {?>
	
     
<div style="width:900px;padding:15px;">
	<div id="delete" class="postbox">
		<h3><span>Delete a Career Opening</span></h3>
		<div class="inside">
		<p>You have choosen to delete: 
		<?php
			foreach(eco_getCareerPostName($_REQUEST['jobid']) as $key => $row) {
				echo $row->JobTitle;
			}
		?>
		</p>
		<p>
			<form action="admin.php?page=eco-plugin&action=delete" method="post" class="forms">
				<input type="hidden" name="jobid" id="jobid" value="<?php echo $_REQUEST['jobid'];?>" />
				<input type="submit" name="submit" value="Delete"/>
			</form>
		</p>
		<p>Click <a href="admin.php?page=eco-plugin">Here</a> to go back to the current jobs list</p>
		</div>
	</div>
</div>
<?php } ?>