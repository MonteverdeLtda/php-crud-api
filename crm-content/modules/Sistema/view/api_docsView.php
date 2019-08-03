
	<mv:login-button scope="email" onlogin="checkLoginState();">
	</mv:login-button>


	<div id="status">
	</div>
	<div id="docs">
	</div>
    <!-- // <redoc spec-url='https://api.monteverdeltda.com/openapi'></redoc> -->
    <script src="https://cdn.jsdelivr.net/npm/redoc@next/bundles/redoc.standalone.js"> </script>
	<script>
	document.getElementById('status').innerHTML = 'Welcome!  Fetching your information.... ';

	Redoc.init('/openapi?core=api', {
	  scrollYOffset: 50
	}, document.getElementById('docs'))
	</script>