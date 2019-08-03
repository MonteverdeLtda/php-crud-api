<?php 
$picture = new PicturesModel();
if(isset($_GET['id']) && ((int) $_GET['id']) > 0){
	$b = $picture->getById($_GET['id']);
}else{
	exit("KO");
}
?>
<!-- image cropping -->

	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<!-- image cropping -->
		<div class="container cropper">
		  <div class="row">
			<div class="col-md-9">
			  <div class="img-container">
				<img id="image" src="<?php echo "/index.php?controller=Sistema&action=picture&id={$b->id}&w=original"; ?>" alt="Picture">
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="docs-preview clearfix">
				<div class="img-preview preview-lg"></div>
				<div class="img-preview preview-md"></div>
				<div class="img-preview preview-sm"></div>
				<div class="img-preview preview-xs"></div>
			  </div>

			  <div class="docs-data">
				<!-- // 
				<div class="input-group input-group-sm">
				  <label class="input-group-addon" for="dataX">X</label>
				  <input type="text" class="form-control" id="dataX" placeholder="x">
				  <span class="input-group-addon">px</span>
				</div>
				<div class="input-group input-group-sm">
				  <label class="input-group-addon" for="dataY">Y</label>
				  <input type="text" class="form-control" id="dataY" placeholder="y">
				  <span class="input-group-addon">px</span>
				</div>
				-->
				<div class="input-group input-group-sm">
				  <label class="input-group-addon" for="dataWidth">Ancho (Píxeles)</label>
				  <input type="text" class="form-control" id="dataWidth" placeholder="width">
				  <span class="input-group-addon">px</span>
				</div>
				<div class="input-group input-group-sm">
				  <label class="input-group-addon" for="dataHeight">Alto (Píxeles)</label>
				  <input type="text" class="form-control" id="dataHeight" placeholder="height">
				  <span class="input-group-addon">px</span>
				</div>
				<div class="input-group input-group-sm">
				  <label class="input-group-addon" for="dataRotate">Rotar</label>
				  <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
				  <span class="input-group-addon">deg</span>
				</div>
				<!-- // 
				<div class="input-group input-group-sm">
				  <label class="input-group-addon" for="dataScaleX">Scalar X</label>
				  <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
				</div>
				<div class="input-group input-group-sm">
				  <label class="input-group-addon" for="dataScaleY">Scalar Y</label>
				  <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
				</div>
				-->
				<div class="input-group input-group-sm docs-toggles">
					  <!-- <h3 class="page-header">Toggles:</h3> -->
					  <div class="btn-group btn-group-justified" data-toggle="buttons">
						<label class="btn btn-primary active">
						  <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
						  <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 16 / 9">
							16:9
						  </span>
						</label>
						<label class="btn btn-primary">
						  <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
						  <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 4 / 3">
							4:3
						  </span>
						</label>
						<label class="btn btn-primary">
						  <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
						  <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 1 / 1">
							1:1
						  </span>
						</label>
						<label class="btn btn-primary">
						  <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
						  <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 2 / 3">
							2:3
						  </span>
						</label>
						<label class="btn btn-primary">
						  <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
						  <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: NaN">
							Free
						  </span>
						</label>
					  </div>

					  <div class="btn-group btn-group-justified" data-toggle="buttons">
						<label class="btn btn-primary active">
						  <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
						  <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
							Ajustar
						  </span>
						</label>
						<label class="btn btn-primary">
						  <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
						  <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
							Rellenar
						  </span>
						</label>
						<!-- // 
						<label class="btn btn-primary active">
						  <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
						  <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
							VM0
						  </span>
						</label>
						<label class="btn btn-primary">
						  <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
						  <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
							VM1
						  </span>
						</label>
						<label class="btn btn-primary">
						  <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
						  <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
							VM2
						  </span>
						</label>
						<label class="btn btn-primary">
						  <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
						  <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
							VM3
						  </span>
						</label>
						-->
					  </div>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-9 docs-buttons">
			  <!-- <h3 class="page-header">Toolbar:</h3> -->
			  <div class="btn-group">
				<button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Mover Imagen">
					<span class="fa fa-arrows"></span>
				  </span>
				</button>
				<button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Recortar Imagen">
					<span class="fa fa-crop"></span>
				  </span>
				</button>
			  </div>

			  <div class="btn-group">
				<button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Aumentar Zoom">
					<span class="fa fa-search-plus"></span>
				  </span>
				</button>
				<button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Reducir Zoom">
					<span class="fa fa-search-minus"></span>
				  </span>
				</button>
			  </div>

			  <div class="btn-group">
				<button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Mover imagen (Izquierda)">
					<span class="fa fa-arrow-left"></span>
				  </span>
				</button>
				<button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Mover imagen (Derecha)">
					<span class="fa fa-arrow-right"></span>
				  </span>
				</button>
				<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Mover imagen (Arriba)">
					<span class="fa fa-arrow-up"></span>
				  </span>
				</button>
				<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Mover imagen (Abajo)">
					<span class="fa fa-arrow-down"></span>
				  </span>
				</button>
			  </div>

			  <div class="btn-group">
				<button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Rotar a la izquierda">
					<span class="fa fa-rotate-left"></span> 
				  </span>
				</button>
				<button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Rotar a la derecha">
					<span class="fa fa-rotate-right"></span> 
				  </span>
				</button>
			  </div>

			  <div class="btn-group">
				<button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Voltear Horizontalmente">
					<span class="fa fa-arrows-h"></span> 
				  </span>
				</button>
				<button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Voltear Verticalmente">
					<span class="fa fa-arrows-v"></span> 
				  </span>
				</button>
			  </div>

			  <div class="btn-group">
				<button type="button" class="btn btn-primary" data-method="disable" title="Disable">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Bloquear Movimiento">
					<span class="fa fa-lock"></span>
				  </span>
				</button>
				<button type="button" class="btn btn-primary" data-method="enable" title="Enable">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Desbloquear Movimiento">
					<span class="fa fa-unlock"></span>
				  </span>
				</button>
			  </div>

			  <div class="btn-group">
				<!-- //
				<label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
				  <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Subir imagen">
					<span class="fa fa-upload"></span> 
					Subir imagen
				  </span>
				</label>
				-->
				
			  </div>

			  <div class="btn-group btn-group-crop">
				<button type="button" class="btn btn-primary" data-method="getCroppedCanvas">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Guardar Imagen">
					Guardar Imagen
				  </span>
				</button>
				<button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Guardar Imagen (160&times;90)">
					Guardar Imagen (160&times;90)
				  </span>
				</button>
				<button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
				  <span class="docs-tooltip" data-toggle="tooltip" title="Guardar Imagen (320&times;180)">
					Guardar Imagen (320&times;180)
				  </span>
				</button>
			  </div>

			  <!-- Show the cropped image in modal -->
			  <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					  <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.png">Download</a>
					</div>
				  </div>
				</div>
			  </div><!-- /.modal -->
			  <button type="button" class="btn btn-primary" data-method="moveTo" data-option="0">
				<span class="docs-tooltip" data-toggle="tooltip" title="cropper.moveTo(0)">
				  0,0
				</span>
			  </button>
			  <button type="button" class="btn btn-primary" data-method="zoomTo" data-option="1">
				<span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoomTo(1)">
				  100%
				</span>
			  </button>
			  <button type="button" class="btn btn-primary" data-method="rotateTo" data-option="180">
				<span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotateTo(180)">
				  180°
				</span>
			  </button>
			</div><!-- /.docs-buttons -->

			<div class="col-md-3">

			</div><!-- /.docs-toggles -->
		  </div>
		</div>
		<!-- /image cropping -->
	  </div>
	</div>
<!-- /image cropping -->