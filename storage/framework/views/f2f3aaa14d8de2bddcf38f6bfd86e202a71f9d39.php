<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <script>window.Laravel = { csrfToken: '<?php echo e(csrf_token()); ?>' }</script>
        <title>Blog</title>
        <link rel="stylesheet" href="<?php echo e(url('assets/vendors/core/core.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/vendors/font-awesome/css/font-awesome.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/vendors/simplemde/simplemde.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/vendors/dropzone/dropzone.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/vendors/dropify/dist/dropify.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/css/demo_1/style.css')); ?>">
        <link rel="shortcut icon" href="<?php echo e(url('assets/images/favicon.png')); ?>"/>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>

            <div id="app">
                <router-view></router-view>
            </div>
            
        <script src="<?php echo e(asset('js/app.js')); ?>"></script>
        <script src="<?php echo e(url('assets/vendors/core/core.js')); ?>"></script>
        <script src="<?php echo e(url('assets/vendors/chartjs/Chart.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/vendors/jquery.flot/jquery.flot.js')); ?>"></script>
        <script src="<?php echo e(url('assets/vendors/jquery.flot/jquery.flot.resize.js')); ?>"></script>
        <script src="<?php echo e(url('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/vendors/apexcharts/apexcharts.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/vendors/simplemde/simplemde.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/vendors/dropzone/dropzone.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/vendors/dropify/dist/dropify.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/simplemde.js')); ?>"></script>
        <script src="<?php echo e(url('assets/vendors/progressbar.js/progressbar.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/vendors/feather-icons/feather.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/dashboard.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/datepicker.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /Users/apple/Sites/github/BlogApp/resources/views/dashboard.blade.php ENDPATH**/ ?>