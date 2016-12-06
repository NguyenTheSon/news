<?php
class StatisticsController extends AppController {
	public $components = array('RequestHandler');
	public function admin_index(){
		$this->autoRender = false;
		return;
	}
	public function admin_user_chart() {
        $this->loadModel('User');
        $this_month = array();
        $this_week = array();
        $this_year = array();
        if($this->request->is('post')) {
          $this->autoRender = false;
          $type = $this->request->data['type'];
          $data = $this->request->data['date'];
          if($type=="month"){
            $month = isset($data['month'])?$data['month'] : date("m");
            $year =   isset($data['year'])?$data['year'] : date("Y");
            $numofmonth = date("t",mktime(0, 0, 0, $month , 1,$year));
            for ($i = 1; $i <= $numofmonth; $i++) {
                  $day = date("Y-m-d", mktime(0, 0, 0, $month , $i,$year));
                  $nextday = date("Y-m-d", mktime(0, 0, 0, $month , $i + 1,$year));
                  $user_num = $this->User->find('count',
                           array('conditions' => array(
                                  array('User.created >= ' => $day,
                                        'User.created < ' => $nextday
                                       )
                                  )
                          )
                      );
              $this_month[$i]['date'] = $day;
              $this_month[$i]['value'] = $user_num;
              if($day >= date("Y-m-d")) break;
              }
              echo json_encode($this_month);
              return;
          }
          if($type=="week"){
              if($data['week'] == "this week"){
                $date["d"] = date("d", strtotime('monday this week'));
                $date["m"] = date("m", strtotime('monday this week'));
                $date["Y"] = date("Y", strtotime('monday this week'));

              }
              else{
                $date['d'] = date("d", strtotime('monday last week'));
                $date['m'] = date("m", strtotime('monday last week'));
                $date['Y'] = date("Y", strtotime('monday last week'));
              }
              for ($i = 0; $i <= 7; $i++) {
                      $day2 = date("Y-m-d", mktime(0, 0, 0, $date['m'] , $date['d']+$i,$date['Y']));
                      $nextday2 = date("Y-m-d", mktime(0, 0, 0, $date['m'] , $date['d']+$i+1,$date['Y']));
                      $user_num2 = $this->User->find('count',
                               array('conditions' => array(
                                      array('User.created >= ' => $day2,
                                            'User.created < ' => $nextday2
                                           )
                                      )
                              )
                          );
                  $this_week[$i]['date'] =  $day2;
                  $this_week[$i]['value'] = $user_num2;
                  if($day2 >= date("Y-m-d")) break;
              }
              echo json_encode($this_week);
              return;
          }
          if($type=="year"){
            $year = isset($data['year'])? $data['year']: date("Y");
              //YEAR
            for ($i = 1; $i <= date("m"); $i++) {
                  $startofmonth = date("Y-m-d", mktime(0, 0, 0, $i , 1,$year));
                  $startofnextmonth = date("Y-m-d", mktime(0, 0, 0, $i+1 , 1,$year));
                  $user_num = $this->User->find('count',
                           array('conditions' => array(
                                  array('User.created >= ' => $startofmonth,
                                        'User.created < ' => $startofnextmonth
                                       )
                                  )
                          )
                      );
              $this_year[$i]['date'] = date("m-Y",strtotime($startofmonth));
              $this_year[$i]['value'] = $user_num;
              }
              echo json_encode($this_year);
              return;
          }
        }
    }
public function admin_product_chart() {
        $this->loadModel('Product');
        $this_month = array();
        $this_week = array();
        $this_year = array();
        if($this->request->is('post')) {
          $this->autoRender = false;
          $type = $this->request->data['type'];
          $data = $this->request->data['date'];
          if($type=="month"){
            $month = isset($data['month'])?$data['month'] : date("m");
            $year =   isset($data['year'])?$data['year'] : date("Y");
            $numofmonth = date("t",mktime(0, 0, 0, $month , 1,$year));
            for ($i = 1; $i <= $numofmonth; $i++) {
                  $day = date("Y-m-d", mktime(0, 0, 0, $month , $i,$year));
                  $nextday = date("Y-m-d", mktime(0, 0, 0, $month , $i + 1,$year));
                  $user_num = $this->Product->find('count',
                           array('conditions' => array(
                                  array('Product.created >= ' => $day,
                                        'Product.created < ' => $nextday
                                       )
                                  )
                          )
                      );
              $this_month[$i]['date'] = $day;
              $this_month[$i]['value'] = $user_num;
              if($day >= date("Y-m-d")) break;
              }
              echo json_encode($this_month);
              return;
          }
          if($type=="week"){
              if($data['week'] == "this week"){
                $date["d"] = date("d", strtotime('monday this week'));
                $date["m"] = date("m", strtotime('monday this week'));
                $date["Y"] = date("Y", strtotime('monday this week'));

              }
              else{
                $date['d'] = date("d", strtotime('monday last week'));
                $date['m'] = date("m", strtotime('monday last week'));
                $date['Y'] = date("Y", strtotime('monday last week'));
              }
              for ($i = 0; $i <= 7; $i++) {
                      $day2 = date("Y-m-d", mktime(0, 0, 0, $date['m'] , $date['d']+$i,$date['Y']));
                      $nextday2 = date("Y-m-d", mktime(0, 0, 0, $date['m'] , $date['d']+$i+1,$date['Y']));
                      $user_num2 = $this->Product->find('count',
                               array('conditions' => array(
                                      array('Product.created >= ' => $day2,
                                            'Product.created < ' => $nextday2
                                           )
                                      )
                              )
                          );
                  $this_week[$i]['date'] =  $day2;
                  $this_week[$i]['value'] = $user_num2;
                  if($day2 >= date("Y-m-d")) break;
              }
              echo json_encode($this_week);
              return;
          }
          if($type=="year"){
            $year = isset($data['year'])? $data['year']: date("Y");
              //YEAR
            for ($i = 1; $i <= date("m"); $i++) {
                  $startofmonth = date("Y-m-d", mktime(0, 0, 0, $i , 1,$year));
                  $startofnextmonth = date("Y-m-d", mktime(0, 0, 0, $i+1 , 1,$year));
                  $user_num = $this->Product->find('count',
                           array('conditions' => array(
                                  array('Product.created >= ' => $startofmonth,
                                        'Product.created < ' => $startofnextmonth
                                       )
                                  )
                          )
                      );
              $this_year[$i]['date'] = date("m-Y",strtotime($startofmonth));
              $this_year[$i]['value'] = $user_num;
              }
              echo json_encode($this_year);
              return;
          }
        }
    }

