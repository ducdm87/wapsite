<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SearchController extends FrontEndController {

    function init() {
        parent::init();
    }

    public function actionDisplay() {
        $media = Media::getInstance();
        $data = array();

        if (isset($_GET['q']) && $_GET['q']) {
            $data['videos'] = $media->getMedias(0, 0, array('m.status' => 1), $_GET['q']);
        } else {
            $this->redirect('/app');
        }
        $this->render('default', $data);
    }

}
