<?php 

$html = "";
foreach($this as $key => $value){
	$html .= "<h5>{$key}</h5>\n";
	if(is_array($value) || is_object($value)){
		echo $this->tableDebug($value)."\n <hr>\n";
	}
	else {
		
	}
	$html .= "<hr>\n";
	/*
	if(is_array($value) || is_object($value)){
		echo "<h5>{$key}</h5>\n";
		
	} else {
		echo "<h5>" . json_encode($key) . "</h5>\n";
		echo json_encode({$value})."\n";
	}*/
}
?>

<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Consola Debug</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="">
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<h4>empty</h4>
					<?php echo $this->tableDebug(); ?>
					<h4>$This</h4>
					<?php echo $this->tableDebug($this); ?>
				</div>
			</div>
		</div>
	</div>
</div>