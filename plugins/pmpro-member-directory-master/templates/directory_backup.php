<?php

/*

	This shortcode will display the members list and additional content based on the defined attributes.

*/

function pmpromd_shortcode($atts, $content=null, $code="")

{

	// $atts    ::= array of attributes

	// $content ::= text within enclosing form of shortcode element

	// $code    ::= the shortcode found, when == callback name

	// examples: [pmpro_member_directory show_avatar="false" show_email="false" levels="1,2"]



	extract(shortcode_atts(array(

		'avatar_size' => '128',

		'fields' => NULL,

		'layout' => 'table',

		'level' => NULL,

		'levels' => NULL,

		'limit' => NULL,

		'link' => NULL,

		'order_by' => 'last_name',

		'order' => 'ASC',

		'show_avatar' => NULL,

		'show_email' => NULL,

		'show_level' => NULL,

		'show_search' => NULL,

		'show_startdate' => NULL,

	), $atts, "pmpro_member_directory"));



	global $wpdb, $post, $pmpro_pages, $pmprorh_registration_fields;



	//some page vars

	if(!empty($pmpro_pages['directory']))

		$directory_url = get_permalink($pmpro_pages['directory']);

	if(!empty($pmpro_pages['profile']))

		$profile_url = get_permalink($pmpro_pages['profile']);



	//turn 0's into falses

	if($link === "0" || $link === "false" || $link === "no")

		$link = false;

	else

		$link = true;



	//did they use level instead of levels?

	if(empty($levels) && !empty($level))

		$levels = $level;



	if($show_avatar === "0" || $show_avatar === "false" || $show_avatar === "no")

		$show_avatar = false;

	else

		$show_avatar = true;



	if($show_email === "0" || $show_email === "false" || $show_email === "no")

		$show_email = false;

	else

		$show_email = true;



	if($show_level === "0" || $show_level === "false" || $show_level === "no")

		$show_level = false;

	else

		$show_level = true;



	if($show_search === "0" || $show_search === "false" || $show_search === "no")

		$show_search = false;

	else

		$show_search = true;



	if($show_startdate === "0" || $show_startdate === "false" || $show_startdate === "no")

		$show_startdate = false;

	else

		$show_startdate = true;



	if(isset($_REQUEST['ps']))

		$s = $_REQUEST['ps'];

	else

		$s = "";



	if(isset($_REQUEST['pn']))

		$pn = intval($_REQUEST['pn']);

	else

		$pn = 1;



	if(isset($_REQUEST['limit']))

		$limit = intval($_REQUEST['limit']);

	elseif(empty($limit))

		$limit = 15;



	$end = $pn * $limit;

	$start = $end - $limit;



	if($s)

	{

		$sqlQuery = "SELECT SQL_CALC_FOUND_ROWS u.ID, u.user_login, u.user_email, u.user_nicename, u.display_name, UNIX_TIMESTAMP(u.user_registered) as joindate, mu.membership_id, mu.initial_payment, mu.billing_amount, mu.cycle_period, mu.cycle_number, mu.billing_limit, mu.trial_amount, mu.trial_limit, UNIX_TIMESTAMP(mu.startdate) as startdate, UNIX_TIMESTAMP(mu.enddate) as enddate, m.name as membership, umf.meta_value as first_name, uml.meta_value as last_name FROM $wpdb->users u LEFT JOIN $wpdb->usermeta umh ON umh.meta_key = 'pmpromd_hide_directory' AND u.ID = umh.user_id LEFT JOIN $wpdb->usermeta umf ON umf.meta_key = 'first_name' AND u.ID = umf.user_id LEFT JOIN $wpdb->usermeta uml ON uml.meta_key = 'last_name' AND u.ID = uml.user_id LEFT JOIN $wpdb->usermeta um ON u.ID = um.user_id LEFT JOIN $wpdb->pmpro_memberships_users mu ON u.ID = mu.user_id LEFT JOIN $wpdb->pmpro_membership_levels m ON mu.membership_id = m.id WHERE mu.status = 'active' AND (umh.meta_value = '1') AND mu.membership_id > 0 AND ";



		$sqlQuery .= "(u.user_login LIKE '%" . esc_sql($s) . "%' OR u.user_email LIKE '%" . esc_sql($s) . "%' OR u.display_name LIKE '%" . esc_sql($s) . "%' OR um.meta_value LIKE '%" . esc_sql($s) . "%') ";



		if($levels)

			$sqlQuery .= " AND mu.membership_id IN(" . esc_sql($levels) . ") ";



		$sqlQuery .= "GROUP BY u.ID ORDER BY ". esc_sql($order_by) . " " . $order;

	}

	else

	{

		$sqlQuery = "SELECT SQL_CALC_FOUND_ROWS u.ID, u.user_login, u.user_email, u.user_nicename, u.display_name, UNIX_TIMESTAMP(u.user_registered) as joindate, mu.membership_id, mu.initial_payment, mu.billing_amount, mu.cycle_period, mu.cycle_number, mu.billing_limit, mu.trial_amount, mu.trial_limit, UNIX_TIMESTAMP(mu.startdate) as startdate, UNIX_TIMESTAMP(mu.enddate) as enddate, m.name as membership, umf.meta_value as first_name, uml.meta_value as last_name FROM $wpdb->users u LEFT JOIN $wpdb->usermeta umh ON umh.meta_key = 'pmpromd_hide_directory' AND u.ID = umh.user_id LEFT JOIN $wpdb->usermeta umf ON umf.meta_key = 'first_name' AND u.ID = umf.user_id LEFT JOIN $wpdb->usermeta uml ON uml.meta_key = 'last_name' AND u.ID = uml.user_id LEFT JOIN $wpdb->pmpro_memberships_users mu ON u.ID = mu.user_id LEFT JOIN $wpdb->pmpro_membership_levels m ON mu.membership_id = m.id";

		$sqlQuery .= " WHERE mu.status = 'active' AND (umh.meta_value = '1') AND mu.membership_id > 0 ";

		if($levels)

			$sqlQuery .= " AND mu.membership_id IN(" . esc_sql($levels) . ") ";

		$sqlQuery .= "ORDER BY ". esc_sql($order_by) . " " . esc_sql($order);

	}



	$sqlQuery .= " LIMIT $start, $limit";



	$sqlQuery = apply_filters("pmpro_member_directory_sql", $sqlQuery, $levels, $s, $pn, $limit, $start, $end, $order_by, $order);



	$theusers = $wpdb->get_results($sqlQuery);

	$totalrows = $wpdb->get_var("SELECT FOUND_ROWS() as found_rows");



	//update end to match totalrows if total rows is small

	if($totalrows < $end)

		$end = $totalrows;



	$layout_cols = preg_replace('/[^0-9]/', '', $layout);

	if(!empty($layout_cols))

		$theusers_chunks = array_chunk($theusers, $layout_cols);

	else

		$theusers_chunks = array_chunk($theusers, 1);



	ob_start();



	?>

	<?php if(!empty($show_search)) { ?>

	<form role="search" class="pmpro_member_directory_search search-form">

		<label>

			<span class="screen-reader-text"><?php _e('Search for:','pmpromd'); ?></span>

			<input type="search" class="search-field" placeholder="<?php _e('Search Members','pmpromd'); ?>" name="ps" value="<?php if(!empty($_REQUEST['ps'])) echo esc_attr($_REQUEST['ps']);?>" title="<?php _e('Search Members','pmpromd'); ?>" />

			<input type="hidden" name="limit" value="<?php echo esc_attr($limit);?>" />

		</label>

		<input type="submit" class="search-submit" value="<?php _e('Search Members','pmpromd'); ?>">

	</form>

<?php } ?>



	<h3 id="pmpro_member_directory_subheading">

		<?php if(!empty($s)) { ?>

			<?php printf(__('Profiles Within <em>%s</em>.','pmpromd'), ucwords(esc_html($s))); ?>

		<?php } else { ?>

			<?php _e('Viewing All Profiles','pmpromd'); ?>

		<?php } ?>

		<?php if($totalrows > 0) { ?>

			<small class="muted">

				(<?php

				if($totalrows == 1)

					printf(__('Showing 1 Result','pmpromd'), $start + 1, $end, $totalrows);

				else

					printf(__('Showing %s-%s of %s Results','pmpromd'), $start + 1, $end, $totalrows);

				?>)

			</small>

		<?php } ?>

	</h3>

	<?php

	if(!empty($theusers))

	{

		if(!empty($fields))

		{

			$fields_array = explode(";",$fields);

			if(!empty($fields_array))

			{

				for($i = 0; $i < count($fields_array); $i++ )

					$fields_array[$i] = explode(",", trim($fields_array[$i]));

			}

		}

		else

			$fields_array = false;



		// Get Register Helper field options

		$rh_fields = array();

		if(!empty($pmprorh_registration_fields)) {

			foreach($pmprorh_registration_fields as $location) {

				foreach($location as $field) {

					if(!empty($field->options))

						$rh_fields[$field->name] = $field->options;

				}

			}

		}

		?>

		<div class="pmpro_member_directory" style="width:auto">

			<hr class="clear" />

			<?php

			if($layout == "table")

			{

				?>
				<!-- KABA -->
				<script type="text/javascript">
					jQuery(document).ready(function () {
						document.getElementById("defaultTab").click();
					});
					function openTab(evt, cityName) {
						var i, tabcontent, tablinks;
						tabcontent = document.getElementsByClassName("tabcontent");
						for (i = 0; i < tabcontent.length; i++) {
							tabcontent[i].style.display = "none";
						}
						tablinks = document.getElementsByClassName("tablinks");
						for (i = 0; i < tablinks.length; i++) {
							tablinks[i].className = tablinks[i].className.replace(" active", "");
						}
						document.getElementById(cityName).style.display = "block";
						evt.currentTarget.className += " active";
					}
				</script>


				<div class="tab">
					<button class="tablinks" onclick="openTab(event, 'Attorneys')" id="defaultTab">Attorneys</button>
					<button class="tablinks" onclick="openTab(event, 'Law Students')">Law Students</button>
				</div>

				<div id="Attorneys" class="tabcontent">
					<table style="width: 100%;table-layout: fixed;word-wrap: break-word;overflow: auto;">

						<thead>

							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('Profile Pic', 'pmpromd'); ?>

								</h3>

							</th>

							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('Name', 'pmpromd'); ?>

								</h3>

							</th>

							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('Preferred Name', 'pmpromd'); ?>

								</h3>

							</th>

							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('E-mail Address', 'pmpromd'); ?>

								</h3>

							</th>

							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('Company/Employer', 'pmpromd'); ?>

								</h3>

							</th>

							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('Practice Areas', 'pmpromd'); ?>

								</h3>

							</th>

						</thead>

						<tbody>

							<?php

							$count = 0;

							foreach($theusers as $auser)

							{
								$is_law_school = get_user_meta($auser->ID, 'is_law_student',true);
								if (empty($is_law_school)){

									$auser = get_userdata($auser->ID);

									$auser->membership_level = pmpro_getMembershipLevelForUser($auser->ID);

									$count++;

									?>

									<tr id="pmpro_member_directory_row-<?php echo $auser->ID; ?>" class="pmpro_member_directory_row<?php if(!empty($link) && !empty($profile_url)) { echo " pmpro_member_directory_linked"; } ?>">
										<td>

											<h4 class="pmpro_member_directory_display-name">
												<?php
												$profile_pic_url = get_user_meta($auser->ID, 'profile_pic_url', true);

												if(!empty($link) && !empty($profile_url)) { ?>
													<a class="<?php echo $avatar_align; ?>" href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>" target="_blank">
														<?php if ( !empty($profile_pic_url) ) {?>
															<img src="<?php echo esc_attr($profile_pic_url); ?>" width="250" height="250" />
														<?php
														} else {
															echo get_avatar($auser->ID, $avatar_size, NULL, $auser->user_nicename);
														}?>
													</a>
												<?php
												} else { ?>
													<span class="<?php echo $avatar_align; ?>"><?php echo get_avatar($auser->ID, $avatar_size, NULL, $auser->user_nicename); ?></span>
												<?php
												} ?>
											</h4>

										</td>
										<td>

											<h4 class="pmpro_member_directory_display-name">
												<?php
													$f_name =  get_user_meta($auser->ID, 'first_name', true);
													$l_name = get_user_meta($auser->ID, 'last_name', true);
													$full_name = $l_name . ", " . $f_name;
												if(!empty($link) && !empty($profile_url)) { ?>
													<a href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>" target="_blank"><?php echo $full_name; ?></a>
												<?php } else { ?>
													<?php echo $full_name; ?>
												<?php } ?>
											</h4>

										</td>

										<td>

											<h4 class="pmpro_member_directory_display-name">

												<?php echo esc_attr(get_user_meta($auser->ID, 'pref_name', true)); ?>

											</h4>

										</td>

										<td>

											<h4 class="pmpro_member_directory_display-name">

												<?php
												$receiver = esc_attr($auser->user_email);
												echo "<a href='mailto:" . $receiver . "'>" . $receiver . "</a>";  ?>

											</h4>

										</td>

										<td>

											<h4 class="pmpro_member_directory_display-name">

												<?php echo esc_attr(get_user_meta($auser->ID, 'company_name', true)); ?>

											</h4>

										</td>

										<td>

											<h4 class="pmpro_member_directory_display-name">
											<?php
											// echo esc_attr(get_user_meta($auser->ID, 'practice_areas', true));

											$selected_areas = explode(',', get_user_meta($auser->ID, 'practice_areas', true));
											$area_other = get_user_meta($auser->ID, 'area_other', true);
											if (!empty($selected_areas)){
												foreach($selected_areas as $area){
													if ($area != "Other") {
														echo esc_attr($area);
													}
													else{
														echo esc_attr('Other (' . $area_other . ')');
													}
											?>
													<br/>
												<?php
												}

											}
											?>
											</h4>

										</td>


										<!-- <td>

											<h3 class="pmpro_member_directory_display-name">

												<?php if(!empty($link) && !empty($profile_url)) { ?>

													<a href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>"><?php echo $auser->display_name; ?></a>

												<?php } else { ?>

													<?php echo $auser->display_name; ?>

												<?php } ?>

											</h3>

										</td>											 -->

									</tr>
								<?php } ?>

							<?php

							}

							?>

						</tbody>

					</table>
				</div>

				<div id="Law Students" class="tabcontent">
					<table style="width: 100%;table-layout: fixed;word-wrap: break-word;overflow: auto;">

						<thead>
							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('Profile Pic', 'pmpromd'); ?>

								</h3>

							</th>

							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('Name', 'pmpromd'); ?>

								</h3>

							</th>

							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('Preferred Name', 'pmpromd'); ?>

								</h3>

							</th>

							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('E-mail Address', 'pmpromd'); ?>

								</h3>

							</th>

							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('Law School', 'pmpromd'); ?>

								</h3>

							</th>

							<th>

								<h3 class="pmpro_member_directory_display-name">

									<?php _e('Graduation Year', 'pmpromd'); ?>

								</h3>

							</th>

						</thead>

						<tbody>

							<?php

							$count = 0;

							foreach($theusers as $auser)

							{
								$is_law_school = get_user_meta($auser->ID, 'is_law_student',true);
								if ($is_law_school == 1){

									$auser = get_userdata($auser->ID);

									$auser->membership_level = pmpro_getMembershipLevelForUser($auser->ID);

									$count++;

									?>

									<tr id="pmpro_member_directory_row-<?php echo $auser->ID; ?>" class="pmpro_member_directory_row<?php if(!empty($link) && !empty($profile_url)) { echo " pmpro_member_directory_linked"; } ?>">

										<td>

											<h4 class="pmpro_member_directory_display-name">
												<?php
												$profile_pic_url = get_user_meta($auser->ID, 'profile_pic_url', true);

												if(!empty($link) && !empty($profile_url)) { ?>
													<a class="<?php echo $avatar_align; ?>" href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>" target="_blank">
														<?php if ( !empty($profile_pic_url) ) {?>
															<img src="<?php echo esc_attr($profile_pic_url); ?>" width="250" height="250" />
														<?php
														} else {
															echo get_avatar($auser->ID, $avatar_size, NULL, $auser->user_nicename);
														}?>
													</a>
												<?php
												} else { ?>
													<span class="<?php echo $avatar_align; ?>"><?php echo get_avatar($auser->ID, $avatar_size, NULL, $auser->user_nicename); ?></span>
												<?php
												} ?>
											</h4>

										</td>
										<td>

											<h4 class="pmpro_member_directory_display-name">

												<?php
													$f_name =  get_user_meta($auser->ID, 'first_name', true);
													$l_name = get_user_meta($auser->ID, 'last_name', true);
													$full_name = $l_name . ", " . $f_name;
												if(!empty($link) && !empty($profile_url)) { ?>
													<a href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>" target="_blank"><?php echo $full_name; ?></a>
												<?php } else { ?>
													<?php echo $full_name; ?>
												<?php } ?>

											</h4>

										</td>

										<td>

											<h4 class="pmpro_member_directory_display-name">

												<?php echo esc_attr(get_user_meta($auser->ID, 'pref_name', true)); ?>

											</h4>

										</td>

										<td>

											<h4 class="pmpro_member_directory_display-name">

												<?php
												$receiver = esc_attr($auser->user_email);
												echo "<a href='mailto:" . $receiver . "'>" . $receiver . "</a>";  ?>

											</h4>

										</td>

										<td>

											<h4 class="pmpro_member_directory_display-name">

												<?php
												$schoolName = get_user_meta($auser->ID, 'school_name', true);
													if  (!empty($schoolName) && $schoolName != "Other")
													{
														echo esc_attr($schoolName);
													}
													else{
														echo esc_attr(get_user_meta($auser->ID, 'school_other', true));
													}
												?>

											</h4>

										</td>

										<td>

											<h4 class="pmpro_member_directory_display-name">
												<?php
												echo esc_attr(get_user_meta($auser->ID, 'graduation_date', true));
												?>
											</h4>

										</td>


										<!-- <td>

											<h3 class="pmpro_member_directory_display-name">

												<?php if(!empty($link) && !empty($profile_url)) { ?>

													<a href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>"><?php echo $auser->display_name; ?></a>

												<?php } else { ?>

													<?php echo $auser->display_name; ?>

												<?php } ?>

											</h3>

										</td> -->

									</tr>

								<?php } ?>

							<?php

							}

							?>

						</tbody>

					</table>
				</div>



					<?php

				}

				else

				{

					$count = 0;

					foreach($theusers_chunks as $row): ?>

						<div class="row">

							<?php

							foreach($row as $auser)

							{

								$count++;

								$auser = get_userdata($auser->ID);

								$auser->membership_level = pmpro_getMembershipLevelForUser($auser->ID);

								?>

								<div class="medium-<?php

								if($layout == '2col')

								{

									$avatar_align = "alignright";

								echo '6 ';

							}

							elseif($layout == '3col')

							{

								$avatar_align = "aligncenter";

								echo '4 text-center ';

							}

							elseif($layout == '4col')

							{

								$avatar_align = "aligncenter";

								echo '3 text-center ';

							}

							else

							{

								$avatar_align = "alignright";

								echo '12 ';

							}

							if($count == $end)

								echo 'end ';

							?>

								columns">

								<div id="pmpro_member-<?php echo $auser->ID; ?>">

									<?php if(!empty($show_avatar)) { ?>

										<div class="pmpro_member_directory_avatar">

											<?php if(!empty($link) && !empty($profile_url)) { ?>

												<a class="<?php echo $avatar_align; ?>" href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>"><?php echo get_avatar($auser->ID, $avatar_size, NULL, $auser->display_name); ?></a>

											<?php } else { ?>

												<span class="<?php echo $avatar_align; ?>"><?php echo get_avatar($auser->ID, $avatar_size, NULL, $auser->display_name); ?></span>

											<?php } ?>

										</div>

									<?php } ?>

									<h3 class="pmpro_member_directory_display-name">

										<?php if(!empty($link) && !empty($profile_url)) { ?>

											<a href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>"><?php echo $auser->display_name; ?></a>

										<?php } else { ?>

											<?php echo $auser->display_name; ?>

										<?php } ?>

									</h3>

									<?php if(!empty($show_email)) { ?>

										<p class="pmpro_member_directory_email">

											<strong><?php _e('Email Address', 'pmpromd'); ?></strong>

											<?php echo $auser->user_email; ?>

										</p>

									<?php } ?>

									<?php if(!empty($show_level)) { ?>

										<p class="pmpro_member_directory_level">

											<strong><?php _e('Level', 'pmpromd'); ?></strong>

											<?php echo $auser->membership_level->name; ?>

										</p>

									<?php } ?>

									<?php if(!empty($show_startdate)) { ?>

										<p class="pmpro_member_directory_date">

											<strong><?php _e('Start Date', 'pmpromd'); ?></strong>

											<?php echo date(get_option("date_format"), $auser->membership_level->startdate); ?>

										</p>

									<?php } ?>

									<?php

									if(!empty($fields_array))

									{

										foreach($fields_array as $field)

										{

											$meta_field = $auser->{$field[1]};

											if(!empty($meta_field))

											{

												?>

												<p class="pmpro_member_directory_<?php echo $field[1]; ?>">

													<?php

													if(is_array($meta_field) && !empty($meta_field['filename']) )

													{

														//this is a file field

														?>

														<strong><?php echo $field[0]; ?></strong>

														<?php echo pmpromd_display_file_field($meta_field); ?>

														<?php

													}

													elseif(is_array($meta_field))

													{

														//this is a general array, check for Register Helper options first

														if(!empty($rh_fields[$field[1]])) {

															foreach($meta_field as $key => $value)

																$meta_field[$key] = $rh_fields[$field[1]][$value];

														}

														?>

														<strong><?php echo $field[0]; ?></strong>

														<?php echo implode(", ",$meta_field); ?>

														<?php

													}

													elseif($field[1] == 'user_url')

													{

														?>

														<a href="<?php echo $auser->{$field[1]}; ?>" target="_blank"><?php echo $field[0]; ?></a>

														<?php

													}

													else

													{

														?>

														<strong><?php echo $field[0]; ?>:</strong>

														<?php echo make_clickable($auser->{$field[1]}); ?>

														<?php

													}

													?>

												</p>

												<?php

											}

										}

									}

									?>

									<?php if(!empty($link) && !empty($profile_url)) { ?>

										<p class="pmpro_member_directory_link">

											<a class="more-link" href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>"><?php _e('View Profile','pmpromd'); ?></a>

										</p>

									<?php } ?>

								</div> <!-- end pmpro_addon_package-->

							</div>

							<?php

						}

						?>

					</div> <!-- end row -->

					<hr />

					<?php

				endforeach;

			}

			?>

		</div> <!-- end pmpro_member_directory -->

		<?php

	}

	else

	{

		?>

		<p class="pmpro_member_directory_message pmpro_message pmpro_error">

			<?php _e('No matching profiles found','pmpromd'); ?>

			<?php

			if($s)

			{

				printf(__('within <em>%s</em>.','pmpromd'), ucwords(esc_html($s)));

				if(!empty($directory_url))

				{

					?>

					<a class="more-link" href="<?php echo $directory_url; ?>"><?php _e('View All Members','pmpromd'); ?></a>

					<?php

				}

			}

			else

			{

				echo ".";

			}

			?>

		</p>

		<?php

	}



	//prev/next

	?>

	<div class="pmpro_pagination">

		<?php

		//prev

		if($pn > 1)

		{

			?>

			<span class="pmpro_prev"><a href="<?php echo esc_url(add_query_arg(array("ps"=>$s, "pn"=>$pn-1, "limit"=>$limit), get_permalink($post->ID)));?>">&laquo; <?php _e('Previous','pmpromd'); ?></a></span>

			<?php

		}

		//next

		if($totalrows > $end)

		{

			?>

			<span class="pmpro_next"><a href="<?php echo esc_url( add_query_arg( array( "ps"=>$s, "pn"=>$pn+1, "limit"=>$limit ), get_permalink( $post->ID ) ) );?>"><?php _e( 'Next', 'pmpromd' ); ?> &raquo;</a></span>

			<?php

		}

		?>

	</div>

	<?php

	?>

	<?php

	$temp_content = ob_get_contents();

	ob_end_clean();

	return $temp_content;

}

add_shortcode("pmpro_member_directory", "pmpromd_shortcode");
