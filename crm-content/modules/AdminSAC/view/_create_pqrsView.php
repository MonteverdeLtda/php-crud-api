<?php 

?>
<div class="" id="app">
	<div class="page-title">
		<div class="title_left">
			<h3>PQRs <small>Crear </small></h3>
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
			<div class="x_content">
				<br />
				<form v-on:submit="createRecord" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					<template v-for="(value, key) in record"  v-if="fields[key] != undefined && fields[key].show === undefined || fields[key] != undefined && fields[key].show === true">
						<div class="form-group">
							<label v-if="fields[key] != undefined && fields[key].title != undefined" class="control-label col-md-3 col-sm-3 col-xs-12" v-bind:for="key">
								{{ fields[key].title }} 
								<span v-if="fields[key] != undefined && fields[key].required != undefined && fields[key].required  == true" class="required">*</span>
							</label>
							<label v-else="" class="control-label col-md-4 col-sm-4 col-xs-12" v-bind:for="key">
								{{ key }} 
								<span v-if="fields[key] != undefined && fields[key].required != undefined && fields[key].required  == true" class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<!-- // references[key] === false && -->
								<input v-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput != 'select' && fields[key].typeInput != 'textarea'" :type="fields[key].typeInput" class="form-control col-md-7 col-xs-12"  />
								<select 
									v-else-if="references[key] != false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput == 'select'" 
									class="form-control col-md-7 col-xs-12" v-bind:id="key" v-model="record[key]">
									<option value=""></option>
									<option v-for="option in options[references[key]]" v-bind:value="option.key">
										{{ option.value }}
									</option>
								</select>
								<textarea 
									v-else-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput == 'textarea'" 
									class="form-control col-md-7 col-xs-12" v-bind:id="key" v-model="record[key]"></textarea>
								<input v-else="" class="form-control col-md-7 col-xs-12" v-bind:id="key" v-model="record[key]" :disabled="key === primaryKey" /> 
								<!-- // v-bind:id="key" v-model="record[key]" :disabled="key === primaryKey" -->
								<!-- // <input v-else-if="references[key] === false" class="form-control col-md-7 col-xs-12" v-bind:id="key" v-model="record[key]" :disabled="key === primaryKey" /> -->
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
</template>


<script>
var Add = Vue.extend({
	mixins: [util, orm],
	template: '#create',
	props: ['definition'],
	data: function () {
		return {
			id: this.$route.params.id,
			subject: this.$route.params.subject,
			record: null,
			options: {},
			fields: {
				type: {
					title: "Tipo de solicitud",
					required: true,
					typeInput: "select",
				},
				name: {
					show: true,
					title: "Nombres o Razon social",
					required: true,
					typeInput: "text"
				},
				surname: {
					show: true,
					title: "Apellidos",
					required: true,
					typeInput: "text"
				},
				department: {
					title: "Departamento",
					required: true,
					typeInput: "select"
				},
				city: {
					show: true,
					title: "Ciudad",
					required: true,
					typeInput: "select"
				},
				identification_type: {
					show: true,
					title: "Tipo de Identificacion",
					required: true,
					typeInput: "select"
				},
				identification_number: {
					show: true,
					title: "Numero de Identificacion",
					required: true,
					typeInput: "text"
				},
				email: {
					show: true,
					title: "Correo electronico",
					required: true,
					typeInput: "text"
				},
				phone: {
					show: true,
					title: "Teléfono Fijo",
					required: true,
					typeInput: "text"
				},
				mobile: {
					show: true,
					title: "Teléfono Móvil",
					required: true,
					typeInput: "text"
				},
				address: {
					show: true,
					title: "Dirección",
					required: true,
					typeInput: "textarea"
				},
				event_occurred: {
					show: true,
					title: "Hechos del evento",
					required: true,
					typeInput: "textarea"
				},
				event_date: {
					show: true,
					title: "Fecha del evento",
					required: true,
					typeInput: "text"
				},
				petition: {
					show: true,
					title: "Peticion",
					required: true,
					typeInput: "textarea"
				},
				created: {
					show: false,
					title: "Fecha de Creacion de la PQR",
					required: true,
					typeInput: "text"
				},
				updated: {
					show: false,
					title: "Ultima Actualizacion",
					required: true,
					typeInput: "text"
				},
			}
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
		getFieldByName(name){
			var self = this;
			if(self.fields[name].title != undefined){
				return self.fields[name].title;
			} else {
				return name;
			}
		}
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
    return {
		definition: null,
	};
  },
  mounted: function () {
	  this.$router.push({path: '/pqrs/create'});
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
