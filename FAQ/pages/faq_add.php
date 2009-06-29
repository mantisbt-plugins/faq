<?php
require( 'faq_api.php' );
require( 'css_faq.php' );
html_page_top1();
if (OFF == plugin_config_get( 'faq_view_window' ) ){
	html_page_top2( );
}

access_ensure_project_level( DEVELOPER );

# Add faq
$f_project_id = gpc_get_string( 'project_id' );
$f_poster_id = auth_get_current_user_id( );

$f_bug_id = gpc_get_string( 'bugid' );
$t_bug_p = bug_get( $f_bug_id, true );
$f_answere  = urlencode( $t_bug_p->description );
$f_answere .= " ";
$f_answere .= urlencode( $t_bug_p->additional_information );
$f_question  = category_full_name( $t_bug_p->category_id );
$f_question .= " -> ";
$f_question .= urlencode( $t_bug_p->summary );

if (ON == plugin_config_get( 'faq_view_check' ) ){
	$f__view_level = gpc_get_string( 'faq_view_threshold' );
} else {
	$f_view_level =plugin_config_get( 'faq_view_threshold' );
}

$result = faq_add_query( $f_project_id, $f_poster_id, $f_question, $f_answere , $f_view_level );
$f_question = string_display( $f_question );
$f_answere = string_display( $f_answere );
?>

<p>
<div align="center">
<?php
	if ( $result ) {			# SUCCESS
		echo lang_get( 'operation_successful' ) . '<p>';
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

	if (ON == plugin_config_get( 'faq_view_window' ) ){
	?>
	<a href="javascript:window.opener='x';window.close();"><?php echo plugin_lang_get( 'close_window' ) ?></a>
<?PHP
	
	} else {
		print_bracket_link( $g_faq_menu_page, lang_get( 'proceed' ) );
	}
?>
</div>
<?php html_page_bottom1( __FILE__ ) ?>
