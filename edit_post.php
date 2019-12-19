<?php
session_start();

// is user logged in they can view the page if not they will be returned to the header function

if(!isset($_SESSION["user_id"])){
    header("Location: http://" . $_SERVER["SERVER_NAME"] . "/login.php"); //. "login.php" to get to a diffrent page and remove the ) after SERVER_NAME]
} 

include_once("header.php");

?>


<div class="container">
    
    <div class="col-12"><h1 class="mt-3 mb-2">Edit Post</h1></div>

    <?php include($_SERVER["DOCUMENT_ROOT"] . "/includes/error_check.php"); ?>




    <form action="/actions/update_post_action.php" method="post" enctype="multipart/form-data">
        <?php
        $photo_url = $_GET["featured_image"];
        $photo_caption = $_GET["caption"];
        $photo_location = $_GET["place"];
        $photo_id = $_GET["post_id"];
        ?>

        <div class="form-group">

            <input type="hidden" name="post_id" value="<?= $photo_id ?>"> 

            <div class="input-icons">
                
                <input type="text" name="location" id="location" value="<?= $photo_location ?>" class="form-control rounded-pill in_index"> 
                <icon class="fas fa-map-marker-alt icon"></icon>

            </div>

            
        </div>

        <div class="form-group">
            <img class="post-preview imageDisplay mb-3" src="<?= $photo_url ?>" alt="" id="postDisplay"> <br>
        </div>



        <div class="form-group">
            <textarea name="caption" id="caption" class="form-control form-rounded" rows="4"><?= $photo_caption ?></textarea>
        </div>

        

        <button class="btn-warning thiccbtn rounded-pill" name="action" value="update">Update!</button>



    
    </form>

        
    
</div>

<script src="scripts.js"></script>



<?php

require_once("footer.php");

?>