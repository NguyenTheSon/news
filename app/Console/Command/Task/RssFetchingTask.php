<?php
App::uses('SimplepieComponent', 'Simplepie.Controller/Component');
App::uses('ComponentCollection', 'Controller');

class RssFetchingTask extends Shell {
	public $components = array('Simplepie.Simplepie');
	
    public $uses = array('User', 'Rss', 'Article');
    public function execute() {
    	$this->out('Start Rss Fetching');

    	$rsses = $this->Rss->find('all');
    	
    	foreach ($rsses as $rss) {
    		$collection = new ComponentCollection();
	        $this->Simplepie = new SimplepieComponent($collection);

    		$feeds = $this->Simplepie->feed($rss['Rss']['url']); 
    		$this->out(print_r($feeds));
			if ($feeds != false)
			{
				
				$save = array();
				foreach ($feeds as $feed) {
					$this->Article->create();
					$save['title'] = $feed['title'];
					$save['permalink'] = $feed['permalink'];
					$save['description'] = $feed['content'];
					$save['date'] = $feed['date'];
					$save['rss_id'] = $rss['Rss']['id'];
					if ($this->Article->save($save))
					{
						$this->out('@@@@@@Insert news: '.$feed['title']);
					} else {
						$this->out('======Cannot insert news: '.$feed['title']);
					}
						
				}		
			}	
    	}
    	
    	$this->out('End Rss Fetching');
    }
}
?>