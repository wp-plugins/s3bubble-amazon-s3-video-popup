<?php
/*
Plugin Name: S3Bubble Featured Video Advertising Popup
Plugin URI: https://www.s3bubble.com/
Description: S3Bubble offers simple, secure media streaming from Amazon S3 to WordPress and adding your very own adverts. In just 4 simple steps. 
Version: 0.1
Author: S3Bubble
Author URI: https://s3bubble.com/
License: GPL2
*/ 
 
/*  Copyright YEAR  Samuel East  (email : mail@samueleast.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/ 


if (!class_exists("s3bubble_video_popup")) {
	class s3bubble_video_popup {

		/*
		 * Class properties
		 * @author sameast
		 * @params noen
		 */ 
        public  $s3bubble_video_popup_key          = 'mWWMeyGgW';
		public  $s3bubble_video_popup_width        = 600;
		public  $s3bubble_video_popup_button_text  = 'Featured Video Powered by S3Bubble';
		public  $s3bubble_button_position          = 'bottom';
		public  $s3bubble_video_popup_link         = 'https://s3bubble.com/';
		public  $s3bubble_video_popup_link_text    = 'S3Bubble';
		public  $version                           = 1;
		
		/*
		 * Constructor method to intiat the class
		 * @author sameast
		 * @params none
		 */ 
		function s3bubble_video_popup(){

			/*
			 * Add default option to database
			 * @author sameast
			 * @params none
			 */ 
			add_option("s3bubble_video_popup_key", $this->s3bubble_video_popup_key);
			add_option("s3bubble_video_popup_width", $this->s3bubble_video_popup_width);
			add_option("s3bubble_video_popup_button_text", $this->s3bubble_video_popup_button_text);
			add_option("s3bubble_button_position", $this->s3bubble_button_position);
			add_option("s3bubble_video_popup_link", $this->s3bubble_video_popup_link);
			add_option("s3bubble_video_popup_link_text", $this->s3bubble_video_popup_link_text);

			/*
			 * Run the add admin menu class
			 * @author sameast
			 * @params none
			 */ 
			add_action('admin_menu', array( $this, 's3bubble_video_popup_admin_menu' ));
			
			/*
			 * Add css to the header of the document
			 * @author sameast
			 * @params none
			 */ 
			add_action( 'wp_head', array( $this, 's3bubble_video_popup_css' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 's3bubble_video_popup_javascript' ), 11 );
			
			/*
			 * Add css to the wordpress admin document
			 * @author sameast
			 * @params none
			 */ 
			add_action( 'admin_head', array( $this, 's3bubble_video_popup_css_admin' ) );
			
			/*
			 * Add javascript to the frontend footer connects to wp_footer
			 * @author sameast
			 * @params none
			 */ 
			add_action( 'admin_footer', array( $this, 's3bubble_video_popup_javascript_admin' ) );
			
			/*
			 * Grab the popup html
			 */ 
			add_action( 'wp_ajax_s3bubble_video_popup_internal_ajax', array( $this, 's3bubble_video_popup_internal_ajax' ) );
			add_action('wp_ajax_nopriv_s3bubble_video_popup_internal_ajax', array( $this, 's3bubble_video_popup_internal_ajax' ) ); 
			
		}

		/*
		* Adds the menu item to the wordpress admin
		* @author sameast
		* @none
		*/ 
        function s3bubble_video_popup_internal_ajax(){
			$s3bubble_video_popup_key	      = get_option("s3bubble_video_popup_key");
            $s3bubble_video_popup_link	      = get_option("s3bubble_video_popup_link");
			$s3bubble_video_popup_link_text   = get_option("s3bubble_video_popup_link_text");
			$data = array(
						'link'=> $s3bubble_video_popup_link,
              			'linktext'=> $s3bubble_video_popup_link_text,
              			);
			  
            echo '<div id="s3bubble-frame">
					<a id="s3bubble-frame-close" href="#">Close</a>
						<div id="s3bubble-frame-wrap">
							<iframe id="s3bubble-iframe-load" style="width:100%;" src="//s3bubble.com/popup?v=' . $s3bubble_video_popup_key . '&' . http_build_query($data, '', '&amp;') . '" marginheight="0" marginwidth="0" frameborder="0" allowtransparency="true" webkitAllowFullScreen="true" mozallowfullscreen="true" allowFullScreen="true" />
						</div>
				</div>';
			die();	
		}		
        
		/*
		* Adds the menu item to the wordpress admin
		* @author sameast
		* @none
		*/ 
        function s3bubble_video_popup_admin_menu(){	
			add_menu_page( 's3bubble_video_popup', 'S3Bubble Popup', 'manage_options', 's3bubble_video_popup', array($this, 's3bubble_video_popup_admin'), plugins_url('assets/images/s3bubblelogo.png',__FILE__ ) );
    	}
        
		/*
		* Add css to wordpress admin to run colourpicker
		* @author sameast
		* @none
		*/ 
		function s3bubble_video_popup_css_admin(){
			wp_register_style( 's3bubble.video.popup.admin', plugins_url('assets/css/s3bubble.video.popup.admin.css', __FILE__) );
			wp_enqueue_style('s3bubble.video.popup.admin');
			wp_register_style( 's3bubble.video.popup.plugin', plugins_url('assets/css/s3bubble.video.popup.plugin.css', __FILE__) );
			wp_enqueue_style('s3bubble.video.popup.plugin');
		}
		
        /*
		* Add javascript to the admin header
		* @author sameast
		* @none
		*/ 
		function s3bubble_video_popup_javascript_admin(){

		} 
		
		/*
		* Add css ties into wp_head() function
		* @author sameast
		* @params none
        */ 
		function s3bubble_video_popup_css(){
			$width = get_option("s3bubble_video_popup_width");
			wp_register_style( 's3bubble.button', plugins_url('assets/css/s3bubble.button.css', __FILE__), array(), $this->version );
			wp_enqueue_style('s3bubble.button');
			wp_register_style( 's3bubble.frame', plugins_url('assets/css/s3bubble.frame.css', __FILE__), array(), $this->version );
			wp_enqueue_style('s3bubble.frame');
			echo "<style type='text/css'>#s3bubble-frame{max-width: " . (empty($width) ? 600 : $width ) . "px}</style>";
		}
		
		/*
		* Add javascript to the footer connect to wp_footer()
		* @author sameast
		* @none
		*/ 
		function s3bubble_video_popup_javascript(){
           if (!is_admin()) {
           	    $text     = get_option("s3bubble_video_popup_button_text");
			    $position = get_option("s3bubble_button_position");
	            wp_deregister_script( 'jquery' );
	            wp_register_script( 'jquery', '//code.jquery.com/jquery-1.11.0.min.js', false, null);
	            wp_enqueue_script('jquery');
	            wp_register_script( 'jquery-migrate', '//code.jquery.com/jquery-migrate-1.2.1.min.js', false, null);
	            wp_enqueue_script('jquery-migrate');
				wp_register_script( 'button.min', plugins_url('assets/js/button.js',__FILE__ ), array(), $this->version );
	            wp_enqueue_script('button.min');
				echo '<script type="text/javascript">
				/* <![CDATA[ */
				var s3bubblePopup = {
					"text":"' . (empty($text) ? 'Video Tutorial' : $text ) . '", 
					"position":"' . (empty($text) ? 'right' : $position ) . '", 
					"ajax":"' . admin_url('admin-ajax.php') . '"
					};
				/* ]]> */
				</script>';
            } 
		}
        
		/*
		* Add javascript to the footer connect to wp_footer()
		* @author sameast
		* @none
		*/ 
		function s3bubble_video_popup_admin(){	
			if ( isset($_POST['submit']) ) {
				$nonce = $_REQUEST['_wpnonce'];
				if (! wp_verify_nonce($nonce, 'isd-updatesettings') ) die('Security check failed'); 
				if (!current_user_can('manage_options')) die(__('You cannot edit the video popup options.'));
				check_admin_referer('isd-updatesettings');	
				// Get our new option values
				$s3bubble_video_popup_key	      = $_POST['s3bubble_video_popup_key'];
				$s3bubble_video_popup_width	      = $_POST['s3bubble_video_popup_width'];
				$s3bubble_video_popup_button_text = $_POST['s3bubble_video_popup_button_text'];
				$s3bubble_button_position         = $_POST['s3bubble_button_position'];
				$s3bubble_video_popup_link        = $_POST['s3bubble_video_popup_link'];
				$s3bubble_video_popup_link_text   = $_POST['s3bubble_video_popup_link_text'];
				
			    // Update the DB with the new option values
				update_option("s3bubble_video_popup_key", $s3bubble_video_popup_key);
				update_option("s3bubble_video_popup_width", $s3bubble_video_popup_width);
				update_option("s3bubble_video_popup_button_text", $s3bubble_video_popup_button_text);
				update_option("s3bubble_button_position", $s3bubble_button_position);
				update_option("s3bubble_video_popup_link", $s3bubble_video_popup_link);
				update_option("s3bubble_video_popup_link_text", $s3bubble_video_popup_link_text);
			}

			$s3bubble_video_popup_key	      = get_option("s3bubble_video_popup_key");
			$s3bubble_video_popup_width	      = get_option("s3bubble_video_popup_width");
			$s3bubble_video_popup_button_text = get_option("s3bubble_video_popup_button_text");
			$s3bubble_button_position         = get_option("s3bubble_button_position");
			$s3bubble_video_popup_link        = get_option("s3bubble_video_popup_link");
			$s3bubble_video_popup_link_text   = get_option("s3bubble_video_popup_link_text");
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"></div>
			<h2>S3Bubble Amazon S3 Popup Video</h2>
			<div class="metabox-holder has-right-sidebar">
				<div class="inner-sidebar" style="width:50%">
					<div class="postbox">
						<h3><span>PLEASE WATCH TUTORIAL VIDEO</span></h3>
						<div class="inside">
							<iframe width="100%" height="315" src="//www.youtube.com/embed/GcTLSOvddaM" frameborder="0" allowfullscreen></iframe>
						</div> 
					</div>

				</div>
				<div id="post-body">
					<div id="post-body-content" style="margin-right: 51%;">
						<div class="postbox">
							<h3><span>Please sign up for an account at <a href="https://s3bubble.com/auth/?action=register&utm_source=wordpress&utm_medium=link&utm_campaign=pluginpage" target="_blank">https://s3bubble.com</a> you will need to use the username and email you signed up with.</span></h3>
							<div class="inside">
								<form action="" method="post" id="isd-config" style="overflow: hidden;">
								    <table class="form-table">
								      <?php if (function_exists('wp_nonce_field')) { wp_nonce_field('isd-updatesettings'); } ?>
								      <tr>
								        <th scope="row" valign="top"><label for="s3bubble_video_popup_key">S3Bubble Video ID:</label></th>
								        <td><input type="text" name="s3bubble_video_popup_key" id="s3bubble_video_popup_key" class="regular-text" value="<?php echo $s3bubble_video_popup_key; ?>"/>
								        	<br />
								        	<span class="description">Video ID can be found in S3Bubble admin.</span>
								        </td>
								      </tr>  
								      <tr>
								        <th scope="row" valign="top"><label for="s3bubble_video_popup_button_text">Button Text:</label></th>
								        <td><input type="text" name="s3bubble_video_popup_button_text" id="s3bubble_video_popup_button_text" class="regular-text" value="<?php echo $s3bubble_video_popup_button_text; ?>"/>
								        	<br />
								        	<span class="description">Text for the button</span>
								        </td>
								      </tr> 
								      <tr>
								        <th scope="row" valign="top"><label for="s3bubble_video_popup_width">Video Width:</label></th>
								        <td><input type="text" name="s3bubble_video_popup_width" id="s3bubble_video_popup_width" class="regular-text" value="<?php echo $s3bubble_video_popup_width; ?>"/>
								        	<br />
								        	<span class="description">Do not add px</span>
								        </td>
								      </tr>
								      <tr>
								        <th scope="row" valign="top"><label for="s3bubble_button_position">Button Position:</label></th>
								        <td><select name="s3bubble_button_position" id="s3bubble_button_position">
								            <option value="<?php echo $s3bubble_button_position; ?>"><?php echo $s3bubble_button_position; ?></option>
								            <option value="left">left</option>
								            <option value="right">right</option>
								            <option value="bottom">bottom</option>
								          </select>
								          <br />
								          <span class="description">Change button position.</p></td>
								      </tr>
								      <tr>
								        <th scope="row" valign="top"><label for="s3bubble_video_popup_link">Video Link:</label></th>
								        <td><input type="text" name="s3bubble_video_popup_link" id="s3bubble_video_popup_link" class="regular-text" value="<?php echo $s3bubble_video_popup_link; ?>"/>
								        	<br />
								        	<span class="description">Optional leave blank for no link</span>
								        </td>
								      </tr>
								      <tr>
								        <th scope="row" valign="top"><label for="s3bubble_video_popup_link_text">Video Link Text:</label></th>
								        <td><input type="text" name="s3bubble_video_popup_link_text" id="s3bubble_video_popup_link_text" class="regular-text" value="<?php echo $s3bubble_video_popup_link_text; ?>"/>
								        	<br />
								        	<span class="description">Video link text url must be supplied</span>
								        </td>
								      </tr>  
								    </table>
								    <br/>
								    <span class="description">To remove branding please upgrade your account. <a href="https://s3bubble.com/pricing/" target="_blank">Upgrade</a></p>
								    <span class="submit" style="border: 0;">
								    <input type="submit" name="submit" class="button button-primary button-hero" value="Save Settings" />
								    </span>
								  </form>
							</div><!-- .inside -->
						</div>
					</div> <!-- #post-body-content -->
				</div> <!-- #post-body -->
			</div> <!-- .metabox-holder -->
		</div> <!-- .wrap -->
		<?php	
       } 

	}
	/*
	* Initiate the class
	* @author sameast
	* @none
	*/ 
	$s3bubble_video_popup = new s3bubble_video_popup();

} //End Class s3audible