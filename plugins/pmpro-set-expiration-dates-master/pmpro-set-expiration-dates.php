<?php
/*
Plugin Name: PMPro Set Expiration Dates
Plugin URI: http://www.paidmembershipspro.com/wp/pmpro-set-expiration-dates/
Description: Set a specific expiration date (e.g. 2013-12-31) for a PMPro membership level or discount code. 
Version: .1.1
Author: Stranger Studios
Author URI: http://www.strangerstudios.com
*/

/*
	This first set of functions adds our fields to the edit membership levels page
*/
//add level cost text field to level price settings
function pmprosed_pmpro_membership_level_after_other_settings()
{
    $level_id = intval($_REQUEST['edit']);
    if($level_id > 0)
        $set_expiration_date = pmpro_getSetExpirationDate($level_id);
    else
        $set_expiration_date = "";
    ?>
    <h3 class="topborder">Set Expiration Date</h3>
    <p>To have this level expire on a specific date, enter it below in YYYY-MM-DD format. <strong>Note:</strong> You must also set an expiration date above (e.g. 1 Year) which will be overwritten by the value below.</p>
    <table>
        <tbody class="form-table">
        <tr>
            <th scope="row" valign="top"><label for="set_expiration_date">Expiration Date:</label></th>
            <td>
                <input type="text" name="set_expiration_date" value="<?php echo esc_attr($set_expiration_date);?>" />
                <br /><small>YYYY-MM-DD format. Enter "Y" for current year, "Y2" for next year. M, M2 for current/next month.</small>
            </td>
        </tr>
        </tbody>
    </table>
<?php
}
add_action("pmpro_membership_level_after_other_settings", "pmprosed_pmpro_membership_level_after_other_settings");

//save level cost text when the level is saved/added
function pmprosed_pmpro_save_membership_level($level_id)
{
    pmpro_saveSetExpirationDate($level_id, $_REQUEST['set_expiration_date']);			//add level cost text for this level
}
add_action("pmpro_save_membership_level", "pmprosed_pmpro_save_membership_level");

/*
	Update expiration date of level at checkout.
*/
function pmprosed_pmpro_checkout_level($level)
{
    global $wpdb;

    //get discount code passed in
    $discount_code = preg_replace("/[^A-Za-z0-9\-]/", "", $_REQUEST['discount_code']);

    if(!empty($discount_code))
        $discount_code_id = $wpdb->get_var("SELECT id FROM $wpdb->pmpro_discount_codes WHERE code = '" . esc_sql($discount_code) . "' LIMIT 1");
    else
        $discount_code_id = NULL;

    //does this level have a set expiration date?
    $set_expiration_date = pmpro_getSetExpirationDate($level->id, $discount_code_id);

    //check for Y
    if(strpos($set_expiration_date, "Y") !== false)
        $used_y = true;

    if(!empty($set_expiration_date))
    {
        //replace vars
        $Y = date("Y");
        $Y2 = intval($Y) + 1;
        $M = date("m");
        if($M == 12)
            $M2 = "01";
        else
            $M2 = str_pad(intval($M) + 1, 2, "0", STR_PAD_LEFT);

        $searches = array("Y-", "Y2-", "M-", "M2-");
        $replacements = array($Y . "-", $Y2 . "-", $M . "-", $M2 . "-");

        $set_expiration_date = str_replace($searches, $replacements, $set_expiration_date);

        //how many days until expiration
        $todays_date = time();
        $time_left = strtotime($set_expiration_date) - $todays_date;
        if($time_left > 0)
        {
            $days_left = ceil($time_left/(60*60*24));

            //update number and period
            $level->expiration_number = $days_left;
            $level->expiration_period = "Day";

            return $level;	//stop
        }
        elseif(!empty($used_y))
        {
            $timestamp = strtotime($set_expiration_date);

            //add one year to expiration date
            $set_expiration_date = date("Y-m-d", mktime(0, 0, 0, date('m', $timestamp), date('d', $timestamp), date('Y', $timestamp) + 1));

            //how many days until expiration
            $time_left = strtotime($set_expiration_date) - $todays_date;
            $days_left = ceil($time_left/(60*60*24));

            //update number and period
            $level->expiration_number = $days_left;
            $level->expiration_period = "Day";

            return $level; //stop
        }
        else
        {
            //expiration already here, don't let people signup
            $level = NULL;

            return $level; //stop
        }
    }

    return $level;	//no change
}
add_filter("pmpro_checkout_level", "pmprosed_pmpro_checkout_level");

/*	
	This function will save a the set expiration dates into wp_options.
*/
function pmpro_saveSetExpirationDate($level_id, $set_expiration_date, $code_id = NULL)
{
    if($code_id)
        $key = "pmprosed_" . $level_id . "_" . $code_id;
    else
        $key = "pmprosed_" . $level_id;

    update_option($key, $set_expiration_date);
}

/*
	This function will return the expiration date for a level or discount code/level combo
*/
function pmpro_getSetExpirationDate($level_id, $code_id = NULL)
{
    if($code_id)
        $key = "pmprosed_" . $level_id . "_" . $code_id;
    else
        $key = "pmprosed_" . $level_id;

    return get_option($key, "");
}


/*
	This next set of functions adds our field to the edit discount code page
*/
//add our field to level price settings
function pmprosed_pmpro_discount_code_after_level_settings($code_id, $level)
{
    $set_expiration_date = pmpro_getSetExpirationDate($level->id, $code_id);
    ?>
    <table>
        <tbody class="form-table">
        <tr>
            <td>
        <tr>
            <th scope="row" valign="top"><label for="set_expiration_date">Expiration Date:</label></th>
            <td>
                <input type="text" name="set_expiration_date[]" value="<?php echo esc_attr($set_expiration_date);?>" />
                <br /><small>YYYY-MM-DD format. Enter "Y" for current year, "Y2" for next year. M, M2 for current/next month. Be sure to set an expiration date above as well.</small>
            </td>
        </tr>
        </td>
        </tr>
        </tbody>
    </table>
<?php
}
add_action("pmpro_discount_code_after_level_settings", "pmprosed_pmpro_discount_code_after_level_settings", 10, 2);

//save level cost text for the code when the code is saved/added
function pmprosed_pmpro_save_discount_code_level($code_id, $level_id)
{
    $all_levels_a = $_REQUEST['all_levels'];							//array of level ids checked for this code
    $set_expiration_date_a = $_REQUEST['set_expiration_date'];			//expiration dates for levels checked

    if(!empty($all_levels_a))
    {
        $key = array_search($level_id, $all_levels_a);				//which level is it in the list?
        pmpro_saveSetExpirationDate($level_id, $set_expiration_date_a[$key], $code_id);
    }
}
add_action("pmpro_save_discount_code_level", "pmprosed_pmpro_save_discount_code_level", 10, 2);