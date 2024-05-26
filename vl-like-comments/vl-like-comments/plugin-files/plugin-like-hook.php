<?php 
    add_action("wp_ajax_plugin_user_like", "handle_custom_plugin_like");
    add_action("wp_ajax_nopriv_plugin_user_like", "handle_custom_plugin_like");


    function handle_custom_plugin_like() {
        $isValid;
        $currentPostIDFront = $_POST["currentPostIDFront"];
        

        $userLoginOP = wp_get_current_user();

        $userCurrentName = $userLoginOP->user_login;
        $current_user_ID = $current_user->ID;
        // var_dump($userCurrentName);
        // die();
     
        global $current_user;
        date_default_timezone_set('Africa/Cairo');
        $date = new DateTimeImmutable();
        $Date_Time = $date->format('d/m/Y h:i:s A');

        $post_id;

        $the_query = new WP_Query( array(
            'post_type' => 'users_like_comment',
            'author' => $current_user->ID,
        )); 
        
        if ( $the_query->posts[0]->ID) {
            $post_id = $the_query->posts[0]->ID;
            // var_dump("i already have a post");
            $isValid = "false";
        }
        else {
            $post_id = wp_insert_post( array(
                'post_status' => 'publish',
                'post_type' => 'users_like_comment',
                'post_title' => $current_user->user_login,
            ));

            $isValid = "true";
        }
       

        
        // Update ACF Repeater For Likes
        $fieldLikesRepeater_key = 'field_6409be1a4b7f3';
        $fieldLikes_value =  array(
            'field_6409be364b7f4' => $currentPostIDFront,
            'field_6409be5b4b7f5' => $Date_Time
        );
        add_row($fieldLikesRepeater_key, $fieldLikes_value, $post_id);
            
        // if( have_rows('field_6409be1a4b7f3',$post_id) ):
        //     // loop through the rows of data
        //     while ( have_rows('field_6409be1a4b7f3',$post_id) ) : the_row();
        //         //$rowNum ++;
        //         if($currentPostIDFront == get_sub_field('field_6409be364b7f4')){
                    
        //             echo 'id  found';
        //         } else {
        //             add_row($fieldLikesRepeater_key, $fieldLikes_value, $post_id);
        //             echo 'id not found';
        //         } 
            
        //     endwhile;
        // else :
        //     // no rows found
        // endif;


        /* after relation added */

        // get Relation Functions Fields Start
        function get_field_value($fieldKey, $postIDvalue) {
            return get_field($fieldKey, $postIDvalue);
        } 
        function get_check_update_array($fieldValue) {
            if(!is_array($fieldValue)){
                $fieldValue = array();
            }
            return $fieldValue;
        } 
        // get Relation Functions Fields End
        $likedUsersList = get_field_value('like_user_relation', $currentPostIDFront);
        
        $get_check_update_array_value_liked_users_list = get_check_update_array($likedUsersList);
        array_push($get_check_update_array_value_liked_users_list , $post_id);
        update_field('like_user_relation', $get_check_update_array_value_liked_users_list, $currentPostIDFront);
        
 
        echo $isValid;
        wp_die();

    }


?>