<?php
App::uses('AppController', 'Controller');
class ContactsController   extends AppController {
	public $components = array('RequestHandler',);
	public function beforeFilter()
	{
		parent::beforeFilter();
	}
		
	public function index()
	{
		$this->layout = "news";
	}

	public function admin_index($val = 0)
	{

	}
	

	public function admin_del()
	{
	}

	public function admin_edit()
	{
	
	}
}
?>