<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!-- Include the above in your HEAD tag -->

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<div class="main">
    
	<style>
	@charset "utf-8";
	@import url//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css);

	div.main{
		background: #0264d6; /* Old browsers */
		background: -moz-radial-gradient(center, ellipse cover,  #0264d6 1%, #1c2b5a 100%); /* FF3.6+ */
		background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(1%,#0264d6), color-stop(100%,#1c2b5a)); /* Chrome,Safari4+ */
		background: -webkit-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%); /* Chrome10+,Safari5.1+ */
		background: -o-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%); /* Opera 12+ */
		background: -ms-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%); /* IE10+ */
		background: radial-gradient(ellipse at center,  #0264d6 1%,#1c2b5a 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0264d6', endColorstr='#1c2b5a',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
		/* height:calc(100vh); */
		width: 100%;
		height: 100%;
	}

	[class*="fontawesome-"]:before {
	  font-family: 'FontAwesome', sans-serif;
	}

	/* ---------- GENERAL ---------- */

	* {
	  box-sizing: border-box;
		margin:0px auto;

	  &:before,
	  &:after {
		box-sizing: border-box;
	  }

	}

	body {
		color: #606468;
		font: 87.5%/2.5em 'Open Sans', sans-serif;
		margin: 0;
	}

	a {
		color: #eee;
		text-decoration: none;
	}

	a:hover {
		text-decoration: underline;
	}

	input, select {
		border: none;
		font-family: 'Open Sans', Arial, sans-serif;
		font-size: 14px;
		line-height: 1.5em;
		padding: 0;
		-webkit-appearance: none;
	}

	p {
		line-height: 1.5em;
	}

	.clearfix {
	  *zoom: 1;

	  &:before,
	  &:after {
		content: ' ';
		display: table;
	  }

	  &:after {
		clear: both;
	  }

	}

	.container {
	  left: 50%;
	  position: fixed;
	  top: 50%;
	  transform: translate(-50%, -50%);
	}

	/* ---------- LOGIN ---------- */

	#login form{
		width: 250px;
	}
	#login, .logo{
		display:inline-block;
		width:40%;
	}
	#login{
	border-right:1px solid #fff;
	  padding: 0px 22px;
	  width: 59%;
	}
	.logo{
	color:#fff;
	font-size:50px;
	  line-height: 125px;
	}

	#login form span.fa {
		background-color: #fff;
		border-radius: 3px 0px 0px 3px;
		color: #000;
		display: block;
		float: left;
		height: 50px;
		font-size:24px;
		line-height: 50px;
		text-align: center;
		width: 50px;
	}

	#login form input, #login form select	 {
		height: 50px;
	}
	fieldset{
		padding:0;
		border:0;
		margin: 0;

	}
	#login form input[type="text"], input[type="password"], select {
		background-color: #fff;
		border-radius: 0px 3px 3px 0px;
		color: #000;
		margin-bottom: 1em;
		padding: 0 16px;
		width: 200px;
	}

	#login form input[type="submit"] {
	  border-radius: 3px;
	  -moz-border-radius: 3px;
	  -webkit-border-radius: 3px;
	  background-color: #000000;
	  color: #eee;
	  font-weight: bold;
	  /* margin-bottom: 2em; */
	  text-transform: uppercase;
	  padding: 5px 10px;
	  height: 30px;
	}

	#login form input[type="submit"]:hover {
		background-color: #d44179;
	}

	#login > p {
		text-align: center;
	}

	h2, h4 {
		color: whitesmoke;
		font-weight: 700;
	}
	p {
		color: whitesmoke;
	}

	#login > p span {
		padding-left: 5px;
	}
	.middle {
	  display: flex;
	  width: 600px;
	}
	</style>
    <div class="container">
		<center>
			<div class="middle">
				<div id="login">
				
					<form action="<?php echo $helper->url("Login","login"); ?>" method="post">
						<fieldset class="clearfix">
							<p>
								<h4>Tipo de Identificacion</h4>
								<span class="fa fa-user"></span>
								<select class="form-controls" name="identification_type" required>
									<option value="">Seleccione una option.</option>
									<?php foreach($options->types_identifications as $type_identification) {
									echo "<option value=\"{$type_identification->id}\">
										{$type_identification->code} - {$type_identification->name}
									</option>";
									} ?>
								</select>
							</p>
							<p>
								<h4># Documento</h4>
								<span class="fa fa-user"></span>
								<input name="identification_number" type="text"  Placeholder="# Documento" required autocomplete="off" />
							</p>
							<div>
								<span style="width:48%; text-align:left;  display: inline-block;">
									<a class="small-text" href="#">
										Olvidaste tu contraseña?
									</a>
								</span>
								<span style="width:50%; text-align:right;  display: inline-block;">
									<input type="hidden" name="controller" value="Login">
									<input type="hidden" name="view" value="login">
									<input type="submit" value="Continuar">
								</span>
							</div>
						</fieldset>
						<div class="clearfix"></div>
					</form>
					<div class="clearfix"></div>
				</div>
				
				<div>
					<img src="/crm-content/uploads/login-graphic-woman-using-app.png" style="width: 100%;" />
					
					<h2><?php echo $title; ?></h2>
					<div class="clearfix"></div>
				</div>
			</div>
		</center>
	</div>
</div>