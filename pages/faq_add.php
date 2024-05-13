<?php
require( "faq_api.php" );
layout_page_header( );
layout_page_begin();
access_ensure_project_level( DEVELOPER );

# Add faq
$f_question	  = gpc_get_string( 'question' );
$f_answere	  = gpc_get_string( 'answere' );
$f_project_id = gpc_get_string( 'project_id' );
$f_poster_id  = auth_get_current_user_id();
$f_view_level =plugin_config_get('faq_view_threshold');

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

</table>
<p>
<?php
	} else {					# FAILURE
		PRINT lang_get( 'operation_failed' ) . '<p>';
	}

		print_bracket_link( $g_faq_menu_page, lang_get( 'proceed' ) );

?>
</div>
<?php layout_page_end();
