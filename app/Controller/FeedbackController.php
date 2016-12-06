<?php
App::uses('AppController', 'Controller');
class FeedbackController   extends AppController {
	public $components = array('RequestHandler','ImageUploader');
	public function beforeFilter()
	{
		parent::beforeFilter();
	}
	
	public function index()
	{
		
		$this->layout = "feedbacks";
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
		if($this->RequestHandler->isAjax()){
			$this->autoRender = false;
			$id = $this->request->data['id'];
			$item = $this->Feedback->read(null,$id);
			echo json_encode($item);
			return;
		}
		$msg_success = "";
		$loading ="";
		$welcome = "";
		$logged = $this->Session->read('Auth.User');
		$id = 3;
		$Data_User = array("id" => 3, "Name" => "Khách");
		if(isset($logged))
		{
			if(isset($logged['id']))
			{
				$Data_User = array("id" => $logged['id'], "Name" => $logged['name']);
				$welcome = "Chào mừng <b>".$logged['name']."</b>";
				$id = $logged['id'];
			}
			else
			{
				$welcome = "Bạn đang dùng tài khoản Khách vui lòng đăng nhập để hưởng các ưu đãi.";
				$id = 3;
			}

		}
		else
		{
			$welcome = "Bạn đang dùng tài khoản Khách vui lòng đăng nhập để hưởng các ưu đãi.";
			$id = 3;
		}
		if($this->RequestHandler->isPost()){
			if(!isset($this->request->form['img']))
			{
				$this->Session->setFlash('Bạn chưa chọn ảnh mà!','flash_error');
					return $this->redirect(array(
						'controller' => 'Feedback',
						'action' => 'index',
				));
			}
			else
			{
				$logged = $this->Session->read('Auth.User');
				$files = $this->request->form['img'];
			//	$GoogleUpload = new GoogleDriveImage();
				$url = array();
				$sql_url = "";
				if(isset($files['type']))
				{
					if(strpos("a".$files['type'],"image/"))
					{
						$fileDestination = "files/upload/feedback/";
                         $options = array(
                            'max_width'=>600,
                            'max_height' => 600,
                        );  
                       
                        $ext = $this->get_file_ext($files['name']);
                        $files['name'] = md5($this->request->data['username'].time().rand(0,99999)).$ext; 
                        try{
                            $output = $this->ImageUploader->upload($files,$fileDestination,$options);
                        }catch(Exception $e){
                                $message = $e->getMessage();
                                $this->error_detail(9999, $message);
                        }
                        if ($output['bool'] == 1)
                        {
                            $url = "http://hairspa.vn/".$output['file_path'];
                        } else 
                        {
                            $this->error(1007);
                            return;
                            
                        }
					//	$sql_url .= $GoogleUpload->uploadimage($files['tmp_name']);
					//	$url[] = $sql_url;
					}
				}
				$Question = $this->Feedback->create();
				$InsertQuestion = $this->Feedback->save( 
					array(
						'user_id' => $id,
						'images' => $url,
						'detail' => $this->request->data['comment'],
						'approved' => 0,
						'username' => $this->request->data['username'],
					)
				);
				$this->Session->setFlash('Bạn đã đăng khoảnh khắc thành công!','flash_success');
					return $this->redirect(array(
						'controller' => 'Feedback',
						'action' => 'index',
				));
			}
		}
			
		$Feedbacks = $this->Feedback->find("all",		
		array(
			'order' => 'id desc',
			'limit' => 10,
			)
		);
		$this->set(compact('welcome'));
		$this->set(compact('msg_success'));
		$this->set(compact('loading'));
		$this->set(compact('Feedbacks'));
		$this->set(compact('img_news'));
		$this->set(compact('Data_User'));
	}
	public function loadmore($page = 1){
		$this->layout = false;
		$this->autoRender = false;
		$offset = ($page - 1) * 10;
		$Feedbacks = $this->Feedback->find("all",		
		array(
			'order' => 'id desc',
			'offset' => $offset,
			'limit' => 10,
			)
		);
		$this->set(compact('Feedbacks'));
		$this->render("/Elements/Feedback/index");
		return;
	}

	public function admin_index()
	{
		$this->Paginator = $this->Components->load('Paginator');

		$this->Paginator->settings = array(
			'Feedback' => array(
				'contain' => array('User'),
				'recursive' => -1,
				'order' => array(
					'created' => 'DESC'
				),
				'limit' => 20,
				'paramType' => 'querystring',
			)
		);
		$Feedbacks = $this->Paginator->paginate();

		$this->set(compact('Feedbacks'));

	}

	public function admin_approved()
	{
		$id = intval($this->params->pass[0]);
		if($id>0)
		{

			$feedback = $this->Feedback->read(null,$id);
			$app_val = $feedback['Feedback']['approved'];
			$new_val = 0;
			if($app_val == 0)
				$new_val = 1;
			$this->Feedback->create();
			$this->Feedback->id = $id;
			$this->Feedback->save(array("approved"=> $new_val));
			$this->Session->setFlash('Đã duyệt ảnh thành công','flash_success');
					return $this->redirect(array(
						'controller' => 'Feedback',
						'action' => 'admin_index',
					));
		}
	}
	
	public function admin_del()
	{
		$id = intval($this->params->pass[0]);
		if($id>0)
		{
			$this->Feedback->create();
			$this->Feedback->id = $id;
			if ($this->Feedback->exists()) 
			{
				$this->Feedback->delete();
				$this->Session->setFlash('Đã xoá thành công','flash_success');
						return $this->redirect(array(
							'controller' => 'Feedback',
							'action' => 'admin_index',
				));
			}
			else
			{
				$this->Session->setFlash('Ảnh không tồn tại','flash_error');
						return $this->redirect(array(
							'controller' => 'Feedback',
							'action' => 'admin_index',
				));
			}
		}
	}

	public function detail($id){
		$this->layout = "news";
		$detail = $this->Feedback->read(null,$id);
		$this->header['title'] = "Feedback của ".$detail['Feedback']['username']." sau khi làm tóc tại ThanhHuyen Salon";
		$this->header['description'] =  strip_tags($detail['Feedback']['detail']);
		$this->header['image'] = $detail['Feedback']['images'];
		$this->set(compact('detail'));
	}
	private function get_file_ext($name){
        // Get file extension
        $path_part = explode(".", $name);
        $file_ext = count($path_part) > 1 ? ('.' . end($path_part)) : '';
        return $file_ext;
    }
}
?>