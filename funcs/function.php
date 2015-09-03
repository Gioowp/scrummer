<?php

//function getters
function getBoards(){

    $taxonomies = ['scrummer_board'];

    $args = array(
        'orderby'           => 'name',
        'order'             => 'ASC',
        'hide_empty'        => false,
        'exclude'           => array(),
        'exclude_tree'      => array(),
        'include'           => array(),
        'number'            => '',
        'fields'            => 'all',
        'slug'              => '',
        'parent'            => '',
        'hierarchical'      => true,
        'child_of'          => 0,
        'childless'         => false,
        'get'               => '',
        'name__like'        => '',
        'description__like' => '',
        'pad_counts'        => false,
        'offset'            => '',
        'search'            => '',
        'cache_domain'      => 'core'
    );

    $terms = get_terms($taxonomies, $args);

    return $terms;
//    print_r($terms);

}


function getLists(){
    return __file_part( ['file'=>'board-lists-loop', 'dir'=>'view','plugin'=>'scrummer'] );
}

/////////////////////
////// widgets
function labelsBox($params=''){
    $params = __params("tax=&");

    $colors = presetParams('color');


    $ret = '';
    foreach($colors as $v){

        $ret .= "<div style='background:#{$v}' class='labelRow' hexcode='{$v}'>
                    <input type='text' value='' />
                    <div class='labelStatus glyphicon glyphicon-ok pull-right'></div>
            </div>";

    }

    return "<div class='dropdown-menu labelBox'>
                <h3>Set Labels</h3>
                {$ret}
                <div class='doCloseDropdown btn btn-success pull-left'>Close</div>
                <div class='note pull-right'>Click color to edit</div>
            </div>";
}

function membersBox($params=''){
    $params = __params("tax=&");

    $members = ['Member One', 'Member tWo'];


    $ret = '';
    foreach($members as $k=>$v){
        $tmp = explode(' ', $v);
        $abreviation = strtoupper( substr(trim($tmp[0]),0,1) ).strtoupper( substr(trim($tmp[1]),0,1) );
        $ret .= "<div class='memberRow' memberId='{$k}'>
                    <div class='memberAbreviation' memberId='{$k}' title='{$v}'>{$abreviation}</div>
                    <div class='memberTitle'>{$v}</div>
                    <div class='memberStatus glyphicon glyphicon-ok pull-right'></div>
            </div>";

    }

    return "<div class='dropdown-menu memberBox'>
                <h3>Set Members</h3>
                {$ret}
                <div class='doCloseDropdown btn btn-success pull-left'>Close</div>
            </div>";
}


///////////////////
function saveComment(){

}

function saveItem(){

}

function saveAttachment(){

}

function saveList(){
    print_r($_POST);
    $tmp = explode(',',$_POST['members']);

    $members = [];
    foreach($tmp as $v){
        if(empty($v))continue;
        $members[] = $v;
    }

    $post = array(
//        'ID'             => [ <post id> ] // Are you updating an existing post?
  'post_content'   => $_POST['new-list-title'],
  'post_name'      => $_POST['new-list-title'],
  'post_title'     => $_POST['new-list-title'],
  'post_status'    => 'publish',
  'post_type'      => 'scrummer_list',

);

    $listId = wp_insert_post( $post );
    update_post_meta($listId, 'members', $members);

    wp_set_post_terms( $listId, [$_POST['board']], 'scrummer_board' );

    return $listId;


}

function saveBoard(){
//    print_r($_POST);
    if(!chek_val($_POST, 'new-board-title'))return false;

    $term = strip_tags($_POST['new-board-title']);

    $ar = get_term_by( 'name', $term, 'scrummer_board', ARRAY_A );

//    print_r($ar);
    if(isset($ar['term_id'])){
        return "Ooops... <br /> Board with name {$term} already exists. <br /> Try another one!";
    }

    wp_insert_term( $term, 'scrummer_board' );
    return "All is Ok <br /> New board created";
}




function getAttribute($params=''){
    $params = __params("tax=&");




}



///////////////

function presetParams($type=''){
    if($type=='color') {
        return $colors = ['16a085', '27ae60', '2980b9', '8e44ad', '2c3e50', 'f39c12', 'd35400', 'c0392b', 'bdc3c7', '7f8c8d'];
    }

    return false;

}





/////////////////////////////////////////////////////
add_action('wp_ajax_nopriv_ajaxactions', 'ajaxActions');
add_action('wp_ajax_ajaxactions', 'ajaxActions');

function ajaxActions() {

    if(isset($_POST['whattodo']) && function_exists($_POST['whattodo'])){
        print call_user_func($_POST['whattodo']);
    }

    exit;
    die(); // this is required to return a proper result
}


function loadScrummerPostTypes(){

///// post types
    $args = array(
        'label'               => __( 'Scrummer List', 'text_domain' ),
        'description'         => __( 'Scrummer List Description', 'text_domain' ),
        'supports'            => array( ),
        'taxonomies'          => array( 'scrummer_board' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'show_in_admin_bar'   => false,
        'show_in_nav_menus'   => false,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'scrummer_list', $args );



    $args = array(
        'label'               => __( 'Scrummer Item', 'text_domain' ),
        'description'         => __( 'Scrummer Item Description', 'text_domain' ),
        'supports'            => array( ),
        'taxonomies'          => array( 'scrummer_board' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'show_in_admin_bar'   => false,
        'show_in_nav_menus'   => false,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'scrummer_item', $args );


////// taxonomies
    $args = [
        'hierarchical'          => true,
        'labels'                =>['menu_name'=>'Board','name'=>'Board'],
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'scrummer_board' ),
    ];
    register_taxonomy( 'scrummer_board', ['scrummer_list'], $args );



//    $args = [
//        'hierarchical'          => false,
//        'labels'                =>['menu_name'=>'Type','name'=>'Type'],
//        'show_ui'               => true,
//        'show_admin_column'     => true,
//        'update_count_callback' => '_update_post_term_count',
//        'query_var'             => true,
//        'rewrite'               => array( 'slug' => 'scrummer_type' ),
//    ];
//    register_taxonomy( 'scrummer_type', ['scrummer_item'], $args );

//    $args = [
//        'hierarchical'          => false,
//        'labels'                =>['menu_name'=>'Priority','name'=>'Priority'],
//        'show_ui'               => true,
//        'show_admin_column'     => true,
//        'update_count_callback' => '_update_post_term_count',
//        'query_var'             => true,
//        'rewrite'               => array( 'slug' => 'scrummer_priority' ),
//    ];
//    register_taxonomy( 'scrummer_priority', ['scrummer_item'], $args );
//


}

