<?php
require( "faq_api.php" );
layout_page_header( );
layout_page_begin();
access_ensure_project_level( DEVELOPER );

$f_question	  = gpc_get_string( 'question' );
$f_answere	  = gpc_get_string( 'answere' );
$f_project_id = gpc_get_string( 'project_id' );

?>

<?php # Add faq Form BEGIN ?>
<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 
<br/>
<form method="post" action="<?php echo $g_faq_add2 ?>">
<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
		<i class="ace-icon fa fa-text-width"></i>
		<?php echo  plugin_lang_get( 'plugin_format_title' ) . ': ' . plugin_lang_get( 'plugin_format_config' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive"> 
<table class="table table-bordered table-condensed table-striped">
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
</td>
</tr>
</div>
</div>
</div>
</div>

<?php 
layout_page_end();
