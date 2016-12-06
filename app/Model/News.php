<?php
class News extends AppModel
{
	var $hasMany = array(
		'BillService' => array(
			'className'		=> 'BillService',
			'foreignKey'	=> 'bill_id',
			'dependent'		=> true
		),
		
	);
	var $belongsTo = array(
		'User' => array(
			'className'		=> 'User',
			'foreignKey'	=> 'user_id',
			),
		'Category' => array(
			'className'		=> 'Category',
			'foreignKey'	=> 'category_id',
			),
	);

	public function getNewsHome($category_id, $limit = 6){
		$news = $this->find("all", array
		(
			"conditions" => array("category_id" => $category_id),
			"order" => array('created desc'),
			"limit" => $limit 
			)
		);
		return $news;
	}
	public function getLastest($from, $limit = 6){
		$news = $this->find("all", array
		(
			"order" => array('created desc'),
			'offset' => $from,
			"limit" => $limit 
			)
		);
		return $news;
	}
	/*############# Overwrite using cache #####################
   	protected function _readDataSource($type, $query) {

		$cacheName =  $this->name. "-". md5($type.json_encode($query));
		$cache = Cache::read($cacheName, 'long');
		if ($cache !== false) {
			return $cache;
		}

		$results = parent::_readDataSource($type, $query);
		//save cache to group
		$group = Cache::read("group-".$this->name, 'forever');
   		if($group !== false){
   			$group = explode("|",$group);
   		}
   		else{
   			$group = array();
   		}
		$group[] = $cacheName;
		Cache::write("group-".$this->name, implode("|",$group), 'forever');
		##########################################################
		Cache::write($cacheName, $results, 'long');
		return $results;
	}
	public function afterSave($created,$options = array()){
		//delete group cache
		$listCache = Cache::read("group-".$this->name, 'forever');
		if($listCache !== false){
			$listCache = explode("|",$listCache);
			foreach ($listCache as $key => $cache) {
				Cache::delete($cache,"long");
			}
			
		}
		Cache::delete("group-".$this->name, 'forever');
	}*/
}
?>