<?php
/*
Plugin Name:Mail upg 3
Author: Oskar och Tobias
*/

add_shortcode('contact' , 'mailContent');

function mailContent($atts = [], $content = null) {
  $a = shortcode_atts(array(
    'receiver' => get_option('admin_email'),
    'label' => 'Message',
    'placeholder' => 'Skriv Här',
    'submit-text' => 'Skicka',
    'thankyou-text' => 'Thank you',
  ),$atts);

  if(isset($_POST['sub'])){
    $headers = [];
    $headers[] = 'From: '.$a['receiver'];

    wp_mail($a['receiver'],$a['label'],$_POST['message'], $headers);


    return
    '<div class="thankyou">
    '.$a['thankyou-text'].'
    </div>';
  }else {
  return '<p>'.$content.'</p><form class="" action="" method="post">
    <input type="email" name="" value="'.$a['receiver'].'">
    <label for="message">'.$a['label'].'</label>
    <textarea name="message" class="hej" id="message" rows="8" cols="80" placeholder="'.$a['placeholder'].'"></textarea>
    <input type="submit" name="sub" value="'.$a['submit-text'].'">
  </form>'
  ;
}}
add_action('wp_enqueue_scripts' , 'laddainoskarsspecielacssfil');
function laddainoskarsspecielacssfil() {
  wp_enqueue_style('mac_style', plugin_dir_url(__FILE__) . '/style.css');
}
