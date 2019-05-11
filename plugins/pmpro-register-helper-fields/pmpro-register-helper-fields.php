<?php

/*

Plugin Name: Register Helper Example

Plugin URI: http://www.paidmembershipspro.com/wp/pmpro-customizations/

Description: Register Helper Initialization Example

Version: .2

Author: Stranger Studios

Author URI: http://www.strangerstudios.com

*/

//we have to put everything in a function called on init, so we are sure Register Helper is loaded

function my_pmprorh_init()

{

    //don't break if Register Helper is not loaded

    if(!function_exists( 'pmprorh_add_registration_field' )) {

        return false;

    }

    

    $scriptFields = array();

    $scriptFields[] = new PMProRH_Field(

        'js',                		// input name, will also be used as meta key

		'html',							// type of field

		array(			

			'html' => '<script type="text/javascript">

                            function otherTxtbox(obj, location){                                

                                var txtBoxId = "";                                

                                switch (location) {

									case 1: //company

										txtBoxId = "otherTxtWork";                                        

										break;

									case 2: //school

										txtBoxId = "otherTxtSchool";                                        

										break;

									case 3: //additional

										txtBoxId = "otherTxtSchoolInfo";                                        

										break;

									default:

										txtBoxId = "";

                                }                               

                                if (obj.value=="Other")

                                {                                

                                document.getElementById(txtBoxId).style.visibility="visible"                                        

                                } 

                                else 

                                {                                

                                document.getElementById(txtBoxId).style.visibility="hidden"                                

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

                            

                            function addFields(){                                                         

                                // Container <div> where dynamic content will be placed

                                var container = document.getElementById("container");

                                

                                // Append a node with a random text                                    

                                    // Create an <input> element, set its type and name attributes

                                    var inputArea = document.createElement("input");

                                    inputArea.type = "text";                                    

                                    inputArea.placeholder = "Jurisdiction/State"

                                    inputArea.style = "margin-right:5%"

                                    container.appendChild(inputArea);

                                    

                                    var inputDate = document.createElement("input");

                                    inputDate.type = "text";

                                    inputDate.placeholder = "Date"

                                    container.appendChild(inputDate);

                                    

                                    // Append a line break 

                                    container.appendChild(document.createElement("div"));                                

                            }						

                        </script>                       

                    ',

            'label'    	=> ' ',			// custom field label		

			'profile'	=> true			// show in user profile			

		)

	);  

    

    $contactFields = array();

    $contactFields[] = new PMProRH_Field(

		'html_Contact',						// input name, will also be used as meta key

		'html',							// type of field

		array(

			'html'		=> '

                        <table class="name_Table">

								<tr class="name_Table">

									<td id="First Name_div" class="pmpro_checkout-field name_Table">

										<label for="FirstName">First Name</label>

										<input type="text" id="FirstName" name="FirstName" value="" size="20" class="input pmpro_required">                                        

									</td>                                    

									<td id="Last Name_div" class="pmpro_checkout-field name_Table">

										<label for="LastName">Last Name</label>

										<input type="text" id="LastName" name="LastName" value="" size="20" class="pmpro_required">									    

                                    </td>				

								</tr>

                                <tr class="name_Table">

        							<td id="Preffered Name_div" class="pmpro_checkout-field name_Table">

										<label for="PrefferedName">Preferred Name</label>

										<input type="text" id="PrefferedName" name="PrefferedName" value="" size="20" class="pmpro_required">									    

                                    </td>

                                </tr>								

                                <tr class="name_Table">

            						<td id="Sec Email_div" class="pmpro_checkout-field name_Table">

										<label for="Sec Email">Secondary Email Address</label>

										<input type="text" id="Sec Email" name="Sec Email" value="" size="20" class="input ">

                                    </td>

                                </tr>

                                <tr class="name_Table">

                    				<td id="Prm Phone_div" class="pmpro_checkout-field name_Table">

										<label for="Prm Phone">Primary Phone Number</label>

										<input type="text" id="Prm Phone" name="Prm Phone" value="" size="20" class="input ">

                                    </td>

                                </tr>

                                <tr class="name_Table">

                					<td id="Sec Phone_div" class="pmpro_checkout-field name_Table">

										<label for="Sec Phone">Secondary Phone Number</label>

										<input type="text" id="Sec Phone" name="Sec Phone" value="" size="20" class="input ">

                                    </td>

                                </tr>  					

							</table>',			

			'label'     => ' ',			

			'profile'	=> true			// show in user profile			

		)

	); 	

    

    $workFields = array();

    $workFields[] = new PMProRH_Field(

		'html_Work',						// input name, will also be used as meta key

		'html',							// type of field

		array(

			'html'		=> '

                        <input type="checkbox" id="IsLawStudent" onclick="triggerFn()"> Select if you are a law student </input>

                        <table class="name_Table" id="workContact">	

                                <tr class="name_Table">

    								<td id="Company_div" class="pmpro_checkout-field name_Table">

										<label for="Company">Company/Employer</label>

										<input type="text" id="Company" name="Company" value="" size="20" class="pmpro_required">									    

                                    </td>

                                </tr>

                                <tr class="name_Table">

        							<td id="Position_div" class="pmpro_checkout-field name_Table">

										<label for="Position">Position</label>

										<input type="text" id="Position" name="Position" value="" size="20" class="pmpro_required">									    

                                    </td>

                                </tr>

								<tr class="name_Table">

    								<td id="CompanyType_div" class="pmpro_checkout-field name_Table">

										<label for="CompanyType">Employer Type</label>

										<select id="CompanyType" name="CompanyType" class="pmpro_required"

                                        onchange="otherTxtbox(this, 1)">

											<option value=""></option>

											<option value="Private">Private</option>

											<option value="Government">Government</option>

											<option value="Non-Profit">Non-Profit</option>

											<option value="In-house">In-house</option>

											<option value="Other">Other</option>

										</select>                                          

									</td>

                                    <td id="otherTxtWork" class="pmpro_checkout-field name_Table" style="visibility:hidden;">

                                        <label for="otherTxt">Other Type</label>

                                        <input type="textbox"/>

                                    </td>

                                </tr>

                                <tr class="name_Table">

        							<td id="EmpSize_div" class="pmpro_checkout-field name_Table">

										<label for="EmpSize">Employer Size</label>

										<select id="EmpSize" name="EmpSize" class="pmpro_required">

											<option value=""></option>

											<option value="Solo">Solo</option>

											<option value="Small">Small</option>

											<option value="Medium">Medium</option>

											<option value="Large">Large</option>

											<option value="N/A">N/A</option>

										</select>                                          

									</td>                                    

                                </tr>								

								<tr class="name_Table">

    								<td id="OfficeCity_div" class="pmpro_checkout-field name_Table">

										<label for="OfficeCity">Office City</label>

										<input type="text" id="OfficeCity" name="OfficeCity" value="" size="20" class="pmpro_required">										

									</td>

									<td id="OfficeState_div" class="pmpro_checkout-field name_Table">

										<label for="OfficeState">Office State</label>

										<select id="OfficeState" name="OfficeState" class="pmpro_required">

											<option value="AL">Alabama</option>

											<option value="AK">Alaska</option>

											<option value="AZ">Arizona</option>

											<option value="AR">Arkansas</option>

											<option value="CA">California</option>

											<option value="CO">Colorado</option>

											<option value="CT">Connecticut</option>

											<option value="DE">Delaware</option>

											<option value="DC">District Of Columbia</option>

											<option value="FL">Florida</option>

											<option value="GA">Georgia</option>

											<option value="HI">Hawaii</option>

											<option value="ID">Idaho</option>

											<option value="IL">Illinois</option>

											<option value="IN">Indiana</option>

											<option value="IA">Iowa</option>

											<option value="KS">Kansas</option>

											<option value="KY">Kentucky</option>

											<option value="LA">Louisiana</option>

											<option value="ME">Maine</option>

											<option value="MD">Maryland</option>

											<option value="MA">Massachusetts</option>

											<option value="MI">Michigan</option>

											<option value="MN">Minnesota</option>

											<option value="MS">Mississippi</option>

											<option value="MO">Missouri</option>

											<option value="MT">Montana</option>

											<option value="NE">Nebraska</option>

											<option value="NV">Nevada</option>

											<option value="NH">New Hampshire</option>

											<option value="NJ">New Jersey</option>

											<option value="NM">New Mexico</option>

											<option value="NY">New York</option>

											<option value="NC">North Carolina</option>

											<option value="ND">North Dakota</option>

											<option value="OH">Ohio</option>

											<option value="OK">Oklahoma</option>

											<option value="OR">Oregon</option>

											<option value="PA">Pennsylvania</option>

											<option value="RI">Rhode Island</option>

											<option value="SC">South Carolina</option>

											<option value="SD">South Dakota</option>

											<option value="TN">Tennessee</option>

											<option value="TX">Texas</option>

											<option value="UT">Utah</option>

											<option value="VT">Vermont</option>

											<option value="VA">Virginia</option>

											<option value="WA">Washington</option>

											<option value="WV">West Virginia</option>

											<option value="WI">Wisconsin</option>

											<option value="WY">Wyoming</option>

										</select>										

									</td>

                                </tr>								

							</table>

                            

                            <table class="name_Table" id="schoolContact" style="display:none;">

								<tr class="name_Table">

    								<td id="LawSchool_div" class="pmpro_checkout-field name_Table">

										<label for="LawSchool">Law School</label>

										<select id="LawSchool" name="LawSchool" class="pmpro_required"

                                        onchange="otherTxtbox(this, 2)">

											<option value=""></option>

                                            <option value="Abraham Lincoln University School of Law">Abraham Lincoln University School of Law</option>

											<option value="Albany Law School, Union University">Albany Law School, Union University</option>

											<option value="Alben W. Barkley School of Law">Alben W. Barkley School of Law</option>

											<option value="American College of Law">American College of Law</option>

											<option value="American Heritage University School of Law">American Heritage University School of Law </option>

											<option value="American International School of Law">American International School of Law</option>

											<option value="Appalachian School of Law">Appalachian School of Law</option>

											<option value="Arizona Summit Law School, InfiLaw System">Arizona Summit Law School, InfiLaw System</option>

											<option value="Ave Maria School of Law">Ave Maria School of Law</option>

											<option value="Baylor Law School, Baylor University">Baylor Law School, Baylor University</option>

											<option value="Beasley School of Law, Temple University">Beasley School of Law, Temple University</option>

											<option value="Belmont University College of Law">Belmont University College of Law</option>

											<option value="Benjamin N. Cardozo School of Law, Yeshiva University">Benjamin N. Cardozo School of Law, Yeshiva University</option>

											<option value="Birmingham School of Law">Birmingham School of Law</option>

											<option value="Boston College Law School">Boston College Law School</option>

											<option value="Boston University School of Law">Boston University School of Law</option>

											<option value="Brooklyn Law School">Brooklyn Law School</option>

											<option value="Cal Northern School of Law">Cal Northern School of Law</option>

											<option value="California Desert Trial Academy College of Law">California Desert Trial Academy College of Law</option>

											<option value="California Midland School of Law">California Midland School of Law</option>

											<option value="California Pacific School of Law">California Pacific School of Law</option>

											<option value="California School of Law">California School of Law</option>

											<option value="California Southern Law School">California Southern Law School</option>

											<option value="California Southern University">California Southern University</option>

											<option value="California Western School of Law">California Western School of Law</option>

											<option value="Capital University Law School">Capital University Law School</option>

											<option value="Case Western Reserve University School of Law">Case Western Reserve University School of Law</option>

											<option value="Cecil C. Humphreys School of Law, University of Memphis">Cecil C. Humphreys School of Law, University of Memphis</option>

											<option value="Chapman University School of Law">Chapman University School of Law</option>

											<option value="Charleston School of Law">Charleston School of Law</option>

											<option value="Charlotte School of Law InfiLaw System">Charlotte School of Law InfiLaw System</option>

											<option value="Chicago-Kent College of Law, Illinois Institute of Technology">Chicago-Kent College of Law, Illinois Institute of Technology</option>

											<option value="City University of New York School of Law">City University of New York School of Law</option>

											<option value="Cleveland-Marshall College of Law, Cleveland State University">Cleveland-Marshall College of Law, Cleveland State University</option>

											<option value="Columbia Law School">Columbia Law School</option>

											<option value="Columbus School of Law, The Catholic University of America">Columbus School of Law, The Catholic University of America</option>

											

											<option value="Concord Law School, Purdue University Global">Concord Law School, Purdue University Global</option>

											<option value="Concordia University School of Law">Concordia University School of Law</option>

											<option value="Cornell Law School">Cornell Law School</option>

											<option value="Creighton University School of Law">Creighton University School of Law</option>

											<option value="Cumberland School of Law, Samford University">Cumberland School of Law, Samford University</option>

											<option value="David A. Clarke School of Law, University of the District of Columbia">David A. Clarke School of Law, University of the District of Columbia</option>

											<option value="Dedman School of Law, Southern Methodist University">Dedman School of Law, Southern Methodist University</option>

											<option value="DePaul University College of Law">DePaul University College of Law</option>

											<option value="Diamond Graduate Law School LLM Online Program">Diamond Graduate Law School LLM Online Program</option>

											<option value="Dickinson School of Law, Penn State University">Dickinson School of Law, Penn State University</option>

											<option value="Drake University Law School">Drake University Law School</option>

											<option value="Drexel University School of Law">Drexel University School of Law</option>

											<option value="Duke University School of Law">Duke University School of Law</option>

											<option value="Duncan School of Law, Lincoln Memorial University">Duncan School of Law, Lincoln Memorial University</option>

											<option value="Duquesne University School of Law">Duquesne University School of Law</option>

											<option value="Dwayne O. Andreas School of Law">Dwayne O. Andreas School of Law</option>

											<option value="Elon University School of Law">Elon University School of Law</option>

											<option value="Emory University School of Law">Emory University School of Law</option>

											<option value="Empire College School of Law">Empire College School of Law</option>

											<option value="Eugenio María de Hostos School of Law, Universidad de Puerto Rico">Eugenio María de Hostos School of Law, Universidad de Puerto Rico</option>

											<option value="Florida A&M University College of Law">Florida A&M University College of Law</option>

											<option value="Florida Coastal School of Law, InfiLaw System">Florida Coastal School of Law, InfiLaw System</option>

											<option value="Florida International University College of Law">Florida International University College of Law</option>

											<option value="Florida State University College of Law">Florida State University College of Law</option>

											<option value="Fordham University School of Law">Fordham University School of Law</option>

											<option value="George Mason University School of Law">George Mason University School of Law</option>

											<option value="Georgetown University Law Cente">Georgetown University Law Cente</option>

											<option value="Georgia State University College of Law">Georgia State University College of Law</option>

											<option value="Glendale University College of Law">Glendale University College of Law</option>

											<option value="Golden Gate University School of Law">Golden Gate University School of Law</option>

											<option value="Gonzaga University School of Law">Gonzaga University School of Law</option>

											<option value="Gould School of Law, University of Southern California">Gould School of Law, University of Southern California</option>

											<option value="Hamline University School of Law">Hamline University School of Law</option>

											<option value="Harvard Law School">Harvard Law School</option>

											<option value="Hofstra University School of Law">Hofstra University School of Law</option>

											<option value="Howard University School of Law">Howard University School of Law</option>

											

											<option value="Illinois Wesleyan University Law School">Illinois Wesleyan University Law School</option>

											<option value="Indiana Tech Law School">Indiana Tech Law School</option>

											<option value="Indiana University Robert H. McKinney School of Law">Indiana University Robert H. McKinney School of Law</option>

											<option value="Inland Valley University College of Law">Inland Valley University College of Law</option>

											<option value="Interamerican University of Puerto Rico School of Law">Interamerican University of Puerto Rico School of Law</option>

											<option value="International Pacific School of Law">International Pacific School of Law</option>

											<option value="Irvine University College of Law">Irvine University College of Law</option>

											<option value="J. Reuben Clark Law School, Brigham Young University">J. Reuben Clark Law School, Brigham Young University</option>

											<option value="James E. Rogers College of Law, University of Arizona">James E. Rogers College of Law, University of Arizona</option>

											<option value="John F. Kennedy University College of Law">John F. Kennedy University College of Law</option>

											<option value="John Marshall Law School">John Marshall Law School</option>

											<option value="Judge John Haywood Law School">Judge John Haywood Law School</option>

											<option value="La Salle Extension University">La Salle Extension University</option>

											<option value="Larry H. Layton School of Law">Larry H. Layton School of Law</option>

											<option value="Laurence Drivon School of Law, Humphreys College">Laurence Drivon School of Law, Humphreys College</option>

											

											<option value="Lewis & Clark Law School">Lewis & Clark Law School</option>

											<option value="Liberty University School of Law">Liberty University School of Law</option>

											<option value="Lincoln College of Law">Lincoln College of Law</option>

											<option value="Lincoln Law School of Sacramento">Lincoln Law School of Sacramento</option>

											<option value="Lincoln Law School of San Jose">Lincoln Law School of San Jose</option>

											<option value="Lincoln University School of Law">Lincoln University School of Law</option>

											<option value="Litchfield Law School">Litchfield Law School</option>

											<option value="Lorenzo Patiño School of Law, University of Northern California">Lorenzo Patiño School of Law, University of Northern California</option>

											<option value="Louis D. Brandeis School of Law, University of Louisville">Louis D. Brandeis School of Law, University of Louisville</option>

											<option value="Loyola Law School, Loyola Marymount University">Loyola Law School, Loyola Marymount University</option>

											<option value="Loyola University Chicago School of Law">Loyola University Chicago School of Law</option>

											<option value="Loyola University New Orleans College of Law">Loyola University New Orleans College of Law</option>

											<option value="Marquette University Law School">Marquette University Law School</option>

											<option value="Marshall-Wythe School of Law, The College of William and Mary">Marshall-Wythe School of Law, The College of William and Mary</option>

											<option value="Massachusetts School of Law">Massachusetts School of Law</option>

											

											<option value="Maurer School of Law, Indiana University Bloomington">Maurer School of Law, Indiana University Bloomington</option>

											<option value="Maynard-Knox Law School, Hamilton College">Maynard-Knox Law School, Hamilton College</option>

											<option value="McGeorge School of Law, University of the Pacific">McGeorge School of Law, University of the Pacific</option>

											<option value="McMillan Academy of Law">McMillan Academy of Law</option>

											<option value="MD Kirk School of Law">MD Kirk School of Law</option>

											<option value="Michael E. Moritz College of Law, Ohio State University">Michael E. Moritz College of Law, Ohio State University</option>

											<option value="Michigan State University College of Law">Michigan State University College of Law</option>

											<option value="Miles Law School">Miles Law School</option>

											<option value="Mississippi College School of Law">Mississippi College School of Law</option>

											<option value="Monterey College of Law">Monterey College of Law</option>

											<option value="Nashville School of Law">Nashville School of Law</option>

											<option value="National University School of Law">National University School of Law</option>

											<option value="New College of California School of Law">New College of California School of Law</option>

											<option value="New England School of Law">New England School of Law</option>

											<option value="New York Law School">New York Law School</option>

											

											<option value="New York University School of Law">New York University School of Law</option>

											<option value="Norman Adrian Wiggins School of Law, Campbell University">Norman Adrian Wiggins School of Law, Campbell University</option>

											<option value="North Carolina Central University School of Law">North Carolina Central University School of Law</option>

											<option value="Northampton Law School">Northampton Law School</option>

											<option value="Northeastern University School of Law">Northeastern University School of Law</option>

											<option value="Northern Illinois University College of Law">Northern Illinois University College of Law</option>

											<option value="Northrop University">Northrop University</option>

											<option value="Northwestern California University School of Law">Northwestern California University School of Law</option>

											<option value="Northwestern University School of Law">Northwestern University School of Law</option>

											<option value="Notre Dame Law School">Notre Dame Law School</option>

											<option value="O. W. Coburn School of Law">O. W. Coburn School of Law</option>

											<option value="Oak Brook College of Law">Oak Brook College of Law</option>

											<option value="Ohio Northern University, Pettit College of Law">Ohio Northern University, Pettit College of Law</option>

											<option value="Oklahoma City University School of Law">Oklahoma City University School of Law</option>

											<option value="Pace University School of Law">Pace University School of Law</option>

											

											<option value="Pacific Coast University School of Law">Pacific Coast University School of Law</option>

											<option value="Pacific West College of Law">Pacific West College of Law</option>

											<option value="Paul M. Hebert Law Center, Louisiana State University">Paul M. Hebert Law Center, Louisiana State University</option>

											<option value="Penn State Law, Penn State University">Penn State Law, Penn State University</option>

											<option value="Peoples College of Law">Peoples College of Law</option>

											<option value="Pepperdine University School of Law">Pepperdine University School of Law</option>

											<option value="Pinnacles School of Law">Pinnacles School of Law</option>

											<option value="Pontifical Catholic University of Puerto Rico School of Law">Pontifical Catholic University of Puerto Rico School of Law</option>

											<option value="Pressler School of Law, Louisiana College">Pressler School of Law, Louisiana College</option>

											<option value="Princeton Law School">Princeton Law School</option>

											<option value="Quinnipiac University School of Law">Quinnipiac University School of Law</option>

											<option value="Regent University School of Law">Regent University School of Law</option>

											<option value="Robert H. Terrell Law School">Robert H. Terrell Law School</option>

											<option value="Roger Williams University School of Law">Roger Williams University School of Law</option>

											<option value="Rutgers Law School (Camden campus)">Rutgers Law School (Camden campus)</option>

											

											<option value="Rutgers Law School (Newark campus)">Rutgers Law School (Newark campus)</option>

											<option value="S.J. Quinney College of Law, University of Utah">S.J. Quinney College of Law, University of Utah</option>

											<option value="Saint Louis University School of Law">Saint Louis University School of Law</option>

											<option value="Salmon P. Chase College of Law, Northern Kentucky University">Salmon P. Chase College of Law, Northern Kentucky University</option>

											<option value="San Francisco Law School">San Francisco Law School</option>

											<option value="San Joaquin College of Law">San Joaquin College of Law</option>

											<option value="Sandra Day O Connor College of Law, Arizona State University">Sandra Day O Connor College of Law, Arizona State University</option>

											<option value="Santa Barbara College of Law">Santa Barbara College of Law</option>

											<option value="Santa Clara University School of Law">Santa Clara University School of Law</option>

											<option value="Savannah Law School">Savannah Law School</option>

											<option value="Seattle University School of Law">Seattle University School of Law</option>

											<option value="Seton Hall University School of Law">Seton Hall University School of Law</option>

											<option value="Shepard Broad Law Center, Nova Southeastern University">Shepard Broad Law Center, Nova Southeastern University</option>

											<option value="South Texas College of Law">South Texas College of Law</option>

											<option value="Southern California Institute of Law">Southern California Institute of Law</option>

											

											<option value="Southern Illinois University School of Law">Southern Illinois University School of Law</option>

											<option value="Southern University Law Center">Southern University Law Center</option>

											<option value="Southwestern University School of Law">Southwestern University School of Law</option>

											<option value="St. Francis School of Law">St. Francis School of Law</option>

											<option value="St. John Fisher College School of Law">St. John Fisher College School of Law</option>

											<option value="St. Johns University School of Law">St. Johns University School of Law</option>

											<option value="St. Marys University School of Law">St. Marys University School of Law</option>

											<option value="St. Thomas University School of Law">St. Thomas University School of Law</option>

											<option value="Stanford Law School">Stanford Law School</option>

											<option value="State and National Law School">State and National Law School</option>

											<option value="Stetson University College of Law">Stetson University College of Law</option>

											<option value="Sturm College of Law, University of Denver">Sturm College of Law, University of Denver</option>

											<option value="Suffolk University Law School">Suffolk University Law School</option>

											<option value="Syracuse University College of Law">Syracuse University College of Law</option>

											<option value="Taft Law School, William Howard Taft University">Taft Law School, William Howard Taft University</option>

											

											<option value="Texas A&M University School of Law">Texas A&M University School of Law</option>

											<option value="Texas Tech University School of Law">Texas Tech University School of Law</option>

											<option value="The George Washington University Law School">The George Washington University Law School</option>

											<option value="The Judge Advocate Generals Legal Center and School">The Judge Advocate Generals Legal Center and School</option>

											<option value="Thomas Goode Jones School of Law, Faulkner University">Thomas Goode Jones School of Law, Faulkner University</option>

											<option value="Thomas Jefferson School of Law">Thomas Jefferson School of Law</option>

											<option value="Thurgood Marshall School of Law, Texas Southern University">Thurgood Marshall School of Law, Texas Southern University</option>

											<option value="Touro College Jacob D. Fuchsberg Law Center">Touro College Jacob D. Fuchsberg Law Center</option>

											<option value="Trinity Law School, Trinity International University">Trinity Law School, Trinity International University</option>

											<option value="Tulane University School of Law">Tulane University School of Law</option>

											

											<option value="University at Buffalo Law School, SUNY">University at Buffalo Law School, SUNY</option>

											<option value="University of Akron School of Law">University of Akron School of Law</option>

											<option value="University of Alabama School of Law">University of Alabama School of Law</option>

											<option value="University of Alaska at Anchorage">University of Alaska at Anchorage</option>

											<option value="University of Arkansas School of Law">University of Arkansas School of Law</option>

											

											<option value="University of Baltimore School of Law">University of Baltimore School of Law</option>

											<option value="University of California, Berkeley School of Law (Boalt Hall)">University of California, Berkeley School of Law (Boalt Hall)</option>

											<option value="University of California, Davis School of Law (King Hall)">University of California, Davis School of Law (King Hall)</option>

											<option value="University of California, Hastings College of the Law">University of California, Hastings College of the Law</option>

											<option value="University of California, Irvine School of Law">University of California, Irvine School of Law</option>

											<option value="University of California, Los Angeles School of Law">University of California, Los Angeles School of Law</option>

											<option value="University of Chicago Law School">University of Chicago Law School</option>

											<option value="University of Cincinnati College of Law">University of Cincinnati College of Law</option>

											<option value="University of Colorado School of Law">University of Colorado School of Law</option>

											<option value="University of Connecticut School of Law">University of Connecticut School of Law</option>

											<option value="University of Dayton School of Law">University of Dayton School of Law</option>

											<option value="University of Detroit Mercy School of Law">University of Detroit Mercy School of Law</option>

											<option value="University of Florida Levin College of Law">University of Florida Levin College of Law</option>

											<option value="University of Georgia School of Law">University of Georgia School of Law</option>

											<option value="University of Honolulu School of Law">University of Honolulu School of Law</option>

											

											<option value="University of Houston Law Cente">University of Houston Law Cente</option>

											<option value="University of Idaho College of Law">University of Idaho College of Law</option>

											<option value="University of Illinois College of Law">University of Illinois College of Law</option>

											<option value="University of Iowa College of Law">University of Iowa College of Law</option>

											<option value="University of Kansas School of Law">University of Kansas School of Law</option>

											<option value="University of Kentucky College of Law">University of Kentucky College of Law</option>

											<option value="University of La Verne College of Law">University of La Verne College of Law</option>

											<option value="University of Maine School of Law">University of Maine School of Law</option>

											<option value="University of Maryland School of Law">University of Maryland School of Law</option>

											<option value="University of Massachusetts School of Law">University of Massachusetts School of Law</option>

											<option value="University of Miami School of Law">University of Miami School of Law</option>

											<option value="University of Michigan Law School">University of Michigan Law School</option>

											<option value="University of Minnesota Law School">University of Minnesota Law School</option>

											<option value="University of Mississippi School of Law">University of Mississippi School of Law</option>

											<option value="University of Missouri - Kansas City School of Law">University of Missouri - Kansas City School of Law</option>

											

											<option value="University of Missouri School of Law">University of Missouri School of Law</option>

											<option value="University of Montana School of Law">University of Montana School of Law</option>

											<option value="University of Nebraska–Lincoln College of Law">University of Nebraska–Lincoln College of Law</option>

											<option value="University of New Hampshire School of Law">University of New Hampshire School of Law</option>

											<option value="University of New Mexico School of Law">University of New Mexico School of Law</option>

											<option value="University of North Carolina School of Law">University of North Carolina School of Law</option>

											<option value="University of North Dakota School of Law">University of North Dakota School of Law</option>

											<option value="University of North Texas at Dallas College of Law">University of North Texas at Dallas College of Law</option>

											<option value="University of Oklahoma College of Law">University of Oklahoma College of Law</option>

											<option value="University of Oregon School of Law">University of Oregon School of Law</option>

											<option value="University of Pennsylvania Law School">University of Pennsylvania Law School</option>

											<option value="University of Pittsburgh School of Law">University of Pittsburgh School of Law</option>

											<option value="University of Puerto Rico School of Law">University of Puerto Rico School of Law</option>

											<option value="University of Richmond School of Law">University of Richmond School of Law</option>

											<option value="University of San Diego School of Law">University of San Diego School of Law</option>

											

											<option value="University of San Francisco School of Law">University of San Francisco School of Law</option>

											<option value="University of San Luis Obispo School of Law">University of San Luis Obispo School of Law</option>

											<option value="University of Silicon Valley Law School">University of Silicon Valley Law School</option>

											<option value="University of South Carolina School of Law">University of South Carolina School of Law</option>

											<option value="University of South Dakota School of Law">University of South Dakota School of Law</option>

											<option value="University of St. Thomas School of Law">University of St. Thomas School of Law</option>

											<option value="University of Tennessee College of Law">University of Tennessee College of Law</option>

											<option value="University of Texas School of Law">University of Texas School of Law</option>

											<option value="University of Toledo College of Law">University of Toledo College of Law</option>

											<option value="University of Tulsa College of Law">University of Tulsa College of Law</option>

											<option value="University of Virginia School of Law">University of Virginia School of Law</option>

											<option value="University of Washington School of Law">University of Washington School of Law</option>

											<option value="University of West Los Angeles School of Law">University of West Los Angeles School of Law</option>

											<option value="University of Wisconsin Law School">University of Wisconsin Law School</option>

											<option value="University of Wyoming College of Law">University of Wyoming College of Law</option>

											

											<option value="Valparaiso University School of Law">Valparaiso University School of Law</option>

											<option value="Vanderbilt University Law School">Vanderbilt University Law School</option>

											<option value="Ventura College of Law">Ventura College of Law</option>

											<option value="Vermont Law School">Vermont Law School</option>

											<option value="Villanova University School of Law">Villanova University School of Law</option>

											<option value="Wake Forest University School of Law">Wake Forest University School of Law</option>

											<option value="Walter F. George School of Law, Mercer University">Walter F. George School of Law, Mercer University</option>

											<option value="Washburn University School of Law">Washburn University School of Law</option>

											<option value="Washington and Lee University School of Law">Washington and Lee University School of Law</option>

											<option value="Washington College of Law, American University">Washington College of Law, American University</option>

											<option value="Washington University School of Law">Washington University School of Law</option>

											<option value="Wayne State University Law School">Wayne State University Law School</option>

											<option value="West Virginia University College of Law">West Virginia University College of Law</option>

											<option value="Western Michigan University Thomas M. Cooley Law School">Western Michigan University Thomas M. Cooley Law School</option>

											<option value="Western New England University School of Law">Western New England University School of Law</option>

											

											<option value="Western Sierra Law School">Western Sierra Law School</option>

											<option value="Western State College of Law">Western State College of Law</option>

											<option value="Whittier Law School">Whittier Law School</option>

											<option value="Widener Law Commonwealth">Widener Law Commonwealth</option>

											<option value="Widener University School of Law">Widener University School of Law</option>

											<option value="Willamette University College of Law">Willamette University College of Law</option>

											<option value="William H. Bowen School of Law, University of Arkansas at Little Rock">William H. Bowen School of Law, University of Arkansas at Little Rock</option>

											<option value="William Mitchell College of Law">William Mitchell College of Law</option>

											<option value="William S. Boyd School of Law, University of Nevada, Las Vegas">William S. Boyd School of Law, University of Nevada, Las Vegas</option>

											<option value="William S. Richardson School of Law, University of Hawaii">William S. Richardson School of Law, University of Hawaii</option>

											<option value="Winchester Law School">Winchester Law School</option>

											<option value="Woodrow Wilson College of Law">Woodrow Wilson College of Law</option>

											<option value="Yale Law School">Yale Law School</option>

											

											<option value="Other">Other</option>

										</select>                                          

									</td>

                                    <td id="otherTxtSchool" class="pmpro_checkout-field name_Table" style="visibility:hidden;">

                                        <label for="otherTxt">Other Law School</label>

                                        <input type="textbox"/>

                                    </td>

                                </tr>

                                <tr class="name_Table">

                					<td id="GraduationDate_div" class="pmpro_checkout-field name_Table">

										<label for="GraduationDate">Expected Graduation Year</label>

										<input type="text" id="GraduationDate" name="GraduationDate" size="20" class="pmpro_required">									    

                                    </td>

                                </tr>

							</table>',			

			'label'     => ' ',			

			'profile'	=> true			// show in user profile			

		)

	); 	

	

	//define the fields

	$fields = array();		

    $fields[] = new PMProRH_Field(

        'barAdm',						// input name, will also be used as meta key

		'html',							// type of field

		array(			

			'html' => ' <button onclick="addFields()" type="button">Add Bar Admission</button>

                        </br>

                        Type Your Bar Admission Area with Date (i.e. MD, VA, DC and Other)                        

                        <div></div>

                        <div id="container"/>

                    ',

            'label'    	=> 'Bar Admission(s)',			// custom field label		

			'profile'	=> true,			// show in user profile

			'required'	=> false,			// make this field required

            'showrequired'  => false

		)

	);  

	$fields[] = new PMProRH_Field(

		'koreanProficiency',						// input name, will also be used as meta key

		'select',							// type of field

		array(

			'label'		=> 'Korean Proficiency',			// custom field label			

			'profile'	=> true,			// show in user profile

			'options' => array(				// <option> elements for select field

				''		=> '',			// blank option - cannot be selected if this field is required

                'N/A'    => 'N/A',

				'Conversational'	=> 'Conversational',	

				'Fluent'	=> 'Fluent (reading and writing)',	

				'Native'	=> 'Native'

			)	

		)

	);

	$fields[] = new PMProRH_Field(

		'otherLang',						// input name, will also be used as meta key

		'text',							// type of field

		array(

			'label'		=> 'Other Language Skills',			// custom field label

			'size'		=> 40,				// input size			

			'profile'	=> true,			// show in user profile

			'hint'      => 'Please provide other languages and skill level'

		)

	);  

    

    $fields[] = new PMProRH_Field(

        'html_lawschool',    					// input name, will also be used as meta key

		'html',							// type of field

		array(			

			'html' => '     <table class="name_Table" id="schoolInfo">

    							<tr class="name_Table">

    								<td id="SchoolInfo_div" class="pmpro_checkout-field name_Table">

										<label for="SchoolInfo">Law School</label>

										<select id="SchoolInfo" name="SchoolInfo" class="input"

                                        onchange="otherTxtbox(this, 3)">

											<option value=""></option>

                                            <option value="Abraham Lincoln University School of Law">Abraham Lincoln University School of Law</option>

											<option value="Albany Law School, Union University">Albany Law School, Union University</option>

											<option value="Alben W. Barkley School of Law">Alben W. Barkley School of Law</option>

											<option value="American College of Law">American College of Law</option>

											<option value="American Heritage University School of Law">American Heritage University School of Law </option>

											<option value="American International School of Law">American International School of Law</option>

											<option value="Appalachian School of Law">Appalachian School of Law</option>

											<option value="Arizona Summit Law School, InfiLaw System">Arizona Summit Law School, InfiLaw System</option>

											<option value="Ave Maria School of Law">Ave Maria School of Law</option>

											<option value="Baylor Law School, Baylor University">Baylor Law School, Baylor University</option>

											<option value="Beasley School of Law, Temple University">Beasley School of Law, Temple University</option>

											<option value="Belmont University College of Law">Belmont University College of Law</option>

											<option value="Benjamin N. Cardozo School of Law, Yeshiva University">Benjamin N. Cardozo School of Law, Yeshiva University</option>

											<option value="Birmingham School of Law">Birmingham School of Law</option>

											<option value="Boston College Law School">Boston College Law School</option>

											<option value="Boston University School of Law">Boston University School of Law</option>

											<option value="Brooklyn Law School">Brooklyn Law School</option>

											<option value="Cal Northern School of Law">Cal Northern School of Law</option>

											<option value="California Desert Trial Academy College of Law">California Desert Trial Academy College of Law</option>

											<option value="California Midland School of Law">California Midland School of Law</option>

											<option value="California Pacific School of Law">California Pacific School of Law</option>

											<option value="California School of Law">California School of Law</option>

											<option value="California Southern Law School">California Southern Law School</option>

											<option value="California Southern University">California Southern University</option>

											<option value="California Western School of Law">California Western School of Law</option>

											<option value="Capital University Law School">Capital University Law School</option>

											<option value="Case Western Reserve University School of Law">Case Western Reserve University School of Law</option>

											<option value="Cecil C. Humphreys School of Law, University of Memphis">Cecil C. Humphreys School of Law, University of Memphis</option>

											<option value="Chapman University School of Law">Chapman University School of Law</option>

											<option value="Charleston School of Law">Charleston School of Law</option>

											<option value="Charlotte School of Law InfiLaw System">Charlotte School of Law InfiLaw System</option>

											<option value="Chicago-Kent College of Law, Illinois Institute of Technology">Chicago-Kent College of Law, Illinois Institute of Technology</option>

											<option value="City University of New York School of Law">City University of New York School of Law</option>

											<option value="Cleveland-Marshall College of Law, Cleveland State University">Cleveland-Marshall College of Law, Cleveland State University</option>

											<option value="Columbia Law School">Columbia Law School</option>

											<option value="Columbus School of Law, The Catholic University of America">Columbus School of Law, The Catholic University of America</option>

											

											<option value="Concord Law School, Purdue University Global">Concord Law School, Purdue University Global</option>

											<option value="Concordia University School of Law">Concordia University School of Law</option>

											<option value="Cornell Law School">Cornell Law School</option>

											<option value="Creighton University School of Law">Creighton University School of Law</option>

											<option value="Cumberland School of Law, Samford University">Cumberland School of Law, Samford University</option>

											<option value="David A. Clarke School of Law, University of the District of Columbia">David A. Clarke School of Law, University of the District of Columbia</option>

											<option value="Dedman School of Law, Southern Methodist University">Dedman School of Law, Southern Methodist University</option>

											<option value="DePaul University College of Law">DePaul University College of Law</option>

											<option value="Diamond Graduate Law School LLM Online Program">Diamond Graduate Law School LLM Online Program</option>

											<option value="Dickinson School of Law, Penn State University">Dickinson School of Law, Penn State University</option>

											<option value="Drake University Law School">Drake University Law School</option>

											<option value="Drexel University School of Law">Drexel University School of Law</option>

											<option value="Duke University School of Law">Duke University School of Law</option>

											<option value="Duncan School of Law, Lincoln Memorial University">Duncan School of Law, Lincoln Memorial University</option>

											<option value="Duquesne University School of Law">Duquesne University School of Law</option>

											<option value="Dwayne O. Andreas School of Law">Dwayne O. Andreas School of Law</option>

											<option value="Elon University School of Law">Elon University School of Law</option>

											<option value="Emory University School of Law">Emory University School of Law</option>

											<option value="Empire College School of Law">Empire College School of Law</option>

											<option value="Eugenio María de Hostos School of Law, Universidad de Puerto Rico">Eugenio María de Hostos School of Law, Universidad de Puerto Rico</option>

											<option value="Florida A&M University College of Law">Florida A&M University College of Law</option>

											<option value="Florida Coastal School of Law, InfiLaw System">Florida Coastal School of Law, InfiLaw System</option>

											<option value="Florida International University College of Law">Florida International University College of Law</option>

											<option value="Florida State University College of Law">Florida State University College of Law</option>

											<option value="Fordham University School of Law">Fordham University School of Law</option>

											<option value="George Mason University School of Law">George Mason University School of Law</option>

											<option value="Georgetown University Law Cente">Georgetown University Law Cente</option>

											<option value="Georgia State University College of Law">Georgia State University College of Law</option>

											<option value="Glendale University College of Law">Glendale University College of Law</option>

											<option value="Golden Gate University School of Law">Golden Gate University School of Law</option>

											<option value="Gonzaga University School of Law">Gonzaga University School of Law</option>

											<option value="Gould School of Law, University of Southern California">Gould School of Law, University of Southern California</option>

											<option value="Hamline University School of Law">Hamline University School of Law</option>

											<option value="Harvard Law School">Harvard Law School</option>

											<option value="Hofstra University School of Law">Hofstra University School of Law</option>

											<option value="Howard University School of Law">Howard University School of Law</option>

											

											<option value="Illinois Wesleyan University Law School">Illinois Wesleyan University Law School</option>

											<option value="Indiana Tech Law School">Indiana Tech Law School</option>

											<option value="Indiana University Robert H. McKinney School of Law">Indiana University Robert H. McKinney School of Law</option>

											<option value="Inland Valley University College of Law">Inland Valley University College of Law</option>

											<option value="Interamerican University of Puerto Rico School of Law">Interamerican University of Puerto Rico School of Law</option>

											<option value="International Pacific School of Law">International Pacific School of Law</option>

											<option value="Irvine University College of Law">Irvine University College of Law</option>

											<option value="J. Reuben Clark Law School, Brigham Young University">J. Reuben Clark Law School, Brigham Young University</option>

											<option value="James E. Rogers College of Law, University of Arizona">James E. Rogers College of Law, University of Arizona</option>

											<option value="John F. Kennedy University College of Law">John F. Kennedy University College of Law</option>

											<option value="John Marshall Law School">John Marshall Law School</option>

											<option value="Judge John Haywood Law School">Judge John Haywood Law School</option>

											<option value="La Salle Extension University">La Salle Extension University</option>

											<option value="Larry H. Layton School of Law">Larry H. Layton School of Law</option>

											<option value="Laurence Drivon School of Law, Humphreys College">Laurence Drivon School of Law, Humphreys College</option>

											

											<option value="Lewis & Clark Law School">Lewis & Clark Law School</option>

											<option value="Liberty University School of Law">Liberty University School of Law</option>

											<option value="Lincoln College of Law">Lincoln College of Law</option>

											<option value="Lincoln Law School of Sacramento">Lincoln Law School of Sacramento</option>

											<option value="Lincoln Law School of San Jose">Lincoln Law School of San Jose</option>

											<option value="Lincoln University School of Law">Lincoln University School of Law</option>

											<option value="Litchfield Law School">Litchfield Law School</option>

											<option value="Lorenzo Patiño School of Law, University of Northern California">Lorenzo Patiño School of Law, University of Northern California</option>

											<option value="Louis D. Brandeis School of Law, University of Louisville">Louis D. Brandeis School of Law, University of Louisville</option>

											<option value="Loyola Law School, Loyola Marymount University">Loyola Law School, Loyola Marymount University</option>

											<option value="Loyola University Chicago School of Law">Loyola University Chicago School of Law</option>

											<option value="Loyola University New Orleans College of Law">Loyola University New Orleans College of Law</option>

											<option value="Marquette University Law School">Marquette University Law School</option>

											<option value="Marshall-Wythe School of Law, The College of William and Mary">Marshall-Wythe School of Law, The College of William and Mary</option>

											<option value="Massachusetts School of Law">Massachusetts School of Law</option>

											

											<option value="Maurer School of Law, Indiana University Bloomington">Maurer School of Law, Indiana University Bloomington</option>

											<option value="Maynard-Knox Law School, Hamilton College">Maynard-Knox Law School, Hamilton College</option>

											<option value="McGeorge School of Law, University of the Pacific">McGeorge School of Law, University of the Pacific</option>

											<option value="McMillan Academy of Law">McMillan Academy of Law</option>

											<option value="MD Kirk School of Law">MD Kirk School of Law</option>

											<option value="Michael E. Moritz College of Law, Ohio State University">Michael E. Moritz College of Law, Ohio State University</option>

											<option value="Michigan State University College of Law">Michigan State University College of Law</option>

											<option value="Miles Law School">Miles Law School</option>

											<option value="Mississippi College School of Law">Mississippi College School of Law</option>

											<option value="Monterey College of Law">Monterey College of Law</option>

											<option value="Nashville School of Law">Nashville School of Law</option>

											<option value="National University School of Law">National University School of Law</option>

											<option value="New College of California School of Law">New College of California School of Law</option>

											<option value="New England School of Law">New England School of Law</option>

											<option value="New York Law School">New York Law School</option>

											

											<option value="New York University School of Law">New York University School of Law</option>

											<option value="Norman Adrian Wiggins School of Law, Campbell University">Norman Adrian Wiggins School of Law, Campbell University</option>

											<option value="North Carolina Central University School of Law">North Carolina Central University School of Law</option>

											<option value="Northampton Law School">Northampton Law School</option>

											<option value="Northeastern University School of Law">Northeastern University School of Law</option>

											<option value="Northern Illinois University College of Law">Northern Illinois University College of Law</option>

											<option value="Northrop University">Northrop University</option>

											<option value="Northwestern California University School of Law">Northwestern California University School of Law</option>

											<option value="Northwestern University School of Law">Northwestern University School of Law</option>

											<option value="Notre Dame Law School">Notre Dame Law School</option>

											<option value="O. W. Coburn School of Law">O. W. Coburn School of Law</option>

											<option value="Oak Brook College of Law">Oak Brook College of Law</option>

											<option value="Ohio Northern University, Pettit College of Law">Ohio Northern University, Pettit College of Law</option>

											<option value="Oklahoma City University School of Law">Oklahoma City University School of Law</option>

											<option value="Pace University School of Law">Pace University School of Law</option>

											

											<option value="Pacific Coast University School of Law">Pacific Coast University School of Law</option>

											<option value="Pacific West College of Law">Pacific West College of Law</option>

											<option value="Paul M. Hebert Law Center, Louisiana State University">Paul M. Hebert Law Center, Louisiana State University</option>

											<option value="Penn State Law, Penn State University">Penn State Law, Penn State University</option>

											<option value="Peoples College of Law">Peoples College of Law</option>

											<option value="Pepperdine University School of Law">Pepperdine University School of Law</option>

											<option value="Pinnacles School of Law">Pinnacles School of Law</option>

											<option value="Pontifical Catholic University of Puerto Rico School of Law">Pontifical Catholic University of Puerto Rico School of Law</option>

											<option value="Pressler School of Law, Louisiana College">Pressler School of Law, Louisiana College</option>

											<option value="Princeton Law School">Princeton Law School</option>

											<option value="Quinnipiac University School of Law">Quinnipiac University School of Law</option>

											<option value="Regent University School of Law">Regent University School of Law</option>

											<option value="Robert H. Terrell Law School">Robert H. Terrell Law School</option>

											<option value="Roger Williams University School of Law">Roger Williams University School of Law</option>

											<option value="Rutgers Law School (Camden campus)">Rutgers Law School (Camden campus)</option>

											

											<option value="Rutgers Law School (Newark campus)">Rutgers Law School (Newark campus)</option>

											<option value="S.J. Quinney College of Law, University of Utah">S.J. Quinney College of Law, University of Utah</option>

											<option value="Saint Louis University School of Law">Saint Louis University School of Law</option>

											<option value="Salmon P. Chase College of Law, Northern Kentucky University">Salmon P. Chase College of Law, Northern Kentucky University</option>

											<option value="San Francisco Law School">San Francisco Law School</option>

											<option value="San Joaquin College of Law">San Joaquin College of Law</option>

											<option value="Sandra Day O Connor College of Law, Arizona State University">Sandra Day O Connor College of Law, Arizona State University</option>

											<option value="Santa Barbara College of Law">Santa Barbara College of Law</option>

											<option value="Santa Clara University School of Law">Santa Clara University School of Law</option>

											<option value="Savannah Law School">Savannah Law School</option>

											<option value="Seattle University School of Law">Seattle University School of Law</option>

											<option value="Seton Hall University School of Law">Seton Hall University School of Law</option>

											<option value="Shepard Broad Law Center, Nova Southeastern University">Shepard Broad Law Center, Nova Southeastern University</option>

											<option value="South Texas College of Law">South Texas College of Law</option>

											<option value="Southern California Institute of Law">Southern California Institute of Law</option>

											

											<option value="Southern Illinois University School of Law">Southern Illinois University School of Law</option>

											<option value="Southern University Law Center">Southern University Law Center</option>

											<option value="Southwestern University School of Law">Southwestern University School of Law</option>

											<option value="St. Francis School of Law">St. Francis School of Law</option>

											<option value="St. John Fisher College School of Law">St. John Fisher College School of Law</option>

											<option value="St. Johns University School of Law">St. Johns University School of Law</option>

											<option value="St. Marys University School of Law">St. Marys University School of Law</option>

											<option value="St. Thomas University School of Law">St. Thomas University School of Law</option>

											<option value="Stanford Law School">Stanford Law School</option>

											<option value="State and National Law School">State and National Law School</option>

											<option value="Stetson University College of Law">Stetson University College of Law</option>

											<option value="Sturm College of Law, University of Denver">Sturm College of Law, University of Denver</option>

											<option value="Suffolk University Law School">Suffolk University Law School</option>

											<option value="Syracuse University College of Law">Syracuse University College of Law</option>

											<option value="Taft Law School, William Howard Taft University">Taft Law School, William Howard Taft University</option>

											

											<option value="Texas A&M University School of Law">Texas A&M University School of Law</option>

											<option value="Texas Tech University School of Law">Texas Tech University School of Law</option>

											<option value="The George Washington University Law School">The George Washington University Law School</option>

											<option value="The Judge Advocate Generals Legal Center and School">The Judge Advocate Generals Legal Center and School</option>

											<option value="Thomas Goode Jones School of Law, Faulkner University">Thomas Goode Jones School of Law, Faulkner University</option>

											<option value="Thomas Jefferson School of Law">Thomas Jefferson School of Law</option>

											<option value="Thurgood Marshall School of Law, Texas Southern University">Thurgood Marshall School of Law, Texas Southern University</option>

											<option value="Touro College Jacob D. Fuchsberg Law Center">Touro College Jacob D. Fuchsberg Law Center</option>

											<option value="Trinity Law School, Trinity International University">Trinity Law School, Trinity International University</option>

											<option value="Tulane University School of Law">Tulane University School of Law</option>

											

											<option value="University at Buffalo Law School, SUNY">University at Buffalo Law School, SUNY</option>

											<option value="University of Akron School of Law">University of Akron School of Law</option>

											<option value="University of Alabama School of Law">University of Alabama School of Law</option>

											<option value="University of Alaska at Anchorage">University of Alaska at Anchorage</option>

											<option value="University of Arkansas School of Law">University of Arkansas School of Law</option>

											

											<option value="University of Baltimore School of Law">University of Baltimore School of Law</option>

											<option value="University of California, Berkeley School of Law (Boalt Hall)">University of California, Berkeley School of Law (Boalt Hall)</option>

											<option value="University of California, Davis School of Law (King Hall)">University of California, Davis School of Law (King Hall)</option>

											<option value="University of California, Hastings College of the Law">University of California, Hastings College of the Law</option>

											<option value="University of California, Irvine School of Law">University of California, Irvine School of Law</option>

											<option value="University of California, Los Angeles School of Law">University of California, Los Angeles School of Law</option>

											<option value="University of Chicago Law School">University of Chicago Law School</option>

											<option value="University of Cincinnati College of Law">University of Cincinnati College of Law</option>

											<option value="University of Colorado School of Law">University of Colorado School of Law</option>

											<option value="University of Connecticut School of Law">University of Connecticut School of Law</option>

											<option value="University of Dayton School of Law">University of Dayton School of Law</option>

											<option value="University of Detroit Mercy School of Law">University of Detroit Mercy School of Law</option>

											<option value="University of Florida Levin College of Law">University of Florida Levin College of Law</option>

											<option value="University of Georgia School of Law">University of Georgia School of Law</option>

											<option value="University of Honolulu School of Law">University of Honolulu School of Law</option>

											

											<option value="University of Houston Law Cente">University of Houston Law Cente</option>

											<option value="University of Idaho College of Law">University of Idaho College of Law</option>

											<option value="University of Illinois College of Law">University of Illinois College of Law</option>

											<option value="University of Iowa College of Law">University of Iowa College of Law</option>

											<option value="University of Kansas School of Law">University of Kansas School of Law</option>

											<option value="University of Kentucky College of Law">University of Kentucky College of Law</option>

											<option value="University of La Verne College of Law">University of La Verne College of Law</option>

											<option value="University of Maine School of Law">University of Maine School of Law</option>

											<option value="University of Maryland School of Law">University of Maryland School of Law</option>

											<option value="University of Massachusetts School of Law">University of Massachusetts School of Law</option>

											<option value="University of Miami School of Law">University of Miami School of Law</option>

											<option value="University of Michigan Law School">University of Michigan Law School</option>

											<option value="University of Minnesota Law School">University of Minnesota Law School</option>

											<option value="University of Mississippi School of Law">University of Mississippi School of Law</option>

											<option value="University of Missouri - Kansas City School of Law">University of Missouri - Kansas City School of Law</option>

											

											<option value="University of Missouri School of Law">University of Missouri School of Law</option>

											<option value="University of Montana School of Law">University of Montana School of Law</option>

											<option value="University of Nebraska–Lincoln College of Law">University of Nebraska–Lincoln College of Law</option>

											<option value="University of New Hampshire School of Law">University of New Hampshire School of Law</option>

											<option value="University of New Mexico School of Law">University of New Mexico School of Law</option>

											<option value="University of North Carolina School of Law">University of North Carolina School of Law</option>

											<option value="University of North Dakota School of Law">University of North Dakota School of Law</option>

											<option value="University of North Texas at Dallas College of Law">University of North Texas at Dallas College of Law</option>

											<option value="University of Oklahoma College of Law">University of Oklahoma College of Law</option>

											<option value="University of Oregon School of Law">University of Oregon School of Law</option>

											<option value="University of Pennsylvania Law School">University of Pennsylvania Law School</option>

											<option value="University of Pittsburgh School of Law">University of Pittsburgh School of Law</option>

											<option value="University of Puerto Rico School of Law">University of Puerto Rico School of Law</option>

											<option value="University of Richmond School of Law">University of Richmond School of Law</option>

											<option value="University of San Diego School of Law">University of San Diego School of Law</option>

											

											<option value="University of San Francisco School of Law">University of San Francisco School of Law</option>

											<option value="University of San Luis Obispo School of Law">University of San Luis Obispo School of Law</option>

											<option value="University of Silicon Valley Law School">University of Silicon Valley Law School</option>

											<option value="University of South Carolina School of Law">University of South Carolina School of Law</option>

											<option value="University of South Dakota School of Law">University of South Dakota School of Law</option>

											<option value="University of St. Thomas School of Law">University of St. Thomas School of Law</option>

											<option value="University of Tennessee College of Law">University of Tennessee College of Law</option>

											<option value="University of Texas School of Law">University of Texas School of Law</option>

											<option value="University of Toledo College of Law">University of Toledo College of Law</option>

											<option value="University of Tulsa College of Law">University of Tulsa College of Law</option>

											<option value="University of Virginia School of Law">University of Virginia School of Law</option>

											<option value="University of Washington School of Law">University of Washington School of Law</option>

											<option value="University of West Los Angeles School of Law">University of West Los Angeles School of Law</option>

											<option value="University of Wisconsin Law School">University of Wisconsin Law School</option>

											<option value="University of Wyoming College of Law">University of Wyoming College of Law</option>

											

											<option value="Valparaiso University School of Law">Valparaiso University School of Law</option>

											<option value="Vanderbilt University Law School">Vanderbilt University Law School</option>

											<option value="Ventura College of Law">Ventura College of Law</option>

											<option value="Vermont Law School">Vermont Law School</option>

											<option value="Villanova University School of Law">Villanova University School of Law</option>

											<option value="Wake Forest University School of Law">Wake Forest University School of Law</option>

											<option value="Walter F. George School of Law, Mercer University">Walter F. George School of Law, Mercer University</option>

											<option value="Washburn University School of Law">Washburn University School of Law</option>

											<option value="Washington and Lee University School of Law">Washington and Lee University School of Law</option>

											<option value="Washington College of Law, American University">Washington College of Law, American University</option>

											<option value="Washington University School of Law">Washington University School of Law</option>

											<option value="Wayne State University Law School">Wayne State University Law School</option>

											<option value="West Virginia University College of Law">West Virginia University College of Law</option>

											<option value="Western Michigan University Thomas M. Cooley Law School">Western Michigan University Thomas M. Cooley Law School</option>

											<option value="Western New England University School of Law">Western New England University School of Law</option>

											

											<option value="Western Sierra Law School">Western Sierra Law School</option>

											<option value="Western State College of Law">Western State College of Law</option>

											<option value="Whittier Law School">Whittier Law School</option>

											<option value="Widener Law Commonwealth">Widener Law Commonwealth</option>

											<option value="Widener University School of Law">Widener University School of Law</option>

											<option value="Willamette University College of Law">Willamette University College of Law</option>

											<option value="William H. Bowen School of Law, University of Arkansas at Little Rock">William H. Bowen School of Law, University of Arkansas at Little Rock</option>

											<option value="William Mitchell College of Law">William Mitchell College of Law</option>

											<option value="William S. Boyd School of Law, University of Nevada, Las Vegas">William S. Boyd School of Law, University of Nevada, Las Vegas</option>

											<option value="William S. Richardson School of Law, University of Hawaii">William S. Richardson School of Law, University of Hawaii</option>

											<option value="Winchester Law School">Winchester Law School</option>

											<option value="Woodrow Wilson College of Law">Woodrow Wilson College of Law</option>

											<option value="Yale Law School">Yale Law School</option>

											

											<option value="Other">Other</option>

										</select>                                          

									</td>

                                    <td id="otherTxtSchoolInfo" class="pmpro_checkout-field name_Table" style="visibility:hidden;">

                                        <label for="otherTxt">Other Law School</label>

                                        <input type="textbox"/>

                                    </td>

                                </tr>                                

							</table>

                    ',

            'label'    	=> ' ',			// custom field label		

			'profile'	=> true,			// show in user profile

			'required'	=> false,			// make this field required

            'showrequired'  => false

		)

	);     

    

    $fields[] = new PMProRH_Field(

    	'gradYr',						// input name, will also be used as meta key

		'text',							// type of field

		array(

			'label'		=> 'Graduation Year',			// custom field label

			'size'		=> 40,				// input size			

			'profile'	=> true,			// show in user profile			

		)

	);  

	

	$fields[] = new PMProRH_Field(

		'Areas',						// input name, will also be used as meta key

		'html',							// type of field

		array(

			'html'		=> '<div>Please check all of your Practice Areas</div>

                            <div id="Areas">

    							<input type="checkbox" name="areas" value="Adoption"> Adoption </input></br>

    							<input type="checkbox" name="areas" value="Antitrust"> Antitrust </input></br>

                                <input type="checkbox" name="areas" value="Appellate"> Appellate </input></br>

        						<input type="checkbox" name="areas" value="Bankruptcy"> Bankruptcy </input></br>

                                <input type="checkbox" name="areas" value="Child custody/support"> Child custody/support </input></br>

        						<input type="checkbox" name="areas" value="Civil litigation"> Civil litigation </input></br>

                                <input type="checkbox" name="areas" value="Class Action"> Class Action </input></br>

                                <input type="checkbox" name="areas" value="Commercial"> Commercial </input></br>

        						<input type="checkbox" name="areas" value="Contract"> Contract </input></br>

                                <input type="checkbox" name="areas" value="Copyright"> Copyright </input></br>

                                <input type="checkbox" name="areas" value="Corporate"> Corporate </input></br>

        						<input type="checkbox" name="areas" value="Criminal"> Criminal </input></br>

                                <input type="checkbox" name="areas" value="Discrimination"> Discrimination </input></br>

        						<input type="checkbox" name="areas" value="Divorce"> Divorce </input></br>

                                <input type="checkbox" name="areas" value="Employment"> Employment </input></br>

        						<input type="checkbox" name="areas" value="Estate Planning"> Estate Planning </input></br>

                                <input type="checkbox" name="areas" value="Family"> Family </input></br>

        						<input type="checkbox" name="areas" value="Government"> Government </input></br>

                                <input type="checkbox" name="areas" value="Health Care"> Health Care </input></br>

                                <input type="checkbox" name="areas" value="Immigration"> Immigration </input></br>

                                <input type="checkbox" name="areas" value="Insurance"> Insurance </input></br>

                                <input type="checkbox" name="areas" value="Intellectual Property"> Intellectual Property </input></br>

                                <input type="checkbox" name="areas" value="International"> International </input></br>

                                <input type="checkbox" name="areas" value="International Trade"> International Trade </input></br>

                                <input type="checkbox" name="areas" value="Labor"> Labor </input></br>

                                <input type="checkbox" name="areas" value="Land Use (planning/zoning)"> Land Use (planning/zoning) </input></br>

                                <input type="checkbox" name="areas" value="Litigation"> Litigation </input></br>

                                <input type="checkbox" name="areas" value="Malpractice"> Malpractice </input></br>

                                <input type="checkbox" name="areas" value="Not for Profit"> Not for Profit </input></br>

                                <input type="checkbox" name="areas" value="Patent and Trademark"> Patent and Trademark </input></br>

                                <input type="checkbox" name="areas" value="Personal Injury"> Personal Injury </input></br>

                                <input type="checkbox" name="areas" value="Privacy"> Privacy </input></br>

                                <input type="checkbox" name="areas" value="Product Liability"> Product Liability </input></br>

                                <input type="checkbox" name="areas" value="Real Estate"> Real Estate </input></br>

                                <input type="checkbox" name="areas" value="Regulatory"> Regulatory </input></br>

                                <input type="checkbox" name="areas" value="Tax"> Tax </input></br>

                                <input type="checkbox" name="areas" value="Traffic (DUI & DWI)"> Traffic (DUI & DWI) </input></br>

                                <input type="checkbox" name="areas" value="White Collar"> White Collar </input></br>

                                <input type="checkbox" name="areas" value="Wills/Trusts & Estate Planning"> Wills/Trusts & Estate Planning </input></br>

                                <input type="checkbox" name="areas" value="Other"> Other </input></br>                                

							</div>',			// custom field label	

			'label'     => 'Practice Area(s)',

			'profile'	=> true,			// show in user profile		

			'required'	=> false,

			'showrequired'  => false,

		)		

	); 	    

    

	

	

	pmprorh_add_checkout_box("scriptField", " ","",1);

	pmprorh_add_checkout_box("contactField", "Contact Information","",2);

    pmprorh_add_checkout_box("workField", "Work Information","",3);

	pmprorh_add_checkout_box("business", "More Information", "Fields below will help us in verifying your account.",4);

	

	//adds customized fields to the page

    // foreach($scriptFields as $scriptField)

    // 	pmprorh_add_registration_field(

	// 		'scriptField',

	// 		//'checkout_boxes',				// location on checkout page

	// 		$scriptField						// PMProRH_Field object

	// 	);

	//foreach($contactFields as $contactField)

	//	pmprorh_add_registration_field(

	//		'contactField',

			//'checkout_boxes',				// location on checkout page

	//		$contactField						// PMProRH_Field object

	//	);

    // foreach($workFields as $workField)

    // 	pmprorh_add_registration_field(

	// 		'workField',

	// 		//'checkout_boxes',				// location on checkout page

	// 		$workField						// PMProRH_Field object

	// 	);    

	// foreach($fields as $field)

	// 	pmprorh_add_registration_field(

	// 		'business',

	// 		//'checkout_boxes',				// location on checkout page

	// 		$field						// PMProRH_Field object

	// 	);

	

	//that's it. see the PMPro Register Helper readme for more information and examples.

}

add_action( 'init', 'my_pmprorh_init' );

