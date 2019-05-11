<?php
/**
 * Template Name: Edit Profile Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>



<div id="main-content" class="main-content">
<?php
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Load Required Extra Contact Info
		if ( isset( $_POST['first_name'] ) ) {
			$first_name = sanitize_text_field( $_POST['first_name'] );
		} else {
			$first_name = "";
		}
		if ( isset( $_POST['last_name'] ) ) {
			$last_name = sanitize_text_field( $_POST['last_name'] );
		} else {
			$last_name = "";
		}
		if ( isset( $_POST['pref_name'] ) ) {
			$pref_name = sanitize_text_field( $_POST['pref_name'] );
		} else {
			$pref_name = "";
		}

		// Work
		if ( isset( $_POST['company_name'] ) ) {
			$company_name = sanitize_text_field( $_POST['company_name'] );
		} else {
			$company_name = "";
		}
		if ( isset( $_POST['position'] ) ) {
			$position = sanitize_text_field( $_POST['position'] );
		} else {
			$position = "";
		}
		if ( isset( $_POST['company_type'] ) ) {
			$company_type = $_POST['company_type'];
			if ($company_type == "Other" && isset( $_POST['company_other'] )){
				$company_other = sanitize_text_field( $_POST['company_other'] );
			}
		} else {
			$company_type = "";
		}
		if ( isset( $_POST['company_size'] ) ) {
			$company_size =  $_POST['company_size'] ;
		} else {
			$company_size = "";
		}

		// School
		if ( isset( $_POST['school_name'] ) ) {
			$school_name =  $_POST['school_name'];
			if ($school_name == "Other" && isset( $_POST['school_other'] )){
				$school_other = sanitize_text_field( $_POST['school_other'] );
			}
		} else {
			$school_name = "";
		}
		if ( isset( $_POST['graduation_date'] ) ) {
			$graduation_date = sanitize_text_field( $_POST['graduation_date'] );
		} else {
			$graduation_date = "";
		}

		//KABA
		$pmpro_error_fields = array();
		$pmpro_required_user_profile = array();
		$pmpro_required_user_profile_work = array();
		$pmpro_required_user_profile_school = array();


		// Extra Contact Info
		$pmpro_required_user_profile    = array(	

			"first_name"      => $first_name,

			"last_name"      => $last_name,

			"pref_name"     => $pref_name	

		);
		$pmpro_required_user_profile    = apply_filters( "pmpro_required_user_profile", $pmpro_required_user_profile );

		// Work
		$pmpro_required_user_profile_work    = array(	

			"company_name"      => $company_name,

			"position"      => $position,

			"company_type"     => $company_type,

			"company_other"      => $company_other,
			
			"company_size"       => $company_size

		);
		$pmpro_required_user_profile_work    = apply_filters( "pmpro_required_user_profile_work", $pmpro_required_user_profile_work );

		// School
		$pmpro_required_user_profile_school    = array(	

			"school_name"      => $school_name,

			"school_other"      => $school_other,

			"graduation_date"     => $graduation_date	

		);
		$pmpro_required_user_profile_school    = apply_filters( "pmpro_required_user_profile_school", $pmpro_required_user_profile_school );


		//check user Extra Contact

		foreach ( $pmpro_required_user_profile as $key => $field ) {

			if ( ! $field ) {			
					$pmpro_error_fields[] = $key;

			}

		}		

		$isValid = true;
		if ( ! empty( $_POST['IsLawStudent'] ) ) {		
			//check user School Info
			foreach ( $pmpro_required_user_profile_school as $key => $field ) {
				if ($key == "school_name" && $field == "Other"){
					$isValid = false;
				}	
				if ( ! $field ) {
					if ($key == "school_other" && $isValid){
						continue;					
					}
					else{
						$pmpro_error_fields[] = $key;
					}
				}

			}		
		}		
		else{
			//check user Work Info
			foreach ( $pmpro_required_user_profile_work as $key => $field ) {
				if ($key == "company_type" && $field == "Other"){
					$isValid = false;
				}	
				if ( ! $field ) {
					if ($key == "company_other" && $isValid){
						continue;					
					}
					else{
						$pmpro_error_fields[] = $key;
					}
				}

			}
		}


		if ( ! empty( $pmpro_error_fields ) ) {
			//pmpro_setMessage( __( "Please complete all required fields.", 'paid-memberships-pro' ), "pmpro_error" );
			echo "<div class='pmpro_error' style='margin-left: 50%;''> Please complete all required fields which is highlighted in Red.</div>";
		}
		else {
			// Contact Info
			if(isset($_POST['first_name']))
			update_usermeta( $user_id, 'first_name', $_POST['first_name'] );
			if(isset($_POST['last_name']))
				update_usermeta( $user_id, 'last_name', $_POST['last_name'] );	
			if(isset($_POST['pref_name']))
				update_usermeta( $user_id, 'pref_name', $_POST['pref_name'] );
			if(isset($_POST['sec_email']))
				update_usermeta( $user_id, 'sec_email', $_POST['sec_email'] );		
			if(isset($_POST['prm_phone']))
				update_usermeta( $user_id, 'prm_phone', $_POST['prm_phone'] );
			if(isset($_POST['sec_phone']))
				update_usermeta( $user_id, 'sec_phone', $_POST['sec_phone'] );

			if (isset( $_POST['IsLawStudent'] ) ) {
				$is_law_student = true;	
				// School Info
				if(isset($_POST['school_name'])) {
					update_usermeta( $user_id, 'school_name', $_POST['school_name'] );
					if ($_POST['school_name'] == "Other" && isset($_POST['school_other'])) {
						update_usermeta( $user_id, 'school_other', $_POST['school_other'] );
					}
				}
				if(isset($_POST['graduation_date']))
					update_usermeta( $user_id, 'graduation_date', $_POST['graduation_date'] );
			} else{
				$is_law_student = false;	
				// Work Info
				if(isset($_POST['company_name']))
					update_usermeta( $user_id, 'company_name', $_POST['company_name'] );
				if(isset($_POST['position']))
					update_usermeta( $user_id, 'position', $_POST['position'] );
				if(isset($_POST['company_type'])) {
					update_usermeta( $user_id, 'company_type', $_POST['company_type'] );
					if ($_POST['company_type'] == "Other" && isset($_POST['company_other'])) {
						update_usermeta( $user_id, 'company_other', $_POST['company_other'] );
					}
				}
				if(isset($_POST['company_size']))
					update_usermeta( $user_id, 'company_size', $_POST['company_size'] );
				if(isset($_POST['company_city']))
					update_usermeta( $user_id, 'company_city', $_POST['company_city'] );
				if(isset($_POST['company_state']))
					update_usermeta( $user_id, 'company_state', $_POST['company_state'] );
			}
			update_usermeta($user_id, "is_law_student", $is_law_student);		

			// More 
			// Bar Admission
			if (isset($_POST['ba_area'])) {
				$ba_count = count($_POST['ba_area']);
					if($ba_count > 0) {
						$item_count = 0;			
						$ba_area = "";
						$ba_date = "";
						for($i=0; $i<$ba_count; $i++) {
							if(!empty($_POST["ba_area"][$i]) || !empty($_POST["ba_date"][$i])) {
								$item_count++;
								if($ba_area != "") {
									$ba_area .= ",";
								}
								$ba_area .= $_POST["ba_area"][$i];
								if($ba_date != "") {
									$ba_date .= ",";
								}
								$ba_date .= $_POST["ba_date"][$i];
							}
						}
						if($item_count != 0) {
							update_usermeta($user_id, "ba_area", $ba_area);
							update_usermeta($user_id, "ba_date", $ba_date);
						}
					}
			}	
			if(isset($_POST['kor_proficiency']))
				update_usermeta( $user_id, 'kor_proficiency', $_POST['kor_proficiency'] );
			
			// Other Languagues
			if (isset($_POST['lang_name'])) {
				$lang_name_count = count($_POST['lang_name']);
					if($lang_name_count > 0) {
						$item_count = 0;			
						$lang_name = "";
						$lang_level = "";
						for($i=0; $i<$lang_name_count; $i++) {
							if(!empty($_POST["lang_name"][$i]) || !empty($_POST["lang_level"][$i])) {
								$item_count++;
								if($lang_name != "") {
									$lang_name .= ",";
								}
								$lang_name .= $_POST["lang_name"][$i];
								if($lang_level != "") {
									$lang_level .= ",";
								}
								$lang_level .= $_POST["lang_level"][$i];
							}
						}
						if($item_count != 0) {
							update_usermeta($user_id, "lang_name", $lang_name);
							update_usermeta($user_id, "lang_level", $lang_level);
						}
					}
			}	

			// More Law Schools	
			if (isset($_POST['more_school_name'])) {
				$more_school_count = count($_POST['more_school_name']);
					if ($more_school_count > 0) {
						$item_count = 0;
						$more_school_name = "";
						$more_school_other = "";
						for($i = 0; $i < $more_school_count; $i++) {
							if (!empty($_POST["more_school_name"][$i])) {
								$item_count++;
								if ($more_school_name != "") {
									$more_school_name .= ";";
								}
								$more_school_name .= $_POST["more_school_name"][$i];
								
								if ( $i > 0) {
									$more_school_other .= ",";
								}
								$more_school_other .= $_POST["more_school_other"][$i];		
							}
						}
						if ($item_count > 0) {
							update_usermeta($user_id, "more_school_name", $more_school_name);
							update_usermeta($user_id, "more_school_other", $more_school_other);
						}
					}
			}
			
			if(isset($_POST['graduation_year']))
				update_usermeta( $user_id, 'graduation_year', $_POST['graduation_year'] );
			if(isset($_POST['areas'])) {
				$is_first_data = true;
				$practice_areas = "";
				foreach($_POST['areas'] as $value){
					if ($is_first_data) {
						$practice_areas = $value;
						$is_first_data = false;
					}
					else{
						$practice_areas = $practice_areas. "," .$value;
					}		
				}
				update_usermeta($user_id, "practice_areas", $practice_areas);		
			}			
			if(isset($_POST['public_profile']))
				update_usermeta( $user_id, 'public_profile', $_POST['public_profile'] );

			if(isset($_POST['area_other']))
				update_usermeta( $user_id, 'area_other', $_POST['area_other'] );

			if ($_POST['public_directory'] == 1) {
				update_usermeta( $user_id, 'pmpromd_hide_directory', 1 );
			} 
			else{
				update_usermeta( $user_id, 'pmpromd_hide_directory', NULL );
			}
			
			//Upload Profile Pic
			if(isset($_FILES["file"]["type"]))
			{
				$validextensions = array("jpeg", "jpg", "png");
				$temporary = explode(".", $_FILES["file"]["name"]);
				$file_extension = end($temporary);

				if ( ( ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg") )
				&& ($_FILES["file"]["size"] <= 2000000)//Approx. up to 2MB file can be uploaded.
				&& in_array($file_extension, $validextensions) ) {
					$currentDir = $_SERVER['DOCUMENT_ROOT'];
					$uploadDirectory = "/wp-content/uploads/ProfilePic/";
					
					$fileName = $_FILES['file']['name'];
					$fileTmpName  = $_FILES['file']['tmp_name'];

					$uploadPath = $currentDir . $uploadDirectory . basename($fileName); 
					
					$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

					if ($didUpload) {
						$profile_pic_url = "http://" . $_SERVER['SERVER_NAME'] . $uploadDirectory . basename($fileName);
						update_usermeta($user_id, "profile_pic_url", $profile_pic_url);
					} else {
						print_r(error_get_last());
					}
				}
			}
		}
	}
?>

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>
		$(document).ready(function (e) {
			// Function to preview image after validation
				$("#file").change(function() {
					$("#message").empty(); // To remove the previous error message
					var file = this.files[0];
					var imagefile = file.type;
					var imageSize = file.size;
					
					var match= ["image/jpeg","image/png","image/jpg"];
					if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
					{
						$('#previewing').attr('src','noimage.png');
						$("#message").html("<p id='error' style='color: red;'>Please select a VALID image (jpg, jpeg and png)</p>");
						$('#image_preview').css("display", "none");
						
						return false;
					}
					else if (imageSize > 2000000){
						$('#previewing').attr('src','noimage.png');
						$("#message").html("<p id='error' style='color: red;'>Please select a image size less than 2MB</p>");
						$('#image_preview').css("display", "none");
						
						return false;
					}
					else
					{
						var reader = new FileReader();
						reader.onload = imageIsLoaded;
						reader.readAsDataURL(this.files[0]);
					}
				});
			function imageIsLoaded(e) {
				$("#file").css("color","green");
				$('#image_preview').css("display", "block");
				$('#previewing').attr('src', e.target.result);
				$('#previewing').attr('width', '250px');
				$('#previewing').attr('height', '230px');
			};
		});
	</script>

	<div id="primary" class="content-area" style="margin-left: 15%;width: 50%;">
		<div id="content" class="site-content" role="main">
		<form action="" method="post" enctype="multipart/form-data">			
			<script type="text/javascript">
			jQuery(document).ready(function () {					

				var isSchool = "<?php echo  get_user_meta($current_user->ID, 'is_law_student', true); ?>";
				if (isSchool == 1){
				document.getElementById("workContact").style.display = "none";
				document.getElementById("schoolContact").style.display = "block";     
				}
				else{
				document.getElementById("workContact").style.display = "block";
				document.getElementById("schoolContact").style.display = "none"; 
				}		
				
				var companyType = "<?php if (!empty( $pmpro_error_fields)) {echo $company_type;}else {echo esc_attr(get_user_meta($current_user->ID, 'company_type', true)); }  ?>";
				if (companyType == "Other"){
					document.getElementById("otherTxtWork").style.visibility="visible"; 
				}
				else{
					document.getElementById("otherTxtWork").style.visibility="hidden"; 
				}

				var schoolName = "<?php if (!empty( $pmpro_error_fields)) {echo $school_name;}else {echo esc_attr(get_user_meta($current_user->ID, 'school_name', true)); }  ?>";
				if (schoolName == "Other"){
					document.getElementById("otherTxtSchool").style.visibility="visible"; 
				}
				else{
					document.getElementById("otherTxtSchool").style.visibility="hidden"; 
				}

				var getSchoolArr = "<?php echo implode(";", get_user_meta($current_user->ID, 'more_school_name', false) ) ; ?>";
				var moreSchoolArr = getSchoolArr.split(";");
				for (var i = 0; i < moreSchoolArr.length; i++){
					if (moreSchoolArr[i] == "Other") {
						document.getElementById("otherTxtSchoolInfo_" + i).style.visibility="visible";
					}
				}

				var areaOtherTxt = "<?php echo get_user_meta($current_user->ID, 'area_other', true); ?>";
				if (areaOtherTxt != "" ) {
					document.getElementById("area_other").style.visibility="visible"; 
				}
				else{
					document.getElementById("area_other").style.visibility="hidden"; 
				}				
			});		
				function otherTxtbox(obj, location){                             
					var txtBoxId = "";
					var valueId = "";                                
					switch (location) {
						case 1: //company
							txtBoxId = "otherTxtWork"; 
							vaueId = "company_other";                                       
							break;
						case 2: //school
							txtBoxId = "otherTxtSchool";
							valueId = "school_other";                                       
							break;
						default:
							txtBoxId = "";
							valueId = "";
					}                               

					if (obj.value=="Other")
					{                                
					document.getElementById(txtBoxId).style.visibility="visible";                                        
					} 
					else 
					{                                
					document.getElementById(txtBoxId).style.visibility="hidden";
					jQuery('#'+vaueId).val(""); 
					};                               
				}		

				function triggerFn(){
					var chkBox = document.getElementById("IsLawStudent");
					var workInfo = document.getElementById("workContact");
					var schoolInfo = document.getElementById("schoolContact");  		                          
						if (chkBox.checked == true){
							workInfo.style.display = "none";
							schoolInfo.style.display = "block";                                    
						}
						else{
							workInfo.style.display = "block";
							schoolInfo.style.display = "none"; 
						}
				}			
				
				function addBarAdmission(){    
					var fields = "<tr class='name_Table'>"				
					+ "<td style='float: left; margin-right: 5%; margin-left: 2%;' class='name_Table'><input type='text' name='ba_area[]' placeholder='Jurisdiction/State' /></td>"
					+ "<td style='float: left;' class='name_Table'><input type='text' name='ba_date[]' placeholder='YYYY' /></td>"
					+ "<td class='name_Table' style='float: left; margin-left: 3%; margin-top: -0.5%;'><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteBarAdmission()'>x</span></td>"
					+ "</tr>";
					jQuery("#bar_admission_container").append(fields);
				}
				function deleteBarAdmission(){
					jQuery("#bar_admission_container").on('click', '.btnDelete', function () {
						jQuery(this).closest('tr').remove();
					});
				}

				function addLanguage(){    
					var fields = "<tr class='name_Table'>"				
					+ "<td style='float: left; margin-right: 5%; margin-left: 2%;' class='name_Table'><input type='text' name='lang_name[]' placeholder='Other Language' /></td>"
					+ "<td style='float: left; margin-top: 1%; width: 30%;' class='name_Table'>"
					+ "<select name='lang_level[]'>"
					+ "<option value=''>Select Level</option>"
					+ "<option value='N/A'>N/A</option>"
					+ "<option value='Conversational'>Conversational</option>"
					+ "<option value='Fluent'>Fluent</option>"
					+ "<option value='Native'>Native</option>"		
					+ "</select></td>"
					+ "<td class='name_Table' style='float: left; margin-top: -0.5%;'><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteLanguage()'>x</span></td>"
					+ "</tr>";
					jQuery("#language_container").append(fields);
				}
				function deleteLanguage(){
					jQuery("#language_container").on('click', '.btnDelete', function () {
						jQuery(this).closest('tr').remove();
					});
				}
				
				function otherSchoolTxtbox(obj){
					if (obj.value=="Other")
					{                                
						jQuery(obj).closest('tr').find('td.otherTxtSchoolInfo').attr("style", "visibility: visible");
					} 
					else 
					{       
						jQuery(obj).closest('tr').find('td.otherTxtSchoolInfo').attr("style", "visibility: hidden");         
						jQuery(obj).closest('tr').find('input').val("");
					};                               
				}		
				
				function addLawSchool(){    
					var phpCode = '<?php global $school_name_arr; foreach($school_name_arr as $name){ echo '<option value="'.$name.'" >'.$name.'</option>'; }?>';
					var fields = '<tbody class="name_Table"><tr class="name_Table more_school">'
					+			'<td id="more_school_name_div" class="pmpro_checkout-field name_Table" style="padding-right: 10px;">'
					+				'<label for="more_school_name">Law School</label>'
					+				'<select id="more_school_name" name="more_school_name[]" onchange="otherSchoolTxtbox(this)">'
					+					'<option value=""></option>'
					+ phpCode
					+				'</select>'                                  
					+			'</td>'			
					+			'<td id="otherTxtSchoolInfo" class="pmpro_checkout-field name_Table otherTxtSchoolInfo" style="visibility:hidden;">'
					+				'<label for="more_school_other">Other Law School</label>'
					+				'<input type="text" name="more_school_other[]" size="20">'
					+			'</td>'	
					+		"</tr>"
					+ "<tr><td class='name_Table'><div style='margin-left: 0.5%;margin-top: -5%;'><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteLawSchool()'>x</span></div></td></tr></tbody>"
					jQuery("#more_school_container").append(fields);
				}
				function deleteLawSchool(){
					jQuery("#more_school_container").on('click', '.btnDelete', function () {
						jQuery(this).closest('tbody').remove();
					});
				}	

				function toggleTxtBox(ele) {
					if (ele.checked) {
						jQuery('#area_other').attr("style", "visibility: visible");
					}
					else {
						jQuery('#area_other').attr("style", "visibility: hidden");
						jQuery('#area_other').val(""); 
					}
				}
		</script> 

		<h1>EDIT PROFILE</h1>

		<h4 class="pmpro_member_directory_display-name">
			<?php
				$profile_pic_url = get_user_meta($current_user->ID, 'profile_pic_url', true);													
				if (!empty($profile_pic_url)){
			?>
				<img src="<?php echo esc_attr($profile_pic_url); ?>" width="250" height="250" />
			<?php 
				} else { 
				echo get_avatar($current_user->ID, $avatar_size, NULL, $current_user->user_nicename);
			}
			?>
			
		</h4>
		<hr id="line">
		
		<div id="image_preview" style="display:none"><label>New profile image preview</label>
		<br/>
		<img id="previewing" src="noimage.png" /></div>
		<div id="selectImage">
			<label>Select Your Profile Image</label><br/>
			<input type="file" name="file" id="file" />
		</div>
		<div id="message"></div>
		
		<br/>
		<!-- Uncheck below to be hidden from directory-->
		<br/>
		<label for="public_directory">
			<input name="public_directory" type="checkbox" id="public_directory" <?php checked( get_user_meta($current_user->ID, 'pmpromd_hide_directory', true), 1); ?> value="1">
			<?php printf(__(' Click if you would like your information to be included in our public directory.')); ?>
		</label>

		<!-- Contact -->
		<h3>Contact Information</h3>
		<table class="name_Table">
			<tr class="name_Table">
				<td id="first_name_div" class="pmpro_checkout-field name_Table">
					<label for="first_name">First Name *</label>
					<input type="text" id="first_name" name="first_name" value="<?php if (!empty( $pmpro_error_fields)) {
						echo $first_name;
					}
					else {
						echo esc_attr(get_user_meta($current_user->ID, 'first_name', true)); 
					} ?>" size="20" class="input <?php echo pmpro_getClassForField("first_name");?>">
					
				</td>			
											
				<td id="Last Name_div" class="pmpro_checkout-field name_Table">
					<label for="last_name">Last Name *</label>
					<input type="text" id="last_name" name="last_name" value="<?php if (!empty( $pmpro_error_fields)) {
						echo $last_name;
					}
					else {
						echo esc_attr(get_user_meta($current_user->ID, 'last_name', true)); 
					} ?>" size="20" class="input <?php echo pmpro_getClassForField("last_name");?>">									    
				</td>				
			</tr>

			<tr class="name_Table">
				<td id="pref_name_div" class="pmpro_checkout-field name_Table">
					<label for="pref_name">Preferred Name *</label>
					<input type="text" id="pref_name" name="pref_name" value="<?php if (!empty( $pmpro_error_fields)) {
						echo $pref_name;
					}
					else {
						echo esc_attr(get_user_meta($current_user->ID, 'pref_name', true)); 
					} ?>" size="20" class="input <?php echo pmpro_getClassForField("pref_name");?>">								    
				</td>
			</tr>								

			<tr class="name_Table">
				<td id="sec_email_div" class="pmpro_checkout-field name_Table">
					<label for="sec_email">Secondary Email Address</label>
					<input type="text" id="sec_email" name="sec_email" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'sec_email', true)); ?>" size="20">
				</td>
			</tr>

			<tr class="name_Table">
				<td id="prm_phone_div" class="pmpro_checkout-field name_Table">
					<label for="prm_phone">Primary Phone Number</label>
					<input type="text" id="prm_phone" name="prm_phone" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'prm_phone', true)); ?>" size="20">							    
				</td>
			</tr>								

			<tr class="name_Table">
				<td id="sec_phone_div" class="pmpro_checkout-field name_Table">
					<label for="sec_phone">Secondary Phone Number</label>
					<input type="text" id="sec_phone" name="sec_phone" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'sec_phone', true)); ?>" size="20">
				</td>
			</tr>				
		</table>

		<h3>Work Information</h3>	
		<input type="checkbox" id="IsLawStudent" name="IsLawStudent" onclick="triggerFn()" <?php echo get_user_meta($current_user->ID, 'is_law_student', true) == 1 ? 'checked="checked"' : ''; ?>> Select if you are a law student </input>

		<!-- Work Info-->
		<table class="name_Table" id="workContact">	
			<tr class="name_Table">
				<td id="company_name_div" class="pmpro_checkout-field name_Table">
					<label for="company_name">Company/Employer *</label>
					<input type="text" id="company_name" name="company_name" value="<?php if (!empty( $pmpro_error_fields)) {
						echo $company_name;
					}
					else {
						echo esc_attr(get_user_meta($current_user->ID, 'company_name', true)); 
					} ?>" size="20" class="input <?php echo pmpro_getClassForField("company_name");?>">							    
				</td>
			</tr>								

			<tr class="name_Table">
				<td id="position_div" class="pmpro_checkout-field name_Table">
					<label for="position">Position *</label>
					<input type="text" id="position" name="position" value="<?php if (!empty( $pmpro_error_fields)) {
						echo $position;
					}
					else {
						echo esc_attr(get_user_meta($current_user->ID, 'position', true)); 
					} ?>" size="20" class="input <?php echo pmpro_getClassForField("position");?>">	
				</td>
			</tr>			

			<tr class="name_Table">
				<td id="company_type_div" class="pmpro_checkout-field name_Table">
					<label for="company_type">Employer Type *</label>
					<select id="company_type" name="company_type" class="input <?php echo pmpro_getClassForField("company_type");?>" onchange="otherTxtbox(this, 1)">
						<option value=""></option>	
						<?php 										
							global $company_type_arr;
							$selected_type = get_user_meta($current_user->ID, 'company_type', true);
							if (!empty($pmpro_error_fields)) $selected_type = $company_type;
							foreach($company_type_arr as $type){
								if ( !empty($selected_type) && $selected_type == $type) {
									echo '<option value="'.$type.'" selected="selected">'.$type.'</option>';
								}
								else{
									echo '<option value="'.$type.'" >'.$type.'</option>';
								}
							}
						?>
					</select>                                       
				</td>
				<td id="otherTxtWork" class="pmpro_checkout-field name_Table" style="visibility:hidden;">
					<label for="company_other">Other Type *</label>
					<input type="text" id="company_other" name="company_other" value="<?php if (!empty( $pmpro_error_fields)) {
						echo $company_other;
					}
					else {
						echo esc_attr(get_user_meta($current_user->ID, 'company_other', true)); 
					} ?>" size="20" class="input <?php echo pmpro_getClassForField("company_other");?>">					
				</td>
			</tr>		
			
			<tr class="name_Table">
				<td id="company_size_div" class="pmpro_checkout-field name_Table">
					<label for="company_size">Employer Size *</label>
					<br/>
					<select id="company_size" name="company_size" class="input <?php echo pmpro_getClassForField("company_size");?>">
						<option value=""></option>	
						<?php 		
							global $company_size_arr;
							$size_db = get_user_meta($current_user->ID, 'company_size', true);
							if (!empty($pmpro_error_fields)) $size_db = $company_size;
							foreach($company_size_arr as $size){
								if (!empty($size_db) && $size_db == $size){
									echo '<option value="'.$size.'" selected="selected">'.$size.'</option>';
								}
								else{
									echo '<option value="'.$size.'" >'.$size.'</option>';
								}
							}
						?>
					</select>                                         
				</td>                                    
			</tr>

			
			<tr class="name_Table">
				<td id="company_city_div" class="pmpro_checkout-field name_Table">
					<label for="company_city">Office City</label>
					<input type="text" id="company_city" name="company_city" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'company_city', true)); ?>" size="20" class="input <?php echo pmpro_getClassForField("company_city");?>">						
				</td>

				<td id="company_state_div" class="pmpro_checkout-field name_Table">
					<label for="company_state">Office State</label>
					<select id="company_state" name="company_state" class="input <?php echo pmpro_getClassForField("company_state");?>">
						<option value=""></option>
						<?php 	
							global $company_state_arr;
							$selected_state = get_user_meta($current_user->ID, 'company_state', true);
							foreach($company_state_arr as $state){
								if ( !empty($selected_state) && $selected_state == $state) {
									echo '<option value="'.$state.'" selected="selected">'.$state.'</option>';
								}
								else{
									echo '<option value="'.$state.'" >'.$state.'</option>';
								}
							}
							?>	
					</select>								
				</td>
			</tr>							
		</table>

		<!-- School Info -->
		<table class="name_Table" id="schoolContact" style="display:none;">
			<tr class="name_Table">
				<td id="school_name_div" class="pmpro_checkout-field name_Table">
					<label for="school_name">Law School *</label>
					<select id="school_name" name="school_name" class="<?php echo pmpro_getClassForField("school_name");?>" onchange="otherTxtbox(this, 2)">
						<option value=""></option>	
						<?php 	
							global $school_name_arr;
							$selected_school = get_user_meta($current_user->ID, 'school_name', true);
							if (!empty($pmpro_error_fields)) $selected_school = $school_name;
							foreach($school_name_arr as $name){
								if ( !empty($selected_school) && $selected_school == $name) {
									echo '<option value="'.$name.'" selected="selected">'.$name.'</option>';
								}
								else{
									echo '<option value="'.$name.'" >'.$name.'</option>';
								}
							}
						?>					
					</select>                                          

				</td>			
				<td id="otherTxtSchool" class="pmpro_checkout-field name_Table" style="visibility:hidden;">
					<label for="school_other">Other Law School *</label>
					<input type="text" id="school_other" name="school_other" value="<?php if (!empty( $pmpro_error_fields)) {
						echo $school_other;
					}
					else {
						echo esc_attr(get_user_meta($current_user->ID, 'school_other', true)); 
					} ?>" size="20" class="input <?php echo pmpro_getClassForField("school_other");?>">	
				</td>			
			</tr>
			<tr class="name_Table">
				<td id="graduation_date_div" class="pmpro_checkout-field name_Table">
					<label for="graduation_date">Expected Graduation Year *</label>
					<input type="text" id="graduation_date" name="graduation_date" value="<?php if (!empty( $pmpro_error_fields)) {
						echo $graduation_date;
					}
					else {
						echo esc_attr(get_user_meta($current_user->ID, 'graduation_date', true)); 
					} ?>" size="20" class="input <?php echo pmpro_getClassForField("graduation_date");?>">			    
				</td>
			</tr>
		</table>

		<!-- More Info-->
		<h3>More Information</h3>

		<table class="name_Table">
			<tr class="name_Table">
				<td id="bar_admission_div" class="pmpro_checkout-field name_Table">
					<button onclick="addBarAdmission()" type="button">Add Bar Admission</button>
					</br>
					Type Your Bar Admission Jurisdiction and Year                        
					<div></div>
					<table class="name_Table">
						<tbody id="bar_admission_container" class="name_Table">
						<?php 	
								$ba_area_arr = explode(',', get_user_meta($current_user->ID, 'ba_area', true));
								$ba_date_arr = explode(',', get_user_meta($current_user->ID, 'ba_date', true));
								if (count($ba_area_arr) > 0){
									for ($i = 0; $i < count($ba_area_arr); $i++){
										?>
										<tr class="name_Table">
											<td style="float: left; margin-right: 5%; margin-left: 2%;" class="name_Table"><input type="text" name="ba_area[]" value="<?php echo esc_attr($ba_area_arr[$i]); ?>" 
											<?php if(empty($ba_area_arr[$i])) {
												?> placeholder="Jurisdiction/State" <?php
											} ?>/> </td>
											<td style="float: left;" class="name_Table"><input type="text" name="ba_date[]" value="<?php echo esc_attr($ba_date_arr[$i]); ?>" 
											<?php if(empty($ba_date_arr[$i])) {
												?> placeholder="YYYY" <?php
											} ?>/> </td>
											<td class="name_Table" style="float: left; margin-left: 3%; margin-top: -0.5%;"><span class="btnDelete" style="font-size: 25px; cursor: pointer;" onclick="deleteBarAdmission()">x</span></td>
										</tr> 
										<?php
									}
								}
							?>		
						</tbody>
					</table>
				</td>				
			</tr>

			<tr class="name_Table">
				<td id="kor_proficiency_div" class="pmpro_checkout-field name_Table">
					<label for="kor_proficiency">Korean Proficiency</label>
					<br/>
					<select id="kor_proficiency" name="kor_proficiency">
						<option value=""></option>	
						<?php 	
							global $lang_skills_arr;
							$selected_skill = get_user_meta($current_user->ID, 'kor_proficiency', true);
							foreach($lang_skills_arr as $skill){
								if ( !empty($selected_skill) && $selected_skill == $skill) {
									echo '<option value="'.$skill.'" selected="selected">'.$skill.'</option>';
								}
								else{
									echo '<option value="'.$skill.'" >'.$skill.'</option>';
								}
							}
						?>		
					</select>   
					<p></p> 
				</td>                                    
			</tr>
			<tr class="name_Table">
				<td id="other_languages_div" class="pmpro_checkout-field name_Table"> 
					<button onclick="addLanguage()" type="button">Add Other Language Skills</button>
					</br>
					Please provide other languages and skill level                        
					<div></div>
					<table class="name_Table">
						<tbody id="language_container" class="name_Table">
							<?php 	
								$lang_name_arr = explode(',', get_user_meta($current_user->ID, 'lang_name', true));
								$lang_level_arr = explode(',', get_user_meta($current_user->ID, 'lang_level', true));
								if (count($lang_name_arr) > 0){
									for ($i = 0; $i < count($lang_name_arr); $i++){
										?>
										<tr class="name_Table">
											<td style="float: left; margin-right: 5%; margin-left: 2%;" class="name_Table"><input type="text" name="lang_name[]" value="<?php echo esc_attr($lang_name_arr[$i]); ?>"
											<?php if(empty($lang_name_arr[$i])) {
												?> placeholder="Other Language" <?php
											} ?>/> </td>
											<td style="float: left; margin-top: 1%; width: 30%;" class="name_Table">
												<select name="lang_level[]">
													<option value="">Select Level</option>
													<?php 	
														global $lang_skills_arr;
														foreach($lang_skills_arr as $skill){
															if ( !empty($lang_level_arr[$i]) && $lang_level_arr[$i] == $skill) {
																echo '<option value="'.$skill.'" selected="selected">'.$skill.'</option>';
															}
															else{
																echo '<option value="'.$skill.'" >'.$skill.'</option>';
															}
														}
													?>		
												</select>
											</td>
											<td style="float: left; margin-top: -0.5%;" class='name_Table' ><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteLanguage()'>x</span></td>
										</tr>									
										<?php
									}
								}
							?>		
						</tbody>
					</table>
				</td>				
			</tr>		

			<tr class="name_Table">
				<td id="law_schools_div" class="pmpro_checkout-field name_Table"> 
					<button onclick="addLawSchool()" type="button">Add Law Schools</button>
					<div></div>
					<table class="name_Table" id="more_school_container" style="margin-left: 0%;">
							<?php 	
								$more_school_name_arr = explode(';', get_user_meta($current_user->ID, 'more_school_name', true));
								$more_school_other_arr = explode(',', get_user_meta($current_user->ID, 'more_school_other', true));
								if (count($more_school_name_arr) > 0){
									for ($i = 0; $i < count($more_school_name_arr); $i++){
										?>		
									<tbody class="name_Table">
										<tr class="name_Table">
											<td class="pmpro_checkout-field name_Table" style="padding-right: 10px;">
												<label for="more_school_name">Law School</label>
												<select id="more_school_name" name="more_school_name[]" onchange="otherSchoolTxtbox(this)">
													<option value=""></option>
													<?php 	
														global $school_name_arr;
														$selected_school = $more_school_name_arr[$i];
														foreach($school_name_arr as $name){
															if ( !empty($selected_school) && $selected_school == $name) {
																echo '<option value="'.$name.'" selected="selected">'.$name.'</option>';
															}
															else{
																echo '<option value="'.$name.'" >'.$name.'</option>';
															}
														}
														?>	
												</select>                                   
											</td>
											<td id="otherTxtSchoolInfo_<?php echo $i ?>" class="pmpro_checkout-field name_Table otherTxtSchoolInfo" style="visibility:hidden;">
												<label for="more_school_other">Other Law School</label>
												<input type="text" id="more_school_other" name="more_school_other[]" value="<?php echo esc_attr($more_school_other_arr[$i]); ?>" size="20">
											</td>
										</tr>	
										<tr>
											<td class='name_Table'><div style='margin-left: 0.5%;margin-top: -5%;'><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteLawSchool()'>x</span></div></td>						
										</tr>
									</tbody>
										<?php
									}
								}
							?>		
					</table>
				</td>				
			</tr>	

			<tr class="name_Table">
				<td id="graduation_year_div" class="pmpro_checkout-field name_Table">
					<label for="graduation_year">Graduation Year</label>
					<input type="text" id="graduation_year" name="graduation_year" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'graduation_year', true)); ?>" size="20">			    
					<p></p>
				</td>
			</tr>

			<tr class="name_Table">
				<td id="public_profile_div" class="pmpro_checkout-field name_Table">
					<label for="public_profile" style="font-size: 18px; font-weight: bold;">Public Profile URL <span style="font-size:75%;">(one of facebook, linkedin, lawfirm website and etc)<span></label>
					<input type="text" id="public_profile" name="public_profile" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'public_profile', true)); ?>" size="40">
					<p></p>
				</td>
			</tr>

			<tr class="name_Table">
				<td id="practice_areas_div" class="pmpro_checkout-field name_Table">
					<label for="practice_areas" style="font-size: 18px; font-weight: bold;">Practice Area(s)</label>
					<div>Please check all of your Practice Areas</div>
					<div id="practice_areas">
						<?php 	
							global $areas_arr;
							$selected_areas = explode(',', get_user_meta($current_user->ID, 'practice_areas', true));
							foreach($areas_arr as $area) {
								$checked="";
								if ( in_array($area, $selected_areas) ) {
									$checked = "checked";
								}

								if ($area == "Other") {
									echo '<input type="checkbox" name="areas[]" onchange="toggleTxtBox(this)" value="'.$area.'" '.$checked.'> '.$area.' </input></br>';
									$area_other = get_user_meta($current_user->ID, 'area_other', true);								
									echo '<input type="text" id="area_other" name="area_other" value="'.$area_other.'" size="20" style="visibility:hidden" placeholder="Other Area">';							
								}
								else{
									echo '<input type="checkbox" name="areas[]" value="'.$area.'" '.$checked.'> '.$area.' </input></br>';							
								}
							}
						?>	
					</div>
				</td>
			</tr>			
		</table>
		<p>
			<button type="submit" value="<?php esc_attr_e('Update Profile'); ?>"><?php esc_html_e('Update Profile'); ?></button>
			<a href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/membership-account"?>" style="margin-left: 10%;" ><?php _e("BACK", 'paid-memberships-pro' );?></a>
		</p>
	</form>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
