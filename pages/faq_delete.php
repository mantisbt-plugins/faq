<?php
require( "faq_api.php" );
layout_page_header( );
layout_page_begin();
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
print_bracket_link( $g_faq_menu_page, lang_get( 'proceed' ) );
?>
</div>
<?php 
layout_page_end();