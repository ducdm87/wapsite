<?php
Yii::import('zii.widgets.CPortlet');

class SearchJob extends CPortlet {

    public $_title = 'Tags';

    protected function renderContent() {
        ?>
        <div class="left-search">
            <div class="search" >
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/Black_Search.png" alt="" />
                <p>JOB </p>
                <p>SEARCH</p>
            </div>
            <div class="search-op">
                <span class="new_homedasdasd" >

                </span>
                <ul class="search-op-menu" style="display: block;">
                    <li id="" class=""><a target="_blank" href="http://www.jobtop.org" title="">United State</a></li>
                    <li id="" class=""><a target="_blank" href="http://www.jobcareer.ca" title="">Canada</a></li>
                    <li id="" class=""><a target="_blank" href="http://www.jobtop.co.uk" title="">United Kingdom</a></li>
                    <li id="" class=""><a target="_blank" href="http://www.jobsearcher.com.au" title="">Australia</a></li>
                    <li id="" class=""><a target="_blank" href="http://www.jobtop.in" title="">India</a></li>
                    <li id="" class=""><a target="_blank" href="http://www.vieclam86.com" title="">Việt Nam</a></li>
                </ul>
            </div>

        </div>
        <?php
    }

}
