<?php

if (!class_exists('WP_Awesome_Instagram_Widget')) {

  add_action('widgets_init', 'load_thememove_instagram_widget');

  function load_thememove_instagram_widget()
  {
    register_widget('WP_Awesome_Instagram_Widget');
  }
  /**
   * Instagram Widget by Jewel Theme
   */
  class WP_Awesome_Instagram_Widget extends WP_Widget{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
      parent::__construct(
        'wp_awesome_instagram_widget',
        __('WP Awesome Instagram Widget', 'jeweltheme'),
        array('description' => __('Displays latest Instagram photos', 'jeweltheme'))
      );

      //wp_enqueue_style('thememove-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');

    }

    function widget($args, $instance) {
      extract( $args );

      $title            = isset($instance['title']) ? $instance['title'] : '';
      $username         = isset($instance['username']) ? $instance['username'] : '';
      $number_items     = isset($instance['number_items']) ? $instance['number_items'] : '6';
      
      $columns          = isset($instance['columns']) ? $instance['columns'] : '';

      
      $spacing          = isset($instance['spacing']) ? $instance['spacing'] : '3';

      $height          = isset($instance['height']) ? $instance['height'] : '125';
      $width           = isset($instance['width']) ? $instance['width'] : '125';

      $show_likes_comments  = isset($instance['show_likes_comments']) ? $instance['show_likes_comments'] : '';
      $link_new_page    = isset($instance['link_new_page']) ? $instance['link_new_page'] : '';
      $show_follow_text  = isset($instance['show_follow_text']) ? $instance['show_follow_text'] : '';
      $follow_text      = isset($instance['follow_text']) ? $instance['follow_text'] : __('Follow us on Instagram', 'jeweltheme');


      echo $args['before_widget'];

      $output = '<h3 class="widget-title">' . $title . '</h3>';

      // if hidden on device, find [class*=col] and replace to '', use only vc_hidden
      //$class_container = preg_replace( '/\-(one_column|two_column|three_column|four_column)[^\s]*/', '', $class);
      $output .= '<div class="wp-awesome-insta insta-container">';
      if (!empty($username)) {
        $media_array = $this->scrape_instagram( $username, $number_items );

        if ( is_wp_error( $media_array ) ) {
          $output .= '<div class="wp-awesome-insta--error"><p>' . $media_array->get_error_message() . '</p></div>';
        } else {
          $output .= '<ul class="wp-awesome-insta-img row">';
          foreach($media_array as $item) {
            $output .= '<li class="item insta_column-' . $columns . '"style="margin:' . $spacing . 'px;height:' . $height . 'px; width:' . $width . 'px;">';

            if ('on' == $show_likes_comments) {
              $output .= '<ul class="item-info">';
              $output .= '<li class="likes"><span>' . $item['likes'] . '</span></li>';
              $output .= '<li class="comments"><span>' . $item['comments'] . '</span></li>';
              $output .= '</ul>';
            }

            $output .= '<a  href="' . esc_url($item['link']) . '" target="' . ($link_new_page == 'on' ? '_blank' : '_self') . '" class="item-link' . ($show_likes_comments == 'on' ? ' show-info' : '') . '">';
            $output .= '<img style="height:' . $height . 'px; width:' . $width . 'px;" src="' . esc_url( $item['thumbnail'] ) . '" alt="' . $item['description'] . '"  title="' .  $item['description'] . '" class="item-image"/>';

            $output .= '</a>';
            $output .= '</li>';
          }
          $output .= '</ul>';
          if('on' == $show_follow_text) {
            $output .= '<p class="wp-awesome-insta-follow-links">' . $follow_text . '</p>';
          }
        }
      }

      $output .= '</div>';

      echo $output;

      echo $args['after_widget'];
    }

    function form($instance) {
      $title                = isset($instance['title']) ? $instance['title'] : '';
      $username             = isset($instance['username']) ? $instance['username'] : '';
      $number_items         = isset($instance['number_items']) ? $instance['number_items'] : '6';
      
      $columns              = isset($instance['columns']) ? $instance['columns'] : '';

      $spacing              = isset($instance['spacing']) ? $instance['spacing'] : '3';
      
      $height               = isset($instance['height']) ? $instance['height'] : '125';
      $width                = isset($instance['width']) ? $instance['width'] : '125';

      $show_likes_comments  = isset($instance['show_likes_comments']) ? $instance['show_likes_comments'] : '';
      $show_follow_text  = isset($instance['show_follow_text']) ? $instance['show_follow_text'] : '';
      $follow_text      = isset($instance['follow_text']) ? $instance['follow_text'] : __('Follow us on Instagram', 'jeweltheme');
      $link_new_page    = isset($instance['link_new_page']) ? $instance['link_new_page'] : '';

      ?>

      <p>
        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title', 'jeweltheme') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
               name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>"/>
      </p>
      <p>
        <label for="<?php echo esc_attr($this->get_field_id('username')); ?>"><?php _e('User Name', 'jeweltheme') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('username')); ?>"
               name="<?php echo esc_attr($this->get_field_name('username')); ?>" value="<?php echo esc_attr($username); ?>"/>
      </p>
      <p>
        <label for="<?php echo esc_attr($this->get_field_id('number_items')); ?>"><?php _e('Number of items', 'jeweltheme') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('usenumber_itemsrname')); ?>"
               name="<?php echo esc_attr($this->get_field_name('number_items')); ?>" value="<?php echo esc_attr($number_items); ?>"/>
      </p>

      <p>
        <label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Selct Columns', 'wp_widget_plugin'); ?></label>
        <select name="<?php echo $this->get_field_name('columns'); ?>" id="<?php echo $this->get_field_id('columns'); ?>" class="widefat">
          <?php
            $options = array('one', 'two', 'three');
              foreach ($options as $option) {
                echo '<option value="' . $option . '" id="' . $option . '"', $columns == $option ? ' selected="selected"' : '', '>', $option, '</option>';
            }
          ?>
        </select>
      </p>
      
      <p>
        <label for="<?php echo esc_attr($this->get_field_id('spacing')); ?>"><?php _e('Item spacing', 'jeweltheme') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('spacing')); ?>"
               name="<?php echo esc_attr($this->get_field_name('spacing')); ?>" value="<?php echo esc_attr($spacing); ?>"/>
      </p>      

      <p>
        <label for="<?php echo esc_attr($this->get_field_id('height')); ?>"><?php _e('Height', 'jeweltheme') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('height')); ?>"
               name="<?php echo esc_attr($this->get_field_name('height')); ?>" value="<?php echo esc_attr($height); ?>"/>
      </p>

      <p>
        <label for="<?php echo esc_attr($this->get_field_id('width')); ?>"><?php _e('Width', 'jeweltheme') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('width')); ?>"
               name="<?php echo esc_attr($this->get_field_name('width')); ?>" value="<?php echo esc_attr($width); ?>"/>
      </p>
      <p>
        <input type="checkbox" id="<?php echo esc_attr($this->get_field_id('show_likes_comments')); ?>" name="<?php echo esc_attr($this->get_field_name('show_likes_comments')); ?>" <?php checked($show_likes_comments, 'on'); ?> />
        <label for="<?php echo esc_attr($this->get_field_id('show_likes_comments')); ?>"><?php _e('Show likes and comments', 'jeweltheme') ?></label>
      </p>
      <p>
        <input type="checkbox" id="<?php echo esc_attr($this->get_field_id('show_follow_text')); ?>" name="<?php echo esc_attr($this->get_field_name('show_follow_text')); ?>" <?php checked($show_follow_text, 'on'); ?> />
        <label for="<?php echo esc_attr($this->get_field_id('show_follow_text')); ?>"><?php _e('Show follow text', 'jeweltheme') ?></label>
      </p>
      <p>
        <label for="<?php echo esc_attr($this->get_field_id('follow_text')); ?>"><?php _e('Text', 'jeweltheme') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('spacing')); ?>"
               name="<?php echo esc_attr($this->get_field_name('follow_text')); ?>" value="<?php echo esc_attr($follow_text); ?>"/>
      </p>
      <p>
        <input type="checkbox" id="<?php echo esc_attr($this->get_field_id('link_new_page')); ?>" name="<?php echo esc_attr($this->get_field_name('link_new_page')); ?>" <?php checked($link_new_page == 'on'); ?> />
        <label for="<?php echo esc_attr( $this->get_field_id('link_new_page') ); ?>"><?php _e('Open links in new page:', 'jeweltheme') ?></label>
      </p>



    <?php
    }


    /**
     * Quick-and-dirty Instagram web scrape
     * based on https://gist.github.com/cothree_columnocatalano/4544576
     * @param $username
     * @param int $slice
     * @return array|WP_Error
     */
    public function scrape_instagram( $username, $slice ) {

      $username = strtolower( $username );

      if ( false === ( $instagram = get_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ) ) ) ) {

        $remote = wp_remote_get( 'http://instagram.com/'.trim( $username ) );

        if ( is_wp_error( $remote ) )
          return new WP_Error( 'site_down', __( 'Unable to communicate with Instagram.', 'jeweltheme' ) );

        if ( 200 != wp_remote_retrieve_response_code( $remote ) )
          return new WP_Error( 'invalid_response', __( 'Instagram did not return a 200.', 'jeweltheme' ) );

        $shards = explode( 'window._sharedData = ', $remote['body'] );
        $insta_json = explode( ';</script>', $shards[1] );
        $insta_array = json_decode( $insta_json[0], TRUE );

        if ( !$insta_array )
          return new WP_Error( 'bad_json', __( 'Instagram has returned invalid data.', 'jeweltheme' ) );

        // old style
        if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
          $media_arr = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
          $type = 'old';
          // new style
        } else if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
          $media_arr = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
          $type = 'new';
        } else {
          return new WP_Error( 'bad_josn_2', __( 'Instagram has returned invalid data.', 'jeweltheme' ) );
        }

        if ( !is_array( $media_arr ) )
          return new WP_Error( 'bad_array', __( 'Instagram has returned invalid data.', 'jeweltheme' ) );

        $instagram = array();

        switch ( $type ) {
          case 'old':
            foreach ( $media_arr as $media ) {

              if ( $media['user']['username'] == $username ) {

                $media['link']						  = preg_replace( "/^http:/i", "", $media['link'] );
                $media['images']['thumbnail']		   = preg_replace( "/^http:/i", "", $media['images']['thumbnail'] );
                $media['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $media['images']['standard_resolution'] );
                $media['images']['low_resolution']	  = preg_replace( "/^http:/i", "", $media['images']['low_resolution'] );

                $instagram[] = array(
                  'description' => $media['caption']['text'],
                  'link'		  	=> $media['link'],
                  'time'		  	=> $media['created_time'],
                  'comments'	  => $media['comments']['count'],
                  'likes'		 	  => $media['likes']['count'],
                  'thumbnail'	 	=> $media['images']['thumbnail'],
                  'large'		 	  => $media['images']['standard_resolution'],
                  'three_columnall'		 	  => $media['images']['low_resolution'],
                  'type'		  	=> $media['type']
                );
              }
            }
            break;
          default:
            foreach ( $media_arr as $media ) {

              $media['display_src'] = preg_replace( "/^http:/i", "", $media['display_src'] );

              if ( $media['is_video']  == true ) {
                $type = 'video';
              } else {
                $type = 'image';
              }

              $instagram[] = array(
                'description'   => __( 'Instagram Image', 'jeweltheme' ),
                'link'		  	  => '//instagram.com/p/' . $media['code'],
                'time'		  	  => $media['date'],
                'comments'	  	=> $media['comments']['count'],
                'likes'		 	    => $media['likes']['count'],
                'thumbnail'	 	  => $media['display_src'],
                'type'		  	  => $type
              );
            }
            break;
        }

        // do not set an empty transient - should help catch private or empty accounts
        if ( ! empty( $instagram ) ) {
          $instagram = base64_encode( serialize( $instagram ) );
          set_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
        }
      }

      if ( ! empty( $instagram ) ) {

        $instagram = unserialize( base64_decode( $instagram ) );
        return array_slice( $instagram, 0, $slice );;

      } else {

        return new WP_Error( 'no_images', __( 'Instagram did not return any images.', 'jeweltheme' ) );

      }
    }
  } // end class
} // end if







