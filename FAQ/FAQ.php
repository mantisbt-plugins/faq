<?php
require_once( config_get_global( 'class_path' ) . 'MantisPlugin.class.php' );

class FAQPlugin extends MantisPlugin {

	function register() {
		$this->name        = 'FAQ';
		$this->description = 'Adds Frequently Asked Questions to your Mantis installation.';
		$this->version     = '0.96.3';
		$this->requires    = array('MantisCore'       => '1.2.0rc1',);
		$this->author      = 'Cas Nuy / based upon scripts from pbia@engineer.com';
		$this->contact     = 'Cas-at-nuy.info';
		$this->url         = 'http://www.nuy.info';
		$this->page        = 'config';
	}


/**
 * Default plugin configuration.
 */ 
	function config() {
		return array(
			'promote_text'       => ON,
			'promote_threshold'  => 55,
			'project_text'       => ON,
			'faq_view_window'    => OFF,
			'faq_view_check'     => OFF,
			'faq_view_threshold' => 10,
			);
	}


/**
 * Default hooks for main menu and issue menu
 */
	function hooks() {
		return array(
			'EVENT_MENU_MAIN' => 'main_menu',
			'EVENT_MENU_ISSUE' => 'faq_menu',
		);
	}
	

 /**
  * Default function generate main menu links
  * @return array of links
  */
	function main_menu() {
		return array('<a href="'. plugin_page( 'faq_menu_page' ) . '">' . plugin_lang_get( 'menu_link' ) . '</a>' );
	}


 /**
  * Default function generate issue menu links
  * @return array of links
  */
	function faq_menu() {
		if (ON == plugin_config_get( 'promote_text' ) ){
			$bugid =  gpc_get_int( 'id' );
			if ( access_has_bug_level( plugin_config_get( 'promote_threshold' ), $bugid ) ){
				$t_bug_p = bug_get( $bugid, true );
				if ( OFF == plugin_config_get( 'project_text')) {
					$proj_id = 0 ;
				} else{
					$proj_id = $t_bug_p->project_id ;
				}
				if (ON == plugin_config_get('faq_view_check') ){
					$import_page ='faq_add_page2.php';
				} else {
					$import_page ='faq_add.php';
				}
				$import_page .='&bugid=';
				$import_page .= $bugid ;
				$import_page .='&project_id=';
				$import_page .= $proj_id;
		
				if (ON == plugin_config_get('faq_view_check') ){
					return array( plugin_lang_get( 'import_faq' )=>plugin_page( $import_page ). '" target="_new' );	
				} else {
					return array( plugin_lang_get( 'import_faq' )=>plugin_page( $import_page ) );	

				}
			}
			else
			{
				return array( );
			}
		}
		else
		{
			return array ();
		}
	}


	function schema() {
		return array(
			array( 'CreateTableSQL', array( plugin_table( 'results' ), "
				id				I		NOTNULL UNSIGNED ZEROFILL AUTOINCREMENT PRIMARY,
				project_id		I		NOTNULL UNSIGNED ZEROFILL ,
				poster_id		I		NOTNULL UNSIGNED ZEROFILL ,
				date_posted		T		NOTNULL,
				last_modified	T		NOTNULL,
				question		C(250)	DEFAULT \" '' \",
				answere			XL		NOTNULL DEFAULT \" '' \",
				view_access		I		NOTNULL UNSIGNED ZEROFILL DEFAULT \" '10' \"
				" ) ),
		);
	}

}