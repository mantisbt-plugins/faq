<?php
require( "faq_api.php" );

layout_page_header( );
layout_page_begin();
$f_id = gpc_get_int( 'f_id' );
?>
<p>
<div align="center">
	<?php echo plugin_lang_get( 'delete_faq_sure_msg' ) . "<br>" ?>
<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 
<form method="post" action="<?php echo $g_faq_delete ?>">
<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
		<i class="ace-icon fa fa-text-width"></i>
		<?php echo lang_get( 'tasks' ) . ': ' . lang_get( 'plugin_format_config' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive"> 
<table class="table table-bordered table-condensed table-striped"> 
<input type="hidden" name="f_id" value="<?php echo $f_id ?>">
<input type="submit" value="<?php echo plugin_lang_get( 'delete_faq_sure_msg' ) ?>">
</div>
</td>
<td>
<center>
<?php
global $g_faq_view_page   ;
$g_faq_view_page   .= "&f_id=";
$g_faq_view_page   .= $f_id;
print_bracket_link( $g_faq_view_page, lang_get( 'back_link' ) );
?>
</center>
</td>
</tr>
</div>
</form>
</div>
</div>
</div>
</div>
</table>
</div>
</div>
<?php 
layout_page_end();
