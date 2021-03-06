<?php 
Class Categorias extends Controller{

	
	public function __construct(){
		parent::__construct();
		if(isset($_POST['formulario_categorias'])){ 
			if($_POST['id'] > 0){
					$this->edit($_POST); 
				   
			}else{
				
					$this->save($_POST); 
			}
			
			header('Location: categorias');
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
		
		$categorias = $this->model->getList();
		$this->view->categorias = $categorias;
        $this->view->render("categorias/index",$categorias);
    }

	public function del($id){
		var_dump($id);
		$this-> db = new Database();
        $this -> db = $this -> db -> conectar();
		$query = 'SELECT count(1) as cantidad FROM categorias WHERE id = '.$id;
		$consulta = $this->db->query($query)->fetch(PDO::FETCH_OBJ);
		if($consulta->cantidad){
			$query = "UPDATE `categorias` SET `activo`= 0  WHERE id = ".$id."; ";
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
            $sql = "INSERT INTO categorias( ".implode(',',$columns).") VALUES('".implode("','",$datos)."')";
			//echo $sql;die();
			
            $this->  db ->exec($sql);
			
			 
	} 
	
	

	
	public function edit($data){
		
			$data['activo'] = isset($_POST['activo'])?1:0;
			
			$id = $data['id'];
			unset($data['id']);
        $this-> db = new Database();
        $this -> db = $this -> db -> conectar();
            // foreach($data as $key => $value){
			// 	if(!is_array($value)){
			// 		if($value != null){	
			// 			$columns[]=$key." = '".$value."'"; 
			// 		}
			// 	}
            // }
            // $sql = "UPDATE marcas SET ".implode(',',$columns)." WHERE id = ".$id;
			$sql = "UPDATE categorias SET id=$id, nombre= ".'"'.$data['nombre'].'"'.", activo= ".$data['activo']." WHERE id = $id";
			
            $this-> db-> exec($sql);

			header('Location: categorias');
	} 
}
?>