<?php

//print_r($_POST);

$args = array(
//    'author_email' => '',
//    'author__in' => '',
//    'author__not_in' => '',
//    'include_unapproved' => '',
//    'fields' => '',
//    'ID' => '',
//    'comment__in' => '',
//    'comment__not_in' => '',
//    'karma' => '',
//    'number' => '',
//    'offset' => '',
//    'orderby' => '',
//    'order' => 'DESC',
//    'parent' => '',
//    'post_author__in' => '',
//    'post_author__not_in' => '',
//    'post_ID' => '', // ignored (use post_id instead)
    'post_id' => $_POST['itemid'],
//    'post__in' => '',
//    'post__not_in' => '',
//    'post_author' => '',
//    'post_name' => '',
//    'post_parent' => '',
//    'post_status' => '',
//    'post_type' => '',
//    'status' => 'all',
//    'type' => '',
//    'type__in' => '',
//    'type__not_in' => '',
//    'user_id' => '',
//    'search' => '',
//    'count' => false,
//    'meta_key' => '',
//    'meta_value' => '',
//    'meta_query' => '',
//    'date_query' => null, // See WP_Date_Query
);

$comments = get_comments( $args );
//print_r($comments);

foreach($comments as $v){
$abreviation = strtoupper(substr($v->comment_author,0,2));
    ?>
    <div class="col-lg-12 mb-10">
        <div class="member author pull-left"><div class="memberAbreviation"><?=$abreviation?></div></div>
        <div class="commntContent pull-left"><?=$v->comment_content?></div>
    </div>
<?php }

?>