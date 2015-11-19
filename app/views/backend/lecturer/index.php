<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('themes/navbar');
$this->load->view('themes/sidebar');
?>
        <section class="content-header">
          <h1>
          <?= $this->lang->line('lecturer_module');?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?= $this->lang->line('lecturer');?></li>
          </ol>
        </section>

        
       <section class="content">
          <div class="row">
            
            <div class="col-md-12">

              <div class="box box-info">
              <form action="<?= base_url('backend/lecturer/delete');?>" method="POST">
                <div class="box-header with-border">
                  <h3 class="box-title"><?= $this->lang->line('available_lecturer');?></h3>
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
                        <th><?= $this->lang->line('lecturer');?></th>
                        <th>Department</th>
                        <th><?= $this->lang->line('last_update');?></th>
                        <th><?= $this->lang->line('actions');?></th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php foreach($lecturer as $key => $value):
                      echo '<tr>
                            <td width="1%"><input type="checkbox" name="selector[]" id="selector[]" value="'.$value->id. '"/>
                            <td>'.$value->name.'</td>
                            <td>'.$value->department.'</td>
                            <td>'.$value->last_update.'</td>
                            <td> <a href="'.base_url('backend/'.$this->aauth->get_user()->name.'/lecturer/preview/'.$value->id).'" class="btn btn-sm btn-info btn-flat"> <i class="fa fa-eye"></i> '.$this->lang->line('preview').'</a> </td>';
                         endforeach; ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
                <div class="box-footer clearfix">
                <div class="btn-group">
                  <a href="#" data-toggle="modal" data-target="#addLecturer" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span>  New</a>
                   <button type="submit" class="btn btn-danger" onclick="return confirm('Deleted item(s) cannot be undone. Are you sure?');" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button>
                </div>
                 <div class="pull-right"></div>
                </div>
              </div>
              </form>
            </div>
            </div>
        </section>
      </div>

       <div id="addLecturer" class="modal">
        <?= form_open(base_url('backend/lecturer/index'));?>
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $this->lang->line('add_lecturer');?></h4>
                  </div>
                  <div class="modal-body">
                  <div class="form-group has-feedback">
                  <?php 
                      $attributes = array(
                        'name'=>'lecturer_name',
                        'class'=>'form-control',
                        'placeholder'=> $this->lang->line('lecturer')
                        );
                        echo form_input($attributes);?>
                     <span class="glyphicon glyphicon-blackboard form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                         <?php 
                      $attributes = array(
                        'name'=>'department',
                        'class'=>'form-control',
                        'placeholder'=> $this->lang->line('lecturer_dept')
                        );
                        echo form_input($attributes);?>
                     <span class="glyphicon glyphicon-blackboard form-control-feedback"></span>
                  </div>
                  </div>
                 <div class="modal-footer">
                     <?php echo form_submit('submit', $this->lang->line('add_lecturer'), "class='btn btn-primary'"); ?>
                    </div>
                </div>
              </div>
              <?= form_close();?>
            </div>
            </div>
            
<?php
$this->load->view('themes/footer');
?>