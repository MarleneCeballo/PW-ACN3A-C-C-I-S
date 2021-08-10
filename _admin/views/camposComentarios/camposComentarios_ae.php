<?php 
require('inc/header.php');

?> 

<div class="container-fluid">
      
      <?php $comentariosCamposMenu = 'ComentariosCampos';
	    include('inc/side_bar.php');
        if(isset($_GET['editar'])){
        $campos = $this -> comentarios;
        
        }
       
     
	   if(  !in_array('user.add',$_SESSION['usuarios']['permisos']['cod']) &&		
			!in_array('user.edit',$_SESSION['usuarios']['permisos']['cod']) ){ 
				header('Location: index.php');
			}
	
	
	
	
	?>
	  
	  
        
        <div class="col-sm-9 col-md-10 main">
     
          <p class="visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
          </p>
          
	  <h1 class="page-header">
      <?php  if(isset($_GET['editar'])){
                    echo "Editar Campo Comentario";
                } else { echo "Nuevo Campo Comentario";}
                  
                ?>
                   
          </h1>
  
          <div class="col-md-2"></div>
            <form action="camposComentarios" method="post" class="col-md-6 from-horizontal">
            <div class="form-group">
                    <label for="type" class="col-sm-2 control-label">Type</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="type" name="type" placeholder="" value="<?php echo isset($campos->type)?$campos->type:'';?>">
                    </div>
                </div> 
                <div class="form-group">
                    <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="" value="<?php echo isset($campos->nombre)?$campos->nombre:'';?>">
                    </div>
                </div> 
                <div class="form-group">
                    <label for="opciones" class="col-sm-2 control-label">Opciones: (Dividir por un |)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="opciones" name="opciones" placeholder="" value="<?php echo isset($campos->opciones)?$campos->opciones:'';?>">
                    </div>
                </div> 
           
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                        <input type="checkbox" name="activo" value="1" <?php echo (isset($campos->activo)?(($campos->activo == 1) ?'checked':''):'');?>> Activo
                        </label>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="formulario_camposComentarios">Guardar</button>
                    </div>
                </div> 
                <input type="hidden" class="form-control" id="id" name="id" placeholder="" value="<?php echo isset($campos->id)?$campos->id:'';?>">

            </form>
          </div>
 
          
      </div><!--/row-->
	</div>
</div><!--/.container-->

<?php 


include('inc/footer.php');?>