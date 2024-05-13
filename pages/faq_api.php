<?php
	#----------------------------------
	# faq page definitions

	$g_faq_menu_page                 = plugin_page( 'faq_menu_page.php' );
	$g_faq_view_page                 = plugin_page( 'faq_view_page.php' );

	$g_faq_edit_page                 = plugin_page( 'faq_edit_page.php' );
	$g_faq_add_page                  = plugin_page( 'faq_add_page.php' );
	$g_faq_add                       = plugin_page( 'faq_add.php' );
	$g_faq_add2                      = plugin_page( 'faq_add2.php' );
	$g_faq_delete_page               = plugin_page( 'faq_delete_page.php' );
	$g_faq_delete                    = plugin_page( 'faq_delete.php' );
	$g_faq_update                    = plugin_page( 'faq_update.php' );

	#----------------------------------

	###########################################################################
	# faq API
	###########################################################################

	# function faq_add   ( $p_project_id, $p_poster_id, $p_question, $p_answere );
	# function faq_delete( $p_id );
	# function faq_update( $p_id, $p_question, $p_answere );
	# function faq_select( $p_id );

	# --------------------
	function faq_add_query( $p_project_id, $p_poster_id, $p_question, $p_answere ,$p_view_level= 10) {
		$t_query = 'insert into {plugin_FAQ_results} ( project_id, poster_id, date_posted, last_modified, question, answere, view_access ) values (' 
				. db_param() . ', ' . db_param() . ', ' . db_param() . ', ' . db_param() . ', ' . db_param() . ', ' . db_param() . ', ' . db_param() . ' )';
		$now =  date("Y/m/d") ;
		return db_query( $t_query, array($p_project_id, $p_poster_id , $now , $now,$p_question,$p_answere,$p_view_level) );
		
	}
	# --------------------
	# Delete the faq entry
	function faq_delete_query( $p_id ) {
		$query = "DELETE
				FROM {plugin_FAQ_results}
	    		WHERE id='$p_id'";
	    return db_query( $query );
	}
	# --------------------
	# Update faq item
	function faq_update_query( $p_id, $p_question, $p_answere, $p_project_id ,$p_view_level) {
		$t_query = 'update {plugin_FAQ_results} set question =  ' . db_param() . ', answere = '  . db_param() . ' , project_id = '   . db_param() . ' , view_access = '  . db_param() . ' , last_modified = '  . db_param() . ' where id =  ' . db_param() . '';
		$now =  date("Y/m/d") ;
				return db_query( $t_query, array($p_question,$p_answere,$p_project_id,$p_view_level,$now ,$p_id) );
	}
	# --------------------
	# Selects the faq item associated with the specified id
	function faq_select_query( $p_id ) {
		$query = "SELECT *
			FROM {plugin_FAQ_results}
			WHERE id='$p_id'";
	    $result = db_query( $query );
		return db_fetch_array( $result );
	}
	# --------------------
	# get faq count (selected project plus sitewide posts)
	function faq_count_query( $p_project_id ) {
		$query = "SELECT COUNT(*)
				FROM {plugin_FAQ_results}
				WHERE project_id='$p_project_id' OR project_id='0000000'";
		$result = db_query( $query );
	    return db_result( $result, 0, 0 );
	}
	
	# print the bracketed links used near the top
# if the $p_link is blank then the text is printed but no link is created
# if $p_new_window is true, link will open in a new window, default false.
function print_bracket_link( $p_link, $p_url_text, $p_new_window = false, $p_class = '' ) {
	echo '<span class="bracket-link">[&#160;';
	print_link( $p_link, $p_url_text, $p_new_window, $p_class );
	echo '&#160;]</span> ';
}

