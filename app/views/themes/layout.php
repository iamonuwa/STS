<!doctype html>
<html class="no-js" lang="<?php echo $lang; ?>" ng-app="app">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $site_title; ?></title>
<meta name="description" content="<?php echo $site_description; ?>" />
<meta name="keywords" content="<?php echo $site_keywords; ?>" />
<?php echo $meta_tag; ?>
<?php echo $styles; ?>
<?php echo $scripts_header; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
	<?php echo $content; ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>
  
 <?php echo $scripts_footer; ?>
 <script>
      $(function () {
        $('#datatables').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": false,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
</body>
</html>
