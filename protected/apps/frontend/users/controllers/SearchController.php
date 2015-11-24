<?php
class SearchController extends FrontEndController {
    function init() {
        parent::init();
    } 
     public function actionDisplay() {
    }
    //tim kiem
    public function actionSearch() { 
        $media = User::getInstance();
        $data = array();

        if (isset($_GET['q']) && $_GET['q']) {
            $data['videos'] = $media->getVideos(15, 0, array('m.status' => 1), $_GET['q']);
        } else {
            $this->redirect('/app');
        }//var_dump($data); die;
        
        $this->render('default', $data);
    }
}
