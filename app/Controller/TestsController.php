<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor','phpExcel/PHPExcel');
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class TestsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	
/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function index()
	{
		$this->layout = 'home';
		$this->loadModel("Menu");
		$menu = $this->Menu->find("all", array(
			"order" => array("sort asc")));
		$menu = Set::extract("/Menu/.",$menu);
		$this->set(compact('menu'));
	}
	public function sms(){
		$this->send_sms("01687773333","test sent sms from api website");
	}
	
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	public function contact()
	{
		$this->autoRender = false;

		if( $this->request->is( 'post' ) )
		{
			$data = $this->request->data;
			$errors = array();
			$response = array();
			if( !$data['name'] )
			{ 
				$errors[] = $this->error_messages['name'];		        		       
		    } 
		    if( !$data['subject'] ){ 
			    
			    $errors[] = $this->error_messages['subject'];
		    } 
		    if( !$data['message'] ){ 
		    	$errors[] = $this->error_messages['message'];
		    } 

		    if( empty( $data['email'] ) || ! filter_var( $data['email'], FILTER_VALIDATE_EMAIL )) 
		    {  
		    	$errors[] = $this->error_messages['email']; 
		    }
		    if( count( $errors ) )
		    {
		    	$response = array(
		            'success' => 0,
		            'message' => implode( '<br />', $errors )
		        );		
		        $this->json = json_encode($response);
                $this->response->body($this->json);
                return;         
		    }

			$Email = new CakeEmail('gmail');
			$Email->from($data['email']);
			$Email->to( 'info@mqsolutions.vn' );
			$Email->subject( 'Mercari Contact Mail '. $data['subject'] );
			try {
				if( $Email->send( $data['message'] ))
				{
					$response = array(
			            'success' => 1,
			            'message' => $this->success_message
			        );
				}
				else
				{
					$response = array(
			            'success' => 0,
			            'message' => $this->error_messages['else']
			        );
				}
			} catch (Exception $e) {
				$response = array(
		            'success' => 0,
		            'message' => $this->error_messages['else']
		        );
			}
			$this->json = json_encode( $response );			
		}
		else
		{
			return $this->redirect('/');
		}
		$this->response->body($this->json);
	}
	public function getcontact(){

	    $objPHPExcel = PHPExcel_IOFactory::load("/Volumes/Data/1.xls");
	    $objWorksheet = $objPHPExcel->setActiveSheetIndexbyName('Sheet');
	 /*   $starting = 2;
	    $end      = 5;
	    $arrayLabel = array("B","D");

	    for($i = $starting;$i<=$end; $i++)
	    {

	       for($j=0;$j<count($arrayLabel);$j++)
	       {
	           //== display each cell value
	           echo $objWorksheet->getCell($arrayLabel[$j].$i)->getValue();
	       }
	    }*/
	     //or dump data
	     $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	     $prefix = array(
	     	"chị" => "chị",
	     	"em" => "em",
	     	"c" => "chị",
	     	"e" => "em",
	     	"a" => "anh",
	     	"anh" => "anh",
	     	"cô" => "cô"
	     );
	     foreach ($sheetData as $key => $row) {
	     	$name = $row['B'];
	     	$phone = $row['D'];
	     	$firstwr = explode(".",$name);
	     	if(count($firstwr) == 1){
	     		$firstwr = explode(" ",$name);
	     	}
	     	$firstw = $firstwr[0];
	     	$pre = "";
	     	if(isset($prefix[strtolower($firstw)])){
	     		unset($firstwr[0]);
	     		$name = implode(" ", $firstwr);
				$pre = $prefix[strtolower($firstw)];  	
	     	}
	     	$this->loadModel("User");
	     	$this->User->Create();
	     	$this->User->save(array(
	     		"phonenumber" => $phone,
	     		"name" => $name,
	     		"prefix" =>$pre,
	     		"password" => $phone,
	     		"role" => "3",
	     		"active" => "1",
	     	));
	     	
	     }
//	     var_dump($sheetData);
	     exit;
	}
}
