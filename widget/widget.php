<?php
/*
Plugin Name: Widget upggift 2
Author:Oskar och Tobias
*/

Class YoutubePlayer extends WP_Widget {

//(end(explode('?v=' , $url))) : $url

  function __construct() {
    parent::__construct('Video' , 'YoutubePlayer');
  }

  public function Widget($args, $instance) {
    echo $args['before_widget'];
    apply_filters('widget_title' , $args['before_title'] . 'Youtube Player' . $args['after_title']);
    $url = $instance['url'];
    $url2 = $instance['url'];
    $parse = parse_url($url2);
    parse_str($parse['query'] ,$query);
    $id = (substr($url, 0,4) === 'http') ? $query['v']:$url;
    $autoplay = $instance['autoplay'];
    $controls = $instance['controls'];
    ?>

    <div id="player"></div>

    <script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '390',
          width: '640',
          videoId: '<?php echo $id; ?>',
          <?php if(!$controls){echo "playerVars: {'controls': 0 },";} ?>
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        <?php
        if ($instance['autoplay']){
          echo 'event.target.playVideo();';
        }

        ?>
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }
    </script>
    <?php
    echo $args['widget_after'];


  }

  public function update($new_instance, $old_instance) {
    $instance = [];
    $instance['url'] = ! empty ($new_instance['url']) ? $new_instance['url'] : 'M7lc1UVf-VE';
    $instance['autoplay'] = isset($new_instance['autoplay']) ? true: false;
    $instance['controls'] = isset($new_instance['controls']) ? true: false;
    return $instance;
  }
//  $test = true ? $såBlirTestDetta : $annarsDetta
  public function form($instance) {
    $url = ! empty( $instance['url']) ? $instance['url'] : 'M7lc1UVf-VE';
    $autoplay = $instance['autoplay'] ? true: false;
    $controls = $instance['controls'] ? true: false;
    ?>
    <label for="<?php echo $this->get_field_id('url'); ?>">Youtube videons ID eller Url</label>
    <input type="text" name="<?php echo $this->get_field_name('url'); ?>" id="<?php echo $this->get_field_id('url'); ?>" value="<?php echo $url;?>">
    <label for="<?php echo $this->get_field_id('autoplay'); ?>">Autoplay?</label>
    <input type="checkbox" <?php if($autoplay){echo 'checked';} ?> name="<?php echo $this->get_field_name('autoplay'); ?>" id="<?php echo $this->get_field_id('autoplay'); ?>" value="<?php echo $autoplay;?>">
    <label for="<?php echo $this->get_field_id('controls'); ?>">Controls?</label>
    <input type="checkbox" <?php if($controls){echo 'checked';} ?> name="<?php echo $this->get_field_name('controls'); ?>" id="<?php echo $this->get_field_id('controls'); ?>" value="<?php echo $controls;?>">
    <?php

  }

}

add_action('widgets_init' , 'register_widget_youtube');

function register_widget_youtube() {
  register_widget( 'YoutubePlayer' );
}
