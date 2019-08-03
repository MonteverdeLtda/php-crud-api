
<div class="" id="app">
	<div class="page-title">
		<div class="title_left">
			<h3>Usuarios <small>todos los usuarios</small></h3>
		</div>
		<!-- // 
		<div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Go!</button>
					</span>
				</div>
			</div>
		</div>
		-->
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

<template id="menu">
	<div v-if="subjects!==null" class="nav flex-column nav-pills">
		<ul class="nav nav-tabs tabs-left">
			<router-link v-for="subject in subjects" v-bind:to="{name: 'List', params: {subject: subject.name}}"  :key="subject.name">
				<li><a href="#home" data-toggle="tab">{{ subject.name }}</a></li>
			</router-link>
		</ul>
	</div>
</template>

<template id="home">
  <div></div>
</template>

<template id="list">
	<div>
		<div class="x_panel">
			<div class="x_title">
				<h2>{{ subject }} <small> Listado</small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <router-link tag="li" v-bind:to="{name: 'Add', params: {subject: subject}}">
					<a><i class="fa fa-plus"></i></a>
				  </router-link>
				</ul>
				<div class="clearfix"></div>
			</div>
				  
			<div class="x_content table-responsive">
				<div class="card bg-light" v-if="field"><div class="card-body">
					<div style="float:right;"><router-link v-bind:to="{name: 'List', params: {subject: subject}}">Clear filter</router-link></div>
						<p class="card-text">Filtrado por: {{ field }} = {{ id }}</p>
					</div>
				</div>
				<p v-if="records===null">Cargando...</p>				
				<table v-else class="table table-hover">
				  <thead>
					<tr>
					  <th v-for="value in Object.keys(properties)">{{ value }}</th>
					  <th v-if="related">Relacionado</th>
					  <th v-if="primaryKey"></th>
					</tr>
				  </thead>
				  <tbody>
					<tr v-for="record in records">
					  <template v-for="(value, key) in record">
						<td v-if="references[key] !== false">
						  <router-link v-bind:to="{name: 'View', params: {subject: references[key], id: referenceId(references[key], record[key])}}">{{ referenceText(references[key], record[key]) }}</router-link>
						</td>
						<td v-else>{{ value }}</td>
					  </template>
					  <td v-if="related">
						<template v-for="(relation, i) in referenced">
						  <router-link v-bind:to="{name: 'Filter', params: {subject: relation[0], field: relation[1], id: record[primaryKey]}}">{{ relation[0] }}</router-link>&nbsp;
						</template>
					  </td>
					  <td v-if="primaryKey" style="padding: 6px; white-space: nowrap;">
						<router-link class="btn btn-info btn-sm btn-round" v-bind:to="{name: 'View', params: {subject: subject, id: record[primaryKey]}}">
							<i class="fa fa-eye"></i>
						</router-link>
						<router-link class="btn btn-warning btn-sm btn-round" v-bind:to="{name: 'Edit', params: {subject: subject, id: record[primaryKey]}}">
							<i class="fa fa-pencil"></i>
						</router-link>
						<router-link class="btn btn-danger btn-sm btn-round" v-bind:to="{name: 'Delete', params: {subject: subject, id: record[primaryKey]}}">
							<i class="fa fa-trash"></i>
						</router-link>
					  </td>
					</tr>
				  </tbody>
				</table>
			</div>
		</div>
		
   
  </div>
</template>

<template id="create">
	<div>
		<div class="x_panel">
			<div class="x_title">
				<h2>{{ subject }} <small> Crear</small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <router-link tag="li" v-bind:to="{name: 'Add', params: {subject: subject}}">
					<a><i class="fa fa-plus"></i></a>
				  </router-link>
				</ul>
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


<template id="view">
	<div>
    <h2>{{ subject }} - Observando</h2>
    <p v-if="record===null">Cargando...</p>
    <dl v-else>
      <template v-for="(value, key) in record">
		<table class="table table-responsive table-hover">
			<tr>
				<th>{{ key }}</th>
				<td>{{ value }}</td>
			</tr>
		</table>
      </template>
    </dl>
      <router-link class="btn btn-default" v-bind:to="{name: 'List', params: {subject: subject}}">Regresar al listado</router-link>
  </div>
</template>

