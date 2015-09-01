<?php
/**
The template name: Scrummer List
 */


get_header(); ?>


<div class="row">

    <div class="col-lg-2 manageCol">
        <div class="btn btn-success col-lg-12 text-left">  <span class="glyphicon glyphicon-plus"></span> Create New Board</div>
        &nbsp;

        <?php for($i=1; $i<=4; $i++){ ?>
            <div class="panel-group boardManagers" >

                <div class="panel panel-default" id="panel1">
                    <div class="panel-heading">
                        <h4 class="panel-title"> Board <?=$i?> Name</h4>

                    </div>

                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="col-lg-12 btn btn-warning mb-5 text-left"><span class="glyphicon glyphicon-tasks"></span> Board</div>
                            <div class="col-lg-12 btn btn-warning mb-5 text-left"><span class="glyphicon glyphicon-stats"></span> Stats</div>
                            <div class="col-lg-12 btn btn-warning mb-5 text-left"><span class="glyphicon glyphicon-file"></span> Files</div>
                            <div class="col-lg-12 btn btn-warning mb-5 text-left"><span class="glyphicon glyphicon-user"></span> Team</div>
                            <div class="col-lg-12 btn btn-warning mb-5 text-left"><span class="glyphicon glyphicon-cog"></span> Config</div>



                        </div>
                    </div>
                </div>



            </div>
        <?php } ?>




    </div>
    <div class="col-lg-10 bodyCol">


        <?php for($i=1; $i<=4; $i++){ ?>
            <div class="boardList panel panel-default">

                <div class="panel-heading">
                    <div class="pull-left">list Name <?=$i?></div>



                    <div class="btn-xs btn-default pull-right doAddNewListItem" id="dropdownMenu1" title="Add item to list">
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
                    <div class="panel panel-success listItem">
                        <div class="panel-heading">


                            <div class="dropdown itemPoint pull-left">
                                <div class="btn-xs btn-default" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">TM</div>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><span class="glyphicon glyphicon-record"></span> 1 Point </li>
                                    <li><span class="glyphicon glyphicon-record"></span> 2 Point </li>
                                    <li><span class="glyphicon glyphicon-record"></span> 3 Point </li>
                                    <li><span class="glyphicon glyphicon-record"></span> 4 Point </li>
                                </ul>
                            </div>

                            <div class="dropdown itemType pull-left">
                                <div class="btn-xs btn-default" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">T</div>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><span class="glyphicon glyphicon-map-marker"></span> Improvement </li>
                                    <li><span class="glyphicon glyphicon-map-marker"></span> Bug </li>
                                    <li><span class="glyphicon glyphicon-map-marker"></span> Task </li>
                                    <li><span class="glyphicon glyphicon-map-marker"></span> Feature </li>
                                </ul>
                            </div>


                            <div class="dropdown itemPriority pull-left">
                                <div class="btn-xs btn-default" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">P</div>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><span class="glyphicon glyphicon-pushpin"></span> Low </li>
                                    <li><span class="glyphicon glyphicon-pushpin"></span> Normal </li>
                                    <li><span class="glyphicon glyphicon-pushpin"></span> High </li>
                                    <li><span class="glyphicon glyphicon-pushpin"></span> Urgent </li>
                                </ul>
                            </div>

                            <div class="dropdown itemValue pull-left">
                                <div class="btn-xs btn-default" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">V</div>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><span class="glyphicon glyphicon-pushpin"></span> 1 Value </li>
                                    <li><span class="glyphicon glyphicon-pushpin"></span> 2 Value </li>
                                    <li><span class="glyphicon glyphicon-pushpin"></span> 3 Value </li>
                                    <li><span class="glyphicon glyphicon-pushpin"></span> 4 Value </li>
                                </ul>
                            </div>


                            <div class="dropdown itemActions pull-left">
                                <div class="btn-xs btn-default" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><span class="glyphicon glyphicon-list-alt"></span> Show Item </li>
                                    <li><span class="glyphicon glyphicon-off"></span> Delete </li>
                                    <li><span class="glyphicon glyphicon-tags"></span> Clone </li>
                                    <li><span class="glyphicon glyphicon-ok"></span> Mark as Done </li>

                                </ul>
                            </div>



                            <div class="itemStatus pull-right"><span class="glyphicon glyphicon-ok"></span></div>
                            <div class="itemComments pull-right"><span class="glyphicon glyphicon-comment"></span>3</div>
                        </div>

                        <div class="panel-body">
                            Panel content Lorem Ipsum Like textes
                        </div>

                    </div>
                <?php } ?>




            </div>

        <?php } ?>



    </div>



</div>



<div class="listItemForm panel panel-default">
    <div class="panel-body">
        <form>

            <div class="panel panel-primary">
                <div class="panel-heading">Item Text</div>
                <div class="panel-body">
                    <textarea name="new-item" style="border:none; height:100px;"></textarea>
                </div>
            </div>


            <div class="panel panel-primary">
                <div class="panel-heading">Add Attachmen</div>
                <div class="panel-body">


            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">From URL</button>
                </span>
                <input type="text" class="form-control" placeholder="Search for...">
            </div>

            <label class="btn btn-success col-lg-12 mt-15" for="my-file-selector">
                <input id="my-file-selector" type="file" style="display:none;">
                From computer
            </label>

                </div>


            </div>


            <div class="panel panel-primary">
                <div class="panel-body">


                    <div class="dropdown itemPoint pull-left mr-5">
                        <div class="btn btn-primary" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">1 Point</div>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><span class="glyphicon glyphicon-record"></span> 1 Point </li>
                        </ul>
                    </div>

                    <div class="dropdown itemPoint pull-left mr-5">
                        <div class="btn btn-primary" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">1 Point</div>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><span class="glyphicon glyphicon-record"></span> 1 Point </li>
                        </ul>
                    </div>

                    <div class="dropdown itemPoint pull-left mr-5">
                        <div class="btn btn-primary" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">1 Point</div>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><span class="glyphicon glyphicon-record"></span> 1 Point </li>
                        </ul>
                    </div>

                    <div class="dropdown itemPoint pull-left mr-5">
                        <div class="btn btn-primary" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">1 Point</div>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><span class="glyphicon glyphicon-record"></span> 1 Point </li>
                        </ul>
                    </div>

                    <div class="dropdown itemPoint pull-left mr-5">
                        <div class="btn btn-primary" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">1 Point</div>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><span class="glyphicon glyphicon-record"></span> 1 Point </li>
                        </ul>
                    </div>

                    <div class="dropdown itemPoint pull-left mr-5">
                        <div class="btn btn-primary" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">1 Point</div>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><span class="glyphicon glyphicon-record"></span> 1 Point </li>
                        </ul>
                    </div>


                    <div class="btn btn-primary">1 hr.</div>
                    <div class="btn btn-primary">Bug</div>
                    <div class="btn btn-primary">Normal</div>
                    <div class="btn btn-primary">1 value</div>
                    <div class="btn btn-primary">Label</div>
                    <div class="btn btn-primary">Members</div>



                </div>


            </div>


            <input type="submit" value="Save" class="btn btn-primary">
        </form>
    </div>
</div>





<?php get_footer(); ?>

