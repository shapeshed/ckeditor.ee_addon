<?php
/** 
 * ExpressionEngine
 *
 * LICENSE
 *
 * ExpressionEngine by EllisLab is copyrighted software
 * The licence agreement is available here http://expressionengine.com/docs/license.html
 * 
 * CKeditor Extension for EE
 * This extension converts ExpressionEngine Textareas to CKeditor rich text boxes.
 * 
 * @category   Extensions
 * @package    ckeditor
 * @version    1.0.0
 * @since      1.0.0
 * @author     George Ornbo <george@shapeshed.com>
 * @see        {@link http://github.shapeshed.com/expressionengine/extensions/ckeditor.html} 
 * @license    {@link http://opensource.org/licenses/bsd-license.php} 
 */

if ( ! defined('EXT')) {
    exit('Invalid file request'); }

/**
 * CKeditor Extension
 *
 * @category   Extesions
 * @package    ckeditor
 */

class Ckeditor
{

	/**
	* Settings for the extension
	* @var array
	*/
	var $settings		= array();
	
	/**
	* The name of the extension
	* @var string
	*/
	var $name			= 'CKeditor Extension for EE';

	/**
	* The version of the extension
	* @var string
	*/
	var $version		= '1.0.0';

	/**
	* The description of the extension
	* @var string
	*/
	var $description	= 'Converts Textareas in Publish area into WYSIWYG editor (CKeditor)';

	/**
	* Define whether settings exist for the extension
	* Permitted values "y" or "n". Equates to true / false
	* @var bool
	*/
	var $settings_exist	= 'y';

	/**
	* Documentation for the Extension
	* @var bool
	*/
	var $docs_url		= 'http://docs.fckeditor.net/CKEditor_3.x/Developers_Guide';


	/**
	* Used to hold the javascript configuration
	* @var string
	*/
	var $configuration;
	
	/**
	* Used to hold the behaviour configuration
	* @var string
	*/
	var $behaviour;	
	
	/**
	* Used to hold the event delegation configuration
	* @var string
	*/
	var $event;
	
	/**
	* Data returned by the extension
	* @var string
	*/
	var $return_data;

	/**
	* Constructor 
	*/	
	function Ckeditor($settings='')
	{
		$this->settings = $settings;
	}

	/** 
	* Adds JavaScript to the header to do the work
	* 
	* @access public 
	* @return string 
	*/	
	function add_header()
	{
		global $PREFS;
		
		$configuration = implode("\n\t\t", preg_split("/(\r\n|\n|\r)/", trim($this->settings['configuration'])));
		$behaviour = implode("\n\t\t", preg_split("/(\r\n|\n|\r)/", trim($this->settings['behaviour'])));
				
		$event = $this->set_behaviour($behaviour);

		$return_data = '
			<script type="text/javascript" src="'.trim($this->settings['script_url']).'"></script>
			<script type="text/javascript">
				$(document).ready(function(){
					$("textarea").'.$event.'(function()
					{
						var name = $("textarea").attr("name");
						'.$configuration.'
					});
				});
			</script>
			';    
        return $return_data;

    }

	/** 
	* Writes a name to textareas so they can be used by CKeditor
	* 
	* @access public 
	* 
	*/
	function output_tag($fieldID, $field_data, $rows, $field_js, $convert_ascii)
	{
		global $DSP;

		$return_data =  $DSP->input_textarea('field_id_'.$fieldID, $field_data, $rows, 'textarea', '100%', $convert_ascii);

		return $return_data;
	}
	
	/** 
	* Sets the behaviour of how CKeditor is instantiated 
	* 
	* @access public 
	* 
	*/
	function set_behaviour($behaviour)
	{
		switch ($behaviour) {
				
			case 'single_click':
				$event = "click";
				break;

			case 'double_click':
				$event = "dblclick";
				break;
							
			default:
				$event = "ready";
				break;
		}	
		return $event;	
	}

	/** 
	* Activates the extension
	* 
	* @access public 
	* 
	*/		   
    function activate_extension()
    {
    	global $DB, $PREFS;
    	
    	$default_settings = serialize(array('script_url' 	=> $PREFS->ini('site_url', TRUE).'ckeditor/ckeditor.js',
    										'configuration' => 'CKEDITOR.replace(name);',
											'behaviour' 	=> 'page_load'));
    	
    	$DB->query($DB->insert_string('exp_extensions',
    								  array('extension_id'	=> '',
    										'class'			=> "Ckeditor",
    										'method'		=> "add_header",
    										'hook'			=> "publish_form_headers",
    										'settings'		=> $default_settings,
    										'priority'		=> 10,
    										'version'		=> $this->version,
    										'enabled'		=> "y"
    										)
    								 )
    			   );
				   
   		$DB->query($DB->insert_string('exp_extensions',
    								  array('extension_id'	=> '',
    										'class'			=> "Ckeditor",
    										'method'		=> "output_tag",
    										'hook'			=> "publish_form_field_textarea",
    										'settings'		=> "",
    										'priority'		=> 10,
    										'version'		=> $this->version,
    										'enabled'		=> "y"
    										)
    								 )
    			   );
    }

	/** 
	* Updates the extension
	* 
	* @access public 
	* 
	*/
    function update_extension($current='')
    {
	    global $DB;
    	if ($current == '' OR $current == $this->version)
    	{
    		return FALSE;
    	}
		
		if ($current > $this->version){}
    	else
		{    	
			$this->activate_extension();

			$DB->query("UPDATE exp_extensions 
						SET version = '".$DB->escape_str($this->version)."' 
						WHERE class = 'Publish_form'");
		}
    }
	
	/** 
	* Removes old settings
	* 
	* @access public 
	* 
	*/
	function disable_extension()
	{
		global $DB;
		
		$DB->query("DELETE FROM exp_extensions WHERE class = 'Ckeditor'");
	}


	/** 
	* Declares extension settings
	* 
	* @access public 
	* 
	*/   
    function settings()
    {
    	global $PREFS;
    	
    	$settings = array();
    	
    	$settings['script_url']		= $PREFS->ini('site_url', TRUE).'ckeditor/ckeditor.js';
    	$settings['configuration']	= array('t', "CKEDITOR.replace(name);");
    	$settings['behaviour']		= array('s', array('single_click' => "On single click", 'double_click' => "On double click"), 'single_click');
	 
    	
    	return $settings;
    }

}
?>