<template id="update">
	<div>
		<div class="x_panel">
			<div class="x_title">
				<h2>{{ subject }} <small> Modificar</small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <router-link tag="li" v-bind:to="{name: 'Add', params: {subject: subject}}">
					<a><i class="fa fa-plus"></i></a>
				  </router-link>
				</ul>
				<div class="clearfix"></div>
					<div class="x_content">
						<br />
						<p v-if="record===null">Cargando...</p>
						<form v-else v-on:submit="updateRecord" data-parsley-validate class="form-horizontal form-label-left">
							<template v-for="(value, key) in record">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" v-bind:for="key">{{ key }} <!-- // <span class="required">*</span> --></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input v-if="references[key] === false" class="form-control col-md-7 col-xs-12" v-bind:id="key" v-model="record[key]" :disabled="key === primaryKey" />
										<select v-else-if="!options[references[key]]" class="form-control col-md-7 col-xs-12" disabled>
											<option value="" selected>Cargando...</option>
										</select>
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
									<button type="submit" class="btn btn-success">Guardar</button>
								</div>
							</div>
						</form>
				  </div>
			</div>
		</div>
	</div>
</template>

<template id="delete">
  <div>
    <h2>{{ subject }} Eliminar #{{ id }}</h2>
    <form v-on:submit="deleteRecord">
      <p>The action cannot be undone.</p>
      <button type="submit" class="btn btn-danger">Eliminar</button>
      <router-link class="btn btn-secondary" v-bind:to="{name: 'List', params: {subject: subject}}">Cancelar</router-link>
    </form>
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
Vue.component('menu-component', {
  mixins: [util, orm],
  template: '#menu',
  props: ['subjects']
})
var Home = Vue.extend({
  mixins: [util],
  template: '#home'
});
var List = Vue.extend({
  mixins: [util, orm],
  template: '#list',
  data: function () {
    return {
      records: null,
      subject: this.$route.params.subject,
      field: this.$route.params.field,
      id: this.$route.params.id      
    };
  },
  props: ['definition'],
  created: function () {
    this.readRecords();
  },
  computed: {
    related: function () {
      return (this.referenced.filter(function (value) { return value; }).length > 0);
    },
    join: function () {
      return Object.values(this.references).filter(function (value) { return value; });
    },
    properties: function () {
      return this.getProperties('list', this.subject, this.definition);
    },
    references: function () {
      return this.getReferences(this.properties);
    },
    referenced: function () {
      return this.getReferenced(this.properties);
    },
    primaryKey: function () {
      return this.getPrimaryKey(this.properties);
    }
  },
  methods: {
    referenceText(subject, record) {
      var properties = this.getProperties('read', subject, this.definition);
      var displayColumn = this.getDisplayColumn(Object.keys(properties));
      return record[displayColumn];
    },
    referenceId(subject, record) {
      var properties = this.getProperties('read', subject, this.definition);
      var primaryKey = this.getPrimaryKey(properties);
      return record[primaryKey];
    }
  }
});
var View = Vue.extend({
  mixins: [util, orm],
  template: '#view',
  props: ['definition'],
  data: function () {
    return {
      id: this.$route.params.id,
      subject: this.$route.params.subject,
      record: null
    };
  },
  created: function () {
    this.readRecord();
  },
  computed: {
    properties: function () {
      return this.getProperties('read', this.subject, this.definition);
    }
  },
  methods: {   
  }
});
var Edit = Vue.extend({
  mixins: [util, orm],
  template: '#update',
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
    this.readRecord();
    this.readOptions();
  },
  computed: {
    properties: function () {
      return this.getProperties('update', this.subject, this.definition);
    },
    primaryKey: function () {
      return this.getPrimaryKey(this.properties);
    },
    references: function () {
      return this.getReferences(this.properties);
    },
  },
  methods: {
  }
});
var Delete = Vue.extend({
  mixins: [util, orm],
  template: '#delete',
  data: function () {
    return {
      id: this.$route.params.id,
      subject: this.$route.params.subject
    };
  },
  methods: {
  }
});
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
    { path: '/:subject/read/:id', component: View, name: 'View'},
    { path: '/:subject/update/:id', component: Edit, name: 'Edit'},
    { path: '/:subject/delete/:id', component: Delete, name: 'Delete'},
    { path: '/:subject/list', component: List, name: 'List'},
    { path: '/:subject/list/:field/:id', component: List, name: 'Filter'}
  ]
});
app = new Vue({
  router: router,
  data: function () {
    return {definition: null};
  },
  mounted: function () {
	  this.$router.push({path: '/users_login/list'});
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
