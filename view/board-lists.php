<?php
/**
The template name: Scrummer List
 */


get_header(); ?>


<div class="row scrumBoardContainer" >

    <div class="manageCol">

        <div class="btn btn-success col-lg-12 text-left doAddNewBoard">  <span class="glyphicon glyphicon-plus"></span> Create New Board</div>
        &nbsp;

        <?php $boards = getBoards(); foreach($boards as $v){ //print_r($v); ?>
            <div class="panel-group boardManagers" boardId="<?=$v->term_id?>" >

                <div class="panel panel-default" id="panel1">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=$v->name?></h4>
                    </div>

                    <div id="collapseOne" class="panel-collapse collapse in boardSettings" boardId="<?=$v->term_id?>">
                        <div class="panel-body">
                            <div class="col-lg-12 btn btn-success mb-5 text-left doAddNewList" title="Add new list to the board....">
                                <span class="glyphicon glyphicon-plus"></span> Add list
                            </div>

                            <div class="col-lg-12 btn btn-warning mb-5 text-left"><span class="glyphicon glyphicon-tasks"></span> Board</div>
                            <div class="col-lg-12 btn btn-warning mb-5 text-left"><span class="glyphicon glyphicon-stats"></span> Stats</div>
                            <div class="col-lg-12 btn btn-warning mb-5 text-left"><span class="glyphicon glyphicon-file"></span> Files</div>



                        </div>
                    </div>
                </div>



            </div>
        <?php } ?>
    </div>

    <div class="bodyCol" boardId=""></div>

</div>

<div class="boardForm panel panel-default">
    <div class="panel-body">

        <form method="post" id="boardForm">


            <input type="hidden" name="action" value="ajaxactions">
            <input type="hidden" name="whattodo" value="saveBoard">
            <div class="panel panel-primary">
                <div class="panel-heading">Board title</div>
                <div class="panel-body">
                    <input name="new-board-title" style="border:none; width:100%;" />
                </div>
            </div>


            <input type="submit" value="Save" class="btn btn-primary">
        </form>
    </div>
</div>

<div class="listForm panel panel-default">
    <div class="panel-body">
        <form method="post" id="listForm">
<input type="hidden" name="action" value="ajaxactions">
<input type="hidden" name="whattodo" value="saveList">
            <div class="panel panel-primary">
                <div class="panel-heading">List title</div>
                <div class="panel-body">
                    <input name="new-list-title" style="border:none; width: 100%;" />
                </div>
            </div>


            <div class="panel panel-primary listItem col-lg-12">
                <div class="panel-body">


                    <div class="dropup itemValue pull-left mb-15">
                        <div class="btn btn-success doDropDown" type="button" id="dropdownMenu1" aria-haspopup="true" aria-expanded="true">List responsible members</div>
                        <?=membersBox()?>
                    </div>

                    <div class="activeMembers pull-left col-lg-12 mt-10"> </div>


                </div>


            </div>


            <input type="submit" value="Save" class="btn btn-primary">
        </form>
    </div>
</div>

<div class="listItemForm panel panel-default">
    <div class="panel-body">
        <form method="post" id="itemForm">
            <input type="hidden" name="action" value="ajaxactions">
            <input type="hidden" name="whattodo" value="saveItem">

            <div class="panel panel-primary">
                <div class="panel-heading">Item Text</div>
                <div class="panel-body">
                    <textarea name="new-item" style="border:none; height:100px;"></textarea>
                </div>
            </div>


            <div class="panel panel-primary">
                <div class="panel-heading">Add Attachmen</div>
                <div class="panel-body">


                    <div class="input-group col-lg-5 pull-left">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">From URL</button>
                        </span>
                        <input type="text" class="form-control" placeholder="Search for...">
                    </div>

                    <label class="btn btn-success col-lg-5 pull-right" for="my-file-selector">
                        <input id="my-file-selector" type="file" style="display:none;">
                        From computer
                    </label>

                </div>


            </div>


            <div class="panel panel-primary listItem col-lg-12">
                <div class="panel-body">


                    <div class="dropup itemValue pull-left mr-10" title="Set labels">
                        <div class="btn btn-success doDropDown" type="button" id="dropdownMenu1" aria-haspopup="true" aria-expanded="true">LAbels</div>
                        <?=labelsBox()?>
                    </div>

                    <div class="dropup itemValue pull-left">
                        <div class="btn btn-success doDropDown" type="button" id="dropdownMenu1" aria-haspopup="true" aria-expanded="true">Members</div>
                        <?=membersBox()?>
                    </div>
                    <div class="activeLabels"> </div>
                    <div class="activeMembers"> </div>


                </div>


            </div>


            <input type="submit" value="Save" class="btn btn-primary">
        </form>
    </div>
</div>

<div class="commentForm panel panel-default">
        <div class="panel-body">
            <form method="post" id="itemCommentForm">
                <input type="hidden" name="action" value="ajaxactions">
                <input type="hidden" name="whattodo" value="commentItem">

<div class="row">
    <div class="col-lg-9">
        <div class="alert alert-info" role="alert">Item text....</div>

        <div class="activeLabels"> </div>
        <div class="activeMembers"> </div>
        <div class="attachments"> </div>
        <div class="col-lg-12 mb-15">
            <textarea placeholder="Write a comment" class="commentText"></textarea>
            <div class="btn btn-success doNewComment">Comment....</div>
        </div>

        <div class="commentsList"> </div>
    </div>

    <div class="col-lg-3">


        <div class="dropup itemValue pull-left col-lg-12" title="Set labels">
            <div class="btn btn-success doDropDown col-lg-12" type="button" id="dropdownMenu1" aria-haspopup="true" aria-expanded="true">LAbels</div>
            <?=labelsBox()?>
        </div>

        <div class="dropup itemValue pull-left col-lg-12">
            <div class="btn btn-success doDropDown col-lg-12" type="button" id="dropdownMenu1" aria-haspopup="true" aria-expanded="true">Members</div>
            <?=membersBox()?>
        </div>

        <h3>Add Attachmen</h3>
        <div class="input-group col-lg-12 pull-left">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">From URL</button>
            </span>
            <input type="text" class="form-control" placeholder="Search for...">
        </div>

        <label class="btn btn-success col-lg-12 pull-right" for="my-file-selector">
            <input id="my-file-selector" type="file" style="display:none;">
            From computer
        </label>
    </div>

</div>


            </form>
        </div>
    </div>




<?php get_footer(); ?>