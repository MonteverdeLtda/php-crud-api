<?php 

?>
<div class="" id="app">
	<div class="page-title">
		<div class="title_left">
			<h3>APP <small> </small></h3>
		</div>
	</div>
	<div class="clearfix"></div>
	
	<div class="x_panel">
		<div class="x_content">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<router-view></router-view>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<template id="Forms-Create">
	<div>
		<div class="x_panel">
			<div class="x_content">
				<br />
				<!-- // -->
				<form v-on:submit="createRecord" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					<template v-if="fields !== null" v-for="(value, key) in record">
						<div class="form-group" v-if="fields[key] != undefined && fields[key].show === undefined || fields[key] != undefined && fields[key].show === true">
							<label v-if="fields[key] != undefined && fields[key].title != undefined" class="control-label col-md-3 col-sm-3 col-xs-12" v-bind:for="key">
								{{ fields[key].title }} 
								<span v-if="fields[key] != undefined && fields[key].required != undefined && fields[key].required  == true" class="required">*</span>
							</label>
							<label v-else="" class="control-label col-md-4 col-sm-4 col-xs-12" v-bind:for="key">
								{{ key }} 
								<span v-if="fields[key] != undefined && fields[key].required != undefined && fields[key].required  == true" class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" v-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput === 'text'"  class="form-control col-md-7 col-xs-12" v-bind:id="key" :disabled="key === primaryKey" v-model="record[key]"  />
								<input type="number" v-else-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput === 'number'"  class="form-control col-md-7 col-xs-12" v-bind:id="key" :disabled="key === primaryKey" v-model="record[key]"  />
								<input type="date" v-else-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput === 'date'"  class="form-control col-md-7 col-xs-12" v-bind:id="key" :disabled="key === primaryKey" v-model="record[key]"  />
								<input type="datetime-local" v-else-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput === 'datetime-local'"  class="form-control col-md-7 col-xs-12" v-bind:id="key" :disabled="key === primaryKey" v-model="record[key]"  />
								<input type="email" v-else-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput === 'email'"  class="form-control col-md-7 col-xs-12" v-bind:id="key" :disabled="key === primaryKey" v-model="record[key]"  />
								<input type="month" v-else-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput === 'month'"  class="form-control col-md-7 col-xs-12" v-bind:id="key" :disabled="key === primaryKey" v-model="record[key]"  />
								<input type="password" v-else-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput === 'password'"  class="form-control col-md-7 col-xs-12" v-bind:id="key" :disabled="key === primaryKey" v-model="record[key]"  />
								<input type="tel" v-else-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput === 'tel'"  class="form-control col-md-7 col-xs-12" v-bind:id="key" :disabled="key === primaryKey" v-model="record[key]"  />
								<input type="time" v-else-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput === 'time'"  class="form-control col-md-7 col-xs-12" v-bind:id="key" :disabled="key === primaryKey" v-model="record[key]"  />
								<input type="url" v-else-if="references[key] === false && fields[key] != undefined && fields[key].typeInput != undefined && fields[key].typeInput === 'url'"  class="form-control col-md-7 col-xs-12" v-bind:id="key" :disabled="key === primaryKey" v-model="record[key]"  />
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
								<!--
								<input v-else="" class="form-control col-md-7 col-xs-12" v-bind:id="key" v-model="record[key]" :disabled="key === primaryKey" /> 
								-->
							</div>
						</div>
					</template>
					
					<template v-else="" v-for="(value, key) in record">
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
			
			<div class="x_content">
			{{ record }}
				<br />
				<button v-on:click="count++">You clicked me {{ count }} times.</button>
			</div>
			<!-- // 
			<div class="x_content">
				<br />
				{{ options_form }}
			</div>
			<div class="x_content">
				<table>
					<tr><td>count</td><td>{{ count }}</td></tr>
					<tr><td>title</td><td>{{ title }}</td></tr>
					<tr><td>subject</td><td>{{ subject }}</td></tr>
					<tr><td>fields</td><td>{{ fields }}</td></tr>
					<tr><td>definition</td><td>{{ definition }}</td></tr>
					<tr><td>record</td><td>{{ record }}</td></tr>
					<tr><td>options</td><td>{{ options }}</td></tr>
				</table>
			</div>
			-->
		</div>
		
		<!-- //
		<div v-if="options !== undefined">			
			<div class="page-title" v-if="options.title != undefined">
				<div class="title_left">
					<h3>{{ options.title }} <small> </small></h3>
				</div>
			</div>
			{{ options }}
		</div>
		
		<table class="table table-responsive table-hover">
			<tr><th>id</th><td>{{ id }}</td></tr>
			<tr><th>subject</th><td>{{ subject }}</td></tr>
			<tr><th>formConfig</th><td>{{ formConfig }}</td></tr>
			<tr><th>definition</th><td>{{ definition }}</td></tr>
		</table>
		<form v-on:submit="createRecord" >
			<div class="form-group">
				<label class="control-label col-lg-2 col-md-3 col-sm-12 col-xs-3">
					key 
					<span class="required">*</span>
				</label>
				<div class="control-label col-lg-10 col-md-9 col-sm-12 col-xs-12">
					<textarea class="form-control col-sm-12"></textarea>
				</div>
			</div>
		</form>
		
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
		-->
	</div>
</template>


<template id="create-PQRs">
	<div>
		<forms-create :options_form="thisForm"></forms-create>
	</div>
</template>

<script>
var FormsCreate = Vue.component('forms-create', {
	template: '#Forms-Create',
	mixins: [util, orm],
	props: {
		'options_form': {
			'titulo': 'Crear',
			'tabla': ''
		}
	},
	data(){
		return {
			count: 0,
			title: "",
			subject: "",
			fields: {},
			definition: null,
			record: null,
			options: null,
		};
	},
	computed: {
	},
	created(){
		var self = this;
		api.get('/openapi').then(function (response) {
			console.log(response);
			self.definition = response.data;
			self.getOptions();
		}).catch(function (error) {
			console.log(error);console.log(error.response);
		});
	},
	methods: {
		getOptions(){
			var self = this;
			
			if(self.options_form != undefined){
				console.log(self.options_form);
				self.title = (self.options_form.titulo != undefined) ? self.options_form.titulo : '';
				self.subject = (self.options_form.tabla != undefined) ? self.options_form.tabla : '';
				self.fields = (self.options_form.fields != undefined) ? self.options_form.fields : null;
				
				self.initRecord();
				self.readOptions();
			} else {
				console.log('options_form no definido.');
			}
		},
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
});

var AddPQRs = Vue.extend({
	template: '#create-PQRs',
	data: function () {
		return {
			thisForm: {
				titulo: 'Nueva PQRs',
				tabla: "pqrs",
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
						typeInput: "email"
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
						typeInput: "date"
					},
					petition: {
						show: true,
						title: "Peticion",
						required: true,
						typeInput: "textarea"
					},
				},
			}
		};
	},
	
});

var router = new VueRouter({
	linkActiveClass: 'active',
	routes:[
		{ path: '/', component: AddPQRs, name: 'AddPQRs', params: { subject: 'pqrs' } },
	]
});

var app = new Vue({
	router: router,
	components: {
		'forms-create': FormsCreate,
	},
}).$mount('#app');
</script>
 
</div>
