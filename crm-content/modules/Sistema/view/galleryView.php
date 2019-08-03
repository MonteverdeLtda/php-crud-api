<?php 

?>


<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3> Galería <small> </small> </h3>
		</div>
	</div>
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Biblioteca <small> Imagenes </small></h2>
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
					<div class="row">
						<p>Imagenes en la DB.</p>
						<?php 
							$picture = new PicturesModel();
							foreach($picture->getAll() as $i){
								if(isset($i->id)){
									$b = new PicturesModel();
									$item = $b->getById($i->id);
									
									?>
									<div class="col-md-55">
										<div class="thumbnail">
											<div class="image view view-first">
												<img style="width: 100%; display: block;" src="<?php echo "/index.php?controller=Sistema&action=picture&id={$item->id}"; ?>" alt="image" />
												<div class="mask">
													<p><?php echo $item->name; ?></p>
													<div class="tools tools-bottom">
														<a target="_blank" href="<?php echo "/index.php?controller=Sistema&action=picture&id={$item->id}&w=original"; ?>"><i class="fa fa-link"></i></a>
														<a href="<?php echo "/index.php?controller=Sistema&action=picture_editor&id={$item->id}"; ?>"><i class="fa fa-pencil"></i></a>
														<a href="#"><i class="fa fa-times"></i></a>
													</div>
												</div>
											</div>
											<div class="caption"><p><?php #echo $item->description; ?></p></div>
										</div>
									</div>
									<?php 
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

