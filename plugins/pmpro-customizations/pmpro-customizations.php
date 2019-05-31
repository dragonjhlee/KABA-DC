<?php
/*
Plugin Name: PMPro Customizations
Plugin URI: https://www.paidmembershipspro.com/wp/pmpro-customizations/
Description: Customizations for my Paid Memberships Pro Setup
Version: .1
Author: Paid Memberships Pro
Author URI: https://www.paidmembershipspro.com
*/

/*
	Adding Customized Fields in Checkout Form
*/
$company_size_arr = array("Solo","Small","Medium","Large","N/A");
$company_type_arr = array("Private","Government","Non-Profit","In-house","Other");
$company_state_arr = array("Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","District Of Columbia","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana",
							"Iowa","Kansas","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey",
							"New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah",
							"Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");
$school_name_arr = array(
					"Abraham Lincoln University School of Law",
					"Albany Law School, Union University",
					"Alben W. Barkley School of Law",
					"American College of Law",
					"American Heritage University School of Law",
					"American International School of Law",
					"Appalachian School of Law",
					"Arizona Summit Law School, InfiLaw System",
					"Ave Maria School of Law",

					"Baylor Law School, Baylor University",
					"Beasley School of Law, Temple University",
					"Belmont University College of Law",
					"Benjamin N. Cardozo School of Law, Yeshiva University",
					"Birmingham School of Law",
					"Boston College Law School",
					"Boston University School of Law",
					"Brooklyn Law School",

					"Cal Northern School of Law",
					"California Desert Trial Academy College of Law",
					"California Midland School of Law",
					"California Pacific School of Law",
					"California School of Law",
					"California Southern Law School",
					"California Southern University",
					"California Western School of Law",
					"Capital University Law School",
					"Case Western Reserve University School of Law",
					"Cecil C. Humphreys School of Law, University of Memphis",
					"Chapman University School of Law",
					"Charleston School of Law",
					"Charlotte School of Law InfiLaw System",
					"Chicago-Kent College of Law, Illinois Institute of Technology",
					"City University of New York School of Law",
					"Cleveland-Marshall College of Law, Cleveland State University",
					"Columbia Law School",
					"Columbus School of Law, The Catholic University of America",
					"Concord Law School, Purdue University Global",
					"Concordia University School of Law",
					"Cornell Law School",
					"Creighton University School of Law",
					"Cumberland School of Law, Samford University",

					"David A. Clarke School of Law, University of the District of Columbia",
					"Dedman School of Law, Southern Methodist University",
					"DePaul University College of Law",
					"Diamond Graduate Law School LLM Online Program",
					"Dickinson School of Law, Penn State University",
					"Drake University Law School",
					"Drexel University School of Law",
					"Duke University School of Law",
					"Duncan School of Law, Lincoln Memorial University",
					"Duquesne University School of Law",
					"Dwayne O. Andreas School of Law",

					"Elon University School of Law",
					"Emory University School of Law",
					"Empire College School of Law",
					"Eugenio María de Hostos School of Law, Universidad de Puerto Rico",

					"Florida A&M University College of Law",
					"Florida Coastal School of Law, InfiLaw System",
					"Florida International University College of Law",
					"Florida State University College of Law",
					"Fordham University School of Law",

					"George Mason University School of Law",
					"Georgetown University Law Cente",
					"Georgia State University College of Law",
					"Glendale University College of Law",
					"Golden Gate University School of Law",
					"Gonzaga University School of Law",
					"Gould School of Law, University of Southern California",

					"Hamline University School of Law",
					"Harvard Law School",
					"Hofstra University School of Law",
					"Howard University School of Law",

					"Illinois Wesleyan University Law School",
					"Indiana Tech Law School",
					"Indiana University Robert H. McKinney School of Law",
					"Inland Valley University College of Law",
					"Interamerican University of Puerto Rico School of Law",
					"International Pacific School of Law",
					"Irvine University College of Law",

					"J. Reuben Clark Law School, Brigham Young University",
					"James E. Rogers College of Law, University of Arizona",
					"John F. Kennedy University College of Law",
					"John Marshall Law School",
					"Judge John Haywood Law School",

					"La Salle Extension University",
					"Larry H. Layton School of Law",
					"Laurence Drivon School of Law, Humphreys College",
					"Lewis & Clark Law School",
					"Liberty University School of Law",
					"Lincoln College of Law",
					"Lincoln Law School of Sacramento",
					"Lincoln Law School of San Jose",
					"Lincoln University School of Law",
					"Litchfield Law School",
					"Lorenzo Patiño School of Law, University of Northern California",
					"Louis D. Brandeis School of Law, University of Louisville",
					"Loyola Law School, Loyola Marymount University",
					"Loyola University Chicago School of Law",
					"Loyola University New Orleans College of Law",

					"Marquette University Law School",
					"Marshall-Wythe School of Law, The College of William and Mary",
					"Massachusetts School of Law",
					"Maurer School of Law, Indiana University Bloomington",
					"Maynard-Knox Law School, Hamilton College",
					"McGeorge School of Law, University of the Pacific",
					"McMillan Academy of Law",
					"MD Kirk School of Law",
					"Michael E. Moritz College of Law, Ohio State University",
					"Michigan State University College of Law",
					"Miles Law School",
					"Mississippi College School of Law",
					"Monterey College of Law",

					"Nashville School of Law",
					"National University School of Law",
					"New College of California School of Law",
					"New England School of Law",
					"New York Law School",
					"New York University School of Law",
					"Norman Adrian Wiggins School of Law, Campbell University",
					"North Carolina Central University School of Law",
					"Northampton Law School",
					"Northeastern University School of Law",
					"Northern Illinois University College of Law",
					"Northrop University",
					"Northwestern California University School of Law",
					"Northwestern University School of Law",
					"Notre Dame Law School",

					"O. W. Coburn School of Law",
					"Oak Brook College of Law",
					"Ohio Northern University, Pettit College of Law",
					"Oklahoma City University School of Law",

					"Pace University School of Law",
					"Pacific Coast University School of Law",
					"Pacific West College of Law",
					"Paul M. Hebert Law Center, Louisiana State University",
					"Penn State Law, Penn State University",
					"Peoples College of Law",
					"Pepperdine University School of Law",
					"Pinnacles School of Law",
					"Pontifical Catholic University of Puerto Rico School of Law",
					"Pressler School of Law, Louisiana College",
					"Princeton Law School",

					"Quinnipiac University School of Law",

					"Regent University School of Law",
					"Robert H. Terrell Law School",
					"Roger Williams University School of Law",
					"Rutgers Law School (Camden campus)",
					"Rutgers Law School (Newark campus)",

					"S.J. Quinney College of Law, University of Utah",
					"Saint Louis University School of Law",
					"Salmon P. Chase College of Law, Northern Kentucky University",
					"San Francisco Law School",
					"San Joaquin College of Law",
					"Sandra Day O Connor College of Law, Arizona State University",
					"Santa Barbara College of Law",
					"Santa Clara University School of Law",
					"Savannah Law School",
					"Seattle University School of Law",
					"Seton Hall University School of Law",
					"Shepard Broad Law Center, Nova Southeastern University",
					"South Texas College of Law",
					"Southern California Institute of Law",
					"Southern Illinois University School of Law",
					"Southern University Law Center",
					"Southwestern University School of Law",
					"St. Francis School of Law",
					"St. John Fisher College School of Law",
					"St. Johns University School of Law",
					"St. Marys University School of Law",
					"St. Thomas University School of Law",
					"Stanford Law School",
					"State and National Law School",
					"Stetson University College of Law",
					"Sturm College of Law, University of Denver",
					"Suffolk University Law School",
					"Syracuse University College of Law",

					"Taft Law School, William Howard Taft University",
					"Texas A&M University School of Law",
					"Texas Tech University School of Law",
					"The George Washington University Law School",
					"The Judge Advocate Generals Legal Center and School",
					"Thomas Goode Jones School of Law, Faulkner University",
					"Thomas Jefferson School of Law",
					"Thurgood Marshall School of Law, Texas Southern University",
					"Touro College Jacob D. Fuchsberg Law Center",
					"Trinity Law School, Trinity International University",
					"Tulane University School of Law",

					"University at Buffalo Law School, SUNY",
					"University of Akron School of Law",
					"University of Alabama School of Law",
					"University of Alaska at Anchorage",
					"University of Arkansas School of Law",
					"University of Baltimore School of Law",
					"University of California, Berkeley School of Law (Boalt Hall)",
					"University of California, Davis School of Law (King Hall)",
					"University of California, Hastings College of the Law",
					"University of California, Irvine School of Law",
					"University of California, Los Angeles School of Law",
					"University of Chicago Law School",
					"University of Cincinnati College of Law",
					"University of Colorado School of Law",
					"University of Connecticut School of Law",
					"University of Dayton School of Law",
					"University of Detroit Mercy School of Law",
					"University of Florida Levin College of Law",
					"University of Georgia School of Law",
					"University of Honolulu School of Law",
					"University of Houston Law Cente",
					"University of Idaho College of Law",
					"University of Illinois College of Law",
					"University of Iowa College of Law",
					"University of Kansas School of Law",
					"University of Kentucky College of Law",
					"University of La Verne College of Law",
					"University of Maine School of Law",
					"University of Maryland School of Law",
					"University of Massachusetts School of Law",
					"University of Miami School of Law",
					"University of Michigan Law School",
					"University of Minnesota Law School",
					"University of Mississippi School of Law",
					"University of Missouri - Kansas City School of Law",
					"University of Missouri School of Law",
					"University of Montana School of Law",
					"University of Nebraska–Lincoln College of Law",
					"University of New Hampshire School of Law",
					"University of New Mexico School of Law",
					"University of North Carolina School of Law",
					"University of North Dakota School of Law",
					"University of North Texas at Dallas College of Law",
					"University of Oklahoma College of Law",
					"University of Oregon School of Law",
					"University of Pennsylvania Law School",
					"University of Pittsburgh School of Law",
					"University of Puerto Rico School of Law",
					"University of Richmond School of Law",
					"University of San Diego School of Law",
					"University of San Francisco School of Law",
					"University of San Luis Obispo School of Law",
					"University of Silicon Valley Law School",
					"University of South Carolina School of Law",
					"University of South Dakota School of Law",
					"University of St. Thomas School of Law",
					"University of Tennessee College of Law",
					"University of Texas School of Law",
					"University of Toledo College of Law",
					"University of Tulsa College of Law",
					"University of Virginia School of Law",
					"University of Washington School of Law",
					"University of West Los Angeles School of Law",
					"University of Wisconsin Law School",
					"University of Wyoming College of Law",

					"Valparaiso University School of Law",
					"Vanderbilt University Law School",
					"Ventura College of Law",
					"Vermont Law School",
					"Villanova University School of Law",

					"Wake Forest University School of Law",
					"Walter F. George School of Law, Mercer University",
					"Washburn University School of Law",
					"Washington and Lee University School of Law",
					"Washington College of Law, American University",
					"Washington University School of Law",
					"Wayne State University Law School",
					"West Virginia University College of Law",
					"Western Michigan University Thomas M. Cooley Law School",
					"Western New England University School of Law",
					"Western Sierra Law School",
					"Western State College of Law",
					"Whittier Law School",
					"Widener Law Commonwealth",
					"Widener University School of Law",
					"Willamette University College of Law",
					"William H. Bowen School of Law, University of Arkansas at Little Rock",
					"William Mitchell College of Law",
					"William S. Boyd School of Law, University of Nevada, Las Vegas",
					"William S. Richardson School of Law, University of Hawaii",
					"Winchester Law School",
					"Woodrow Wilson College of Law",

					"Yale Law School",

					"Other"
				);
