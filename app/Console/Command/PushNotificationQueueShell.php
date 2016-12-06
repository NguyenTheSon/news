<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
App::import('Controller', 'Cronjob');
class PushNotificationQueueShell extends Shell {
   
    public function main(){
        $Cronjob = new CronjobController;
        $Cronjob->constructClasses(); 
      //  pr($Cronjob->run_tracking());
        $Cronjob->run_notification_in_queue();
    }
    
    
}
?>