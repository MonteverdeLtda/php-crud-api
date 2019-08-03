<?php 
class ThemesAdmin {
	private $themes;
	
	public function __construct(){	
		$this->themes = array();
		$themes = listar_directorios_ruta(folder_content . '/themes/', 10);
		foreach($themes as $theme){
			if(isset($theme->name)){
				$item = new stdClass();
				$item->name = $theme->name;
				$item->author = (isset($theme->author)) ? $theme->author : "Anonimo";
				$item->author_uri = (isset($theme->author_uri)) ? $theme->author_uri : "#";
				$item->description = (isset($theme->description)) ? $theme->description : "Sin descripcion";
				$item->version = (isset($theme->version)) ? $theme->version : "N.N.N";
				$item->licence = (isset($theme->licence)) ? $theme->licence : "GNU General Public License v2 or later";
				$item->licence_uri = (isset($theme->licence_uri)) ? $theme->licence_uri : "http://www.gnu.org/licenses/gpl-2.0.html";
				
				$fileInfo = json_decode(@file_get_contents(folder_content . "/themes/{$item->name}/{$item->name}.json"));
				
				
				$item->info = $fileInfo;
				$this->themes[] = $item;
			}
		}
		
	}
    public function getThemes() {
        return $this->themes;
    }
	
}
$list = new ThemesAdmin();
#$json = $menu->getModules();
#echo json_encode($json);

?>
<div class="" id="app">
	<div class="page-title">
		<div class="title_left">
			<h3>Temas <small>Todos los temas</small></h3>
		</div>
	</div>
	<div class="clearfix"></div>
	
	<div class="row">
	
		<?php 
			$i = 0;
			foreach($list->getThemes() As $theme){
				$i++;
		?>
			<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 widget2 widget_tally_box">
				<div class="x_panel fixed_height_390_" style="overflow-x: hidden;">
					<div class="x_content">
						<div class="flex">
							<ul class="list-inline widget_profile_box">
								<!-- // <li><a><i class="fa fa-cog"></i></a></li> -->
                                <li><img src="<?php echo "/crm-content/uploads/avatar001.jpg"; ?>" alt="..." class="img-circle profile_img"></li>
                                <!-- // <li><a><i class="fa fa-wrench"></i></a></li> -->
							</ul>
						</div>
						
						<h3 class="name"><?php echo ($theme->name); ?></h3>
						<p class="author">Dev by <?php echo ($theme->author); ?></p>
						<div class="flex">
							<ul class="list-inline count2">
								<li>
									<h3><?php echo $theme->info->version; ?></h3>
									<span>Version</span>
								</li>
                                <li>
									<?php echo (TEMA_DEFECTO == $theme->name) ? "<h3><i class=\"fa fa-check\"></i></h3>" : "<h3><i class=\"fa fa-times\"></i></h3>"; ?>
									<span>Activo</span>
                                </li>
							</ul>
						</div>
						<p>
							<?php echo $theme->info->description; ?>
						</p>
						<p>
							<h4>Todo</h4>
							<div class="table-responsive">
								<?php 
									$html = "<div class=\"container-debug table table-responsive\" style=\"width:100%\"><table class=\"table table-responsive\">";
										foreach($theme->info as $k => $v){
											if($k != 'name' && $k != 'version' && $k != 'description'){
												$html .= "<tr>";
													$html .= "<th>{$k}</th>";
													if(is_array($v) || is_object($v)){ $html .= "<td>" . json_encode($v) . "</td>"; } 
													else { $html .= "<td>".($v)."</td>"; }
												$html .= "</tr>";
											}
										}
									$html .= "</table></div>";
									echo $html;
								?>
							</div>
						</p>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>