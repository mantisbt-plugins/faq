<?php
require( "faq_api.php" );
require( "css_faq.php" );
html_page_top1();
// html_page_top2();

$f_question	  = gpc_get_string( 'question' );
$f_answere	  = gpc_get_string( 'answere' );
$f_project_id = gpc_get_string( 'project_id' );

?>

<?php # Add faq Form BEGIN ?>
<p>
<div align="center">
<form method="post" action="<?php echo $g_faq_add ?>">
<input type="hidden" name="f_poster_id" value="<?php echo current_user_get_field( "id" ) ?>">
<table class="width75" cellspacing="1">
<tr>
	<td class="form-title" colspan="2">
		<?php echo plugin_lang_get( 'add_faq_title' ) ?>
	</td>
</tr>
<tr class="row-1">
	<td class="category" width="25%">
		<?php echo plugin_lang_get( 'question' ) ?>
	</td>
	<td width="75%">
		<input type="text" name="question" size="80" maxlength="255" value="<?php echo $f_question ?>">
	</td>
</tr>
<tr class="row-2">
	<td class="category">
		<?php echo plugin_lang_get( 'answere' ) ?>
	</td>
	<td>
		<textarea name="answere" cols="80" rows="10" wrap="virtual" value="<?php echo $f_answere ?>"></textarea>
	</td>
</tr>
<tr class="row-1">
	<td class="category">
		<?php echo plugin_lang_get( 'faq_view_threshold' ) ?>
	</td>
	<td>
		<select name="faq_view_level">
		<?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'faq_view_threshold' )) ?>
		</select>
	</td>
</tr>
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
			print_project_option_list( helper_get_current_project(), $t_sitewide );
		?>
		</select>
	</td>
</tr>
<tr>
	<td class="center" colspan="2">
		<input type="submit" value="<?php echo plugin_lang_get( 'post_faq_button' ) ?>">
	</td>
</tr>
</table>
</form>
</div>
<?php # Add faq Form END ?>

<?php
html_page_bottom1();
