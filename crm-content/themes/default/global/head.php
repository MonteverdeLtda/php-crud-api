
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>CMS  | </title>

    <!-- Bootstrap -->
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo $this->urlNav; ?>/assets/build/css/custom.min.css" rel="stylesheet">

    <!-- bootstrap-datetimepicker -->
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <!-- Ion.RangeSlider -->
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/normalize-css/normalize.css" rel="stylesheet">
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/ion.rangeSlider/css/ion.rangeSlider.css" rel="stylesheet">
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet">
    <!-- Bootstrap Colorpicker -->
    <link href="<?php echo $this->urlNav; ?>/assets/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">

    <link href="<?php echo $this->urlNav; ?>/assets/vendors/cropper/dist/cropper.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.0.2/vue-router.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
	
	<script>
		var api = axios.create({
			baseURL: '/',
			withCredentials: true,
			headers: {
				'X-CORE': 'api'
			}
		});
		api.interceptors.response.use(function (response) {
		  if (response.headers['<?php echo API_xsrf_headerName; ?>']) {
			document.cookie = '<?php echo API_xsrf_cookieName; ?>=' + response.headers['<?php echo API_xsrf_headerName; ?>'] + '; path=/';
			console.log('Cookie');
			console.log(document.cookie);
		  }
		  return response;
		});

		var util = {
		  methods: {
			resolve: function (path, obj) {
			  return path.reduce(function(prev, curr) {
				return prev ? prev[curr] : undefined
			  }, obj || this);
			},
			getDisplayColumn: function (columns) {
			  var index = -1;
			  var names = ['name', 'title', 'description', 'username'];
			  for (var i in names) {
				index = columns.indexOf(names[i]);
				if (index >= 0) {
				  return names[i];
				}
			  }
			  return columns[0];
			},
			getPrimaryKey: function (properties) {
			  for (var key in properties) {
				if (properties[key]['x-primary-key']) {
				  return key;
				}
			  }
			  return false;
			},
			getReferenced: function (properties) {
			  var referenced = [];
			  for (var key in properties) {
				if (properties[key]['x-referenced']) {
				  for (var i = 0; i < properties[key]['x-referenced'].length; i++) {
					referenced.push(properties[key]['x-referenced'][i].split('.'));
				  }
				}
			  }
			  return referenced;
			},
			getReferences: function (properties) {
			  var references = {};
			  for (var key in properties) {
				if (properties[key]['x-references']) {
				  references[key] = properties[key]['x-references'];
				} else {
				  references[key] = false; 
				}
			  }
			  return references;
			},
			getProperties: function (action, subject, definition) {
			  if (action == 'list') {
				path = ['components', 'schemas', action + '-' + subject, 'properties', 'records', 'items', 'properties'];
			  } else {
				path = ['components', 'schemas', action + '-' + subject, 'properties'];
			  }
			  return this.resolve(path, definition);
			}
		  }
		};
		var orm = {
		  methods: {
			readRecord: function () {
			  this.id = this.$route.params.id;
			  this.subject = this.$route.params.subject;
			  this.record = null;
			  var self = this;
			  api.get('/records/' + this.subject + '/' + this.id).then(function (response) {
				self.record = response.data;
			  }).catch(function (error) {
				console.log(error);console.log(error.response);
			  });
			},
			readRecords: function () {
			  this.subject = this.$route.params.subject;
			  this.records = null;
			  var url = '/records/' + this.subject;
			  var params = [];
			  for (var i=0;i<this.join.length;i++) {
				params.push('join='+this.join[i]);
			  }        
			  if (this.field) {
				params.push('filter='+this.field+',eq,'+this.id);
			  }        
			  if (params.length>0) {
				url += '?'+params.join('&');
			  }
			  var self = this;
			  api.get(url).then(function (response) {
				self.records = response.data.records;
			  }).catch(function (error) {
				console.log(error);console.log(error.response);
			  });
			},
			readOptions: function() {
			  this.options = {};
			  var self = this;
			  for (var key in this.references) {
				var subject = this.references[key];
				if (subject !== false) {
				  var properties = this.getProperties('list', subject, this.definition);
				  var displayColumn = this.getDisplayColumn(Object.keys(properties));
				  var primaryKey = this.getPrimaryKey(properties);
				  api.get('/records/' + subject + '?include=' + primaryKey + ',' + displayColumn).then(function (subject, primaryKey, displayColumn, response) {
					self.options[subject] = response.data.records.map(function (record) {
					  return {key: record[primaryKey], value: record[displayColumn]};
					});
					self.$forceUpdate();
				  }.bind(null, subject, primaryKey, displayColumn)).catch(function (error) {
					console.log(error);console.log(error.response);
				  });
				}
			  }
			},
			updateRecord: function () {
			  api.put('/records/' + this.subject + '/' + this.id, this.record).then(function (response) {
				console.log(response.data);
			  }).catch(function (error) {
				console.log(error);console.log(error.response);
			  });
			  router.push({name: 'List', params: {subject: this.subject}});
			},
			initRecord: function () {
			  this.record = {};
			  for (var key in this.properties) {
				if (!this.properties[key]['x-primary-key']) {
				  if (this.properties[key].default) {
					this.record[key] = this.properties[key].default;
				  } else {
					this.record[key] = '';
				  }
				}
			  }
			},
			createRecord: function() {
			  var self = this;
			  api.post('/records/' + this.subject, this.record).then(function (response) {
				self.record.id = response.data;
			  }).catch(function (error) {
				console.log(error);console.log(error.response);
			  });
			  router.push({name: 'List', params: {subject: this.subject}});
			},
			deleteRecord: function () {
			  api.delete('/records/' + this.subject + '/' + this.id).then(function (response) {
				console.log(response.data);
			  }).catch(function (error) {
				console.log(error);console.log(error.response);
			  });
			  router.push({name: 'List', params: {subject: this.subject}});
			}
		  }
		};
	</script>
	
	
	
	
	
	
	<!-- FOOTER FROM -->
	
    <!-- jQuery -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/nprogress/nprogress.js"></script>
	
    <!-- Chart.js -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/Flot/jquery.flot.js"></script>
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	
    <!-- Ion.RangeSlider -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <!-- Bootstrap Colorpicker -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <!-- jquery.inputmask -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- jQuery Knob -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- Cropper -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/cropper/dist/cropper.min.js"></script>
    <!-- validator -->
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/validator/validator.js"></script>

    <script src="<?php echo $this->urlNav; ?>/assets/vendors/jquery-validation/jquery.validate.js"></script>
	
	<script src="<?php echo $this->urlNav; ?>/assets/vendors/bootbox/bootbox.min.js"></script>
    <script src="<?php echo $this->urlNav; ?>/assets/vendors/bootbox/bootbox.locales.min.js"></script>