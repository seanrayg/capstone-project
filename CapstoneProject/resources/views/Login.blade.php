<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Login</title>
	<style>body{padding-top: 60px;}</style>
	
    <link href="/Login/bootstrap3/css/bootstrap.css" rel="stylesheet" />
 
	<link href="/Login/login-register.css" rel="stylesheet" />
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
	
	<script src="/Login/jquery/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="/Login/bootstrap3/js/bootstrap.js" type="text/javascript"></script>
	<script src="/Login/login-register.js" type="text/javascript"></script>
    
    <script>
    
        window.onload = function(){
            openLoginModal();
        }
    </script>

</head>
<body>
    <div class="container">

		 <div class="modal fade login" id="loginModal">
		      <div class="modal-dialog login animated">
    		      <div class="modal-content">
    		         <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                         <br>
                        <h4 class="modal-title text-center">Il Sogno Beach Resort Management System</h4>
                    </div>
                    <div class="modal-body">  
                        <div class="box">
                             <div class="content">
                                <div class="error"></div>
                                <div class="form loginBox">
                                    <form method="post" action="/login" accept-charset="UTF-8">
                                    <input id="email" class="form-control" type="text" placeholder="Email" name="email">
                                    <input id="password" class="form-control" type="password" placeholder="Password" name="password">
                                    <a href="/Dashboard"><input class="btn btn-default btn-login" type="button" value="Login"></a>
                                    </form>
                                </div>
                             </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>        
    		      </div>
		      </div>
		  </div>
    </div>
</body>
</html>