$lang_skills_arr = array("N/A",	"Conversational","Fluent","Native");

$areas_arr = array(	"Adoption",	"Antitrust","Appellate","Bankruptcy","Child custody/support","Civil litigation","Class Action","Commercial","Contract","Copyright",	"Corporate","Criminal",	"Discrimination",
					"Divorce","Employment",	"Estate Planning","Family","Government","Health Care","Immigration","Insurance","Intellectual Property","International","International Trade","Labor","Land Use (planning/zoning)",
					"Litigation","Malpractice",	"Not for Profit","Patent and Trademark","Personal Injury","Privacy","Product Liability","Real Estate","Regulatory",	"Tax","Traffic (DUI & DWI)","White Collar",
					"Wills/Trusts & Estate Planning","Other"
				);
//add the fields to the form
function my_pmpro_checkout_after_password()
{
	// Contact Info
	if(!empty($_REQUEST['first_name']))
		$first_name = $_REQUEST['first_name'];
	else
		$first_name = "";
	if(!empty($_REQUEST['last_name']))
		$last_name = $_REQUEST['last_name'];
	else
		$last_name = "";
	if(!empty($_REQUEST['pref_name']))
		$pref_name = $_REQUEST['pref_name'];
	else
		$pref_name = "";
	if(!empty($_REQUEST['sec_email']))
		$sec_email = $_REQUEST['sec_email'];
	else
		$sec_email = "";
	if(!empty($_REQUEST['prm_phone']))
		$prm_phone = $_REQUEST['prm_phone'];
	else
		$prm_phone = "";
	if(!empty($_REQUEST['sec_phone']))
		$sec_phone = $_REQUEST['sec_phone'];
	else
		$sec_phone = "";


	// work Info
	if(!empty($_REQUEST['company_name']))
		$company_name = $_REQUEST['company_name'];
	else
		$company_name = "";
	if(!empty($_REQUEST['position']))
		$position = $_REQUEST['position'];
	else
		$position = "";
	if(!empty($_REQUEST['company_other']))
		$company_other = $_REQUEST['company_other'];
	else
		$company_other = "";
	if(!empty($_REQUEST['company_city']))
		$company_city = $_REQUEST['company_city'];
	else
		$company_city = "";

	// School Info
	if(!empty($_REQUEST['school_other']))
		$school_other = $_REQUEST['school_other'];
	else
		$school_other = "";
	if(!empty($_REQUEST['graduation_date']))
		$graduation_date = $_REQUEST['graduation_date'];
	else
		$graduation_date = "";

	// More Info

	if(!empty($_REQUEST['graduation_year']))
		$graduation_year = $_REQUEST['graduation_year'];
	else
		$graduation_year = "";
	if(!empty($_REQUEST['public_profile']))
		$public_profile = $_REQUEST['public_profile'];
	else
		$public_profile = "";

	if(!empty($_REQUEST['area_other']))
		$area_other = $_REQUEST['area_other'];
	else
		$area_other = "";
?>
	<script type="text/javascript">
		jQuery(document).ready(function () {

			var isSchool = "<?php echo !empty($_REQUEST['IsLawStudent']); ?>";
			if (isSchool == 1){
			document.getElementById("workContact").style.display = "none";
			document.getElementById("schoolContact").style.display = "block";
			}
			else{
			document.getElementById("workContact").style.display = "block";
			document.getElementById("schoolContact").style.display = "none";
			}

			var companyType = "<?php echo $_REQUEST['company_type']; ?>";
			if (companyType == "Other"){
				document.getElementById("otherTxtWork").style.visibility="visible";
			}
			else{
				document.getElementById("otherTxtWork").style.visibility="hidden";
			}

			var schoolName = "<?php echo $_REQUEST['school_name']; ?>";
			if (schoolName == "Other"){
				document.getElementById("otherTxtSchool").style.visibility="visible";
			}
			else{
				document.getElementById("otherTxtSchool").style.visibility="hidden";
			}

			var areaOtherTxt = document.getElementById("area_other");
			if (areaOtherTxt.value != "") {
				areaOtherTxt.style.visibility="visible";
			}
		});
			function otherTxtbox(obj, location){
				var txtBoxId = "";
				switch (location) {
					case 1: //company
						txtBoxId = "otherTxtWork";
						break;
					case 2: //school
						txtBoxId = "otherTxtSchool";
						break;
					default:
						txtBoxId = "";
				}

				if (obj.value=="Other")
				{
				document.getElementById(txtBoxId).style.visibility="visible";
				}
				else
				{
				document.getElementById(txtBoxId).style.visibility="hidden";
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
				+ "<td class='name_Table'><input type='text' name='ba_area[]' class='kaba_txtBox' placeholder='Jurisdiction/State' /></td>"
				+ "<td class='name_Table'><input type='text' name='ba_date[]' class='kaba_txtBox' placeholder='YYYY' /></td>"
				+ "<td class='name_Table' style='float: left; margin-top: 30%;'><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteBarAdmission()'>x</span></td>"
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
				+ "<td class='name_Table'><input type='text' name='lang_name[]' class='kaba_txtBox' style='margin-top:5%' placeholder='Other Language' /></td>"
				+ "<td class='name_Table'>"
				+ "<select name='lang_level[]' class='kaba_select' style='width:250px'>"
				+ "<option value=''>Select Level</option>"
				+ "<option value='N/A'>N/A</option>"
				+ "<option value='Conversational'>Conversational</option>"
				+ "<option value='Fluent'>Fluent</option>"
				+ "<option value='Native'>Native</option>"
				+ "</select></td>"
				+ "<td class='name_Table'><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteLanguage()'>x</span></td>"
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
					jQuery(obj).closest('tr').find('td#otherTxtSchoolInfo').attr("style", "visibility: visible");
				}
				else
				{
					jQuery(obj).closest('tr').find('td#otherTxtSchoolInfo').attr("style", "visibility: hidden");
					jQuery(obj).closest('tr').find('input').val("");
				};
			}

			function addLawSchool(){
				var phpCode = '<?php global $school_name_arr; foreach($school_name_arr as $name){ echo '<option value="'.$name.'" >'.$name.'</option>'; }?>';
				var fields = '<tbody class="name_Table"><tr class="name_Table more_school">'
				+			'<td id="more_school_name_div" class="pmpro_checkout-field name_Table">'
				+				'<label for="more_school_name">Law School</label>'
				+				'<select id="more_school_name" name="more_school_name[]" onchange="otherSchoolTxtbox(this)" class="kaba_select">'
				+					'<option value=""></option>'
				+ phpCode
				+				'</select>'
				+			'</td>'
				+			'<td id="otherTxtSchoolInfo" class="pmpro_checkout-field name_Table" style="visibility:hidden;">'
				+				'<label for="more_school_other">Other Law School</label>'
				+				'<input type="text" name="more_school_other[]" size="20" class="kaba_txtBox">'
				+			'</td>'
				+		"</tr>"
				+ "<tr><td class='name_Table'><div><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteLawSchool()'>x</span></div></td></tr></tbody>"
				// +		'<tr class="name_Table">'
				// +			'<td id="graduation_year_div" class="pmpro_checkout-field name_Table">'
				// +				'<label for="graduation_year">Graduation Year</label>'
				// +				'<input type="text" name="graduation_year[]" size="20">'
				// +			'</td>'

				// + 		"</tr>";
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

	<br/>
	<!-- Uncheck below to be hidden from directory-->
	<label for="public_directory">
			<input name="public_directory" type="checkbox" id="public_directory" value="1">
			<?php printf(__(' Click if you would like your information to be included in our public directory.')); ?>
	</label>

	<!-- Contact -->
	<h3>Contact Information</h3>
	<table class="name_Table">
		<tr class="name_Table">
			<td id="first_name_div" class="pmpro_checkout-field name_Table">
				<label for="first_name">First Name</label>
				<input type="text" id="first_name" name="first_name" value="<?php echo esc_attr($first_name); ?>" size="20" class="input <?php echo pmpro_getClassForField("first_name");?>">
			</td>

			<td id="Last Name_div" class="pmpro_checkout-field name_Table">
				<label for="last_name">Last Name</label>
				<input type="text" id="last_name" name="last_name" value="<?php echo esc_attr($last_name); ?>" size="20" class="input <?php echo pmpro_getClassForField("last_name");?>">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="pref_name_div" class="pmpro_checkout-field name_Table">
				<label for="pref_name">Preferred Name</label>
				<input type="text" id="pref_name" name="pref_name" value="<?php echo esc_attr($pref_name); ?>" size="20" class="input <?php echo pmpro_getClassForField("pref_name");?>">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="sec_email_div" class="pmpro_checkout-field name_Table">
				<label for="sec_email">Secondary Email Address</label>
				<input type="text" id="sec_email" name="sec_email" value="<?php echo esc_attr($sec_email); ?>" size="20">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="prm_phone_div" class="pmpro_checkout-field name_Table">
				<label for="prm_phone">Primary Phone Number</label>
				<input type="text" id="prm_phone" name="prm_phone" value="<?php echo esc_attr($prm_phone); ?>" size="20">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="sec_phone_div" class="pmpro_checkout-field name_Table">
				<label for="sec_phone">Secondary Phone Number</label>
				<input type="text" id="sec_phone" name="sec_phone" value="<?php echo esc_attr($sec_phone); ?>" size="20">
			</td>
		</tr>
	</table>

	<h3>Work Information</h3>
	<input type="checkbox" id="IsLawStudent" name="IsLawStudent" onclick="triggerFn()" <?php echo (!empty($_REQUEST['IsLawStudent']) ? 'checked="checked"' : '');?>> Select if you are a law student </input>

	<!-- Work Info-->
	<table class="name_Table" id="workContact">
		<tr class="name_Table">
			<td id="company_name_div" class="pmpro_checkout-field name_Table">
				<label for="company_name">Company/Employer</label>
				<input type="text" id="company_name" name="company_name" value="<?php echo esc_attr($company_name); ?>" size="20" class="input <?php echo pmpro_getClassForField("company_name");?>">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="position_div" class="pmpro_checkout-field name_Table">
				<label for="position">Position</label>
				<input type="text" id="position" name="position" value="<?php echo esc_attr($position); ?>" size="20" class="input <?php echo pmpro_getClassForField("position");?>">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="company_type_div" class="pmpro_checkout-field name_Table">
				<label for="company_type">Employer Type</label>
				<select id="company_type" name="company_type" class="input <?php echo pmpro_getClassForField("company_type");?>" onchange="otherTxtbox(this, 1)">
					<option value=""></option>
					<?php
						global $company_type_arr;
						$selected_type = $_REQUEST['company_type'];
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
				<label for="company_other">Other Type</label>
				<input type="text" id="company_other" name="company_other" value="<?php echo esc_attr($company_other); ?>" size="20" class="input <?php echo pmpro_getClassForField("company_other");?>">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="company_size_div" class="pmpro_checkout-field name_Table">
				<label for="company_size">Employer Size</label>
				<select id="company_size" name="company_size" class="input <?php echo pmpro_getClassForField("company_size");?>">
					<option value=""></option>
					<?php
						global $company_size_arr;
						$selected_size = $_REQUEST['company_size'];
						foreach($company_size_arr as $size){
							if ( !empty($selected_size) && $selected_size == $size) {
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
				<input type="text" id="company_city" name="company_city" value="<?php echo esc_attr($company_city); ?>" size="20" class="input <?php echo pmpro_getClassForField("company_city");?>">
			</td>

			<td id="company_state_div" class="pmpro_checkout-field name_Table">
				<label for="company_state">Office State</label>
				<select id="company_state" name="company_state" style="width:300px;" class="input <?php echo pmpro_getClassForField("company_state");?>">
					<option value=""></option>
					<?php
						global $company_state_arr;
						$selected_state = $_REQUEST['company_state'];
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
				<label for="school_name">Law School</label>
				<select id="school_name" name="school_name" class="<?php echo pmpro_getClassForField("school_name");?>" onchange="otherTxtbox(this, 2)">
					<option value=""></option>
					<?php
						global $school_name_arr;
						$selected_school = $_REQUEST['school_name'];
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
				<label for="school_other">Other Law School</label>
				<input type="text" id="school_other" name="school_other" value="<?php echo esc_attr($school_other); ?>" size="20" class="<?php echo pmpro_getClassForField("school_other");?>">
			</td>
		</tr>
		<tr class="name_Table">
			<td id="graduation_date_div" class="pmpro_checkout-field name_Table">
				<label for="graduation_date">Expected Graduation Year</label>
				<input type="text" id="graduation_date" name="graduation_date" size="20" class="input <?php echo pmpro_getClassForField("graduation_date");?>">
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
						<tr class="name_Table">
							<td class="name_Table"><input type="text" name="ba_area[]" placeholder="Jurisdiction/State" /></td>
							<td class="name_Table"><input type="text" name="ba_date[]" placeholder="YYYY"/></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

		<tr class="name_Table">
			<td id="kor_proficiency_div" class="pmpro_checkout-field name_Table">
				<label for="kor_proficiency">Korean Proficiency</label>
				<select id="kor_proficiency" name="kor_proficiency">
					<option value=""></option>
					<?php
						global $lang_skills_arr;
						$selected_skill = $_REQUEST['kor_proficiency'];
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
						<tr class="name_Table">
							<td style="float: left; margin-top: 5%;" class="name_Table"><input type="text" name="lang_name[]" placeholder="Other Language" /></td>
							<td class="name_Table">
								<!-- <label for="lang_level[]">Skill Level</label> -->
								<select name="lang_level[]" style="width:250px">
									<option value="">Select Level</option>
									<?php
										global $lang_skills_arr;
										foreach($lang_skills_arr as $skill){
											echo '<option value="'.$skill.'" >'.$skill.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

		<tr class="name_Table">
			<td id="law_schools_div" class="pmpro_checkout-field name_Table">
				<button onclick="addLawSchool()" type="button">Add Law Schools</button>
				<div></div>
				<table class="name_Table" id="more_school_container" style="margin-left: 0%;">
					<tbody class="name_Table">
						<tr class="name_Table">
							<td class="pmpro_checkout-field name_Table">
								<label for="more_school_name">Law School</label>
								<select id="more_school_name" name="more_school_name[]" onchange="otherSchoolTxtbox(this)">
									<option value=""></option>
									<?php
										global $school_name_arr;
										$selected_school = $_REQUEST['more_school_name'];
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
							<td id="otherTxtSchoolInfo" class="pmpro_checkout-field name_Table" style="visibility:hidden;">
								<label for="more_school_other">Other Law School</label>
								<input type="text" id="more_school_other" name="more_school_other[]" value="<?php echo esc_attr($more_school_other); ?>" size="20">
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

		<!-- <tr>
			<td id="more_school_name_div" class="pmpro_checkout-field name_Table">
				<label for="more_school_name">Law School</label>
				<select id="more_school_name" name="more_school_name" onchange="otherTxtbox(this, 3)">
					<option value=""></option>
					<?php
						global $school_name_arr;
						$selected_school = $_REQUEST['more_school_name'];
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
			<td id="otherTxtSchoolInfo" class="pmpro_checkout-field name_Table" style="visibility:hidden;">
				<label for="more_school_other">Other Law School</label>
				<input type="text" id="more_school_other" name="more_school_other" value="<?php echo esc_attr($more_school_other); ?>" size="20">
			</td>
		</tr>-->

		<tr class="name_Table">
			<td id="graduation_year_div" class="pmpro_checkout-field name_Table">
				<label for="graduation_year">Graduation Year</label>
				<input type="text" id="graduation_year" name="graduation_year" value="<?php echo esc_attr($graduation_year); ?>" size="20">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="public_profile_div" class="pmpro_checkout-field name_Table">
				<label for="public_profile" style="font-size: 18px; font-weight: bold;">Public Profile URL<span style="font-size:75%;">(one of facebook, linkedin, lawfirm website and etc)<span></label>
				<input type="text" id="public_profile" name="public_profile" value="<?php echo esc_attr($public_profile); ?>" size="40">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="practice_areas_div" class="pmpro_checkout-field name_Table">
				<label for="practice_areas" style="font-size: 18px; font-weight: bold;">Practice Area(s)</label>
				<div>Please check all of your Practice Areas</div>
				<div id="practice_areas">
					<?php
						global $areas_arr;
						$selected_areas = $_REQUEST['areas'];
						foreach($areas_arr as $area){
							$checked="";
							if ( in_array($area, $selected_areas) ) {
								$checked = "checked";
							}
							if ($area == "Other") {
								echo '<input type="checkbox" name="areas[]" onchange="toggleTxtBox(this)" value="'.$area.'" '.$checked.'> '.$area.' </input></br>';
								echo '<input type="text" id="area_other" name="area_other" value="'.esc_attr($area_other).'" size="20" style="visibility:hidden" placeholder="Other Area">';
							}
							else{
								echo '<input type="checkbox" name="areas[]" value="'.$area.'" '.$checked.'> '.$area.' </input></br>';
							}
						}
					?>
					<!-- <input type="checkbox" name="areas[]" value="Adoption"> Adoption </input></br>
					<input type="checkbox" name="areas[]" value="Antitrust"> Antitrust </input></br>
					<input type="checkbox" name="areas[]" value="Appellate"> Appellate </input></br>
					<input type="checkbox" name="areas[]" value="Bankruptcy"> Bankruptcy </input></br>
					<input type="checkbox" name="areas[]" value="Child custody/support"> Child custody/support </input></br>
					<input type="checkbox" name="areas[]" value="Civil litigation"> Civil litigation </input></br>
					<input type="checkbox" name="areas[]" value="Class Action"> Class Action </input></br>
					<input type="checkbox" name="areas[]" value="Commercial"> Commercial </input></br>
					<input type="checkbox" name="areas[]" value="Contract"> Contract </input></br>
					<input type="checkbox" name="areas[]" value="Copyright"> Copyright </input></br>
					<input type="checkbox" name="areas[]" value="Corporate"> Corporate </input></br>
					<input type="checkbox" name="areas[]" value="Criminal"> Criminal </input></br>
					<input type="checkbox" name="areas[]" value="Discrimination"> Discrimination </input></br>
					<input type="checkbox" name="areas[]" value="Divorce"> Divorce </input></br>
					<input type="checkbox" name="areas[]" value="Employment"> Employment </input></br>
					<input type="checkbox" name="areas[]" value="Estate Planning"> Estate Planning </input></br>
					<input type="checkbox" name="areas[]" value="Family"> Family </input></br>
					<input type="checkbox" name="areas[]" value="Government"> Government </input></br>
					<input type="checkbox" name="areas[]" value="Health Care"> Health Care </input></br>
					<input type="checkbox" name="areas[]" value="Immigration"> Immigration </input></br>
					<input type="checkbox" name="areas[]" value="Insurance"> Insurance </input></br>
					<input type="checkbox" name="areas[]" value="Intellectual Property"> Intellectual Property </input></br>
					<input type="checkbox" name="areas[]" value="International"> International </input></br>
					<input type="checkbox" name="areas[]" value="International Trade"> International Trade </input></br>
					<input type="checkbox" name="areas[]" value="Labor"> Labor </input></br>
					<input type="checkbox" name="areas[]" value="Land Use (planning/zoning)"> Land Use (planning/zoning) </input></br>
					<input type="checkbox" name="areas[]" value="Litigation"> Litigation </input></br>
					<input type="checkbox" name="areas[]" value="Malpractice"> Malpractice </input></br>
					<input type="checkbox" name="areas[]" value="Not for Profit"> Not for Profit </input></br>
					<input type="checkbox" name="areas[]" value="Patent and Trademark"> Patent and Trademark </input></br>
					<input type="checkbox" name="areas[]" value="Personal Injury"> Personal Injury </input></br>
					<input type="checkbox" name="areas[]" value="Privacy"> Privacy </input></br>
					<input type="checkbox" name="areas[]" value="Product Liability"> Product Liability </input></br>
					<input type="checkbox" name="areas[]" value="Real Estate"> Real Estate </input></br>
					<input type="checkbox" name="areas[]" value="Regulatory"> Regulatory </input></br>
					<input type="checkbox" name="areas[]" value="Tax"> Tax </input></br>
					<input type="checkbox" name="areas[]" value="Traffic (DUI & DWI)"> Traffic (DUI & DWI) </input></br>
					<input type="checkbox" name="areas[]" value="White Collar"> White Collar </input></br>
					<input type="checkbox" name="areas[]" value="Wills/Trusts & Estate Planning"> Wills/Trusts & Estate Planning </input></br>
					<input type="checkbox" name="areas[]" value="Other"> Other </input></br>                                 -->
				</div>
			</td>
		</tr>
	</table>
<?php
}
add_action('pmpro_checkout_after_user_fields', 'my_pmpro_checkout_after_password');









function my_show_extra_profile_fields($user)
{
?>
	<script type="text/javascript">
		jQuery(document).ready(function () {

			var isSchool = "<?php echo get_user_meta($user->ID, 'is_law_student', true); ?>";
			if (isSchool == 1){
			document.getElementById("workContact").style.display = "none";
			document.getElementById("schoolContact").style.display = "block";
			}
			else{
			document.getElementById("workContact").style.display = "block";
			document.getElementById("schoolContact").style.display = "none";
			}

			var companyType = "<?php echo get_user_meta($user->ID, 'company_type', true); ?>";
			if (companyType == "Other"){
				document.getElementById("otherTxtWork").style.visibility="visible";
			}
			else{
				document.getElementById("otherTxtWork").style.visibility="hidden";
			}

			var companyType = "<?php echo get_user_meta($user->ID, 'school_name', true); ?>";
			if (companyType == "Other"){
				document.getElementById("otherTxtSchool").style.visibility="visible";
			}
			else{
				document.getElementById("otherTxtSchool").style.visibility="hidden";
			}

			var getSchoolArr = "<?php echo implode(";", get_user_meta($user->ID, 'more_school_name', false) ) ; ?>";
			var moreSchoolArr = getSchoolArr.split(";");
			for (var i = 0; i < moreSchoolArr.length; i++){
				if (moreSchoolArr[i] == "Other") {
					document.getElementById("otherTxtSchoolInfo_" + i).style.visibility="visible";
				}
			}

			var areaOtherTxt = "<?php echo get_user_meta($user->ID, 'area_other', true); ?>";
			if (areaOtherTxt.value != "") {
				document.getElementById("area_other").style.visibility="visible";
			}
			else{
				document.getElementById("area_other").style.visibility="hidden";
			}

		});
		function otherTxtbox(obj, location){
				var txtBoxId = "";
				switch (location) {
					case 1: //company
						txtBoxId = "otherTxtWork";
						break;
					case 2: //school
						txtBoxId = "otherTxtSchool";
						break;
					default:
						txtBoxId = "";
				}

				if (obj.value=="Other")
				{
				document.getElementById(txtBoxId).style.visibility="visible";
				}
				else
				{
				document.getElementById(txtBoxId).style.visibility="hidden";
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
				+ "<td class='name_Table'><input type='text' name='ba_area[]' class='kaba_txtBox' placeholder='Jurisdiction/State' /></td>"
				+ "<td style='float: left;' class='name_Table'><input type='text' name='ba_date[]' class='kaba_txtBox' placeholder='YYYY' /></td>"
				+ "<td class='name_Table' style='margin-left: 3%; margin-top: -0.5%;'><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteBarAdmission()'>x</span></td>"
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
				+ "<td class='name_Table'><input type='text' name='lang_name[]' placeholder='Other Language' /></td>"
				+ "<td class='name_Table'>"
				+ "<select name='lang_level[]'>"
				+ "<option value=''>Select Level</option>"
				+ "<option value='N/A'>N/A</option>"
				+ "<option value='Conversational'>Conversational</option>"
				+ "<option value='Fluent'>Fluent</option>"
				+ "<option value='Native'>Native</option>"
				+ "</select></td>"
				+ "<td class='name_Table'><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteLanguage()'>x</span></td>"
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
				+			'<td id="more_school_name_div" class="pmpro_checkout-field name_Table">'
				+				'<label for="more_school_name">Law School</label>'
				+				'<select id="more_school_name" name="more_school_name[]" onchange="otherSchoolTxtbox(this)">'
				+					'<option value=""></option>'
				+ phpCode
				+				'</select>'
				+			'</td>'
				+			'<td id="otherTxtSchoolInfo" class="pmpro_checkout-field name_Table otherTxtSchoolInfo" style="visibility:hidden;">'
				+				'<label for="more_school_other">Other Law School</label>'
				+				'<input type="text" name="more_school_other[]" id="more_school_other" size="20">'
				+			'</td>'
				+		"</tr>"
				+ "<tr><td class='name_Table'><div><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteLawSchool()'>x</span></div></td></tr></tbody>"
				// +		'<tr class="name_Table">'
				// +			'<td id="graduation_year_div" class="pmpro_checkout-field name_Table">'
				// +				'<label for="graduation_year">Graduation Year</label>'
				// +				'<input type="text" name="graduation_year[]" size="20">'
				// +			'</td>'

				// + 		"</tr>";
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

	<!-- Contact -->
	<h3> Additional Contact Information</h3>
	<table class="name_Table">
		<tr class="name_Table">
			<td id="pref_name_div" class="pmpro_checkout-field name_Table">
				<label for="pref_name">Preferred Name</label>
				<input type="text" id="pref_name" name="pref_name" value="<?php echo esc_attr( get_user_meta($user->ID, 'pref_name', true) ); ?>" size="20">
			</td>
		</tr>
		<tr class="name_Table">
			<td id="sec_email_div" class="pmpro_checkout-field name_Table">
				<label for="sec_email">Secondary Email Address</label>
				<input type="text" id="sec_email" name="sec_email" value="<?php echo esc_attr( get_user_meta($user->ID, 'sec_email', true) ); ?>" size="20">
			</td>
		</tr>
		<tr class="name_Table">
			<td id="prm_phone_div" class="pmpro_checkout-field name_Table">
				<label for="prm_phone">Primary Phone Number</label>
				<input type="text" id="prm_phone" name="prm_phone" value="<?php echo esc_attr( get_user_meta($user->ID, 'prm_phone', true) ); ?>" size="20">
			</td>
		</tr>
		<tr class="name_Table">
			<td id="sec_phone_div" class="pmpro_checkout-field name_Table">
				<label for="sec_phone">Secondary Phone Number</label>
				<input type="text" id="sec_phone" name="sec_phone" value="<?php echo esc_attr( get_user_meta($user->ID, 'sec_phone', true) ); ?>" size="20">
			</td>
		</tr>
	</table>

	<h3>Work Information</h3>
	<input type="checkbox" id="IsLawStudent" name="IsLawStudent" onclick="triggerFn()" <?php echo get_user_meta($user->ID, 'is_law_student', true) == 1 ? 'checked="checked"' : ''; ?>> Select if you are a law student </input>

	<!-- Work Info-->
	<table class="name_Table" id="workContact">
		<tr class="name_Table">
			<td id="company_name_div" class="pmpro_checkout-field name_Table">
				<label for="company_name">Company/Employer</label>
				<input type="text" id="company_name" name="company_name" value="<?php echo esc_attr( get_user_meta($user->ID, 'company_name', true) ); ?>" size="20">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="position_div" class="pmpro_checkout-field name_Table">
				<label for="position">Position</label>
				<input type="text" id="position" name="position" value="<?php echo esc_attr(get_user_meta($user->ID, 'position', true)); ?>" size="20">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="company_type_div" class="pmpro_checkout-field name_Table">
				<label for="company_type">Employer Type</label>
				<select id="company_type" name="company_type" onchange="otherTxtbox(this, 1)">
					<?php
						global $company_type_arr;
						$selected_type = get_user_meta($user->ID, 'company_type', true);
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
				<label for="company_other">Other Type</label>
				<input type="text" id="company_other" name="company_other" value="<?php echo esc_attr(get_user_meta($user->ID, 'company_other', true)); ?>" size="20">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="company_size_div" class="pmpro_checkout-field name_Table">
				<label for="company_size">Employer Size</label>
				<select id="company_size" name="company_size">
				<?php
					global $company_size_arr;
					$size_db = get_user_meta($user->ID, 'company_size', true);
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
				<input type="text" id="company_city" name="company_city" value="<?php echo get_user_meta($user->ID, 'company_city', true); ?>" size="20" >
			</td>

			<td id="company_state_div" class="pmpro_checkout-field name_Table">
				<label for="company_state">Office State</label>
				<select id="company_state" name="company_state" class="input <?php echo pmpro_getClassForField("company_state");?>">
					<?php
						global $company_state_arr;
						$selected_state = get_user_meta($user->ID, 'company_state', true);
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
				<label for="school_name">Law School</label>
				<select id="school_name" name="school_name" onchange="otherTxtbox(this, 2)">
					<?php
						global $school_name_arr;
						$selected_school = get_user_meta($user->ID, 'school_name', true);
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
				<label for="school_other">Other Law School</label>
				<input type="text" id="school_other" name="school_other" value="<?php echo esc_attr(get_user_meta($user->ID, 'school_other', true)); ?>" size="20">
			</td>
		</tr>
		<tr class="name_Table">
			<td id="graduation_date_div" class="pmpro_checkout-field name_Table">
				<label for="graduation_date">Expected Graduation Year</label>
				<input type="text" id="graduation_date" name="graduation_date" size="20" value="<?php echo esc_attr(get_user_meta($user->ID, 'graduation_date', true)); ?>">
			</td>
		</tr>
	</table>

	<!-- More Info-->
	<h3>More Information</h3>
	<div class="pmpro_checkout_decription">Fields below will help us in verifying your account.</div>

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
							$ba_area_arr = explode(',', get_user_meta($user->ID, 'ba_area', true));
							$ba_date_arr = explode(',', get_user_meta($user->ID, 'ba_date', true));
							if (count($ba_area_arr) > 0){
								for ($i = 0; $i < count($ba_area_arr); $i++){
									?>
									<tr class="name_Table">
										<td class="name_Table"><input type="text" name="ba_area[]" value="<?php echo esc_attr($ba_area_arr[$i]); ?>"
										<?php if(empty($ba_area_arr[$i])) {
												?> placeholder="Jurisdiction/State" <?php
											} ?>/> </td>
										<td style="float: left;" class="name_Table"><input type="text" name="ba_date[]" value="<?php echo esc_attr($ba_date_arr[$i]); ?>"
										<?php if(empty($ba_date_arr[$i])) {
												?> placeholder="YYYY" <?php
											} ?>/> </td>
										<td class="name_Table" style="margin-left: 3%; margin-top: -0.5%;"><span class="btnDelete" style="font-size: 25px; cursor: pointer;" onclick="deleteBarAdmission()">x</span></td>
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
				<select id="kor_proficiency" name="kor_proficiency">
					<option value=""></option>
					<?php
						global $lang_skills_arr;
						$selected_skill = get_user_meta($user->ID, 'kor_proficiency', true);
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
			</td>
		</tr>

		<!-- TODO -->
		<tr class="name_Table">
			<td id="other_languages_div" class="pmpro_checkout-field name_Table">
				<button onclick="addLanguage()" type="button">Add Other Language Skills</button>
				</br>
				Please provide other languages and skill level
				<div></div>
				<table class="name_Table">
					<tbody id="language_container" class="name_Table">
						<?php
							$lang_name_arr = explode(',', get_user_meta($user->ID, 'lang_name', true));
							$lang_level_arr = explode(',', get_user_meta($user->ID, 'lang_level', true));
							if (count($lang_name_arr) > 0){
								for ($i = 0; $i < count($lang_name_arr); $i++){
									?>
									<tr class="name_Table">
										<td class="name_Table"><input type="text" name="lang_name[]" value="<?php echo esc_attr($lang_name_arr[$i]); ?>" /></td>
										<td class="name_Table">
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
										<td class='name_Table' ><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteLanguage()'>x</span></td>
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
				</br>
				Please provide law school
				<div></div>
				<table class="name_Table" id="more_school_container" style="margin-left: 0%;">
						<?php
							$more_school_name_arr = explode(';', get_user_meta($user->ID, 'more_school_name', true));
							$more_school_other_arr = explode(',', get_user_meta($user->ID, 'more_school_other', true));
							if (count($more_school_name_arr) > 0){
								for ($i = 0; $i < count($more_school_name_arr); $i++){
									?>
								<tbody class="name_Table">
									<tr class="name_Table">
										<td class="pmpro_checkout-field name_Table">
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
										<td class='name_Table'><div><span class='btnDelete' style='font-size: 25px; cursor: pointer;' onclick='deleteLawSchool()'>x</span></div></td>
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
				<input type="text" id="graduation_year" name="graduation_year" value="<?php echo esc_attr(get_user_meta($user->ID, 'graduation_year', true)); ?>" size="20">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="public_profile_div" class="pmpro_checkout-field name_Table">
				<label for="public_profile" style="font-size: 18px; font-weight: bold;">Public Profile URL <span style="font-size:75%;">(one of facebook, linkedin, lawfirm website and etc)<span></label>
				<input type="text" id="public_profile" name="public_profile" value="<?php echo esc_attr(get_user_meta($user->ID, 'public_profile', true)); ?>" size="40">
			</td>
		</tr>

		<tr class="name_Table">
			<td id="practice_areas_div" class="pmpro_checkout-field name_Table">
				<label for="practice_areas" style="font-size: 18px; font-weight: bold;">Practice Area(s)</label>
				<div>Please check all of your Practice Areas</div>
				<div id="practice_areas">
					<?php
						global $areas_arr;
						$selected_areas = explode(',', get_user_meta($user->ID, 'practice_areas', true));
						foreach($areas_arr as $area) {
							$checked="";
							if ( in_array($area, $selected_areas) ) {
								$checked = "checked";
							}

							if ($area == "Other") {
								echo '<input type="checkbox" name="areas[]" onchange="toggleTxtBox(this)" value="'.$area.'" '.$checked.'> '.$area.' </input></br>';
								$area_other = get_user_meta($user->ID, 'area_other', true);
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
		<tr class="name_Table">
			<td id="public_profile_div" class="pmpro_checkout-field name_Table">
				<label for="public_profile" style="font-size: 18px; font-weight: bold;">Public Profile <span style="font-size:75%;">(URL; one of facebook, linkedin, lawfirm website and etc)<span></label>
				<input type="text" id="public_profile" name="public_profile" value="<?php echo esc_attr(get_user_meta($user->ID, 'public_profile', true)); ?>" size="40">
			</td>
		</tr>
	</table>
<?php
}
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );
function my_save_extra_profile_fields( $user_id )
{
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	// Contact Info
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


	// if(isset($_POST['more_school_name'])) {
	// 	update_usermeta( $user_id, 'more_school_name', $_POST['more_school_name'] );
	// 	if ($_POST['more_school_name'] == "Other" && isset($_POST['more_school_other'])) {
	// 		update_usermeta( $user_id, 'more_school_other', $_POST['more_school_other'] );
	// 	}
	// }
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
}
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );



/*
	These bits are required for PayPal Express only.
*/
function my_pmpro_paypalexpress_session_vars()
{
	//save our added fields in session while the user goes off to PayPal
	$_SESSION['first_name'] = $_REQUEST['first_name'];
	$_SESSION['last_name'] = $_REQUEST['last_name'];
	$_SESSION['pref_name'] = $_REQUEST['pref_name'];
	$_SESSION['sec_email'] = $_REQUEST['sec_email'];
}
add_action("pmpro_paypalexpress_session_vars", "my_pmpro_paypalexpress_session_vars");
?>
