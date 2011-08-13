<?php
require( "faq_api.php" );
require( "css_faq.php" );
html_page_top1();
html_page_top2();
access_ensure_project_level( DEVELOPER );
$f_id = gpc_get_int( 'f_id' );
# Delete the faq entry
$result = faq_delete_query( $f_id );
$t_redirect_url = $g_faq_menu_page;
if ( $result ) {
?>
	<div align="center">
<?php
	PRINT lang_get( 'operation_successful' ) . '<p>';
} else {
	print_mantis_error( ERROR_GENERIC );
}
	  if (ON == plugin_config_get('faq_view_window') ){
	?>
	<a href="javascript:window.opener='x';window.close();">Close Window</a>
<?PHP

	  } else {
		print_bracket_link( $g_faq_menu_page, lang_get( 'proceed' ) );
	}
?>
</div>
<?php
html_page_bottom1();