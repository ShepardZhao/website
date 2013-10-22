
<?php
//getCSSId
$getCssId=$_POST['CssId'];

if (isset($getCssId)){

?>
<div class="row-fluid <?php echo $getCssId;?>">
<div class="span12 ">
    <ul class="nav nav-pills nav-stacked commentMarginBottom">
        <li>

            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="">
                </a>
                <div class="media-body">
                    <h5 class="media-heading">Media heading</h5>
                    <h6>Commnets on: 2/7/2013</h6>
                    <p>
                        Cras sit amet nibh libero, in gravida nul
                    </p>

                    <ul class="inline inlineLeftPadding">
                        <li><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i></li>
                        <li><i class="icon-thumbs-up-alt"></i></li>
                        <li><i class="icon-thumbs-down-alt"></i></li>
                    </ul>
                </div>
            </div>
        </li>



        <li>
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" data-src="assets/framework/img/pic.jpeg">
                </a>
                <div class="media-body">
                    <h5 class="media-heading">Media heading</h5>
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    <ul class="inline inlineLeftPadding">
                        <li><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i></li>
                        <li><i class="icon-thumbs-up-alt"></i></li>
                        <li><i class="icon-thumbs-down-alt"></i></li>
                    </ul>
                </div>
            </div>





        </li>

        </li>
    </ul>
</div>
</div>

<?php }
else {
?>
    <div class="row-fluid">

    <div class="span12 ">
        <ul class="nav nav-pills nav-stacked commentMarginBottom">
            <li>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="">
                    </a>
                    <div class="media-body">
                        <h5 class="media-heading">Media heading</h5>
                        <h6>Commnets on: 2/7/2013</h6>
                        <p>
                            Cras sit amet nibh libero, in gravida nul
                        </p>

                        <ul class="inline inlineLeftPadding">
                            <li><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i></li>
                            <li><i class="icon-thumbs-up-alt"></i></li>
                            <li><i class="icon-thumbs-down-alt"></i></li>
                        </ul>
                    </div>
                </div>
            </li>



            <li>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" data-src="assets/framework/img/pic.jpeg">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Media heading</h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        <ul class="inline inlineLeftPadding">
                            <li><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i></li>
                            <li><i class="icon-thumbs-up-alt"></i></li>
                            <li><i class="icon-thumbs-down-alt"></i></li>
                        </ul>
                    </div>
                </div>





            </li>

            </li>
        </ul>
    </div>
    </div>


<?php  }?>
