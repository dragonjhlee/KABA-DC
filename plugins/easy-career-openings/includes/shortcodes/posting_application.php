<?

if (isset($_POST['submit'])){
$uploads = wp_upload_dir();
if ($_FILES["applicantresume"]["name"] != "") {
		$filename = $_FILES["applicantresume"]["name"];
		$filetype = $_FILES["applicantresume"]["type"];
		$fileerror = $_FILES["applicantresume"]["error"];
		$filetmp = $_FILES["applicantresume"]["tmp_name"];
		$file = $_FILES['applicantresume'];

		$allowedExtensions = array("txt", "rtf", "doc", "pdf");

		function isAllowedExtension($fileName) {
  		global $allowedExtensions;
		return in_array(end(explode(".", $fileName)), array("txt", "rtf", "doc", "pdf"));
		}

		if($file['error'] == UPLOAD_ERR_OK) {
  			if(isAllowedExtension($filename)) {
  			$newfilename = preg_replace("/[^!<>@&\/\sA-Za-z0-9_.]/","_", $filename);
  			$newfilename = str_replace(" ", "_", $newfilename);
			
  			
  			//Check to see if the file already exists. If it does, we need to rename it.
  			if (file_exists($uploads['path'].'/'.$newfilename)) {
			$today =  date("y-m-d-H-i-s",time()); 
			$newfilename = $today ."_". $newfilename;
			//echo $newfilename; 
			}
			//Upload Directory
			//$upload_new = $uploadpath;
			//$upload_new = $upload_new. $new_target_file;
			move_uploaded_file($filetmp, $uploads['path'].'/'.$newfilename);
    		$fileuploaded = $newfilename;
    			//processForm($fileuploaded);
    		} else {
   			$message = "You have tried to upload a file type that is invalid. Please use your browsers back button and try again.";
  			}
		} else die("Cannot upload");
		
		
	}


$emailto = $_POST['contactemail'];
$emailfrom = $_POST['applicantemail'];
$emailsubject = 'Resume for: '.$_POST['jobtitle'];
$uploadedfile = $uploads['path'].'/'.$newfilename;
$attachments = array($uploadedfile);
   $headers = "From: ".$_POST['applicantemail'] . "\r\n";
   $mail = wp_mail($emailto, $emailsubject, $_POST['applicantcover'], $headers, $attachments);
   if($mail){
   	echo '<p><strong>Thank you! We will review your information and be in touch soon.</strong></p>';
   } else {
   	echo '<p><strong>There was a problem. Please try again.</strong></p>';
   }
}

global $wpdb;
$sql = "SELECT JobTitle, ContactEmail FROM ".$wpdb->prefix."eco_career_openings WHERE id =".$_REQUEST['jobid'];
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)){
	$jobtitle = $row['JobTitle'];
	$jobcontact = $row['ContactEmail'];
}
?>
<form name="ecoApplication" class="forms" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="jobid" id="jobid" value="<?php echo $_REQUEST['jobid'];?>"/>
<input type="hidden" name="contactemail" id="contactemail" value="<?php echo $jobcontact;?>"/>
<input type="hidden" name="jobtitle" id="jobtitle" value="<?php echo $jobtitle;?>"/>
	<table width="75%" border="0">
		<tr>
			<td>
				<label>Your Name:</label>
			</td>
			<td><input type="text" id="applicatantname" name="applicantname" value="" size="50"></td>
		</tr>
		<tr>
			<td>
				<label>Your Email:</label>
			</td>
			<td><input type="text" id="applicatantemail" name="applicantemail" value="" size="50"></td>
		</tr>
		<tr>
			<td>
				<label>Daytime Phone:</label>
			</td>
			<td><input type="text" id="applicatantphone" name="applicantphone" value="" size="50"></td>
		</tr>
		<tr>
			<td>
				<label>Position:</label>
			</td>
			<td><?= $jobtitle;?></td>
		</tr>
		<tr>
			<td colspan="2">
				<label>Cover Letter:</label><br/><textarea name="applicantcover" id="applicantcover" cols="50" rows="7"></textarea></td>
		</tr>
		<tr>
			<td>
				<label>Your Resume:</label>
			</td>
			<td><input type="file" name="applicantresume" id="applicantresume"/></td>
		</tr>
		<tr>
			<td colspan="2"> <input type="submit" name="submit" value="submit" /> <input type="reset" value="reset" /></td>
		</tr>
	</table>
</form>