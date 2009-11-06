<?php
require( 'faq_api.php' );
require( 'css_faq.php' );
html_page_top1( );
html_page_top2( );
?>
<p>
<?php
	# Select the faq posts

	$minimum_level = access_get_global_level( );
	$t_where_clausole = "view_access <= $minimum_level";
	$p_project_id = helper_get_current_project( );
	if( $p_project_id != '0000000' ) {
		$t_where_clausole .= " and ((project_id='".$p_project_id."' OR project_id='0000000')";
		$t_project_ids = project_hierarchy_get_subprojects( $p_project_id );
		foreach ( $t_project_ids as $value ) {
			$t_where_clausole .= " or project_id='".$value."'";
		}
		$t_where_clausole .= ")";
	}	
	if( !isset( $f_search ) ) {
		$f_search = "";
		$f_search3 = "";
		$f_search2 = "";
		$pos = false;
	}
	else {
		$f_search3 = "";
		$f_search2 = "";
		if( $t_where_clausole != "" ) 
			$t_where_clausole = $t_where_clausole . " AND ";

		$f_search=trim( $f_search ); 
		$what = " ";
		$pos = utf8_strpos( $f_search, $what );

		if (( $pos === false ) or ( isset( $search_string )) ){
			$t_where_clausole = $t_where_clausole . " ( (question LIKE '%".addslashes($f_search)."%')
					OR (answere LIKE '%" . addslashes( $f_search ) . "%') ) ";
		} else {
			$pos1 = utf8_strpos( $f_search, $what, $pos + 1 );
			if ( $pos1 === false ) {
				$f_search2 = utf8_substr( $f_search, $pos );

			} else {
				$len1 = $pos1 - $pos;
				$f_search2 = utf8_substr( $f_search, $pos1, $len1);
			}
			$f_search3 = utf8_substr( $f_search, 0, $pos );
			$f_search3 = trim( $f_search3 );
			$f_search2 = trim( $f_search2 );
			$t_where_clausole = $t_where_clausole . " ((question LIKE '%" . addslashes( $f_search3 ) . "%') and (question LIKE '%" . addslashes( $f_search2 ) . "%'))
				OR ((answere LIKE '%" . addslashes( $f_search3 ) . "%') and (answere LIKE '%" . addslashes( $f_search2 ) . "%')) ";
		}
	}

	$query = "SELECT id, poster_id, project_id, UNIX_TIMESTAMP(date_posted) as date_posted, question, answere
		    	FROM $g_mantis_faq_table";

	if( $t_where_clausole != "" )
		$query = $query . " WHERE $t_where_clausole";

	$query = $query . " ORDER BY UPPER(question) ASC";

	$result = db_query( $query );
	$faq_count = db_num_rows( $result );
?>
<table class="width100" cellspacing="0">
	<form method="post" action="<?php echo $g_faq_menu_page ?>">
		<tr class="row-category2">
			<td class="small-caption">
				<?php echo lang_get( 'search'); ?>
			</td>
			<td class="small-caption">
				<?php echo ""; ?>
			</td>
		</tr>
		<tr>
			<td class="small-caption">
				<input type="text" size="25" name="f_search" value="<?php echo $f_search; ?>">
				<input  type="checkbox" name="search_string" > <?php echo plugin_lang_get( 'search_string' ) ?>
			</td>
			<td class="right">
				<input type="submit" name="f_filter" value="<?php echo lang_get( 'filter_button') ?>">
			</td>
		</tr>
	</form>
</table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="small-caption">
			<?php
				echo $faq_count . " FAQ";
			?>
		</td>
		<td class="right">
			<?php
				$t_update_access = plugin_config_get( 'faq_update_threshold' );

				if ( access_has_project_level( $t_update_access ) ) {
					global $g_faq_add_page;
					print_bracket_link( $g_faq_add_page, plugin_lang_get( 'add_faq' ) );
				}
			?>
		</td>
	</tr>
</table>
<ul>
<?php
	# Loop through results
	if ( is_blank( $f_search ) ) {
			$faq_count1=15;
			if ($faq_count==0){
				$faq_count1=0;
			}
			if ( $faq_count1 > $faq_count ){
				$faq_count1 = $faq_count;
			}
			} else {
				$faq_count1 = $faq_count;
			}

			for ( $i = 0; $i < $faq_count1; $i++ ) {
				$row = db_fetch_array( $result );
				extract( $row, EXTR_PREFIX_ALL, "v" );
				if ( !is_blank( $f_search ) && $pos === false ) {
					$v_question = eregi_replace ( $f_search, "<b>".$f_search."</b>", $v_question );
					$v_answere 	= eregi_replace ( $f_search, "<b>".$f_search."</b>", $v_answere );
				}
				if ( !is_blank( $f_search2 ) ) {
					$v_question = eregi_replace ( $f_search2, "<b>".$f_search2."</b>", $v_question );
					$v_answere  = eregi_replace ( $f_search2, "<b>".$f_search2."</b>", $v_answere );
				}
				if ( !is_blank( $f_search3 ) ) {
					$v_question = eregi_replace ( $f_search3, "<b>".$f_search3."</b>", $v_question );
					$v_answere  = eregi_replace ( $f_search3, "<b>".$f_search3."</b>", $v_answere );
				}

				if ( strlen( $v_answere ) > 25 ) {
					$v_answere = trim( utf8_substr( $v_answere, 0, 25 ) );
					$v_answere .=".............";
				}

				$v_question = string_display( $v_question );
				$v_answere  = string_display_links( $v_answere );
				$v_date_posted = date( $g_complete_date_format, $v_date_posted );

				# grab the username and email of the poster
				$t_poster_name  = user_get_name($v_poster_id );
				$t_poster_email = user_get_email($v_poster_id );

				$t_project_name = "Sitewide";
				if( $v_project_id != 0 )
					$t_project_name = project_get_field( $v_project_id, "name" );

				if (ON == plugin_config_get( 'faq_view_window' ) ){
					if( helper_get_current_project() == '0000000' ){
						echo "<li><span class=\"faq-question\"><a href=\"$g_faq_view_page&f_id=$v_id\" target=_new>$v_question</a> [$t_project_name] </span><br><span>$v_answere</span><br>";
					}else{
						echo "<li><span class=\"faq-question\"><a href=\"$g_faq_view_page&f_id=$v_id\" target=_new>$v_question</a></span><br><span>$v_answere</span><br>";
					}
				} else {
					if( helper_get_current_project() == '0000000' ){
						echo "<li><span class=\"faq-question\"><a href=\"$g_faq_view_page&f_id=$v_id\" >$v_question</a> [$t_project_name] </span><br><span>$v_answere</span><br>";
					} else {
						echo "<li><span class=\"faq-question\"><a href=\"$g_faq_view_page&f_id=$v_id\" >$v_question</a></span><br><span>$v_answere</span><br>";
					}	
				}

				echo "<span  class=\"small\">$v_date_posted - <a class=\"faq-email\" href=\"mailto:$t_poster_email\">$t_poster_name</a></span><br><br>";
			}# end for loop

?>
</ul>
<?php html_page_bottom1( __FILE__ ) ?>
