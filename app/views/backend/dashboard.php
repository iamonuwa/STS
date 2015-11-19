<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('themes/navbar');
$this->load->view('themes/sidebar');
?>
        <section class="content-header">
          <h1>
            Dashboard
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">CPU Traffic</span>
                  <span class="info-box-number">90<small>%</small></span>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Likes</span>
                  <span class="info-box-number">41,410</span>
                </div>
              </div>
            </div>
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Sales</span>
                  <span class="info-box-number">760</span>
                </div>
              </div>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Uploads</span>
                  <span class="info-box-number">13,648</span>
                </div>
              </div>
            </div>
            </div>
          <div class="row">
            
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  
                  </div>
              </div>

              
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Site Back Up</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box">
                <div class="box-header">
                </div>
                <form method="POST" action="<?= base_url('backend/home/error');?>">
                <div class="box-body">
                  
                  <table id="datatables" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="1%" align="left"><input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');"> </th>
                        <th>Error Type</th>
                        <th>Error Title</th>
                        <th>Location</th>
                        <th>Error Line</th>
                        <th>Time</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php foreach($error_log as $key => $value):
                      echo '<tr>
                            <td width="1%"><input type="checkbox" name="selector[]" id="selector[]" value="'.$value->id. '"/>
                            <td>'.$value->errtype.'</td>
                            <td>'.$value->errstr.'</td>
                            <td>'.$value->errfile.'</td>
                            <td>'.$value->errline.'</td>
                            <td>'.$value->time.'</td>';
                         endforeach; ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="box-footer clearfix">
                <div class="btn-group">
                   <button type="submit" class="btn btn-danger" onclick="return confirm('Deleted item(s) cannot be undone. Are you sure?');" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button>
                </div>
                 <div class="pull-right"></div>
                </div>
                </form>
              </div>
              </div>
            </div>
          </div>
        </section>
      </div>
<?php $this->load->view('themes/footer');?>