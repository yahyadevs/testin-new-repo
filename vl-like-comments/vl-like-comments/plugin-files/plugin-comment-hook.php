<?php 
    add_action("wp_ajax_plugin_user_comment", "handle_custom_plugin_comment");
    add_action("wp_ajax_nopriv_plugin_user_comment", "handle_custom_plugin_comment");


    function handle_custom_plugin_comment() {
        $isValid;
        $currentPostIDFront = $_POST["currentPostIDFront"];

        $selectedCommentValue = $_POST["selectedCommentValue"];
        $selectedCommentText = $_POST["selectedCommentText"];

       
        $userLoginOP = wp_get_current_user();

        $userCurrentName = $userLoginOP->user_login;
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
            // $isValid = "false";
        }
        else {
            $post_id = wp_insert_post( array(
                'post_status' => 'publish',
                'post_type' => 'users_like_comment',
                'post_title' => $current_user->user_login,
            ));

            // $isValid = "true";
        }
        
        // Update ACF Repeater For Likes
        $fieldCommentRepeater_key = 'field_6409be7c4b7f6';
        $fieldComment_value =  array(
            'field_6409be7c4b7f7' => $currentPostIDFront,
            'field_6409bebd4b7f9' => $selectedCommentText,
            'field_6409be7c4b7f8' => $Date_Time
        );
        add_row($fieldCommentRepeater_key, $fieldComment_value, $post_id);



        // $the_query_post = new WP_Query( array(
        //     'post_type' => array('recipes', 'chef_recipes', 'eid_dish', 'ramadan_recipes'),
        // )); 
        
        // if ( $the_query_post->posts[0]->ID) {
        //     $recipe_post_id = $the_query_post->posts[0]->ID;
        // }

        
        
        // Update ACF Repeater For Likes
        $fieldCommentRepeaterRecipe_key = 'field_640ddc3210d6c';
        
        $fieldCommentRecipe_value =  array(
            'field_640ddc3e10d6d' => $current_user->ID,
            'field_640ddc7e10d70' => $userCurrentName,
            'field_640ddc6b10d6f' => $selectedCommentText,
            'field_640ddc5810d6e' => $Date_Time
        );
        add_row($fieldCommentRepeaterRecipe_key, $fieldCommentRecipe_value, $currentPostIDFront);
            


        $isValid = 'true';
        echo $isValid;
        wp_die();

    }


?>