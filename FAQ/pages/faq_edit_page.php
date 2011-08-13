<?php
require( "faq_api.php" );
require( "css_faq.php" );
html_page_top1();
if (OFF == plugin_config_get('faq_view_window') ){
	html_page_top2();
}

?>

<?php
	access_ensure_project_level( DEVELOPER );

$f_id = gpc_get_int( 'f_id' );
	# Retrieve faq item data and prefix with v_
	$row = faq_select_query( $f_id );
	if ( $row ) {
    	extract( $row, EXTR_PREFIX_ALL, "v" );
    }

   	$v_question = string_attribute( $v_question );
   	$v_answere 	= string_textarea( $v_answere );
?>

<?php # Edit faq Form BEGIN ?>
<p>
<div align="center">
<form method="post" action="<?php global $g_faq_update; echo $g_faq_update; ?>">
<input type="hidden" name="f_id" value="<?php echo $v_id ?>">
<table class="width75" cellspacing="1">
<tr>
	<td class="form-title">
		<?php echo plugin_lang_get( 'edit_faq_title' ) ?>
	</td>
	<td class="right">
		<?php
		if (OFF == plugin_config_get('faq_view_window') ){
			print_bracket_link( $g_faq_menu_page, lang_get( 'go_back' ) );
		}
		?>
	</td>
</tr>
<tr class="row-1">
	<td class="category" width="25%">
		<?php echo plugin_lang_get( 'question' ) ?>
	</td>
	<td width="75%">
		<input type="text" name="question" size="80" maxlength="255" value="<?php echo $v_question ?>">
	</td>
</tr>
<tr class="row-2">
	<td class="category">
		<?php echo plugin_lang_get( 'answere' ) ?>
	</td>
	<td>
		<textarea name="answere" cols="80" rows="10" wrap="virtual"> <?php echo $v_answere ?></textarea>
	</td>
</tr>

<?php if (ON == plugin_config_get('faq_view_check') ){ ?>

<tr <?php echo helper_alternate_class() ?>>
	<td class="category">
		<?php echo plugin_lang_get( 'faq_view_threshold' ) ?>
	</td>
	<td >

			<select name="faq_view_threshold">
			<?php print_enum_string_option_list( 'access_levels', $v_view_access ) ?>;
			</select>

	</td>
</tr>
<?php } ?>





<tr class="row-1">
	<td class="category">
		<?php echo lang_get( 'post_to' ) ?>
	</td>
	<td>
		<select name="project_id">
		<?php
			$t_sitewide = false;
			if ( access_has_project_level( MANAGER ) ) {
				$t_sitewide = true;
			}
			print_project_option_list( $v_project_id, $t_sitewide );
		?>
		</select>
	</td>
</tr>
<tr>
	<td class="center" colspan="2">
		<input type="submit" value="<?php echo plugin_lang_get( 'update_faq_button' ) ?>">
	</td>
</tr>
</table>
</form>
</div>
<?php # Edit faq Form END ?>

<?php
html_page_bottom1();