<?php
	$g_mantis_faq_table              = plugin_table('results');

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

	/**
	 * Query for add FAQ to database
	 * @param $p_project_id - project identificator
	 * @param $p_poster_id  - user identificator
	 * @param $p_question   - question text
	 * @param $p_answere    - answer text
	 * @param $p_view_level - level for view threshold
	 * @return query result
	 */
	function faq_add_query( $p_project_id, $p_poster_id, $p_question, $p_answere , $p_view_level= 10 ) {
		global $g_mantis_faq_table;

		# " character poses problem when editting so let's just convert them
		$p_question	= db_prepare_string( $p_question );
		$p_answere	= db_prepare_string( $p_answere );

		# Add item
		$query = "INSERT
				INTO $g_mantis_faq_table
	    		( id, project_id, poster_id, date_posted, last_modified, question, answere, view_access )
				VALUES
				( null, '$p_project_id', '$p_poster_id', NOW(), NOW(), '$p_question', '$p_answere', '$p_view_level' )";
		return db_query( $query );
	}
	# --------------------
	
	/**
	 * Delete the faq entry
	 * @param $p_id - FAQ id
	 * @return query result
	 */
	function faq_delete_query( $p_id ) {
		global $g_mantis_faq_table;

		$query = "DELETE
				FROM $g_mantis_faq_table
	    		WHERE id='$p_id'";
		return db_query( $query );
	}


	/**
	 * Update faq item
	 * @param $p_id FAQ id
	 * @param $p_question - new question text
	 * @param $p_answere - new answer text
	 * @param $p_project_id - project id
	 * @param $p_view_level - view level threshold
	 * @return query result
	 */
	function faq_update_query( $p_id, $p_question, $p_answere, $p_project_id ,$p_view_level) {
		global $g_mantis_faq_table;

		# " character poses problem when editting so let's just convert them to '
		$p_question	= db_prepare_string( $p_question );
		$p_answere	= db_prepare_string( $p_answere );

		# Update entry
		$query = "UPDATE $g_mantis_faq_table
				SET question='$p_question', answere='$p_answere',
					project_id='$p_project_id', view_access='$p_view_level', last_modified=NOW()
	    		WHERE id='$p_id'";
		return db_query( $query );
	}


	/**
	 * Selects the faq item associated with the specified id
	 * @param $p_id - FAQ id
	 * @return query result
	 */
	function faq_select_query( $p_id ) {
		global $g_mantis_faq_table;

		$query = "SELECT *
			FROM $g_mantis_faq_table
			WHERE id='$p_id'";
	    $result = db_query( $query );
		return db_fetch_array( $result );
	}


	/**
	 * get faq count (selected project plus sitewide posts)
	 * @param $p_project_id - Project id
	 * @return db result
	 */
	function faq_count_query( $p_project_id ) {
		global $g_mantis_faq_table;

		$query = "SELECT COUNT(*)
				FROM $g_mantis_faq_table
				WHERE project_id='$p_project_id' OR project_id='0000000'";
		$result = db_query( $query );
		return db_result( $result, 0, 0 );
	}

?>