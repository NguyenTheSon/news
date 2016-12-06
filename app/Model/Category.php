<?php
class Category extends AppModel
{
	
	######################################
	public $validate = array(
		'name' => array(
			'rule1' => array(
				'rule' => array('notempty'),
				'message' => 'Name is invalid',
			),
		));
	######################################
	var $hasMany = array(
		'News' => array(
			'className' 	=> 'News',
			'foreignKey' 	=> 'category_id',
			'dependent'		=> true,
		),
		'Category' => array(
			'className'		=> 'Category',
			'foreignKey'	=> 'parent_id',
			'dependent'		=> true
		),
	);
	var $belongsTo = array(
		'Category' => array(
			'className'		=> 'Category',
			'foreignKey'	=> 'parent_id',
	));

	##############
	public function findChild($parent_id){
		$ret = $this->Category->find('list',array('conditions' => array(
			'parent_id' =>$parent_id),
			'fields' => array('id'),
		));
		if($ret)
		foreach ($ret as $catid) {
			$ret= array_merge($ret,$this->findChild($catid));
		}
		return $ret;
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