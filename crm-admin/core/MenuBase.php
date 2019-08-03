<?php 
class MenuBase {
	public $allmodules;
	
	public function __construct(){
		$this->allmodules = $this->getModules();
	}
	
	public function loadMenu($typeMenu){
		echo $typeMenu;
	}
	
	public static function getModules() : array {
		$Mydir = folder_content . '/modules/';
		$dirs = array();
		foreach(glob($Mydir.'*', GLOB_ONLYDIR) as $dir) {
			$dir = str_replace($Mydir, '', $dir);
			$dirs[] = $dir;
		}
		return $dirs;
	}
}
