<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * default layout
 * Location: application/views/
 */
$config['template_layout'] = 'themes/layout';

/**
 * default css
 */
$config['template_css'] = array(
    'assets/default/bootstrap/css/bootstrap.min.css' => 'screen',
    'assets/default/dist/css/ionicframework.css' => 'screen',
    'assets/default/dist/css/font-awesome.css' => 'screen',
    'assets/default/plugins/datatables/dataTables.bootstrap.css' => 'screen',
    //'assets/default/plugins/datatables/jquery.dataTables.css' => 'screen',
    'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' => 'screen',
    'assets/default/dist/css/AdminLTE.min.css' => 'screen' ,
    'assets/default/dist/css/skins/_all-skins.min.css' => 'screen',
    'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css' => 'screen'
);

/**
 * default javascript
 * load javascript on header: FALSE
 * load javascript on footer: TRUE
 */
$config['template_js'] = array(
    //'assets/default/angular/angular.js' => TRUE,
    //'assets/default/angular/angular-app.js' => TRUE,

   	'assets/default/plugins/jQuery/jQuery-2.1.4.min.js' => TRUE,
   	'assets/default/bootstrap/js/bootstrap.min.js' => TRUE,
   	'assets/default/dist/js/app.min.js' => TRUE,
    'assets/default/plugins/datatables/jquery.dataTables.min.js' => TRUE,
    'assets/default/plugins/datatables/dataTables.bootstrap.min.js' => TRUE,
    'assets/default/plugins/fastclick/fastclick.min.js' => TRUE,
    'assets/default/dist/js/app.min.js' => TRUE,
    'assets/default/plugins/sparkline/jquery.sparkline.min.js' => TRUE,
    'assets/default/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js' => TRUE,
    'assets/default/plugins/jvectormap/jquery-jvectormap-world-mill-en.js' => TRUE,
    'assets/default/plugins/slimScroll/jquery.slimscroll.min.js' => TRUE
    // 'assets/default/plugins/chartjs/Chart.min.js' => TRUE,
    // 'assets/default/dist/js/demo.js' => TRUE
);

/**
 * default variable
 */
$config['template_vars'] = array(
    'site_description' => 'Students Timetable Management System',
    'site_keywords' => 'students, timetable, scheduling, automated scheduling, automated timetable'
);

/**
 * default site title
 */
$config['base_title'] = 'STEMS';

/**
 * default title separator
 */
$config['title_separator'] = ' - ';
