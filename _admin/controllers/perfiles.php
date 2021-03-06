<?php 
Class Perfiles extends Controller{

	
	public function __construct(){
		parent::__construct();
		if(isset($_POST['formulario_perfiles'])){ 
			if($_POST['id'] > 0){
					$this->edit($_POST); 
				   
			}else{
				
					$this->save($_POST); 
			}
			
			header('Location: perfiles');
		}	
		 
		if(isset($_GET['delete'])){
				$this->del($_GET['delete']);
		}
		
	}
	// public function loadModel($model){
	// 	$url = 'model/'.$model.'.php';
    //     if (file_exists($url)){
    //         require $url;
    //         $modelName = $model.'Modelo';
    //         $this->model = new $modelName();
    //     }
    // }
	
	
	function render(){
		
		$perfiles = $this->model->getList();
		$this->view->perfiles = $perfiles;
        $this->view->render("perfiles/index",$perfiles);
    }


	public function del($id){
		
		$this-> db = new Database();
        $this -> db = $this -> db -> conectar();
		$query = 'SELECT count(1) as cantidad FROM perfil WHERE id = '.$id;
		$consulta = $this->db->query($query)->fetch(PDO::FETCH_OBJ);
		if($consulta->cantidad){
			$query = "UPDATE `perfil` SET `activo`= 0  WHERE id = ".$id."; ";
			$this->db->exec($query); 
			return 1;
		}
		
	}
	public function save($data){
		$this-> db = new Database();
        $this -> db = $this -> db -> conectar();
            foreach($data as $key => $value){
				
				if(!is_array($value)){
					if($value != null){
						$columns[]=$key;
						$datos[]=$value;
					}
				}
			}
			//var_dump($datos);die();
            $sql = "INSERT INTO perfil(".implode(',',$columns).") VALUES('".implode("','",$datos)."')";
			//echo $sql;die();
			
            $this->  db ->exec($sql);
			$id = $this-> db ->lastInsertId();
			   			
			$sql = '';
			foreach($data['permisos'] as $permisos){
				$sql .= 'INSERT INTO perfil_permisos(perfil_id,permiso_id) 
							VALUES ('.$id.','.$permisos.');';
			}
 			$this->  db ->exec($sql);
			 
	} 
	
	

// 	public function edit($data){
		
// 		$data['activo'] = isset($_POST['activo'])?1:0;
		
// 		$id = $data['id'];
// 		unset($data['id']);
// 	$this-> db = new Database();
// 	$this -> db = $this -> db -> conectar();
// 		// foreach($data as $key => $value){
// 		// 	if(!is_array($value)){
// 		// 		if($value != null){	
// 		// 			$columns[]=$key." = '".$value."'"; 
// 		// 		}
// 		// 	}
// 		// }
// 		// $sql = "UPDATE marcas SET ".implode(',',$columns)." WHERE id = ".$id;
// 		$sql = "UPDATE marcas SET id=$id, nombre= ".'"'.$data['nombre'].'"'.", activo= ".$data['activo']." WHERE id = $id";
		
// 		$this-> db-> exec($sql);

// 		header('Location: marcas');
// } 
// }
	public function edit($data){
			$data['activo'] = isset($_POST['activo'])?1:0;
			$id = $data['id'];
			unset($data['id']);
        $this-> db = new Database();
        $this -> db = $this -> db -> conectar();
            foreach($data as $key => $value){
				if(!is_array($value)){
					if($value != null){	
						$columns[]=$key." = '".$value."'"; 
					}
				}
            }
            // $sql = "UPDATE perfil SET ".implode(',',$columns)." WHERE id = ".$id;
            $sql = "UPDATE perfil SET id=$id, nombre= ".'"'.$data['nombre'].'"'.", activo= ".$data['activo']." WHERE id = $id";
            $this-> db-> exec($sql);
			
			 
			 
			$sql = 'DELETE FROM perfil_permisos WHERE perfil_id= '.$id;
			$this->  db->exec($sql);
			
			$sql = '';
			foreach($data['permisos'] as $permisos){
				$sql .= 'INSERT INTO perfil_permisos(perfil_id,permiso_id) 
							VALUES ('.$id.','.$permisos.');';
			}
			$this->  db->exec($sql);
			header('Location: perfiles');
	} 
}
?>