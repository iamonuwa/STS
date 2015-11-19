<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('themes/navbar');
$this->load->view('themes/sidebar');
?>
        <section class="content-header">
          <h1>
          Backup Module
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
            <li class="active"> Database Backup</li>
          </ol>
        </section>

        
       <section class="content">
          <div class="row">
            
            <div class="col-md-12">

              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Database Backup</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
               <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                  <table id="datatables" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Backup Title</th>
                        <th>Date Backup</th>
                        <th><?= $this->lang->line('actions');?></th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php foreach($building as $key => $value):
                      echo '<tr>
                            <td>'.$value->name.'</td>
                            <td>'.$value->last_update.'</td>
                           <td> <a href="#" data-target="#preview" data-toggle="modal" class="btn btn-sm btn-info btn-flat"> <i class="fa fa-eye"></i> '.$this->lang->line('preview').'</a> </td>';
                             endforeach; ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
                <div class="box-footer clearfix">
                  <a href="#" class="btn btn-sm btn-info btn-flat pull-left">New Backup</a>
                </div>
              </div>
            </div>
            </div>
        </section>
      </div>

<?php
$this->load->view('themes/footer');
?>