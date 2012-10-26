<?php
/*
Plugin Name: Supersized Bg Slider
Plugin URI: https://github.com/sliker/supersized-bg-slider
Description: Supersized Jquery plugin integrated to Wordpress for full background images
Version: 0.1
Author: David Velásquez
Author URI: http://www.davidvu.co

License: GPL2 - http://www.gnu.org/licenses/gpl.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


// If Admin Area, add administration options page
if ( is_admin() ) require_once( dirname( __FILE__ ) . '/admin.php' );

// Load javascripts and css files
if (!is_admin()) {
	
	/**
	 * javascript files
	 */
    add_action('wp_enqueue_scripts', 'supersized_load_js');
    function supersized_load_js() {
       wp_enqueue_script('jquery', plugins_url('js/vendor/jquery-1.8.2.min.js', __FILE__));
	   wp_enqueue_script('jquery_easing', plugins_url('js/vendor/jquery.easing.min.js', __FILE__));
       wp_enqueue_script('supersized', plugins_url('js/supersized.3.2.7.min.js', __FILE__));
    }
	
	/**
     * CSS files
     */
    add_action( 'wp_enqueue_scripts', 'supersized_add_stylesheet' );
    /**
     * Enqueue plugin style-file
     */
    function supersized_add_stylesheet() {
        wp_register_style( 'supersized', plugins_url('/css/supersized.css', __FILE__) );
        wp_enqueue_style( 'supersized' );
    }
	
	/**
	 * Supersized js init code
	 * 
	 */
	//add_action('wp_footer', 'supersized_footer_code');
	add_action('wp_footer', 'supersized_footer_code');
	function supersized_footer_code() {
		$autoplay = ( get_option('supersized_autoplay') == 1 ) ? 'true' : 'false';
		$js = "
			<script type='text/javascript'>
			jQuery(document).ready(function($){
				$('#nextslide').click(function(){
					api.nextSlide();
				});
				$('#prevslide').click(function(){
					api.prevSlide();
				});
				
				$.supersized({
			
				// Functionality
				autoplay				: 	$autoplay,
				slide_interval          :   3000,		// Length between transitions
				transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
				transition_speed		:	700,		// Speed of transition
													   
				// Components							
				slide_links				:	'false',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
				slides 					:  	[			// Slideshow Images
											{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/kazvan-1.jpg', title : 'Image Credit: Maria Kazvan', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/kazvan-1.jpg', url : 'http://www.nonsensesociety.com/2011/04/maria-kazvan/'},
											{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/kazvan-2.jpg', title : 'Image Credit: Maria Kazvan', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/kazvan-2.jpg', url : 'http://www.nonsensesociety.com/2011/04/maria-kazvan/'},  
											{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/kazvan-3.jpg', title : 'Image Credit: Maria Kazvan', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/kazvan-3.jpg', url : 'http://www.nonsensesociety.com/2011/04/maria-kazvan/'},
											{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/wojno-1.jpg', title : 'Image Credit: Colin Wojno', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/wojno-1.jpg', url : 'http://www.nonsensesociety.com/2011/03/colin/'},
											{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/wojno-2.jpg', title : 'Image Credit: Colin Wojno', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/wojno-2.jpg', url : 'http://www.nonsensesociety.com/2011/03/colin/'},
											{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/wojno-3.jpg', title : 'Image Credit: Colin Wojno', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/wojno-3.jpg', url : 'http://www.nonsensesociety.com/2011/03/colin/'},
											{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/shaden-1.jpg', title : 'Image Credit: Brooke Shaden', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/shaden-1.jpg', url : 'http://www.nonsensesociety.com/2011/06/brooke-shaden/'},
											{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/shaden-2.jpg', title : 'Image Credit: Brooke Shaden', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/shaden-2.jpg', url : 'http://www.nonsensesociety.com/2011/06/brooke-shaden/'},
											{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/shaden-3.jpg', title : 'Image Credit: Brooke Shaden', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/shaden-3.jpg', url : 'http://www.nonsensesociety.com/2011/06/brooke-shaden/'}
										]
			
				});
			});
			</script>
		";
		echo $js;
	}
	
	/**
	 * HTML buttons for navigation the background images
	 * 
	 */
	add_action('wp_footer', 'navigation');
	function navigation() {
		$html = "
			<!--Arrow Navigation-->
			<a id=\"prevslide\" class=\"load-item\"></a>
			<a id=\"nextslide\" class=\"load-item\"></a>
		";
		echo $html;
	} 

}
?>