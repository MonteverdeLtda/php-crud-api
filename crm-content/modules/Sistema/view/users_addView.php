
<div class="" id="app">
	<div class="page-title">
		<div class="title_left">
			<h3>Usuarios <small>todos los usuarios</small></h3>
		</div>
	</div>
	<div class="clearfix"></div>
	
	<div class="x_panel">
		<div class="x_content">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<router-view :key="$route.fullPath" v-if="definition!==null" :definition="definition"></router-view>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<template id="create">
	<div>
		<div class="x_panel">
			<div class="x_title">
				<h2>{{ subject }} <small> Crear</small></h2>
				<div class="clearfix"></div>
					<div class="x_content">
						<br />
						<form v-on:submit="createRecord" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<template v-for="(value, key) in record">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" v-bind:for="key">{{ key }} <!-- // <span class="required">*</span> --></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input v-if="references[key] === false" class="form-control col-md-7 col-xs-12" v-bind:id="key" v-model="record[key]" :disabled="key === primaryKey" />
										<select v-else class="form-control col-md-7 col-xs-12" v-bind:id="key" v-model="record[key]">
											<option value=""></option>
											<option v-for="option in options[references[key]]" v-bind:value="option.key">{{ option.value }}</option>
										</select>
									</div>
								</div>
							</template>
							<div class="ln_solid"></div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
									<router-link tag="button" class="btn btn-primary" v-bind:to="{name: 'List', params: {subject: subject}}">Cancelar</router-link>
									<button class="btn btn-primary" type="reset">Limpiar</button>
									<button type="submit" class="btn btn-success">Crear</button>
								</div>
							</div>
						</form>
                  </div>
			</div>
		</div>
	</div>
</template>


<script>
var api = axios.create({
	baseURL: '/index.php',
	withCredentials: true,
	headers: {
		'X-CORE': 'api'
	}
});
api.interceptors.response.use(function (response) {
  if (response.headers['x-xsrf-token']) {
    // document.cookie = 'XSRF-TOKEN=' + response.headers['x-xsrf-token'] + '; path=/';
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
var Add = Vue.extend({
  mixins: [util, orm],
  template: '#create',
  props: ['definition'],
  data: function () {
    return {
      id: this.$route.params.id,
      subject: this.$route.params.subject,
      record: null,
      options: {}
    };
  },
  created: function () {
    this.initRecord();
    this.readOptions();
  },
  computed: {
    properties: function () {
      return this.getProperties('create', this.subject, this.definition);
    },
    primaryKey: function () {
      return this.getPrimaryKey(this.properties);
    },
    references: function () {
      return this.getReferences(this.properties);
    }
  },
  methods: {
  }
});
var router = new VueRouter({
  linkActiveClass: 'active',
  routes:[
    { path: '/:subject/create', component: Add, name: 'Add'},
  ]
});
app = new Vue({
  router: router,
  data: function () {
    return {definition: null};
  },
  mounted: function () {
	  this.$router.push({path: '/users_login/create'});
  },
  created: function () {
    var self = this;
    api.get('/openapi').then(function (response) {
		console.log(response);
      self.definition = response.data;
    }).catch(function (error) {
      console.log(error);console.log(error.response);
    });
  }
}).$mount('#app');
</script>
 
</div>
