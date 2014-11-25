<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from bucketadmin.themebucket.net/login.html by HTTrack Website Copier/3.x [XR&CO'2010], Thu, 07 Aug 2014 04:57:49 GMT -->
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.html">

    <title>Login</title>

    <!--Core CSS -->
    <link href="<?=base_url("static")?>/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url("static")?>/css/bootstrap-reset.css" rel="stylesheet">
    <link href="<?=base_url("static")?>/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="<?=base_url("static")?>/css/style.css" rel="stylesheet">
    <link href="<?=base_url("static")?>/css/style-responsive.css" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="<?=base_url("static")?>/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">

      <form id="frmLogin" class="form-signin" method="POST" action="<?=SSO_SERVER;?>security/login_anev/login_usr">
        <h2 class="form-signin-heading">Login Aplikasi</h2>
        <div class="login-wrap">
            <div class="user-login-info">
                <input id="username" name="username" type="text" class="form-control" placeholder="User ID" autofocus>
                <input name="password" id="password" type="password" class="form-control" placeholder="Password">
            </div>
            <label class="checkbox hide">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>

            <div class="registration hide">
                Don't have an account yet?
                <a class="" href="registration.html">
                    Create an account
                </a>
            </div>

        </div>

          <!-- Modal -->
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Forgot Password ?</h4>
                      </div>
                      <div class="modal-body">
                          <p>Enter your e-mail address below to reset your password.</p>
                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                      </div>
                      <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                          <button class="btn btn-success" type="button">Submit</button>
                      </div>
                  </div>
              </div>
          </div>
          <!-- modal -->

      </form>

    </div>



    <!-- Placed js at the end of the document so the pages load faster -->

    <!--Core js-->
    <script src="<?=base_url("static")?>/js/jquery.js"></script>
    <script src="<?=base_url("static")?>/js/uri_encode_decode.js"></script>
    <script src="<?=base_url("static")?>/bs3/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#frmLogin").submit(function(e){
				param1 = jQuery("#username").val();	
				param2 = jQuery("#password").val();	
				if(param1.length==0) param1 ="6E756C6C";
				if(param2.length==0) param2 ="6E756C6C";
				param1 = DoAsciiHex(param1,"A2H");
				param2 = DoAsciiHex(param2,"A2H");
				e.preventDefault();
				$.ajax({
					url:$(this).attr('action')+"/"+param1+"/"+param2,
					//type: 'post',
					//dataType: 'json',
					
					success:function(result) {
						//alert(result.indexOf('http'));
						if (result.indexOf('http')>=0){
							$.ajax({
								url:"<?=SSO_SERVER;?>security/login_anev/get_session_info"+"/"+param1+"/"+param2,
								dataType: 'json',
								async : false,
								success:function(dataAccess){
									//alert(data[1]);
									$.ajax({
										url:'<?=base_url()?>login/create_session/',
										dataType:'json',
										type:'post',
										async : false,
										data:dataAccess,
										success:function(x){
										//	alert(x);
											window.location=result;
										}
									});
								}
							});	
							
							//window.location=result;
						}
						else
						  alert(result);
						//if (result<>'')
					}
				});
				//alert('kadieu '+$(this).attr('action'));
				
			});
		
		});
	</script>
  </body>

<!-- Mirrored from bucketadmin.themebucket.net/login.html by HTTrack Website Copier/3.x [XR&CO'2010], Thu, 07 Aug 2014 04:57:49 GMT -->
</html>
