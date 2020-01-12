<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <script>window.Laravel = { csrfToken: '<?php echo e(csrf_token()); ?>' }</script>
        <title>Blog | Dashboard</title>
        <link rel="stylesheet" href="<?php echo e(url('assets/backend/vendors/core/core.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/backend/vendors/font-awesome/css/font-awesome.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/backend/vendors/simplemde/simplemde.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/backend/vendors/dropzone/dropzone.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/backend/vendors/dropify/dist/dropify.min.css')); ?>">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@voerro/vue-tagsinput@2.0.2/dist/style.css">
        <link rel="stylesheet" href="<?php echo e(url('assets/backend/css/demo_1/style.css')); ?>">
        <link rel="shortcut icon" href="<?php echo e(url('assets/backend/images/favicon.png')); ?>"/>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>

            <div id="app">
                <router-view></router-view>
            </div>
            
        <script src="<?php echo e(asset('js/app.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/vendors/core/core.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/vendors/chartjs/Chart.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/vendors/jquery.flot/jquery.flot.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/vendors/jquery.flot/jquery.flot.resize.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/vendors/apexcharts/apexcharts.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/vendors/simplemde/simplemde.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/vendors/dropzone/dropzone.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/vendors/dropify/dist/dropify.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/js/simplemde.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/vendors/progressbar.js/progressbar.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/vendors/feather-icons/feather.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/js/dashboard.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/js/datepicker.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /Users/apple/Sites/github/BlogApp/resources/views/dash.blade.php ENDPATH**/ ?>