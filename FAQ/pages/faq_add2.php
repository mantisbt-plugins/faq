<?php
require( "faq_api.php" );
require( "css_faq.php" );
html_page_top1();
  html_page_top2();
?>

<?php
	access_ensure_project_level( DEVELOPER );

	# Add faq
	$f_question	  = gpc_get_string( 'question' );
	$f_answere	  = gpc_get_string( 'answere' );
	$f_project_id = gpc_get_string( 'project_id' );
	$f_poster_id  = auth_get_current_user_id();

	if (ON == plugin_config_get('faq_view_check') ){
		$f__view_level = gpc_get_string( 'faq_view_threshold' );
	} else {
		$f_view_level =plugin_config_get('faq_view_threshold');
	}
    $result 	= faq_add_query( $f_project_id, $f_poster_id, $f_question, $f_answere ,$f_view_level);
    $f_question = string_display( $f_question );
    $f_answere 	= string_display( $f_answere );
?>

<p>
<div align="center">
<?php
	if ( $result ) {			# SUCCESS
		PRINT lang_get( 'operation_successful' ) . '<p>';
?>
<table class="width75" cellspacing="1">
<tr>
	<td class="faq-question">
		<span class="faq-question"><?php echo $f_question ?></span>
	</td>
</tr>
<tr>
	<td class="faq-body">
		<?php echo $f_body ?>
	</td>
</tr>
</table>
<p>
<?php
	} else {					# FAILURE
		print_sql_error( $query );
	}

		print_bracket_link( $g_faq_menu_page, lang_get( 'proceed' ) );
?>
</div>
<?php
html_page_bottom1();
