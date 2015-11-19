<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('themes/navbar');
$this->load->view('themes/sidebar');
?>
        <section class="content-header">
          <h1>
          <?= $this->lang->line('room_module');?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?= $this->lang->line('room');?></li>
          </ol>
        </section>

        
       <section class="content">
          <div class="row">
            
            <div class="col-md-12">
               <form action="<?= base_url('backend/room/delete');?>" method="POST">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title"><?= $this->lang->line('available_room');?></h3>
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
                        <th><?= $this->lang->line('room');?></th>
                        <th><?= $this->lang->line('building');?></th>
                        <th><?= $this->lang->line('room_size');?></th>
                        <th><?= $this->lang->line('last_update');?></th>
                        <th><?= $this->lang->line('actions');?></th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php foreach($room as $key => $value):
                      echo '<tr>
                            <td width="1%"><input type="checkbox" name="selector[]" id="selector[]" value="'.$value->id. '"/>
                            <td>'.$value->name.'</td>
                            <td>'.$this->building_model->get_by('id', $value->building_id)->name.'</td>
                            <td>'.$value->capacity.'</td>
                            <td>'.$value->last_update.'</td>
                            <td> <a href="'.base_url('backend/'.$this->aauth->get_user()->name.'/room/preview/'.$value->id).'" class="btn btn-sm btn-info btn-flat"> <i class="fa fa-eye"></i> '.$this->lang->line('preview').'</a> </td>';
                             endforeach; ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
                <div class="box-footer clearfix">
                  <div class="btn-group">
                  <a href="#" data-toggle="modal"  data-target="#addRoom" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span>  New</a>
                   <button type="submit" class="btn btn-danger" onclick="return confirm('Deleted item(s) cannot be undone. Are you sure?');" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button>
                  </div>
                  </div>
              </div>
              </form>
            </div>
            </div>
        </section>
      </div>

       <div id="addRoom" class="modal">
        <?= form_open(base_url('backend/room/index'));?>
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $this->lang->line('add_room');?></h4>
                  </div>
                  <div class="modal-body">
                  <div class="form-group has-feedback">
                  <div class="form-group has-feedback">
                  <label><?= $this->lang->line('building');?>: </label>
                  <select name="building_name">
                  <?php foreach($building as $key => $value): 
                    echo '<option class="form-control" value="'.$value->id.'">'.$value->name.'</option>';
                  endforeach;?>
                  </select>
                  </div>
                  <div class="form-group has-feedback">
                  <?php 
                      $attributes = array(
                        'name'=>'name',
                        'class'=>'form-control',
                        'placeholder'=> $this->lang->line('room')
                        );
                        echo form_input($attributes);?>
                      <span class="glyphicon glyphicon-edit form-control-feedback"></span>
                  </div>

                  <div class="form-group has-feedback">
                  <?php 
                      $attributes = array(
                        'name'=>'capacity',
                        'class'=>'form-control',
                        'placeholder'=> $this->lang->line('room_size')
                        );
                        echo form_input($attributes);?>
                         <span class="glyphicon glyphicon-edit form-control-feedback"></span>
                  </div>
                  </div>
                  </div>
                 <div class="modal-footer">
                     <?php echo form_submit('submit', $this->lang->line('add_room'), "class='btn btn-primary'"); ?>
                    </div>
                </div>
              </div>
              <?= form_close();?>
            </div>
             
<?php
$this->load->view('themes/footer');
?>