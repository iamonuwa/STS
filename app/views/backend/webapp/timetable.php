<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('themes/navbar');
$this->load->view('themes/sidebar');
?>
        <section class="content-header">
          <h1>
          Timetable Module
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
            <li class="active"> Timetable Module</li>
          </ol>
        </section>

        
       <section class="content">
          <div class="row">
            
            <div class="col-md-12">

              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Timetable Module</h3>
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
                        <th>Session</th>
                        <th>Semester</th>
                        <th>Date Generated</th>
                        <th>Date Published</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php //foreach($building as $key => $value):
                     //  echo '<tr>
                     //        <td>'.$value->name.'</td>
                     //        <td>'.$value->last_update.'</td>
                     //       <td> <a href="#" data-target="#preview" data-toggle="modal" class="btn btn-sm btn-info btn-flat"> <i class="fa fa-eye"></i> '.$this->lang->line('preview').'</a> </td>';
                     //         endforeach; ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
               <div class="box-footer clearfix">
                  <div class="btn-group">
                  <a href="#" data-toggle="modal"  data-target="#addtimetable" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span>  New</a>
                   <button type="submit" class="btn btn-danger" onclick="return confirm('Deleted item(s) cannot be undone. Are you sure?');" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button>
                  </div>
                  </div>
              </div>
              </form>
            </div>
            </div>
        </section>
      </div>

      <div id="addtimetable" class="modal">
        <?= form_open(base_url('backend/timetable/index'));?>
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create New Timetable</h4>
                  </div>
                  <div class="modal-body">
                  <div class="row">
                    <div class="col-xs-8 ">
                  <div class="form-group has-feedback">
                      <?php 
                      $attributes = array(
                        'name'=>'session',
                        'class'=>'form-control',
                        'placeholder'=> 'Session'
                        );
                        echo form_input($attributes);?>
                      <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                  </div>
                  </div>
                  <div class="col-xs-4">
                  <div class="form-group has-feedback">
                  <?php 
                      $attributes = array(
                        'name'=>'semester',
                        'class'=>'form-control',
                        'placeholder'=> 'Semester'
                        );
                        echo form_input($attributes);?>
                      <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                  </div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-8 ">
                  <div class="form-group has-feedback">
                      <?php 
                      $attributes = array(
                        'name'=>'department',
                        'class'=>'form-control',
                        'placeholder'=> 'Department'
                        );
                        echo form_input($attributes);?>
                      <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                  </div>
                  </div>
                  </div>
                  </div>
                 <div class="modal-footer">
                     <?php echo form_submit('submit', 'Generate Timetable', "class='btn btn-success'"); ?>
                    </div>
                </div>
              </div>
              <?= form_close();?>
            </div>
            </div>

<?php
$this->load->view('themes/footer');
?>