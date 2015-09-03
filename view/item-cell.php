<?php



foreach($lists as $v){ ?>
    <div class="boardList panel panel-default">

        <div class="panel-heading">
            <div class="pull-left">list Name <?=$i?></div>



            <div class="btn-xs btn-success pull-right doAddNewListItem" id="dropdownMenu1" title="Add item to list">
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



        <?php for($j=1; $j<=rand(4,12); $j++){ ?>
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
                    <div class="itemTitle">Panel content Lorem Ipsum Like textes</div>
                    <div class="itemComments pull-right"><span class="glyphicon glyphicon-comment"></span> 3</div>
                    <div class="activeLabels"> </div>
                    <div class="activeMembers"> </div>
                </div>

            </div>
        <?php } ?>




    </div>

<?php } ?>