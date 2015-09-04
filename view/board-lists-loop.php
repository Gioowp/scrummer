<table class="listsGrid">
    <tr>
<?php

//print_r($_POST);


$args = ['post_type' => 'scrummer_list',
    'tax_query' => array(
        array(
            'taxonomy' => 'scrummer_board',
            'field' => 'id',
            'terms' => $_POST['boardid'],
        ),

    ),

    'orderby' => ['ID' => 'ASC'],
//    'orderby' => 'post_date',
//    'order'   => 'ASC',
];
$lists = new WP_Query( $args );

//print_r($args);
//print '<pre>';print_r($lists);

foreach($lists->posts as $v){ //print_r($v); ?>
    <td>
    <div class="boardList panel panel-default" listId="<?=$v->ID?>">

        <div class="panel-heading">
            <div class="pull-left"><?=$v->post_title?></div>

            <div class="btn-xs btn-success pull-right doAddNewListItem" id="dropdownMenu1" title="Add item to list" listId="<?=$v->ID?>">
                <span class="glyphicon glyphicon-plus"></span>
            </div>

            <div class="dropdown itemType pull-right">
                <div class="btn-xs btn-default" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="glyphicon glyphicon-chevron-down"></span>
                </div>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li class="doAddNewListItem"><span class="glyphicon glyphicon-plus"></span> Add Item </li>
                    <li><span class="glyphicon glyphicon-ok"></span> Mark as Done </li>
                    <li><span class="glyphicon glyphicon-remove"></span> Delete List </li>
                </ul>
            </div>

        </div>



<?php $_POST['listId'] = $v->ID;
        print getItems();
 ?>

    </div>

    </td>
<?php } ?>
    </tr>
</table>
