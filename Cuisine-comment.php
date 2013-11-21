<!--Display current cuisine Description-->
<?php if(isset($_GET['CuisineID']) && isset($_GET['CuisineName']) && isset($_GET['CurrentUserID'])){?>
    <input type="hidden" id="CommentCuisineID" value="<?php echo $_GET['CuisineID']?>">
    <input type="hidden" id="CommentCurrentUserID" value="<?php echo $_GET['CurrentUserID']?>">

    <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 class="text-center"><i style="color:#e46"><?php echo $_GET['CuisineName']?></i></h3>
        <div class="row-fluid">
            <div class="span12">
                <h4>
                    <ul class="inline CuisineCommentStarGroup">
                        <i style="color:#B4B4B4">Given stars</i>
                        <li><i class="fa CuisineCommentStar-given fa-star-o"></i></li>
                        <li><i class="fa CuisineCommentStar-given fa-star-o"></i></li>
                        <li><i class="fa CuisineCommentStar-given fa-star-o"></i></li>
                        <li><i class="fa CuisineCommentStar-given fa-star-o"></i></li>
                        <li><i class="fa CuisineCommentStar-given fa-star-o"></i></li>
                    </ul>
                </h4>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <textarea class="span12" id="cuisine-comment-area"></textarea>
                </div>
            </div>
            <div class="alert alert-info">
                Notes: you have to choose at least one star and give a comment above, otherwise the system will automately refuse process of submit.
            </div>
        </div>
        <section class="clearfix"><!--check section begins-->
            <div class="row-fluid">
                <div class="span12">
                    <div class="control-group text-center">
                        <button type="botton" class="mySubmit submitCuisineComment"><h5>Go</h5></button>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php }?>