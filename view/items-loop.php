<?php

//print_r($_POST);

$args = ['post_type' => 'scrummer_item',
    'meta_query' => [
        [
            'key' => 'scrummer_list',
            'value' => $_POST['listId'],
        ]
    ],
    'orderby' => ['menu_order'=>'ASC', 'ID' => 'ASC' ],
];
$items = new WP_Query( $args );

foreach($items->posts as $v){ ?>
    <div class="panel panel-info listItem">
        <div class="panel-heading">


            <div class="pull-left mr-5 doSetDate">
                <div class="btn-xs btn-default dueDate" type="button" title="Due date">Due date</div>
                <input type="text" class="dateBuffer" >
            </div>

            <div class="dropdown itemValue pull-left" title="Set labels">
                <div class="btn-xs btn-warning doDropDown" type="button" id="dropdownMenu1" aria-haspopup="true" aria-expanded="true">L</div>
                <?=labelsBox()?>
            </div>

            <div class="dropdown itemValue pull-left">
                <div class="btn-xs btn-default doDropDown" type="button" id="dropdownMenu1" aria-haspopup="true" aria-expanded="true">Members</div>
                <?=membersBox()?>
            </div>


            <div class="dropdown itemActions pull-left">
                <div class="btn-xs btn-default" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="glyphicon glyphicon-th"></span>
                </div>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><span class="glyphicon glyphicon-list-alt"></span> Show Item </li>
                    <li><span class="glyphicon glyphicon-off"></span> Delete </li>
                    <li><span class="glyphicon glyphicon-tags"></span> Copy </li>

                </ul>
            </div>



        </div>

        <div class="panel-body">
            <div class="itemTitle" itemId="<?=$v->ID?>"><?=$v->post_content?></div>
            <div class="itemComments pull-right"><span class="glyphicon glyphicon-comment"></span> 3</div>
            <div class="activeLabels"> </div>
            <div class="activeMembers"> </div>
        </div>

    </div>
<?php }

?>