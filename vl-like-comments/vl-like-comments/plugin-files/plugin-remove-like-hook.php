<?php 
add_action("wp_ajax_remove_user_like", "handle_custom_remove_plugin_like");
add_action("wp_ajax_nopriv_remove_user_like", "handle_custom_remove_plugin_like");


function handle_custom_remove_plugin_like() {
        $isValid;
        $currentPostIDFront = $_POST["currentPostIDFront"];
       

        $userLoginOP = wp_get_current_user();

        $userCurrentName = $userLoginOP->user_login;
        $current_user_ID = $current_user->ID;
        
     
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
        
        if( have_rows('field_6409be1a4b7f3',$post_id) ):
            // loop through the rows of data
            $rowNum = 0; 
            while ( have_rows('field_6409be1a4b7f3',$post_id) ) : the_row();
                $rowNum ++;
                if($currentPostIDFront == get_sub_field('field_6409be364b7f4')){
                    var_dump(delete_row('field_6409be1a4b7f3', $rowNum, $post_id));
                    echo 'id found';
                } else {
                    //echo 'id not found';
                }
            
            endwhile;
        else :
            // no rows found
        endif;
        //add_row($fieldLikesRepeater_key, $fieldLikes_value, $post_id);
        //delete_row($fieldLikesRepeater_key, $fieldLikes_value, $post_id);
            
       
        /* after relation added */
        // get Relation Functions Fields End
       
        $likedUsersList = get_field('like_user_relation', $currentPostIDFront);
        $likedUsersListClone = $likedUsersList;
        // $get_check_update_array_value_liked_users_list = get_check_update_array($likedUsersList);
        // array_push($get_check_update_array_value_liked_users_list , $post_id);
        // update_field('like_user_relation', $get_check_update_array_value_liked_users_list, $currentPostIDFront);
        //var_dump($likedUsersList);
        //$arr should be array as you mentioned as below
        $obIndex = 0;
        foreach($likedUsersList as $value){
            $post_id_in_relation = $value->ID;
            if($post_id == $post_id_in_relation) {
                // var_dump($post_id_in_relation);
                //var_dump($obIndex);
                //conver id to string
                //$post_id_in_relationstr = strval($post_id_in_relation); 
                unset($likedUsersListClone[$obIndex]);
                echo "Object removed from the array!";
            }  else {
                echo "Object not removed from the array!";
            }
            $obIndex++;
        }
        // var_dump($likedUsersListClone);
        update_field('like_user_relation', $likedUsersListClone, $currentPostIDFront);
        
       
        // function findObjectById($post_id){
        //     $array = array($likedUsersList);
        
        //     foreach ( $likedUsersList as $element ) {
        //         var_dump($likedUsersList);
        //         // if ( $post_id == $element->id ) {
        //         //     return $element;
        //         //     echo "iam here";
        //         // }
        //     }
        
        //     return false;
        // }
        

        // var_dump($post_id);
        // var_dump($likedUsersList);
        // var_dump($searchResult);
        wp_die();

        $get_check_update_array_value_liked_users_list = get_check_update_array($likedUsersList);
        array_push($get_check_update_array_value_liked_users_list , $post_id);
        update_field('like_user_relation', $get_check_update_array_value_liked_users_list, $currentPostIDFront);

        // get Relation Functions Fields Start

        
 
        echo $isValid;
        wp_die();

    }


?>