<!DOCTYPE html>
<?php global $hideMenu; ?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $this->pageTitle; ?></title>
        <?php 
        global $cur_temp;
        ?>
         <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/backend/<?php echo $cur_temp; ?>/assets/css/bootstrap.css" rel="stylesheet">
    </head>
    <body> 
         <?php echo $content; ?>
    </body>
</html> 