    public function admin_purchase_chart() {
        $this->loadModel('Purchase');
        $this_month = array();
        $this_week = array();
        $this_year = array();
        if($this->request->is('post')) {
          $this->autoRender = false;
          $type = $this->request->data['type'];
          $data = $this->request->data['date'];
          if($type=="month"){
            $month = isset($data['month'])?$data['month'] : date("m");
            $year =   isset($data['year'])?$data['year'] : date("Y");
            $numofmonth = date("t",mktime(0, 0, 0, $month , 1,$year));
            for ($i = 1; $i <= $numofmonth; $i++) {
                  $day = date("Y-m-d", mktime(0, 0, 0, $month , $i,$year));
                  $nextday = date("Y-m-d", mktime(0, 0, 0, $month , $i + 1,$year));
                  $user_num = $this->Purchase->find('count',
                           array('conditions' => array(
                                  array('Purchase.created >= ' => $day,
                                        'Purchase.created < ' => $nextday
                                       )
                                  )
                          )
                      );
              $this_month[$i]['date'] = $day;
              $this_month[$i]['value'] = $user_num;
              if($day >= date("Y-m-d")) break;
              }
              echo json_encode($this_month);
              return;
          }
          if($type=="week"){
              if($data['week'] == "this week"){
                $date["d"] = date("d", strtotime('monday this week'));
                $date["m"] = date("m", strtotime('monday this week'));
                $date["Y"] = date("Y", strtotime('monday this week'));

              }
              else{
                $date['d'] = date("d", strtotime('monday last week'));
                $date['m'] = date("m", strtotime('monday last week'));
                $date['Y'] = date("Y", strtotime('monday last week'));
              }
              for ($i = 0; $i <= 7; $i++) {
                      $day2 = date("Y-m-d", mktime(0, 0, 0, $date['m'] , $date['d']+$i,$date['Y']));
                      $nextday2 = date("Y-m-d", mktime(0, 0, 0, $date['m'] , $date['d']+$i+1,$date['Y']));
                      $user_num2 = $this->Purchase->find('count',
                               array('conditions' => array(
                                      array('Purchase.created >= ' => $day2,
                                            'Purchase.created < ' => $nextday2
                                           )
                                      )
                              )
                          );
                  $this_week[$i]['date'] =  $day2;
                  $this_week[$i]['value'] = $user_num2;
                  if($day2 >= date("Y-m-d")) break;
              }
              echo json_encode($this_week);
              return;
          }
          if($type=="year"){
            $year = isset($data['year'])? $data['year']: date("Y");
              //YEAR
            for ($i = 1; $i <= date("m"); $i++) {
                  $startofmonth = date("Y-m-d", mktime(0, 0, 0, $i , 1,$year));
                  $startofnextmonth = date("Y-m-d", mktime(0, 0, 0, $i+1 , 1,$year));
                  $user_num = $this->Purchase->find('count',
                           array('conditions' => array(
                                  array('Purchase.created >= ' => $startofmonth,
                                        'Purchase.created < ' => $startofnextmonth
                                       )
                                  )
                          )
                      );
              $this_year[$i]['date'] = date("m-Y",strtotime($startofmonth));
              $this_year[$i]['value'] = $user_num;
              }
              echo json_encode($this_year);
              return;
          }
        }
    }
}
?>