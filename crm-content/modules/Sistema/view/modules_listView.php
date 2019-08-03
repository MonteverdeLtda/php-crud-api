<?php 
class ModulesAdmin {
	private $modules;
	
	public function __construct(){	
		$Mydir = folder_content . '/modules/'; /* Carpeta de los modulos */
		$this->modules = array(); /* Definir `$this->modules`. */
		$this->views = array(); /* Definir `$this->views`. */
		foreach(glob($Mydir.'*', GLOB_ONLYDIR) as $nameModule) {
			$item = new stdClass(); /* Crear item para mostrar */
			$nameModule = str_replace($Mydir, '', $nameModule);
			if(is_dir(folder_content . '/modules/')){
				$nombreclassModulo = ucwords($nameModule)."Controller";
				if(!class_exists($nombreclassModulo)){ cargarControlador($nameModule); }
				$infoThisModule = $nombreclassModulo::getThisModule();
				$infoThisModuleSections = $nombreclassModulo::getSections();
				$infoThisModule->name = (!isset($infoThisModule->name) || $infoThisModule->name == "") ? $nameModule : $infoThisModule->name;
				$classLink = (isset($section->controller) && isset($_GET['controller']) && $section->controller == $_GET['controller']) ? " class=\"active\"" : "";
				$moduloIcon = (isset($infoThisModule->icon) && $infoThisModule->icon != null && $infoThisModule->icon != "") ? " <i class=\"{$infoThisModule->icon}\"></i> " : "";
				
				$item->name = $nameModule;
				$item->nameClass = $nombreclassModulo;
				$item->title = (isset($infoThisModule->name) && $infoThisModule->name != null && $infoThisModule->name != "") ? $infoThisModule->name : "Nombre no detectado";
				$item->isActive = (isset($infoThisModule->isActive) && $infoThisModule->isActive != null && $infoThisModule->isActive != "") ? $infoThisModule->isActive : false;
				$item->author = (isset($infoThisModule->author) && $infoThisModule->author != null && $infoThisModule->author != "") ? $infoThisModule->author : "Anonimo";
				$item->icon = (isset($infoThisModule->icon) && $infoThisModule->icon != null && $infoThisModule->icon != "") ? " <i class=\"{$infoThisModule->icon}\"></i> " : "";
				$item->showTitleModule = (isset($infoThisModule->showTitleModule) && $infoThisModule->showTitleModule != null && $infoThisModule->showTitleModule != "") ? $infoThisModule->showTitleModule : false;
				$item->sections = $this->listarSections($infoThisModuleSections);
				$item->sections_total = $this->sumarSections($infoThisModuleSections);
				$item->views = array(); /* Definir `$item->modules`. */
				
				/* CAMBIAR A VALIDAR SI ES ARCHIVO VIEW */
				$folderView = folder_content . "/modules/{$nameModule}/view/";
				foreach(glob($folderView . "*[View].php") as $file){
					$file = str_replace($folderView, '', $file);
					$file = str_replace("View.php", '', $file);
					$itemV = new stdClass();
					$itemV->name = $file;
					
					$item->views[] = $file;
				};
				
				$item->views_total = count($item->views);
				$this->modules[] = $item;
			}
		}
	}
	
	public function sumarSections($sections){
		$r = 0;
		foreach($sections as $section){
			$r = $r + 1;
			if(isset($section->tree)){
				$r = $r + $this->sumarSections($section->tree);
			}
		}
		return $r;
	}
	
	public function listarSections($sections){
		$r = array();
		foreach($sections as $section){
			$r[] = $section;
			if(isset($section->tree)){
				foreach($this->listarSections($section->tree) as $section2){
					$r[] = $section2;
				}
			}
		}
		return $r;
	}
	
    public function linkUrl($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        return ("index.php?controller=".$controlador."&action=".$accion);
    }
	
