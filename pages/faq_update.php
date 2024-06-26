<?php
require( "faq_api.php" );

layout_page_header( );
layout_page_begin();
?>
<p>
<div align="center">
<?php
	access_ensure_project_level( DEVELOPER );

	# Update faq
	$f_question	  = gpc_get_string( 'question' );
	$f_answere	  = gpc_get_string( 'answere' );
	$f_project_id = gpc_get_int( 'project_id' );
	$f_poster_id  = gpc_get_int( 'f_id' );
	$f_view_access = plugin_config_get( 'faq_view_threshold'  );

    $result = faq_update_query( $f_poster_id, $f_question, $f_answere, $f_project_id,$f_view_access );


    $f_question 	= string_display( $f_question );
    $f_answere 		= string_display( $f_answere );


	if ( $result ) {				# SUCCESS
		PRINT lang_get( 'operation_successful' ) . '<p>';
?>
<table class="width75" cellspacing="1">
<tr>
	<td class="faq-heading">
		<span class="faq-question"><?php echo $f_question ?></span>
	</td>
</tr>
<tr>
	<td class="faq-answere">
		<?php echo $f_answere ?>
	</td>
</tr>
</table>
<p>
<?php
	} else {						# FAILURE
		PRINT lang_get( 'operation_failed' ) . '<p>';

	}

print_bracket_link( $g_faq_menu_page, lang_get( 'proceed' ) );

?>
</div>

<?php
layout_page_end();