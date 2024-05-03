<?php
require( "faq_api.php" );

layout_page_header( );
layout_page_begin();
?>
<?php
$f_id = gpc_get_int( 'f_id' );

	# Select the faq posts
	$query = "SELECT *, UNIX_TIMESTAMP(date_posted) as date_posted
			FROM $g_mantis_faq_table
			WHERE  id='$f_id'";
	$result = db_query( $query );
    $faq_count = db_num_rows( $result );

    # Loop through results
	for ($i=0;$i<$faq_count;$i++) {
		$row = db_fetch_array($result);
		extract( $row, EXTR_PREFIX_ALL, "v" );

		$v_question 	= string_display( $v_question );
		$v_answere 		= string_display_links( $v_answere );
		$v_date_posted 	= date( $g_normal_date_format, $v_date_posted );

    	$t_poster_name	= user_get_name($v_poster_id );
		$t_poster_email	= user_get_email($v_poster_id );
        $t_project_name = "Sitewide";
		if( $v_project_id != 0 )
    		$t_project_name = project_get_field( $v_project_id, "name" );
?>
<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 
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
<tr>
	<td class="faq-heading">
		<span class="faq-question"><?php echo $v_question ?></span> -
		<span class="faq-date"><?php echo $v_date_posted ?></span> -
		<a class="faq-email" href="mailto:<?php echo $t_poster_email ?>"><?php echo $t_poster_name ?></a> -
		<?php echo $t_project_name ?>
	</td>
</tr>
<tr>
	<td class="faq-answere">
<?php
        echo $v_answere;
       	if ( access_has_project_level( DEVELOPER ) ) {
           global $g_faq_edit_page, $g_faq_delete_page;
           PRINT "<p align=\"right\"><span  class=\"small\">";
           print_bracket_link( $g_faq_edit_page . "&f_id=$v_id", plugin_lang_get( 'edit_faq_title',"FAQ" ) );
           print_bracket_link( $g_faq_delete_page . "&f_id=$v_id", plugin_lang_get( 'delete_faq_item_button',"FAQ" ) );
           PRINT "</span></p>";
        }
?>
	</td>
</tr>
</table>
</div>
<?php
	}  # end for loop
?>

<p>
<div align="center">
	<?php
	      global $g_faq_menu_page;
			print_bracket_link( $g_faq_menu_page, lang_get( 'back_link' ) );
    ?>
</div>
</td>
</tr>
</div>
</div>
</div>
</div>
</div>
</table>
</div>
</div>
<?php 
layout_page_end();
