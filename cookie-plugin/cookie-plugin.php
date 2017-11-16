<?php 

/**
* Plugin Name: CMS 2 Labb 1 Cookie Notice (Cookie-monster) / Uppgift 4
* Author: Oskar och Tobias
*/



//Add style to plugin
function pluginNoticeStyle() {
	wp_enqueue_style( 'footer_cookie',  plugin_dir_url( __FILE__ ) . 'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'pluginNoticeStyle' );



//Register admin page
function register_cookie_page() {
    add_menu_page(
        __( 'Cookie Menu', 'cookiemenu' ),
        'Cookie menu',
        'manage_options',
        'custompage',
        'manage_cookie_page'
    );
}
add_action( 'admin_menu', 'register_cookie_page' );



//Look in header for POST request and set cookie
function setMyCookie() {
	if (isset($_POST['cookie_ok'])) {
		setcookie('notice', 'my cookie', time()+86400 * get_option('cookie_days'));
	}

}
add_action('init', 'setMyCookie');


//Content to admin options page
function manage_cookie_page(){
	add_option('cookie_message', $_POST['message']);
	add_option('cookie_days', $_POST['cookie_days']);
	add_option('button_txt', $_POST['button_txt']);

	if (isset($_POST['submit'])) {
		update_option('cookie_message', $_POST['message']);
		update_option('cookie_days', $_POST['cookie_days']);
		update_option('button_txt', $_POST['button_txt']);
	}

    echo '<h1>Manage Cookies</h1>
	    	<form method="POST">
		    	<ul>
		    		<li>
		    			<label for="message">Message</label><br />
		    			<input type="text" name="message" id="message" value="'.get_option('cookie_message').'">
		    		</li>
		    		<li>
		    			<label for="button_txt">Button Text</label><br />
		    			<input type="text" name="button_txt" id="button_txt" value="'.get_option('button_txt').'">
		    		</li>
		    		<li>
		    			<label for="days">Days</label><br />
		    			<input type="number" name="cookie_days" id="days" value="'.get_option('cookie_days').'">
		    		</li>
		    		<li>
		    			'.get_submit_button().'
		    		</li>
		    	</ul>
			</form>
    ';  
}


//Add notice to footer
function addNotice() {
	if (!isset($_COOKIE['notice']) && !isset($_POST['cookie_ok'])) {

		echo '	<div class="cookieNotice">
					<p>'.stripslashes(get_option('cookie_message')).'</p>
					
					<form method="POST">
						<button class="cookie-button" type="submit" name="cookie_ok">'.get_option('button_txt').'</button>
					</form> 
				</div>';
	}
}
add_action('wp_footer', 'addNotice');

























