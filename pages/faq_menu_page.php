<?php
require( "faq_api.php" );
access_ensure_global_level( plugin_config_get( 'faq_view_threshold' ) );
layout_page_header( );
layout_page_begin();

# Select the faq posts
$minimum_level = access_get_global_level();
$t_where_clause = "view_access <= $minimum_level";
$p_project_id = helper_get_current_project();

if( $p_project_id != 0 ) {
    $t_where_clause .= " and ((project_id='".$p_project_id."' OR project_id=0)";
	$t_project_ids = project_hierarchy_get_subprojects( $p_project_id );
	foreach ($t_project_ids as $value) {
		$t_where_clause .= " or project_id='".$value."'";
	}
	$t_where_clause .= ")";
}	
	$f_search= "";
	if ( isset($_POST['f_search']) ) {
		$f_search = trim( $_POST['f_search'] );
	}
if( $f_search == "") {
	$f_search = "";
	$f_search3 = "";
	$f_search2 = "";
} else {
	$f_search3 = "";
	$f_search2 = "";
    if( $t_where_clause != "" ){ 
        $t_where_clause .=  " AND ";
	}

	$what = " ";
	$pos = strpos($f_search, $what);
			
	if (($pos === false) or (isset( $search_string ))){
		$t_where_clause .=  " ( (question LIKE '%".addslashes($f_search)."%')
				OR (answere LIKE '%".addslashes($f_search)."%') ) ";
	} else {
		$pos1 = strpos($f_search, $what, $pos+1);
		if ($pos1 === false) {
			$f_search2 = substr($f_search, $pos); 
		} else {
			$len1=$pos1-$pos;
			$f_search2 = substr($f_search, $pos1,$len1);    
		}
		$f_search3 = substr($f_search,0, $pos); 
		$f_search3=trim($f_search3); 
		$f_search2=trim($f_search2); 
		$t_where_clause .=  " ((question LIKE '%".addslashes($f_search3)."%') and (question LIKE '%".addslashes($f_search2)."%'))
					OR ((answere LIKE '%".addslashes($f_search3)."%') and (answere LIKE '%".addslashes($f_search2)."%')) ";
	}
}
	
$query = "SELECT id, poster_id, project_id, UNIX_TIMESTAMP(date_posted) as date_posted, question, answere FROM $g_mantis_faq_table";
if( $t_where_clause != "" ){
    $query = $query . " WHERE $t_where_clause";
}
	
$query = $query . " ORDER BY UPPER(question) ASC";

$result = db_query( $query );
$faq_count = db_num_rows( $result );
?>
<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 
<br/>
<form action="<?php echo plugin_page( 'faq_menu_page.php' ) ?>" method="post">
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
<tr class="row-category4">
<td class="small-caption">
<?php PRINT lang_get( 'search'); ?>
</td><td></td><td></td><td></td>
</tr>
<tr>
<td class="small-caption">
<input type="text" size="25" name="f_search" value="<?php echo $f_search; ?>">
<input  type="checkbox" name="search_string" > <?php echo plugin_lang_get( 'search_string' ) ?>
</td>
<td class="right">
   <input type="submit" name="f_filter" value="<?php echo lang_get( 'filter_button') ?>">
</td>
<td class="small-caption">
<?php
echo $faq_count . " FAQ";
?>
</td>
<td class="right">
<?php
if ( access_has_project_level( plugin_config_get('faq_view_threshold') ) ) {
    global $g_faq_add_page;
    print_bracket_link( $g_faq_add_page, plugin_lang_get( 'add_faq') );
}
?>
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

# Loop through results
if( $f_search == "" ){
    $faq_count1=15;
	if ($faq_count==0){
		$faq_count1=0;
	}
	if ($faq_count1 > $faq_count){
		$faq_count1=$faq_count;
	}
} else {
    $faq_count1=$faq_count;
}
		
for ($i=0;$i<$faq_count1;$i++) {
	$row = db_fetch_array($result);
	extract( $row, EXTR_PREFIX_ALL, "v" );

	$pos = true;
    if(( isset( $search_string )) or ($pos === false)) {
   		$v_question = preg_replace ( $f_search, "<b>".$f_search."</b>", $v_question );
    	$v_answere 	= preg_replace ( $f_search, "<b>".$f_search."</b>", $v_answere );
    }
    if( $f_search2 != "" )  {
   		$v_question = preg_replace ( $f_search2, "<b>".$f_search2."</b>", $v_question );
    	$v_answere 	= preg_replace ( $f_search2, "<b>".$f_search2."</b>", $v_answere );
    }
    if( $f_search3 != "" )  {
   		$v_question = preg_replace ( $f_search3, "<b>".$f_search3."</b>", $v_question );
    	$v_answere 	= preg_replace ( $f_search3, "<b>".$f_search3."</b>", $v_answere );
    }
	$v_question = string_display( $v_question );
	$v_answere 	= string_display_links( $v_answere );
	$v_date_posted = date( $g_complete_date_format, $v_date_posted );

	# grab the username and email of the poster
   	$t_poster_name	= user_get_name($v_poster_id );
	$t_poster_email	= user_get_email($v_poster_id );

    $t_project_name = "Sitewide";
	if( $v_project_id != 0 ) {
   		$t_project_name = project_get_field( $v_project_id, "name" );
	}
	$v_answere = trim(substr($v_answere, 0, 25)) ;
	$v_answere .=".............";

	PRINT "<br><center>";
	if (ON == plugin_config_get('faq_view_window') ){	
		if( helper_get_current_project() == '0000000' ){
			PRINT "<li><span class=\"faq-question\"><a href=\"$g_faq_view_page&f_id=$v_id\" target=_new>$v_question</a> [$t_project_name] </span><br><span>$v_answere</span><br>";
		}else{
			PRINT "<li><span class=\"faq-question\"><a href=\"$g_faq_view_page&f_id=$v_id\" target=_new>$v_question</a></span><br><span>$v_answere</span><br>";
		}	
	} else{
		if( helper_get_current_project() == '0000000' ){
			PRINT "<li><span class=\"faq-question\"><a href=\"$g_faq_view_page&f_id=$v_id\" >$v_question</a> [$t_project_name] </span><br><span>$v_answere</span><br>";
		}else{
			PRINT "<li><span class=\"faq-question\"><a href=\"$g_faq_view_page&f_id=$v_id\" >$v_question</a></span><br><span>$v_answere</span><br>";
		}	
	}

    PRINT "<span  class=\"small\">$v_date_posted - <a class=\"faq-email\" href=\"mailto:$t_poster_email\">$t_poster_name</a></span><br><br>";
}  # end for loop
?>
</ul></center>
<?php 
layout_page_end();