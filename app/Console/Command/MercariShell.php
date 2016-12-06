<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
App::import('Controller', 'Cronjob');
class MercariShell extends Shell {
   
    public function main(){
        $Cronjob = new CronjobController;
        $Cronjob->constructClasses(); 
      //  pr($Cronjob->run_tracking());
       // $Cronjob->run_notification($this->args[0], $this->args[1]);
        $Cronjob->run_processOnline();
    }
    
    
}
?>