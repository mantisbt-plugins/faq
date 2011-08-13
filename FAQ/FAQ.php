<?php
class FAQPlugin extends MantisPlugin {

  function register() {
    $this->name        = 'FAQ';
    $this->description = 'Adds Frequently Asked Questions to your MantisBT installation.';
    $this->version     = '1.01';
    $this->requires    = array('MantisCore' => '1.2.0',);
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

  function init() {
    plugin_event_hook( 'EVENT_MENU_MAIN', 'mainmenu' );
    plugin_event_hook( 'EVENT_MENU_ISSUE', 'faqmenu' );
  }

  function mainmenu() {
    return array( '<a href="'. plugin_page( 'faq_menu_page.php' ) . '">' . lang_get( 'menu_faq_link' ) . '</a>' );
  }

  function faqmenu() {
    if (ON == plugin_config_get( 'promote_text' ) ){
      $bugid = gpc_get_int( 'id' );
      if ( access_has_bug_level( plugin_config_get( 'promote_threshold' ), $bugid ) ){
        $t_bug_p = bug_get( $bugid, true );
        if ( OFF == plugin_config_get( 'project_text' ) ) {
          $proj_id = 0;
        } else {
          $proj_id = $t_bug_p->project_id;
        }

        $answer = urlencode( $t_bug_p->description );
        $answer .= " ";
        $answer .= urlencode( $t_bug_p->additional_information );

        $question = category_full_name( $t_bug_p->category_id );
        $question .= " -> ";
        $question .= urlencode( $t_bug_p->summary );

        if ( ON == plugin_config_get( 'faq_view_check') ){
          $import_page = 'faq_add_page2.php';
        } else {
          $import_page = 'faq_add.php';
        }
        $import_page .= '&question=';
        $import_page .= $question;
        $import_page .= '&answere=';
        $import_page .= $answer;
        $import_page .= '&project_id=';
        $import_page .= $proj_id;

        if (ON == plugin_config_get('faq_view_check') ){
          return array( plugin_lang_get( 'import_faq' ) => plugin_page( $import_page ). '" target=_new>' );
        } else {
          return array( plugin_lang_get( 'import_faq' ) => plugin_page( $import_page ) );
        }
      }
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
        " )
      ),
    );
  }
}