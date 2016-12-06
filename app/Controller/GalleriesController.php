<?php
App::uses('AppController', 'Controller');
class GalleriesController  extends AppController {
	public $components = array('RequestHandler',);
	public function beforeFilter()
	{
		parent::beforeFilter();
		
	}
	
	public function index()
	{
		$this->layout = "news";
		if($this->RequestHandler->isAjax()){
			$this->autoRender = false;
			$id = $this->request->data['id'];
			$item = $this->Gallery->read(null,$id);
			if($item['Gallery']['video']!="")
			{
				preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $item['Gallery']['video'], $img);
				$item['Gallery']['image'] = "http://img.youtube.com/vi/".$img[1]."/0.jpg";
				$item['Gallery']['video'] = $img[1];
			}
			echo json_encode($item);
			return;
		}
		$galleries = $this->Gallery->find("all",array(
			"limit" => "30",
			"order" => "rand()",
		));
		foreach ($galleries as $key => $item) {
			if($item['Gallery']['video']!="")
			{
				preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $item['Gallery']['video'], $img);
				$galleries[$key]['Gallery']['image'] = "http://img.youtube.com/vi/".$img[1]."/0.jpg";

			}
			else if(substr($item['Gallery']['image'],0,4) !="http"){
				$galleries[$key]['Gallery']['image'] = Router::url("/", true). $galleries[$key]['Gallery']['image'];
			}
		}
		$this->set(compact("galleries"));
		####################
		$galleries = $this->Gallery->find("all",array(
			"limit" => "10",
			"order" => "id desc",
			"offset" => 0,
		));
		foreach ($galleries as $key => $item) {
			if($item['Gallery']['video']!="")
			{
				preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $item['Gallery']['video'], $img);
				$galleries[$key]['Gallery']['image'] = "http://img.youtube.com/vi/".$img[1]."/0.jpg";

			}
			else if(substr($item['Gallery']['image'],0,4) !="http"){
				$galleries[$key]['Gallery']['image'] = Router::url("/", true). $galleries[$key]['Gallery']['image'];
			}
		}
		$this->set("galleries_m",$galleries);
	}
	public function loadmore($page = 1){
		$this->layout = false;
		$this->autoRender = false;
		$offset = ($page - 1) * 10;
		$galleries = $this->Gallery->find("all",array(
			"limit" => "10",
			"order" => "id desc",
			"offset" => $offset,
		));
		foreach ($galleries as $key => $item) {
			if($item['Gallery']['video']!="")
			{
				preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $item['Gallery']['video'], $img);
				$galleries[$key]['Gallery']['image'] = "http://img.youtube.com/vi/".$img[1]."/0.jpg";

			}
			else if(substr($item['Gallery']['image'],0,4) !="http"){
				$galleries[$key]['Gallery']['image'] = Router::url("/", true). $galleries[$key]['Gallery']['image'];
			}
		}
		$this->set(compact("galleries"));
		$this->render("/Elements/Galleries/index");
		return;
	}

	public function detail($id= null){
		$this->layout = "news";
		$item = $this->Gallery->read(null,$id);
		if(!$item){
			throw new NotFoundException('Sai ID');
		}
		if($item['Gallery']['video']!="")
		{
			preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $item['Gallery']['video'], $img);
			$item['Gallery']['image'] = "http://img.youtube.com/vi/".$img[1]."/0.jpg";
			$item['Gallery']['video'] = $img[1];
		}
		if($item['Gallery']['caption'] == ""){
			$this->header['title'] = "Ảnh đẹp tại thư viện ảnh Hairspa";
			$this->header['description'] = "Thư viện Hairspa: nơi lưu trữ những mẫu tóc đẹp nhất, những xu hướng tóc hot nhất của năm ".date("Y");
		}
		else{
			$this->header['title'] = "Thư viện Hairspa ".$item['Gallery']['caption'];
			$this->header['description'] =  strip_tags($item['Gallery']['caption']);
		}
		
		$this->header['image'] = $item['Gallery']['image'];
		$this->set(compact("item"));
	}
	public function admin_index()
	{	
		$conditions = "";

		$this->Paginator = $this->Components->load('Paginator');
		$this->Paginator->settings = array(
				'Gallery' => array(
					'order' => array(
						'Gallery.id' => 'DESC'
					),
					'limit' => 30,
					'paramType' => 'querystring',
				)
			);

		$Galleries = $this->Paginator->paginate();
		$this->set(compact("Galleries"));
	}
	public function admin_add()
	{
		if ($this->request->is('post')) {
			
			if(!$this->request->data['Gallery']['image'] && !$this->request->data['Gallery']['video']){
				$this->Session->setFlash('Nhập URL Video hoặc chọn ảnh','flash_error');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Gallery->create();
			if ($this->Gallery->save($this->request->data)) {
				$this->Session->setFlash('Thêm ảnh/video thành công','flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Có lỗi, hãy thử lại','flash_error');
			}
		}
	}
	public function admin_edit($id = null)
	{
		$this->Gallery->id = $id;
		if (!$this->Gallery->exists()) {
			throw new NotFoundException('Sai ID');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if(!$this->request->data['Gallery']['image'] && !$this->request->data['Gallery']['video']){
				$this->Session->setFlash('Nhập URL Video hoặc chọn ảnh','flash_error');
				return $this->redirect(array('action' => 'index'));
			}
			if ($this->Gallery->save($this->request->data,false)) {
				$this->Session->setFlash('Cập nhật thành công', 'flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Có lỗi, Xin hãy thử lại', 'flash_error');
			}
		} else {
			$this->request->data = $this->Gallery->find("first", array(
				"conditions" => array("Gallery.id" => $id),
			));
		}
	}
	public function admin_delete($id)
	{
		$this->Gallery->id = $id;
		if (!$this->Gallery->exists()) {
			throw new NotFoundException('Sai ID');
		}
		if ($this->Gallery->delete()) {
			$this->Session->setFlash('Xóa ảnh thành công', 'flash_success');
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('Có lỗi, hãy thử lại', 'flash_error');
		return $this->redirect(array('action' => 'index'));
	}	
	

}
?>