<?php
App::uses('AppController', 'Controller');
define('ITEM_PER_PAGE', 6);
class NewsController extends AppController {
	public $components = array('RequestHandler','Convert');
	public function beforeFilter()
	{
		parent::beforeFilter();
	}
	function isMobile() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}
	public function index($id = null)
	{
		$this->layout = "news";
		$conditions = array();
		if($id != null){
			$conditions = array("category_id" => $id);
		}

		$this->paginate = array(
			'limit' => ITEM_PER_PAGE,
			'order' => array('created' => 'desc'),
			);
		$News = $this->paginate("News",$conditions);
		foreach ($News as $key => $new) {
			$News[$key]['News']['title_url'] = $this->Convert->vn_str_filter($News[$key]['News']['title']);
			$News[$key]['News']['description'] = $this->Convert->substrUnicode($News[$key]['News']['description'],0,500);
		}

		$this->set(compact('News'));
		
		#####HEADER ####
		$this->loadModel("Category");
		$headinfo = $this->Category->find("first", array(
			"conditions" => array(
				"id" => $id,
				),
			));
		if($this->isMobile()){
			$headinfo['Category']['images'] = $headinfo['Category']['images_mobile'];
		}
		$this->set(compact("headinfo"));
		
		$NewsRand = $this->News->find("all", array(
			"conditions" => $conditions,
			"order" => array("Rand()"),
			"limit" => 5,
			));
		foreach ($NewsRand as $key => $new) {
			$NewsRand[$key]['News']['title_url'] = $this->Convert->vn_str_filter($NewsRand[$key]['News']['title']);
			$NewsRand[$key]['News']['description'] = $this->Convert->substrUnicode($NewsRand[$key]['News']['description'],0,500);
		}
		$this->set(compact('NewsRand'));
	}
	public function admin_index($cat_id = 0) {
		
		$conditions = array();
		if($cat_id > 0){
			$conditions = array("category_id" => $cat_id);
		}
		if(isset($this->request->data['News']['keyword'])){
			$this->Session->write("News.keyword",$this->request->data['News']['keyword']);
		}
		$conditions['title like'] = "%".$this->Session->read("News.keyword")."%";	
		
		if($this->RequestHandler->isAjax()){
			$this->Paginator = $this->Components->load('Paginator');
			$this->Paginator->settings = array(
				'News' => array(
					'contain' => array('Category'),
					'recursive' => -1,
					'order' => array(
						'News.id' => 'DESC'
						),
					'conditions' => $conditions,
					'limit' => 20,
					'paramType' => 'querystring',
					)
				);
			$News = $this->Paginator->paginate();
			$this->set(compact('News'));
			$this->render('/Elements/News/admin_index');
			return;
		}
		##########################

		$this->loadModel("Category");
		$ListCategories = $this->Category->find("all",
			array
			(
				'order' => array
				(
					"sort" => "ASC",
					),
				)
			);

		$this->set(compact("ListCategories"));

		$this->Paginator = $this->Components->load('Paginator');
		$this->Paginator->settings = array(
			'News' => array(
				'contain' => array(
					"Category",
					),
				'conditions' => $conditions,
				'order' => array(
					'News.id' => 'DESC'
					),
				'limit' => 20,
				'paramType' => 'querystring',
				)
			);

		$News = $this->Paginator->paginate();
		$this->set(compact("cat_id"));
		$this->set(compact("News"));
	}

	public function admin_approved()
	{
		$id = intval($this->params->pass[0]);
		if($id>0)
		{

			$New = $this->News->read(null,$id);
			$app_val = $New['News']['approved'];
			$new_val = 0;
			if($app_val == 0)
				$new_val = 1;
			$this->News->create();
			$this->News->id = $id;
			$this->News->save(array("approved"=> $new_val));
			$this->Session->setFlash(($new_val==0?"Đã ẩn bài viết":"Đã hiện bài viết").' thành công','flash_success');
			return $this->redirect(array(
				'controller' => 'News',
				'action' => 'admin_index',
				));
		}
	}
	

	public function admin_del()
	{
		$id = intval($this->params->pass[0]);
		if($id>0)
		{
			$this->News->create();
			$this->News->id = $id;
			if ($this->News->exists()) 
			{
				$this->News->delete();
				$this->Session->setFlash('Đã xoá thành công','flash_success');
				return $this->redirect(array(
					'controller' => 'News',
					'action' => 'admin_index',
					));
			}
			else
			{
				$this->Session->setFlash('bài viết không tồn tại','flash_error');
				return $this->redirect(array(
					'controller' => 'News',
					'action' => 'admin_index',
					));
			}
		}
	}
	private function mb_strcasecmp($str1, $str2){
		$encoding = "UTF8";
		return strcmp(mb_strtoupper($str1, $encoding), mb_strtoupper($str2, $encoding));
	}
	function extract_id_video($url){
	    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
		return $matches[1];
	    //return "";
	}
	public function admin_edit()
	{
		if($this->RequestHandler->isPost())
		{
			$tags = $this->request->data['News']['tags'];
			$arr_tags = explode(",", $tags);
			$arr_tags = array_map('trim', $arr_tags);
			$this->loadModel("Tag");
			$tagsExist = $this->Tag->find("list", array(
				"conditions" => array(
					"tags" => $arr_tags,
					),
				"fields" => array("tags"),
				));

			$arr_tags = array_udiff($arr_tags, $tagsExist,array($this,'mb_strcasecmp'));
			foreach ($arr_tags as $key => $tag) {
				$this->Tag->Create();
				$this->Tag->save(array("tags" => $tag));
			}
			if($this->request->data['News']['images'] == "" && $this->request->data['News']['url'] !=""){
				$vid = $this->extract_id_video($this->request->data['News']['url']);
				$this->request->data['News']['images'] = "https://ytimg.googleusercontent.com/vi/".$vid."/maxresdefault.jpg";
			}

			if(isset($this->params->pass[0]))
			{
				$id = intval($this->params->pass[0]);
				$this->News->create();
				$this->News->id = $id;
				if ($this->News->exists()) 
				{
					$this->News->save($this->request->data['News'], false);
					$this->Session->setFlash('Đã lưu thành công','flash_success');
					return $this->redirect(array(
						'controller' => 'News',
						'action' => 'admin_index',
						));
				}
				exit;
			}
			else
			{
				$this->News->save($this->request->data['News'], false);
				$this->Session->setFlash('Đã lưu thành công','flash_success');
				return $this->redirect(array(
					'controller' => 'News',
					'action' => 'admin_index',
					));

				exit;
			}
		}

		$this->loadModel("Category");
		$ListCategories = $this->Category->find("all",
			array
			(
				'order' => array
				(
					"sort" => "ASC",
					),
				)
			);
		$ListGroup = array();
		foreach($ListCategories as $Category)
		{
			$ListGroup[$Category['Category']['id']] = $Category['Category']['name'];
		}
		$this->set(compact("ListGroup"));
		if(isset($this->params->pass[0]))
		{
			$id = intval($this->params->pass[0]);
			if($id>0)
			{
				$this->News->create();
				$this->News->id = $id;
				if ($this->News->exists()) 
				{
					$New = $this->News->read(null,$id);
				}
			}
		}
		else
		{

			$New = array("News" => array(
				"id" => "",
				"title"=> "",
				"description" =>"",
				"content" => "",
				"category_id" => 1,
				"approved" => "",
				"images" => "",
				"url" => "",
				"user_id" => "",
				"created" => "",
				"modified" => "",
				)
			);
		}
		$this->set(compact("New"));
	}
	public function Search()
	{
		if(isset($this->request->query['Keyword']) || isset($this->request->query['tags']))
		{
			if(isset($this->request->query['Keyword'])){
				$val = $this->request->query['Keyword'];
				$conditions = array(
					'OR' => array(
						'title LIKE' =>'%'.$val.'%',
						'description LIKE' =>'%'.$val.'%',
						'content LIKE' =>'%'.$val.'%'
						)
					);
			}
			else{
				$val = $this->request->query['tags'];
				$conditions = array(
					"tags like" => "%$val%",
					);
			}
			
			$this->layout = "news";
			if($this->RequestHandler->isAjax()){
				$page = $this->request->data['page'];
				$offset = ($page - 1) * ITEM_PER_PAGE;
				$conditions = array();
				$News = $this->News->find("all", array(
					"conditions" => $conditions,
					"order" => array("created desc"),
					"offset" => $offset,
					"limit" => ITEM_PER_PAGE,
					));
				foreach ($News as $key => $new) {
					$News[$key]['News']['title_url'] = $this->Convert->vn_str_filter($News[$key]['News']['title']);
					$News[$key]['News']['description'] = $this->Convert->substrUnicode($News[$key]['News']['description'],0,500);
				}
				$this->set(compact('News'));
				$this->layout = false;
				$this->render('/Elements/News/index_page');
			}

			$News = $this->News->find("all", array(
				"conditions" => $conditions,
				"order" => array("created desc"),
				"limit" => ITEM_PER_PAGE,
				));
			foreach ($News as $key => $new) {
				$News[$key]['News']['title_url'] = $this->Convert->vn_str_filter($News[$key]['News']['title']);
				$News[$key]['News']['description'] = $this->Convert->substrUnicode($News[$key]['News']['description'],0,500);
			}
			$this->set(compact('News'));
			####
			$this->loadModel('CategoryCaption');
			$Captions = $this->CategoryCaption->find("all", array(
				"conditions" => array(),
				));
			$this->set(compact('Captions'));
			//exit;
			$this->loadModel("Category");
			$headinfo = $this->Category->find("first", array(
				"conditions" => array(
					"id" => "1",
					),
				));
			$this->set(compact("headinfo"));
		}
		else
		{
			header('Content-Type: application/json');
			$val = "";
			if(isset($this->request->query['term']))
				$val = $this->request->query['term'];
			echo "[";
			$News = $this->News->find("all", array(
				"conditions" => array(
					'OR' => array(
						'title LIKE' =>'%'.$val.'%',
						'description LIKE' =>'%'.$val.'%',
						'content LIKE' =>'%'.$val.'%'
						)
					),
				"order" => array("created desc"),
				"limit" => 5,
				));
			$dem = 0;
			foreach($News as $val1)
			{
				if($dem>0)
					echo ",";
				$dem++;
				echo '{"id":"'.$val1['News']['title'].'","label":"'.$val1['News']['title'].'","value":"'.$val1['News']['title'].'"}';
			}
			echo ']';
			exit;
		}

	}
	public function blog($id=null){

		$this->layout = "blog";
		if($this->RequestHandler->isAjax()){
			$page = $this->request->data['page'];
			$offset = ($page - 1) * ITEM_PER_PAGE;
			$conditions = array();
			if($id != null){
				$conditions = array("category_id" => $id);
			}
			$News = $this->News->find("all", array(
				"conditions" => $conditions,
				"order" => array("created desc"),
				"offset" => $offset,
				"limit" => ITEM_PER_PAGE,
				));
			foreach ($News as $key => $new) {
				$News[$key]['News']['title_url'] = $this->Convert->vn_str_filter($News[$key]['News']['title']);
				$News[$key]['News']['description'] = $this->Convert->substrUnicode($News[$key]['News']['description']." ".$News[$key]['News']['content'],0,1000);
			}
			$this->set(compact('News'));
			$this->layout = false;
			$this->render('/Elements/News/blog_page');
		}
		$conditions = array();
		if($id != null){
			$conditions = array("category_id" => $id);
		}
		$News = $this->News->find("all", array(
			"conditions" => $conditions,
			"order" => array("created desc"),
			"limit" => ITEM_PER_PAGE,
			));
		foreach ($News as $key => $new) {
			$News[$key]['News']['title_url'] = $this->Convert->vn_str_filter($News[$key]['News']['title']);
			$News[$key]['News']['description'] = $this->Convert->substrUnicode($News[$key]['News']['description']." ".$News[$key]['News']['content'],0,1000);
			
		}
		$this->set(compact('News'));
		
		#####HEADER ####
		$this->loadModel("Category");
		$headinfo = $this->Category->find("first", array(
			"conditions" => array(
				"id" => $id,
				),
			));
		
		$this->set(compact("headinfo"));
	}
	public function detail($id){
		$this->layout = "home";
		$detail = $this->News->read(null,$id);

		$this->header['title'] = $detail['News']['title'];
		if($detail['News']['description'] !=""){
			$this->header['description'] =  strip_tags($detail['News']['description']);
		}
		else{
			$this->header['description'] =  "Video được đăng tại website hairfashiontv.vn - Kênh video cho ngành tóc Việt.";
		}
		$this->header['image'] = $detail['News']['images'];
		$detail['News']['tags'] = explode(",",$detail['News']['tags']);
		$detail['News']['tags'] = array_map('trim', $detail['News']['tags']);
		$this->set(compact('detail'));


		$NewsRand = $this->News->find("all", array(
			"conditions" =>array("category_id" => $detail['News']['category_id']),
			"order" => array("Rand()"),
			"limit" => 6,
			));
		foreach ($NewsRand as $key => $new) {
			$NewsRand[$key]['News']['title_url'] = $this->Convert->vn_str_filter($NewsRand[$key]['News']['title']);
			$NewsRand[$key]['News']['description'] = $this->Convert->substrUnicode($NewsRand[$key]['News']['description'],0,500);
		}
		$this->set(compact('NewsRand'));
	}
	public function admin_getTags(){
		$this->autoRender = false;
		$this->layout = false;
		if(!isset($_GET['term'])){
			return false;
		}
		$keyword = $_GET['term'];
		$this->loadModel("Tag");
		$Tags = $this->Tag->find("list", array(
			"conditions" => array(
				"tags like" => "%$keyword%",
				),
			"fields" => array("tags")
			));
		$Tags = array_values($Tags);
		echo json_encode($Tags);
		return;
	}

}
?>