    public function getModules() {
        return $this->modules;
    }
	
}
$menu = new ModulesAdmin();
#$json = $menu->getModules();
#echo json_encode($json);
?>
<div class="" id="app">
	<div class="page-title">
		<div class="title_left">
			<h3>Modulos <small>Todos los modulos</small></h3>
		</div>
	</div>
	<div class="clearfix"></div>
	
	<div class="row">
	
		<?php 
			$i = 0;
			foreach($menu->getModules() As $module){
				$i++;
		?>
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 widget2 widget_tally_box">
				<div class="x_panel fixed_height_390">
					<div class="x_content">
						<div class="flex">
							<ul class="list-inline widget_profile_box">
								<li><a><i class="fa fa-cog"></i></a></li>
                                <li><img src="<?php echo "/crm-content/uploads/avatar001.jpg"; ?>" alt="..." class="img-circle profile_img"></li>
                                <li><a><i class="fa fa-wrench"></i></a></li>
							</ul>
						</div>
						
						<h3 class="name"><?php echo "{$module->icon}{$module->title}"; ?></h3>
						<p class="author">Dev by <?php echo $module->author; ?></p>
						<div class="flex">
							<ul class="list-inline count2">
								<li>
									<h3><?php echo $module->sections_total; ?></h3>
									<span>sections</span>
								</li>
								<li>
									<h3><?php echo $module->views_total; ?></h3>
									<span>views</span>
								</li>
                                <li>
									<?php 
										echo ($module->isActive == true) ? "<h3><i class=\"fa fa-check\"></i></h3>" : "<h3><i class=\"fa fa-times\"></i></h3>";
									?>
									<span>Activo</span>
                                </li>
							</ul>
						</div>
						<p>
							<ul>
								<?php echo (class_exists($module->nameClass)) ? "<li>Controlador: <i class=\"fa fa-check\"></i></li>" : "<li>Controlador: <i class=\"fa fa-times\"></i></li>"; ?>
							</ul>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 widget2 widget_tally_box">
				<div class="x_panel fixed_height_390 table-responsive">
					<div class="x_content">
						<div class="" role="tabpanel" data-example-id="togglable-tabs">
							<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
								<li role="presentation" class="active"><a href="#<?php echo "{$i}"; ?>tab_content1" id="<?php echo "{$i}"; ?>home-tab" role="tab" data-toggle="tab" aria-expanded="true">Secciones en la clase (<?php echo count($module->sections); ?>)</a></li>
								<li role="presentation" class=""><a href="#<?php echo "{$i}"; ?>tab_content3" role="tab" id="<?php echo "{$i}"; ?>profile-tab2" data-toggle="tab" aria-expanded="false">Metodos (<?php echo count($module->sections); ?>)</a></li>
								<li role="presentation" class=""><a href="#<?php echo "{$i}"; ?>tab_content2" role="tab" id="<?php echo "{$i}"; ?>profile-tab" data-toggle="tab" aria-expanded="false">Archivos View.php (<?php echo count($module->views); ?>)</a></li>
							</ul>
							<div id="myTabContent" class="tab-content">
								<div role="tabpanel" class="tab-pane fade active in" id="<?php echo "{$i}"; ?>tab_content1" aria-labelledby="<?php echo "{$i}"; ?>home-tab">
									<div class="table table-responsive">
										<table class="table table-responsive table-hover">
											<?php 											
												foreach($module->sections as $sectionDetails){
													$sectionDetails->title = (isset($sectionDetails->title) && $sectionDetails->title != "" && $sectionDetails->title != null) ? $sectionDetails->title : "Sin titulo";
													$sectionDetails->controller = (isset($sectionDetails->controller) && $sectionDetails->controller != "") ? $sectionDetails->controller : null;
													$sectionDetails->action = (isset($sectionDetails->action) && $sectionDetails->action != "" && $sectionDetails->action != null) ? $sectionDetails->action : null;
													$sectionDetails->icon = (isset($sectionDetails->icon) && $sectionDetails->icon != "" && $sectionDetails->icon != null) ? " <i class=\"{$sectionDetails->icon}\"></i> " : "";
												
													$tempClass = new $module->nameClass();
													$sectionDetails->existExc = (method_exists($tempClass, $sectionDetails->action)) ? " <i class=\"fa fa-check\"></i> " : " <i class=\"fa fa-times\"></i> ";
													
													$link = (method_exists($tempClass, $sectionDetails->action) && $sectionDetails->controller != null && $sectionDetails->action != null) ? $this->linkUrl($sectionDetails->controller, $sectionDetails->action) : "#";
													#echo json_encode($sectionDetails);
													echo "<tr>";
														echo "<td>";
															echo "<h5>{$sectionDetails->icon}{$sectionDetails->title}</h5>";
														echo "</td>";
														echo "<td>";
															echo $sectionDetails->existExc;
														echo "</td>";
														echo "<td>";
															echo ($link != "#") ? "<a href=\"{$link}\" target=\"_blank\" class=\"btn btn-info btn-sm\">Abrir Seccion</a>" : "";
														echo "</td>";
													echo "</tr>";
													
												};
											?>
										</table>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="<?php echo "{$i}"; ?>tab_content2" aria-labelledby="<?php echo "{$i}"; ?>profile-tab">
									<div class="table table-responsive">
										<table class="table table-responsive table-hover">
											<?php 											
												foreach($module->views as $viewDetails){ echo "<tr><td><h5>{$viewDetails}</h5></tr>"; };
											?>
										</table>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="<?php echo "{$i}"; ?>tab_content3" aria-labelledby="<?php echo "{$i}"; ?>profile-tab">
									<div class="table table-responsive">
										<table class="table table-responsive table-hover">
											<?php 											 
												foreach($module->sections as $sectionDetails){
													$sectionDetails->title = (isset($sectionDetails->title) && $sectionDetails->title != "" && $sectionDetails->title != null) ? $sectionDetails->title : "Sin titulo";
													$sectionDetails->controller = (isset($sectionDetails->controller) && $sectionDetails->controller != "") ? $sectionDetails->controller : null;
													$sectionDetails->action = (isset($sectionDetails->action) && $sectionDetails->action != "" && $sectionDetails->action != null) ? $sectionDetails->action : null;
													$sectionDetails->icon = (isset($sectionDetails->icon) && $sectionDetails->icon != "" && $sectionDetails->icon != null) ? " <i class=\"{$sectionDetails->icon}\"></i> " : "";
												
													$tempClass = new $module->nameClass();
													foreach(get_class_methods($tempClass) as $method){
														if(
															$method != '__construct' 
															&& $method != '__string'
															&& $method != '__construct' 
															&& $method != '__destruct' 
															&& $method != '__call' 
															&& $method != '__callStatic' 
															&& $method != '__get' 
															&& $method != '__set' 
															&& $method != '__isset' 
															&& $method != '__unset' 
															&& $method != '__sleep' 
															&& $method != '__wakeup' 
															&& $method != '__toString' 
															&& $method != '__invoke' 
															&& $method != '__set_state' 
															&& $method != '__clone' 
															&& $method != '__debugInfo'
														){
															$link = ($sectionDetails->controller != null && $sectionDetails->action != null) ? $this->linkUrl($sectionDetails->controller, $method) : "#";
															echo "<tr>";
																echo "<td>";
																	echo "<h5>{$method}</h5>";
																echo "</td>";
																echo "<td>";
																	echo ($link != "#") ? "<a href=\"{$link}\" target=\"_blank\" class=\"btn btn-info btn-sm\">Ejecutar Comando</a>" : "";
																echo "</td>";
															echo "</tr>";
														}
													}
												};
											?>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>