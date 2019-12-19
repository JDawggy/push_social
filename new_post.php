<?php
session_start();

// is user logged in they can view the page if not they will be returned to the header function

if(!isset($_SESSION["user_id"])){
    header("Location: http://" . $_SERVER["SERVER_NAME"] . "/login.php"); //. "login.php" to get to a diffrent page and remove the ) after SERVER_NAME]
} 

include_once("header.php");

?>


<div class="container">
    
    <div class="col-12"><h1 class="mt-3 mb-2">New Post</h1></div>

    <?php include($_SERVER["DOCUMENT_ROOT"] . "/includes/error_check.php"); ?>
    <form action="/actions/create_post_action.php" method="post" enctype="multipart/form-data">

        <div class="form-group">

            <div class="input-icons">

                <input type="text" name="location" id="location" placeholder="Location" class="form-control rounded-pill in_index"> 
                <icon class="fas fa-map-marker-alt icon"></icon>
            </div>

            
        </div>

        <div class="form-group">
            <img class="post-preview imageDisplay mb-3" src="/images/placeholder.png" onclick="uploadPost()" alt="" id="postDisplay"> <br>

            <label class="btn btn-default btn-file mx-auto">

                <span class="upload-photo mt-3">Upload New Photo</span> 
                <input class="in_index" type="file" name="uploaded_image"  onchange="displayImage(this)" id="uploadedImage" style="display: none;">
            </label>
           
        </div>



        <div class="form-group">
            <textarea name="caption" id="caption" placeholder="Write something to go with your photo!" class="form-control form-rounded" rows="4"></textarea>
        </div>

        

        <button class="btn-warning thiccbtn rounded-pill" name="action" value="publish">Share!</button>



    
    </form>

        
    
</div>

<script src="scripts.js"></script>



<?php

require_once("footer.php");

?>