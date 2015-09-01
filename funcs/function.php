<?php


function saveComment(){

}

function saveItem(){

}

function saveAttachment(){

}


function saveBoard(){

}




function getAttribute($params=''){
    $params = __params("tax=&");




}









/////////////////////////////////////////////////////
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
        'hierarchical'          => false,
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

