<?php 

?>
<div class="" id="app">
	<div class="page-title">
		<div class="title_left">
			<h3>Form Validation</h3>
		</div>	
	</div>
	<div class="clearfix"></div>
	<router-view></router-view>
</div>

<template id="Forms-Create-Diynamic">
	<div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>{{ title }} <small>sub title</small></h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#">Settings 1</a></li>
									<li><a href="#">Settings 2</a></li>
								</ul>
							</li>
							<li><a class="close-link"><i class="fa fa-close"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Error Enviando datos.');">
							<p>
								For alternative validation library <code>parsleyJS</code> check out in the <a href="form.html">form page</a>
							</p>
							<div class="clearfix"></div>
							<br />
							<!-- // -->
							<span class="section">Información Personal</span>
							
							<template v-if="inputs !== null">
								<div>
									<div class="item form-group" v-for="(item, i) in inputs">
										<template v-if="item.show === true">
											
											<label class="control-label col-md-4 col-sm-4 col-xs-12" v-bind:for="'id-' + item.name">
												{{ item.label }} <span class="required" v-if="item.required === true">*</span>
											</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input class="form-control col-xs-12" v-if="item.tag === 'input'" 
													:id="'id-' + item.name" 
													:name="item.name"
													:required="item.required" 
													:readonly="item.readonly" 
													:disabled="item.disabled" 
													:type="item.type" 
													:title="item.title" 
													v-model="record[item.name]"
												/>
												<select v-if="item.tag === 'select'" class="form-control col-xs-12" 
													:id="'id-' + item.name" 
													:name="item.name" 
													:required="item.required" 
													:readonly="item.readonly" 
													:disabled="item.disabled" 
													:type="item.type" 
													:title="item.title" 
													v-model="record[item.name]"
												>
													<option :value="option.value" v-if="item.options != undefined && item.options != null" v-for="(option, index) in item.options">{{ option.text }}</option>
												</select>
												<textarea v-if="item.tag === 'textarea'" class="form-control col-xs-12" 
													:id="'id-' + item.name" 
													:name="item.name" 
													:required="item.required" 
													:readonly="item.readonly" 
													:disabled="item.disabled" 
													:title="item.title" 
													v-model="record[item.name]" 
													rows="8" 
												>{{ record[item.name] }}</textarea>
												
												<template v-if="item.dynamic == true" class="row">
													Resultado => {{ item.result }}
													<div class="row" v-for="(subItem, j) in item.dynamicOptions.inputs">
														<template v-if="subItem.show === true">
															<label class="control-label col-sm-4" v-bind:for="'id-' + subItem.name">
																{{ subItem.label }} <span class="required" v-if="subItem.required === true">*</span>
															</label>
															<div class="col-sm-8">
																<input class="form-control col-xs-12" v-if="subItem.tag === 'input'" 
																	:id="'id-' + subItem.name" 
																	:name="subItem.name"
																	:required="subItem.required" 
																	:readonly="subItem.readonly" 
																	:disabled="subItem.disabled" 
																	:type="subItem.type" 
																	:title="subItem.title" 
																	v-model="otherRecords[subItem.name]" 
																	@change="changeSubItem(item, subItem)"
																/>
																<select v-if="subItem.tag === 'select'" class="form-control col-xs-12" 
																	:id="'id-' + subItem.name" 
																	:name="subItem.name"
																	:required="subItem.required" 
																	:readonly="subItem.readonly" 
																	:disabled="subItem.disabled" 
																	:type="subItem.type" 
																	:title="subItem.title"
																	v-model="otherRecords[subItem.name]" 
																	@change="changeSubItem(item, subItem)"
																>
																	<option :value="option.value" v-if="subItem.options != undefined && subItem.options != null" v-for="(option, index) in subItem.options">{{ option.text }}</option>
																</select>
																<textarea v-if="subItem.tag === 'textarea'" class="form-control col-xs-12" 
																	:id="'id-' + subItem.name" 
																	:name="subItem.name"
																	:required="subItem.required" 
																	:readonly="subItem.readonly" 
																	:disabled="subItem.disabled" 
																	:title="subItem.title" 
																	v-model="otherRecords[subItem.name]" 
																	@change="changeSubItem(item, subItem)" 
																	rows="3" 
																></textarea>
															</div>
														</template>
													</div>
												</template>
												<template v-else></template>
											</div>
										</template>
										<template v-else="">
											<input class="form-control col-xs-12" v-if="item.tag === 'input'" 
												:name="item.name"
												:required="item.required" 
												:readonly="item.readonly" 
												:disabled="item.disabled" 
												:type="item.type" 
												:title="item.title" 
												v-model="record[item.name]" 
											/>
											<template v-if="item.dynamic == true" class="row">
													<div class="row" v-for="(subItem, j) in item.dynamicOptions.inputs">
														<template v-if="subItem.show === true">
															<label class="control-label col-sm-4" v-bind:for="'id-' + subItem.name">
																{{ subItem.label }} <span class="required" v-if="subItem.required === true">*</span>
															</label>
															<div class="col-sm-8">
																<input class="form-control col-xs-12" v-if="subItem.tag === 'input'" 
																	:id="'id-' + subItem.name" 
																	:name="subItem.name"
																	:required="subItem.required" 
																	:readonly="subItem.readonly" 
																	:disabled="subItem.disabled" 
																	:type="subItem.type" 
																	:title="subItem.title" 
																	v-model="otherRecords[subItem.name]" 
																	@change="changeSubItem(item, subItem)"
																/>
																<select v-if="subItem.tag === 'select'" class="form-control col-xs-12" 
																	:id="'id-' + subItem.name" 
																	:name="subItem.name"
																	:required="subItem.required" 
																	:readonly="subItem.readonly" 
																	:disabled="subItem.disabled" 
																	:type="subItem.type" 
																	:title="subItem.title"
																	v-model="otherRecords[subItem.name]" 
																	@change="changeSubItem(item, subItem)"
																>
																	<option :value="option.value" v-if="subItem.options != undefined && subItem.options != null" v-for="(option, index) in subItem.options">{{ option.text }}</option>
																</select>
																<textarea v-if="subItem.tag === 'textarea'" class="form-control col-xs-12" 
																	:id="'id-' + subItem.name" 
																	:name="subItem.name"
																	:required="subItem.required" 
																	:readonly="subItem.readonly" 
																	:disabled="subItem.disabled" 
																	:title="subItem.title" 
																	v-model="otherRecords[subItem.name]" 
																	@change="changeSubItem(item, subItem)" 
																	rows="3" 
																></textarea>
															</div>
														</template>
													</div>
													Resultado => {{ item.result }}
												</template>
												<template v-else></template>
										</template>
									</div>
								</div>
							</template> 
						
							<div class="ln_solid"></div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-3">
									<button type="reset" class="btn btn-default">Limpiar</button>
									<button type="submit" class="btn btn-success" onClick="javascript: $('#messageBox').html('');">Guardar</button>
								</div>
							</div>
						</form>
						<!-- // -->
						<div>
							<!-- //
							<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							</div>
							-->
							<div class="clearfix"></div>
							<br />
							<div id="messageBox"></div>
							
						</div>
						<!-- // -->
						
					</div>
			
					<div class="x_content">
						<br />
						<button v-on:click="count++">You clicked me {{ count }} times.</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="x_panel">
			<div class="x_content">
				{{ rules }}
				<hr>
				{{ otherRecords }}
				<hr>
				{{ record }}
				<hr>
					<!-- //
					<template v-if="fields !== null" v-for="(value, key) in record">						
					</template> -->				
			</div>
		</div>
	</div>
