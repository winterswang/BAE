<?php
class defaultController extends AppController
{
    public function actionIndex(){
		$this->setMeta('title','test');
        $this->render("default", array()); 	
    } 
}