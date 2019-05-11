<?php
global $wpdb;
//Form processing will take place here
if (isset($_POST['submit'])) {
	   $jobtitle = strtoupper($_POST['JobTitle']);
     $contact = $_POST['ContactName'];
     $email = $_POST['ContactEmail'];
     $jbody = $_POST['JobBody'];
     $hpw = $_POST['HoursPerWeek'];
     $city = $_POST['PostingCity'];
     $state = $_POST['PostingState'];
     $zipcode= $_POST['PostingPostalCode'];
     $jobclass = $_POST['JobClassification'];
     $date = date("y-m-d",time());
}

switch ($_REQUEST['action']):
        case 'add':
            if (isset($_POST['submit'])){
              $sql ="INSERT INTO ".$wpdb->prefix."eco_career_openings
              (JobTitle, ContactName, ContactEmail, JobBody, HoursPerWeek, PostingCity, PostingState, PostingPostalCode, JobClassification, PostDate)
              VALUES
              ('$jobtitle', '$contact', '$email', '$jbody', '$hpw', '$city', '$state', '$zipcode', '$jobclass', '$date')";
              //echo $sql;
              if ($add_position_result = mysql_query($sql)) {
                $message = "<div style='margin-left:0px;width:910px;margin-bottom:5px;background-color:#FFFFE0; border: 1px solid #E6DB55;padding:10px;'>Successfully added Job</div>";
              }
              else {
                $message = "<div style='margin-left:0px;width:910px;margin-bottom:5px;background-color:#FFFFE0; border: 1px solid #E6DB55;padding:10px;'>Failed to Save</div>";
              } 
            } 
            $JobTitle = '';
            $ContactName = '';
            $ContactEmail = '';
            $JobBody = '';
            $HoursPerWeek = '';
            $PostingCity = '';
            $PostingState = '';
            $PostingPostalCode = '';
            $JobClassification = '';
            $ActionLabel = "Add";
          break;
        case 'edit':
            if (isset($_POST['submit'])){
              $sql = "UPDATE ".$wpdb->prefix."eco_career_openings SET JobTitle = '".$jobtitle."', ContactName = '".$contact."', ContactEmail = '".$email."', JobBody = '".$jbody."', HoursPerWeek = '".$hpw."', PostingCity = '".$city."', PostingState = '".$state."', PostingPostalCode = '".$zipcode."', JobClassification = '".$jobclass."' WHERE id = ".$_REQUEST['jobid'];
              if ($add_position_result = mysql_query($sql)) {
                $message = "<div style='margin-left:0px;width:910px;margin-bottom:5px;background-color:#FFFFE0; border: 1px solid #E6DB55;padding:10px;'><p>Successfully updated Job</p></div>";
              }
              else {
                $message = "<div style='margin-left:0px;width:910px;margin-bottom:5px;background-color:#FFFFE0; border: 1px solid #E6DB55;padding:10px;'>Failed to Save</div>";
              } 
            }
            $postingsql = "SELECT JobTitle, ContactName, ContactEmail, JobBody, HoursPerWeek, PostingCity, PostingState, PostingPostalCode, JobClassification FROM ".$wpdb->prefix."eco_career_openings WHERE id = ".$_REQUEST['jobid'];
            $postingresult = mysql_query($postingsql);
            while ($row = mysql_fetch_array($postingresult)){
              $JobTitle = $row['JobTitle'];
              $ContactName = $row['ContactName'];
              $ContactEmail = $row['ContactEmail'];
              $JobBody = $row['JobBody'];
              $HoursPerWeek = $row['HoursPerWeek'];
              $PostingCity = $row['PostingCity'];
              $PostingState = $row['PostingState'];
              $PostingPostalCode = $row['PostingPostalCode'];
              $JobClassification = $row['JobClassification'];
            }
            $ActionLabel = "Edit";
          break;
        default:
            $JobTitle = '';
            $ContactName = '';
            $ContactEmail = '';
            $JobBody = '';
            $HoursPerWeek = '';
            $PostingCity = '';
            $PostingState = '';
            $PostingPostalCode = '';
            $JobClassification = '';
            $ActionLabel = "Add";
      endswitch;  