</template>

<template id="create-PQRs-Peticion">
	<div>
		<forms-create-dynamic :options_form="thisForm"></forms-create-dynamic>
	</div>
</template>

<script>
var FormsCreateDynamic = Vue.component('forms-create-dynamic', {
	template: '#Forms-Create-Diynamic',
	props: {
		'options_form': {
			'titulo': 'Crear',
			'tabla': '',
			'fields': null
		}
	},
	data(){
		return {
			count: 0,
			action: "",
			title: "",
			table: "",
			rules: null,
			record: null,
			otherRecords: {},
			options: null,
			jvalidate: null,
			inputs: [],
			callEvent: null
		};
	},
	computed: {
	},
	created(){
		var self = this;
	},
	mounted(){
		var self = this;
		self.getOptionsInputs();
	},
	methods: {
		returnFalse(){
			return false;
		},
		changeSubItem(item, subItem){
			var self = this;
			self.record[item.name] = self.returnResultDynamic(item.result);
		},
		returnResultDynamic(itemResult){
			var self = this;
			var r = '';
			for (const [index, result] of  Object.entries(itemResult)) {
				if (Array.isArray(result)) {
					r += ' ' + self.returnResultDynamic(result);
					// r += '\n';
				} else if (self.otherRecords[result] !== undefined) {
					if (self.otherRecords[result] == '' || self.otherRecords[result] == null || self.otherRecords[result] == 0) {
						r += ' { Falta -> ' + result + '}';
					} else {
						r += ' ' + self.otherRecords[result];
					};
				} else {
					r += ' ' + result;
				};
			}
			return r;
		},
		getValidatorForm(){
			var self = this;
			self.jvalidate = $("#jvalidate").validate({
				//wrapper: "alert alert-danger alert-dismissible fade in",
				///errorContainer: "#messageBox",
				debug: true,
				//errorLabelContainer: "#messageBox",
				//wrapper: "strong",
                ignore: [],
                rules: self.rules,
				onsubmit: true,
				errorPlacement: function(error, element){
					var errorClone = error.clone();
					var errorHTML = '<div class="alert alert-danger alert-dismissible fade in" role="alert">';
						errorHTML += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
						errorHTML += '<strong>' + element[0].title + '</strong> revisa este campo.';
					errorHTML += '</div>';
					$("#messageBox").append(errorHTML);
				},
				submitHandler: function(form){
					console.log('form');
					console.log(form);
					console.log('tabla');
					console.log(self.table);
					console.log('record');
					console.log(self.record);
					
					bootbox.confirm({
						message: "Debes confirmar que deseas continuar, una vez confirmes el envio/guardado no podras volver a modificar el contenido de esta informacion.",
						locale: 'es',
						 buttons: {
							cancel: {
								label: '<i class="fa fa-times"></i> Cancelar'
							},
							confirm: {
								label: '<i class="fa fa-check"></i> Confirmar'
							}
						},
						callback: function (result) {
							if(result === true){
								switch(self.action){
									case 'create':
										api.post('/records/' + self.table, self.record)
										.then(function (z) {
											if(!z.status){
												alert('Ocurrio un error creando el campo del formulario. [' + key + ']');
											} else {
												if(z.status === 200){
													self.callEvent(z.data)
												}else{
													console.log("Console ERROR:");
												}
											}
										})
										.catch(function (e) {
											console.log(e);
											if(e.data){
												console.log(e.data);
												self.callEvent(z.data)
											}
										});
										/**/
									break;
									case 'create':
									break;
									default:
									break;
								}
							}
							//self.submitEvent
						}
					});
				},
			});
		},
		getOptionsInputs(){
			var self = this;
			if(self.options === undefined || self.options === null){
				self.options = {};
			}
			if(self.options_form != undefined){
				fields = (self.options_form.fields != undefined) ? self.options_form.fields : {};
				
				for (const [key, value] of Object.entries(fields)) {
					if(self.options[value.options] === undefined){
						self.options[value.options] = [{ text: "Seleccione una opcion.", value: "" }];
					}
					
					if((value.options != undefined)){
						api.get('/records/' + value.options, {
							params: {}
						})
						.then(function (r) {
							if(!r.status){
								alert('Ocurrio un error creando el campo del formulario. [' + key + ']');
							} else {
								if(r.status === 200){
									for (const [kRecord, vRecord] of Object.entries(r.data.records)) {
										if(vRecord.name != undefined && vRecord.code != undefined){
											self.options[value.options].push({ text: vRecord.code + ' - ' + vRecord.name, value: vRecord.id });
										} else if(vRecord.name != undefined && vRecord.code == undefined){
											self.options[value.options].push({ text: vRecord.name, value: vRecord.id });
										} else if(vRecord.names != undefined && vRecord.name == undefined){
											self.options[value.options].push({ text: vRecord.names, value: vRecord.id });
										}  else if(vRecord.title != undefined && vRecord.name == undefined){
											self.options[value.options].push({ text: vRecord.title, value: vRecord.id });
										} 
										else {
											self.options[value.options].push({ text: vRecord.id, value: vRecord.id });
										}
									};
								}
							}
						})
						.catch(function (e) {
							console.log(e);
						});
					}
				}
				self.getOptions();
			} else {
				console.log('options_form no definido.');
			}
			
			self.getValidatorForm();
		},
		createFormElement(fields){
			var self = this;
			if(fields == undefined || fields == null){ fields = []; };
			
			var returnData = { 
				"fields": fields, 
				"inputs": [],
				"record": {},
				"othersRecord": {},
				"rules": {}
			};
			
			for (const [key, value] of Object.entries(fields)) {
				var optionsRule = {};
				var optionsInput = {};
				// if((value.show !== undefined)){ optionsRule.show = value.show; } else { optionsRule.show = true; }
				if((value.required !== undefined)){ optionsRule.required = value.required; } else {}
				if((value.remote !== undefined)){ optionsRule.remote = value.remote; } else {}
				if((value.min !== undefined)){ optionsRule.min = value.min; } else {}
				if((value.max !== undefined)){ optionsRule.max = value.max; } else {}
				if((value.email !== undefined)){ optionsRule.email = value.email; } else {}
				if((value.minlength !== undefined)){ optionsRule.minlength = value.minlength; } else {}
				if((value.maxlength !== undefined)){ optionsRule.maxlength = value.maxlength; } else {}
				if((value.rangelength !== undefined)){ optionsRule.rangelength = value.rangelength; } else {}
				if((value.range !== undefined)){ optionsRule.range = value.range; } else {}
				if((value.step !== undefined)){ optionsRule.step = value.step; } else {}
				if((value.date !== undefined)){ optionsRule.date = value.date; } else {}
				if((value.dateISO !== undefined)){ optionsRule.dateISO = value.dateISO; } else {}
				if((value.url !== undefined)){ optionsRule.url = value.url; } else {}
				if((value.number !== undefined)){ optionsRule.number = value.number; } else {}
				if((value.digits !== undefined)){ optionsRule.digits = value.digits; } else {}
				if((value.equalTo !== undefined)){ optionsRule.equalTo = value.equalTo; } else {}
				
				// for (const [kValue, vValue] of Object.entries(value)) {};
				
				optionsInput.name = key;
				if(value.label !== undefined){ optionsInput.label = value.label; } else { optionsInput.label = key; }
				if(value.required !== undefined){ optionsInput.required = value.required; } else { optionsInput.required = false; }
				if(value.readonly !== undefined){ optionsInput.readonly = value.readonly; } else { optionsInput.readonly = false; }
				if(value.disabled !== undefined){ optionsInput.disabled = value.disabled; } else { optionsInput.disabled = false; }
				if(value.value !== undefined){
					optionsInput.value = value.value;
					// returnData.record[key] = value.value;
				} else {
					optionsInput.value = null;
					// returnData.record[key] = null;
				}
				if(value.show !== undefined){ optionsInput.show = value.show; } else { optionsInput.show = true; }
				
				
				// returnData.record[key] = value.value;
				if((value.typeInput != undefined)){
					switch(value.typeInput){
						case 'text':
							returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : '';
							optionsInput.tag = 'input';
							optionsInput.type = 'text';
						break;
						case 'email':
							// returnData.record[key] = '';
							returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : '';
							optionsInput.tag = 'input';
							optionsInput.type = 'email';
						break;
						case 'textarea':
							// returnData.record[key] = '';
							returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : '';
							optionsInput.tag = 'textarea';
						break;
						case 'date':
							// returnData.record[key] = '';
							returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : '';
							optionsInput.tag = 'input';
							optionsInput.type = 'date';
						break;
						case 'dateISO':
							// returnData.record[key] = '';
							returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : '';
							optionsInput.tag = 'input';
							optionsInput.type = 'dateISO';
						break;
						case 'datetime':
							// returnData.record[key] = '';
							returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : '';
							optionsInput.tag = 'input';
							optionsInput.type = 'datetime';
						break;
						case 'datetime-local':
							// returnData.record[key] = '';
							returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : '';
							optionsInput.tag = 'input';
							optionsInput.type = 'datetime-local';
						break;
						case 'time':
							// returnData.record[key] = '';
							returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : '';
							optionsInput.tag = 'input';
							optionsInput.type = 'time';
						break;
						case 'number':
							// returnData.record[key] = 0;
							returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : 0;
							optionsInput.tag = 'input';
							optionsInput.type = 'number';
						break;
						case 'select':
							// returnData.record[key] = 0;
							returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : 0;
							optionsInput.tag = 'select';
							if((value.options != undefined)){
								if(self.options[value.options] != undefined){ optionsInput.options = self.options[value.options]; }
							}
						break;
						default:
							// returnData.record[key] = null;
							returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : '';
						break;
					}
				} else {
					//returnData.record[key] = null;
					returnData.record[key] = (optionsInput.value != null) ? optionsInput.value : '';
					optionsInput.tag = 'none';
				}
				optionsInput.title = value.label;
				optionsInput.value = returnData.record[key];
				
				if(optionsInput.show == false){
					optionsInput.tag = 'input';
					optionsInput.type = 'hidden';
				}
				if(value.valueDataDynamic != undefined){
					// validar si existen fields
					if(value.valueDataDynamic.fields != undefined && value.valueDataDynamic.result != undefined){
						optionsInput.readonly = true;
						optionsInput.dynamic = true;
						optionsInput.result = value.valueDataDynamic.result;
						optionsInput.dynamicOptions = self.createFormElement(value.valueDataDynamic.fields);
						
							// console.log(optionsInput.dynamicOptions);
						for (const [kDynamic, vDynamic] of Object.entries(optionsInput.dynamicOptions.record)) {
							// console.log(kDynamic, vDynamic);
							//self.otherRecords.push(console.log(kDynamic));
							if(self.otherRecords[kDynamic] == undefined || self.otherRecords[kDynamic] == null){
								self.otherRecords[kDynamic] = vDynamic;
							}
						};
					}
				}
				
				// self.inputs.push(optionsInput);
				// self.rules[key] = optionsRule;
				
				returnData.inputs.push(optionsInput);
				returnData.rules[key] = optionsRule;
			}
			return returnData;
		},
		getOptions(){
			var self = this;
			self.rules = {};
			self.record = {};
			self.inputs = [];
			if(self.options_form != undefined){
				self.action = (self.options_form.action != undefined) ? self.options_form.action : 'view';
				self.title = (self.options_form.titulo != undefined) ? self.options_form.titulo : '';
				self.table = (self.options_form.tabla != undefined) ? self.options_form.tabla : 'none';
				self.callEvent = (self.options_form.callEvent != undefined) ? self.options_form.callEvent : function(){
					console.log("No hay respuesta configurada.");
				};
				fields = (self.options_form.fields != undefined) ? self.options_form.fields : {};
				fieldsRepair = self.createFormElement(fields);
				
				if(fieldsRepair.record != undefined){ self.record = fieldsRepair.record; };
				if(fieldsRepair.inputs != undefined){ self.inputs = fieldsRepair.inputs; };
				if(fieldsRepair.rules != undefined){ self.rules = fieldsRepair.rules; };
			} else {
				console.log('options_form no definido.');
			}
			
			self.getValidatorForm();
		},
	},
	computed: {
	},
});

