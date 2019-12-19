
<html>
    <head>
    
        <title></title>

        
        <link rel="stylesheet" href="/styles.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">

        <script src="https://kit.fontawesome.com/ea81b73834.js" crossorigin="anonymous"></script>


    </head>
    <body>
        <div class="loginImage">
        <div class="container container-size">

            <div class="row row-size">
                <div class="col-1"></div>
                <div class="col-10 center-position">

                    <div class="background-white">
                        <div class="col-12">
                            <h2 class="mb-4 create">Create an Account!</h2>
                        </div>
                        










                        <!-- Register form  -->
                        <form action="/login.php" method="POST"> 
            
            
                            <!-- First Name -->
                            <div class="row mb-2 mt-3">
                            <div class="form-group col-md-6"> 
                                <div class="input-icons">
                                    <i class="fas fa-user"></i>
                                    <input class="rounded-pill form-control in_log" type="text" name="first_name" placeholder="First Name" value="<?=( isset($_REQUEST["first_name"]) ) ? $_REQUEST["first_name"] : "";?>" required>                
                                </div>
                            </div>
            
            
                            <!-- Last Name -->
                            <div class="form-group col-md-6"> 
                                <div class="input-icons">
                                    <i class="fas fa-user"></i>
                                    <input class="rounded-pill form-control in_log" type="text" name="last_name" placeholder="Last Name" value="<?=( isset($_REQUEST["last_name"]) ) ? $_REQUEST["last_name"] : "";?>" required>
                                </div>
                            </div> <!-- end of form group -->
                            </div> <!-- end of row -->
                    
                            
            
            
            
                            <!-- Email -->
                            <div class="row mb-2">
                            <div class="form-group col-md-6"> 
                                <div class="input-icons">
                                    <i class="fas fa-envelope"></i>
                                    <input class="rounded-pill form-control in_log" type="email" name="email" placeholder="Email" value="<?=( isset($_REQUEST["email"]) ) ? $_REQUEST["email"] : "";?>" required>                 
                                </div>
                            </div>
            
                        
                            <!-- Confirm Email -->
                            <div class="form-group col-md-6"> 
                                <div class="input-icons">
                                    <i class="fas fa-envelope"></i>
                                    <input class="rounded-pill form-control in_log" type="email" name="email2" placeholder="Confirm Email" value="<?=( isset($_REQUEST["email2"]) ) ? $_REQUEST["email2"] : "";?>" required>  
                                </div>               
                            </div> <!-- end of form group -->
                            </div> <!-- end of row -->
                            
            
            
                            
                        
                            <!-- Password -->
                            <div class="row mb-3">
                            <div class="form-group col-md-6">                                              
                                <div class="input-icons">
                                    <i class="fa fa-lock"></i>
                                    <input class="rounded-pill form-control in_log" type="password" name="password" placeholder="Password" value="" required>          
                                </div>
                            </div>
                            
            
                            <!-- Confirm Password -->
                            <div class="form-group col-md-6">                                               
                                <div class="input-icons">
                                    <i class="fa fa-lock"></i>
                                    <input class="rounded-pill form-control in_log" type="password" name="password2" placeholder="Confirm Password" value="" required>  
                                </div>
                            </div> <!-- end of form group -->
                            </div> <!-- end of row -->
                            
            
                            <!-- Sumbit button for register form -->
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="form-group col-md-6"> 






                                    <button class="btn register-button btn-warning rounded-pill form-control" name="action" value="signup" type="submit">Sign Up</button>





                                </div>
                                <div class="col-md-3"></div>
                            </div>
            
                        </form> <!-- Register form -->
                    </div>
                </div>
                <div class="col-1"></div>
            </div>
            
            
        </div> <!-- Container div -->
        </div> <!-- photo div -->
        
    </body>
</html>