<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */
?>
<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <title>Ejemplo PHP MySQLi POO MVC</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <style>
            input{
                margin-top:5px;
                margin-bottom:5px;
            }
            .right{
                float:right;
            }
        </style>
    </head>
    <body>
         
        <div class="col-lg-7">
            <h3><?php echo $title; ?></h3>
			<p><?php echo $description; ?></p>
            <hr/>
        </div>
        <section class="col-lg-7 usuario" style="height:400px;overflow-y:scroll;">
            <?php foreach($allpermissions as $permission) {
				//recorremos el array de objetos y obtenemos el valor de las propiedades 
				
			?>
                <?php echo $permission->id; ?> -
                <?php echo $permission->name; ?> -
                <?php echo json_encode($permission->data); ?>
                <div class="right">
					<!-- // 
                    <a href="<?php echo $helper->url("permisos","borrar"); ?>&id=<?php echo $permission->id; ?>" class="btn btn-danger">Borrar</a> -->
                </div>
                <hr/>
            <?php } ?>
        </section>
        <footer class="col-lg-12">
            <hr/>
           CRM + API REST CURL - Copyright &copy; <?php echo  date("Y"); ?>
        </footer>
    </body>
</html>