var AddPQRsPeticion = Vue.extend({
	template: '#create-PQRs-Peticion',
	data: function () {
		return {
			thisForm: {
				titulo: 'PQRs - Nueva Petición',
				action: "create",
				tabla: "pqrs",
				fields: {
					type: {
						show: false,
						label: "Tipo de PQRs",
						required: true,
						typeInput: "number",
						min: 0,
						value: 1
					},
					name: {
						label: "Nombres o Razon social",
						required: true,
						typeInput: "text"
					},
					surname: {
						label: "Apellidos",
						required: true,
						typeInput: "text"
					},
					department: {
						label: "Departamento",
						required: true,
						typeInput: "select",
						options: "geo_departments"
					},
					city: {
						label: "Ciudad",
						required: true,
						typeInput: "select",
						options: "geo_citys"
					},
					identification_type: {
						label: "Tipo de Identificacion",
						required: true,
						typeInput: "select",
						options: "types_identifications"
					},
					identification_number: {
						label: "Numero de Identificacion",
						required: true,
						typeInput: "text"
					},
					email: {
						label: "Correo electronico",
						required: true,
						typeInput: "email"
					},
					phone: {
						label: "Teléfono Fijo",
						required: true,
						typeInput: "text"
					},
					mobile: {
						label: "Teléfono Móvil",
						required: true,
						typeInput: "text"
					},
					address: {
						label: "Dirección",
						required: true,
						typeInput: "textarea"
					},
					event_occurred: {
						label: "Relacion de los Hechos",
						required: true,
						typeInput: "textarea",
						valueDataDynamic: {
							fields: {
								"lugar": {
									label: "Lugar de los hechos",
									required: true,
									typeInput: "text"
								},
								"direccion": {
									label: "Dirección de los hechos",
									required: true,
									typeInput: "textarea"
								},
								"daño": {
									label: "Daño de los hechos",
									required: true,
									typeInput: "textarea"
								}
							},
							result: [
								[
									"Lugar de los hechos: ",
									"lugar",
									'\n'
								],
								[
									"Dirección de los hechos: ",
									"direccion",
									'\n'
								],
								[
									"Daño: ",
									"daño",
								]
							]
						},
					},
					event_date: {
						label: "Fecha del evento",
						required: true,
						typeInput: "datetime",
						valueDataDynamic: {
							fields: {
								"fecha": {
									label: "Fecha de los hechos",
									required: true,
									typeInput: "date"
								},
								"hora": {
									label: "Hora de los hechos",
									required: true,
									typeInput: "time"
								}
							},
							result: [ [ "fecha", "hora" ] ]
						},
					},
					petition: {
						label: "Peticion",
						required: true,
						typeInput: "textarea"
					},
				},
				callEvent(resultado){
					console.log('resultado callback');
					console.log(resultado);
					
					if(Number(resultado) > 0 && Number(resultado) != 'NaN'){
						bootbox.alert({
							message: "<h1>Muy Bien!</h1><br>La PQRs se a creado y enviado con éxito, el # del Radicado es <h5>" + resultado + "</h5>",
							callback: function () {
								// console.log('This was logged in the callback!');
								location.reload();
							}
						})
					}
				}
			}
		};
	},
	
});

var router = new VueRouter({
	linkActiveClass: 'active',
	routes:[
		{ path: '/', component: AddPQRsPeticion, name: 'AddPQRs-Peticion', params: { subject: 'pqrs' } },
	]
});

var app = new Vue({
	router: router,
	components: {
		'forms-create-dynamic': FormsCreateDynamic,
	},
}).$mount('#app');
</script>
 
</div>
