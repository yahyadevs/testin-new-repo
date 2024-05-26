<?php 
    global $current_user;
    $user_like_status;
    $the_query_user_like_comment_post = new WP_Query( array(
        'post_type' => 'users_like_comment',
        'author' => $current_user->ID,
    )); 
    
    $user_name = wp_get_current_user();
    $current_user_name = $user_name->user_nicename;

    $current_user_id = $user_name->id;
    
    

    // $post_Id = get_the_ID();
    
    $user_post_id = $the_query_user_like_comment_post->posts[0]->ID;

    $likeUsersList = get_field('like_user_relation', $post_Id);
    // var_dump($likeUsersList);
    foreach ($likeUsersList as $valueUserArray) {
        //echo "$valueUserArray <br>";
        $currentUserID = $valueUserArray->ID;
        // var_dump($currentUserID);
        if ( $user_post_id == $currentUserID) {
            $user_like_status = "true";
        }
        else {
            $user_like_status = "false";
        }

      }
    
    //var_dump($likeUsersList);
    //var_dump($the_query_user_like_comment_post->posts[0]->ID);
    
    // $os = $likeUsersList;
    // if (in_array($the_query_user_like_comment_post->posts[0]->ID, $os)) {
    //     echo "Got Irix";
    // } else {
    //     echo "not here";
    // }
    
    // $currentUserID = $likeUsersList[0]->post_title;
    // var_dump($currentUserID);
    //    var_dump($post_Id);
    // var_dump($currentUserID);
    

    // var_dump($currentUserID);

    

    
 
?>
<ul class="nav nav-custom-like-comment">
    <li class="nav-item">
        
        <button class="btn btn-like-01 <?php echo $user_like_status  === 'true' ?  "liked" : "like-btn" ?>" id="btnLikePost">
            <i class="fa-regular fa-heart far"></i> 
            <i class="fa-solid fa-heart fas"></i>
            <span class="">اعجبني</span>
        </button>


    </li>
    <li class="nav-item">
        <!-- <div class="custom-select-wrapper"> -->
            <select class="form-control" id="comments-list">
                <!-- <option value="0">اضف تعليق</option> -->
                <option value="1">شكله حلو اوي</option>
                <option value="2">لازم اجربه</option>
                <option value="3">سهل ولذيذ</option>
                <option value="4">عايزين وصفات زي ديه كتير</option>
                <option value="5">مش عاجبني</option>
            </select>
            
        <!-- </div> -->
    </li>
    <li class="nav-item">
        <button type="button" class="add-comment-btn">اضف التعليق</button>
    </li>
</ul>


<p class="errorMessage"></p>

