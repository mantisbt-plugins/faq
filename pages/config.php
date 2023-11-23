<?php
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
layout_page_header(  plugin_lang_get( 'plugin_format_title' ) );
layout_page_begin( 'config.php' );

print_manage_menu();
?>
<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 
<br/>
<form action="<?php echo plugin_page( 'config_edit' ) ?>" method="post">
<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
		<i class="ace-icon fa fa-text-width"></i>
		<?php echo  plugin_lang_get( 'plugin_format_title' ) . ': ' . lang_get( 'plugin_format_config' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive"> 
<table class="table table-bordered table-condensed table-striped">
<tr>
	<td class="form-title" colspan="3">
		<?php echo plugin_lang_get( 'plugin_format_title' ) . ': ' . plugin_lang_get( 'plugin_format_config' ) ?>
	</td>
</tr>
<tr>
	<td class="category">
		<?php echo plugin_lang_get( 'plugin_format_project_text' ) ?>
	</td>
	<td class="center">
		<label><input type="radio" name="project_text" value="1" <?php echo ( ON == plugin_config_get( 'project_text' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'plugin_format_enabled' ) ?></label>
	</td>
	<td class="center">
		<label><input type="radio" name="project_text" value="0" <?php echo ( OFF == plugin_config_get( 'project_text' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'plugin_format_disabled' ) ?></label>
	</td>
</tr>
<tr >
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'plugin_format_promote_text' ) ?>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="promote_text" value="1" <?php echo ( ON == plugin_config_get( 'promote_text' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'plugin_format_enabled' ) ?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="promote_text" value="0" <?php echo ( OFF == plugin_config_get( 'promote_text' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'plugin_format_disabled' ) ?></label>
	</td>
</tr>


<tr >
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'faq_view_check' ) ?>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="faq_view_check" value="1" <?php echo ( ON == plugin_config_get( 'faq_view_check' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'plugin_format_enabled' ) ?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="faq_view_check" value="0" <?php echo ( OFF == plugin_config_get( 'faq_view_check' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'plugin_format_disabled' ) ?></label>
	</td>
</tr>
<tr>
	<td class="category">
		<?php echo plugin_lang_get( 'faq_view_threshold' ) ?>
	</td>
	<td class="center">
			<select name="faq_view_threshold">
			<?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'faq_view_threshold'  ) ) ?>;
			</select> 
	</td>
	<td>
	</td>

</tr>


<tr>
	<td class="category">
		<?php echo plugin_lang_get( 'plugin_format_threshold_text' ) ?>
	</td>
	<td class="center">
			<select name="promote_threshold">
			<?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'promote_threshold'  ) ) ?>;
			</select> 
	</td>
	<td>
	</td>

</tr>


</div>
</div>
<div class="widget-toolbox padding-8 clearfix">
	<input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo lang_get( 'change_configuration' )?>" />
</div>
</div>
</div>
</table>
</form>
</div>
</div>
<?php
layout_page_end();