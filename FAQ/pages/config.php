<?php
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
html_page_top1( plugin_lang_get( 'title' ) );
html_page_top2();
print_manage_menu();
?>

<br/>
<form action="<?php echo plugin_page( 'config_edit' ) ?>" method="post">
<table align="center" class="width50" cellspacing="1">

<tr>
	<td class="form-title" colspan="3">
		<?php echo plugin_lang_get( 'title' ) . ': ' . plugin_lang_get( 'config' ) ?>
	</td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td class="category">
		<?php echo plugin_lang_get( 'project_text' ) ?>
	</td>
	<td class="center">
		<label><input type="radio" name="project_text" value="1" <?php echo ( ON == plugin_config_get( 'project_text' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo lang_get( 'on' ) ?></label>
	</td>
	<td class="center">
		<label><input type="radio" name="project_text" value="0" <?php echo ( OFF == plugin_config_get( 'project_text' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo lang_get( 'off' ) ?></label>
	</td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'promote_text' ) ?>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="promote_text" value="1" <?php echo ( ON == plugin_config_get( 'promote_text' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo lang_get( 'on' ) ?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="promote_text" value="0" <?php echo ( OFF == plugin_config_get( 'promote_text' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo lang_get( 'off' ) ?></label>
	</td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'view_window' ) ?>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="faq_view_window" value="1" <?php echo ( ON == plugin_config_get( 'faq_view_window' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo lang_get( 'on' ) ?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="faq_view_window" value="0" <?php echo ( OFF == plugin_config_get( 'faq_view_window' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo lang_get( 'off' ) ?></label>
	</td>
</tr>


<tr <?php echo helper_alternate_class() ?>>
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'view_check' ) ?>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="faq_view_check" value="1" <?php echo ( ON == plugin_config_get( 'faq_view_check' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo lang_get( 'on' ) ?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="faq_view_check" value="0" <?php echo ( OFF == plugin_config_get( 'faq_view_check' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo lang_get( 'off' ) ?></label>
	</td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td class="category">
		<?php echo plugin_lang_get( 'view_threshold' ) ?>
	</td>
	<td class="center" colspan = 2>
			<select name="faq_view_threshold">
				<?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'faq_view_threshold' ) ) ?>;
			</select> 
	</td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
	<td class="category">
		<?php echo plugin_lang_get( 'threshold_text' ) ?>
	</td>
	<td class="center" colspan = 2>
			<select name="promote_threshold">
				<?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'promote_threshold' ) ) ?>;
			</select> 
	</td>
</tr>

<tr>
	<td class="center" colspan="3">
		<input type="submit" class="button" value="<?php echo lang_get( 'change_configuration' ) ?>" />
	</td>
</tr>

</table>
</form>

<?php
html_page_bottom1( __FILE__ );
