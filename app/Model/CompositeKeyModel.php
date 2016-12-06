<?php
/*
 su dung:
  insert vao model co 2 primarykey:
  -App::uses("CompositeKeyModel", "Model");
  -class extends CompositeKeyModel
 - var $primaryKeyArray = array('key1','key2');
 - van can truong ID
 #####################
 function beforeSave: su dung neu field ID trong database o dang primarykey1-primaryKey2
 Insert vao model:
 function beforeSave($options = array()){
        parent::beforeSaveChangeID();
}
*/

App::uses("AppModel", "Model");
class CompositeKeyModel extends AppModel {

    function beforeSaveChangeID($options = array()) {
        $id = null;
        foreach ($this->primaryKeyArray as $pk) {
            if (isset($this->data[$this->alias][$pk]) && $this->data[$this->alias][$pk]) {
                $id.=$this->data[$this->alias][$pk]."-";
            }
        }
        if($id != null){
      //      $this->id = substr($id,0,-1);
            $this->set('id',substr($id,0,-1));
            return true;
        }
        else
        {
            return false;
        }
        
    }

    function exists($id = null) {
        $conditions = array();
        foreach ($this->primaryKeyArray as $pk) {
            if (isset($this->data[$this->alias][$pk]) && $this->data[$this->alias][$pk]) {
                $conditions[$this->alias.'.'.$pk] = $this->data[$this->alias][$pk];
            }
            else {
                $conditions[$this->alias.'.'.$pk] = 0;
            }
        }
        if(is_array($id)){
            $conditions = array_merge($id,$conditions);
        }
        $query = array('conditions' => $conditions, 'fields' => array($this->alias.'.'.$this->primaryKey), 'recursive' => -1, 'callbacks' => false);
        if ($exists = $this->find('first', $query)) {
            $this->id = $exists[$this->alias][$this->primaryKey];
            return true;
        }
        elseif(is_array($id)){
            return false;
        }
        else {
            return parent::exists($id);
        }
    }

}

?>