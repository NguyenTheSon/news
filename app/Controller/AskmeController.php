<?php
App::uses('AppController', 'Controller');
class AskmeController   extends AppController {
	public $components = array('RequestHandler','ImageUploader');
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->loadModel('Question');
		$this->loadModel('User');
	}
		
	public function index()
	{
		$this->layout = "news";
 // [UserID] => -1
   // [FullName] => ádasdasd
//    [Email] => acz@asda.ocm
//    [AppointmentContactNumber] => 123213213
//    [Date] => 30/09/2015
//    [MobileDate] => 
//   [Time] => 02:00pm
//   [Service] => Array
//        (
//            [1] => option2
//            [2] => option1
//            [3] => option2
//        )

//)

				$msg_success = "";
				$loading ="";
		if(isset($this->request->data['UserID']))
		{
			$files = $this->request->data['img'];
			 //danh sach cac file
			$url = array();
			$sql_url = "";
			foreach ($files as $key => $file) {
				if(isset($file['type']))
				{
					if(strpos("a".$file['type'],"image/"))
					{
							$fileDestination = "files/upload/askme/";
	                         $options = array(
	                            'max_width'=>600,
	                            'max_height' => 600,
	                        );  
	                       
	                        $ext = $this->get_file_ext($file['name']);
	                        $file['name'] = md5($file['name'].time().rand(0,99999)).$ext; 
	                        try{
	                            $output = $this->ImageUploader->upload($file,$fileDestination,$options);
	                        }catch(Exception $e){
	                                $message = $e->getMessage();
	                                $this->error_detail(9999, $message);
	                        }
	                        if ($output['bool'] == 1)
	                        {
	                            $url[] = "http://hairspa.vn/".$output['file_path'];
	                        } else 
	                        {
	                            $this->error(1007);
	                            return;
	                            
	                        }
					}
				}
			}
			//$this->layout = false;
				$Question = $this->Question->create();
				$InsertQuestion = $this->Question->save( 
					array(
						'user_id' => $this->request->data['UserID'],
						'question' => $this->request->data['title'],
						'content' => $this->request->data['content'],
						'approved' => 0,
						'image' => implode($url,"|"),
					//	'created' => $this->request->data['Time'],
					)
				);
				$msg_success = "<div class='alert alert-success'><strong>Thành công!</strong> Chúng tôi đã nhận được câu hỏi của bạn!</div>";
				$loading = "";

		}
		
		

		$Questions = $this->Question->find("all",		
		array(
			"order" => array("Question.id DESC"),
			"limit" => "10"
			)
		);
		$this->set(compact('msg_success'));
		$this->set(compact('loading'));
		$this->set(compact('Questions'));
	}
	
	public function detail()
	{
		$this->layout = "news";
		$id = intval($this->params->pass[0]);
		if($id>0)
		{

			$detail = $this->Question->read(null,$id);
			$detail["Question"]["url"] = Router::url("/",true).$id;
			$this->set(compact('detail'));
		}
	}

	public function admin_index($val = 0)
	{
		if($val == 0)
		{
			$conditions = array();
		}
		else if($val == 1)
		{
			$conditions = array("answer" => "");
		}
		else
		{
			$conditions = array("answer !=" => "");
		}
		if($this->RequestHandler->isAjax()){
			$this->Paginator = $this->Components->load('Paginator');

			$this->Paginator->settings = array(
				'Question' => array(
					'contain' => array(
						"User",
					),
					'conditions' => $conditions,
					'order' => array(
						'Question.id' => 'DESC'
					),
					'limit' => 5,
					'paramType' => 'querystring',
				)
			);
			$Questions = $this->Paginator->paginate("Question");
			$this->set(compact("Questions"));
			$this->Render("/Elements/Askme/admin_index");
			return;
		}
		
		$this->Paginator = $this->Components->load('Paginator');

		$this->Paginator->settings = array(
				'Question' => array(
					'contain' => array(
						"User",
					),
					'conditions' => $conditions,
					'order' => array(
						'Question.id' => 'DESC'
					),
					'limit' => 5,
					'paramType' => 'querystring',
				)
			);
		$Questions = $this->Paginator->paginate("Question");
		$this->set(compact("Questions"));
	}

	public function admin_approved()
	{
		$id = intval($this->params->pass[0]);
		if($id>0)
		{

			$Question = $this->Question->read(null,$id);
			$app_val = $Question['Question']['approved'];
			$new_val = 0;
			if($app_val == 0)
				$new_val = 1;
			$this->Question->create();
			$this->Question->id = $id;
			$this->Question->save(array("approved"=> $new_val));
			$this->Session->setFlash('Đã duyệt câu hỏi thành công','flash_success');
					return $this->redirect(array(
						'controller' => 'Askme',
						'action' => 'admin_index',
					));
		}
	}
	

	public function admin_del()
	{
		$id = intval($this->params->pass[0]);
		if($id>0)
		{
			$this->Question->create();
			$this->Question->id = $id;
			if ($this->Question->exists()) 
			{
				$this->Question->delete();
				$this->Session->setFlash('Đã xoá thành công','flash_success');
						return $this->redirect(array(
							'controller' => 'Askme',
							'action' => 'admin_index',
				));
			}
			else
			{
				$this->Session->setFlash('câu hỏi không tồn tại','flash_error');
						return $this->redirect(array(
							'controller' => 'Askme',
							'action' => 'admin_index',
				));
			}
		}
	}

	public function admin_answer()
	{
		if($this->RequestHandler->isPost()){
			pr($this->request->data);
			$id = intval($this->params->pass[0]);
			$this->Question->create();
			$this->Question->id = $id;
			if ($this->Question->exists()) 
			{
				$this->Question->save(
					array
					(
						"answer" => $this->request->data['Question']['answer'],
					)
				);
				$this->Session->setFlash('Đã lưu thành công','flash_success');
						return $this->redirect(array(
							'controller' => 'Askme',
							'action' => 'admin_index',
				));
			}
			exit;
		}
		$id = intval($this->params->pass[0]);
		if($id>0)
		{
			$this->Question->create();
			$this->Question->id = $id;
			if ($this->Question->exists()) 
			{
				$Question = $this->Question->read(null,$id);
				$this->set(compact("Question"));
			}
		}
	}
	private function get_file_ext($name){
        // Get file extension
        $path_part = explode(".", $name);
        $file_ext = count($path_part) > 1 ? ('.' . end($path_part)) : '';
        return $file_ext;
    }
}
?>