add_action('admin_init', 'editor_admin_init');
add_action('admin_head', 'editor_admin_head');

function editor_admin_init() {
  wp_enqueue_script('word-count');
  wp_enqueue_script('post');
  wp_enqueue_script('editor');
  wp_enqueue_script('media-upload');
}

function editor_admin_head() {
  wp_tiny_mce();
}

?>
 
<div id="icon-edit" class="icon32 icon32-posts-post"></div><h2 class="jobh2"><?= $ActionLabel;?> a Career Opening</h2>

     <p style="margin-left:40px;">Click <a href="admin.php?page=eco-plugin">Here</a> to go back to the current jobs list</p>
     
<div style="width:900px;padding:15px;">
		<?php if (isset($message)){
			echo $message;
		} ?>
          
       <?php if (isset($_REQUEST['jobid'])) {?>
         <form action="admin.php?page=eco-plugin&action=edit&jobid=<?php echo $_REQUEST['jobid'];?>" method="post" style="margin-top:10px;" name="form" class="forms">
       <?php } else { ?>
       <form action="admin.php?page=eco-plugin&action=add" method="post" style="margin-top:10px;" name="form" class="forms">
        <?php } ?>
        <ul> 
          <li>
           <label style="width:150px;float:left;">Job Title:</label>
           <input type="text" id="JobTitle" name="JobTitle" value="<?= $JobTitle; ?>">
          </li>
          <li>
           <label style="width:150px;float:left;">Contact Person:</label>
           <input type="text" id="ContactName" name="ContactName" value="<?= $ContactName; ?>">
          </li>
          <li>
           <label style="width:150px;float:left;">Contact Email:</label>
           <input type="text" id="ContactEmail" name="ContactEmail" value="<?= $ContactEmail;?>">
          </li>
          <li>
           <label style="width:150px;float:left;">Job Info:</label>
           <?php
                the_editor("$JobBody", "JobBody", "", false);
            ?>
          </li>
          <li>
           <label style="width:150px;float:left;">Hours Per Week:</label>
           <input type="text" id="HoursPerWeek" name="HoursPerWeek" value="<?= $HoursPerWeek; ?>">
          </li>
          <li>
           <label style="width:150px;float:left;">City posted in:</label>
           <input type="text" id="PostingCity" name="PostingCity" value="<?= $PostingCity; ?>">
          </li>
          <li>
           <label style="width:150px;float:left;">State posted in:</label>
           <input type="text" id="PostingState" name="PostingState" value="<?= $PostingState; ?>">
          </li>
          <li>
           <label style="width:150px;float:left;">Zipcode:</label>
           <input type="text" id="PostingPostalCode" name="PostingPostalCode" value="<?= $PostingPostalCode; ?>">
          </li>
          <li>
           <label style="width:150px;float:left;">Job Classification:</label>
           <select name="JobClassification" style="margin:0 16px 0 0px">
           <option selected="selected">-- Select Employee Type --</option>
           <option value="Full" <?php if ($JobClassification == 'Full') {echo ' selected';}?>>Full-time Employee</option>
           <option value="Part" <?php if ($JobClassification == 'Part') {echo ' selected';}?>>Part-time Employee</option>
           <option value="Intern" <?php if ($JobClassification == 'Intern') {echo ' selected';}?>>Intern</option>
           <option value="Contractor" <?php if ($JobClassification == 'Contractor') {echo ' selected';}?>>Contractor</option>
           </select>
          </li>
          <li>
           <input type="hidden" id="PostingDate" name="PostingDate" value="<?php echo date("y-m-d",time());?>">
          </li>
          <div style="margin-top:20px;margin-bottom:40px;">
          <input type="submit" name="submit" value="submit" /> <input type="reset" value="reset" />
          </div>
        </ul> 
        </form>

 </div> 