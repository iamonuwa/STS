<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('themes/navbar');
$this->load->view('themes/sidebar');
?>
        <section class="content-header">
          <h1>
          <?= $this->lang->line('course_module');?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?= $this->lang->line('course');?></li>
          </ol>
        </section>

        
       <section class="content">
          <div class="row">
            
            <div class="col-md-12">

              <div class="box box-info">
              <form action="<?= base_url('backend/course/delete');?>" method="POST">
                <div class="box-header with-border">
                  <h3 class="box-title"><?= $this->lang->line('available_course');?></h3>
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
                        <th width="1%" align="left"><input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');"> </th>
                        <th><?= $this->lang->line('course_title');?></th>
                        <th><?= $this->lang->line('course_code');?></th>
                        <th><?= $this->lang->line('class');?></th>
                        <th><?= $this->lang->line('lecturer');?></th>
                        <th><?= $this->lang->line('last_update');?></th>
                        <th><?= $this->lang->line('actions');?></th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php foreach($course as $key => $value):
                      echo '<tr>
                            <td width="1%"><input type="checkbox" name="selector[]" id="selector[]" value="'.$value->id. '"/>
                            <td>'.$value->title.'</td>
                            <td>'.$value->code.'</td>
                            <td>'.$this->classes_model->get_by('id', $value->level_id)->name.'</td>
                            <td>'.$this->lecturers_model->get_by('id', $value->lecturer_id)->name.'</td>
                            <td>'.$value->last_update.'</td>
                            <td> <a href="'.base_url('backend/'.$this->aauth->get_user()->name.'/course/preview/'.$value->id).'" class="btn btn-sm btn-info btn-flat"> <i class="fa fa-eye"></i> '.$this->lang->line('preview').'</a> </td>';
                             endforeach; ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
                <div class="box-footer clearfix">
                <div class="btn-group">
                  <a href="#" data-toggle="modal"  data-target="#addCourse" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span>  New</a>
                   <button type="submit" class="btn btn-danger" onclick="return confirm('Deleted item(s) cannot be undone. Are you sure?');" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button>
                </div>
                 <div class="pull-right"></div>
                </div>
                </div>
              </div>
              </form>
            </div>
            </div>
        </section>
      </div>

       <div id="addCourse" class="modal">
       <?= form_open(base_url('backend/course/index'));?>
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $this->lang->line('add_course');?></h4>
                  </div>
                  <div class="modal-body">
                   <div class="row">
                    <div class="col-xs-8 ">
                  <div class="form-group has-feedback">
                      <?php 
                      $attributes = array(
                        'name'=>'course_title',
                        'class'=>'form-control',
                        'placeholder'=> $this->lang->line('course_title')
                        );
                        echo form_input($attributes);?>
                      <span class="glyphicon glyphicon-book form-control-feedback"></span>
                  </div>
                  </div>
                  <div class="col-xs-4">
                  <div class="form-group has-feedback">
                  <?php 
                      $attributes = array(
                        'name'=>'course_code',
                        'class'=>'form-control',
                        'placeholder'=> $this->lang->line('course_code')
                        );
                        echo form_input($attributes);?>
                      <span class="glyphicon glyphicon-book form-control-feedback"></span>
                  </div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-8">
                  <div class="form-group has-feedback">
                  <label>Lecturer Name: </label>
                  <select name="course_lecturer">
                  <?php foreach($lecturers as $key => $value): 
                    echo '<option class="form-control" value="'.$value->id.'">'.$value->name.'</option>';
                  endforeach;?>
                  </select>
                  </div>
                  </div>
                  <div class="col-xs-4">
                  <div class="form-group has-feedback">
                  <label>Level: </label>
                  <select name="level_id">
                  <?php foreach($classes as $key => $value): 
                    echo '<option class="form-control" value="'.$value->id.'">'.$value->name.'</option>';
                  endforeach;?>
                  </select>
                  </div>
                  </div>
                  </div>
                  <div class="form-group has-feedback">
                      <?php 
                      $attributes = array(
                        'name'=>'course_description',
                        'class'=>'form-control',
                        'placeholder'=> $this->lang->line('course_desc')
                        );
                        echo form_textarea($attributes);?>
                  </div>
                  </div>
                  <div class="modal-footer">
                   <?php echo form_submit('submit', $this->lang->line('add_course'), "class='btn btn-primary'"); ?>
                     </div>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
            
<?php
$this->load->view('themes/footer');
?>