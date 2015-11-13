<div class="row">
    <div class="col-lg-12">
        <h1>Dashboard <small>Statistics Overview</small></h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
        </ol>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Welcome to Backend
        </div>
    </div>
</div><!-- /.row -->

<div class="row">
    <div class="col-lg-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading"><a href="<?php echo $this->createUrl('users/'); ?>">Users</a></p>
                        <p class="announcement-text">12</p>
                    </div>
                </div>
            </div>              
        </div>
    </div>

    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading"><a href="<?php echo $this->createUrl('resumes/'); ?>">Resumes manager</a></p>                        
                        <p class="announcement-text">56</p>
                    </div>
                </div>
            </div>              
        </div>
    </div>

    <div class="col-lg-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">Comment</p>
                        <p class="announcement-text">180</p>
                    </div>
                </div>
            </div>              
        </div>
    </div>

    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">Config</p>                    
                    </div>
                </div>
            </div>              
        </div>
    </div>

</div><!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Traffic Statistics: October 1, 2013 - October 31, 2013</h3>
            </div>
            <div class="panel-body">
                <div id="morris-chart-area"></div>
            </div>
        </div>
    </div>
</div><!-- /.row -->

<div class="row">          
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading"> <h3 class="panel-title"><i class="fa fa-clock-o"></i> User manager</h3> </div>
            <div class="panel-body">
                <div class="list-group">
                    <a href="#" class="list-group-item">
                        <span class="badge">just now</span> <i class="fa fa-calendar"></i> ducdm87
                    </a>                                
                </div>
                <div class="text-right">
                    <a href="#">View All user <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-money"></i> new resume</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped tablesorter">
                        <thead>
                            <tr>
                                <th>Order # <i class="fa fa-sort"></i></th> <th>Order Date <i class="fa fa-sort"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3326</td> <td>10/21/2013</td>
                            </tr>                     
                        </tbody>
                    </table>
                </div>               
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading"> <h3 class="panel-title"><i class="fa fa-clock-o"></i> Recent comment</h3> </div>
            <div class="panel-body">
                <div class="list-group">
                    <a href="#" class="list-group-item">
                        <span class="badge">just now</span> <i class="fa fa-calendar"></i> ducdm87
                    </a>                                
                </div>               
            </div>
        </div>
    </div>


</div><!-- /.row -->