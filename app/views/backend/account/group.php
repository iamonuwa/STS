<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('themes/navbar');
$this->load->view('themes/sidebar');
?>
        <section class="content-header">
          <h1>
         Group Module
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Accounts</li>
            <li class="active">Groups</li>
          </ol>
        </section>

        
       <section class="content">
          <div class="row">
            
            <div class="col-md-12">

              <div class="box box-info">
              <form action="<?= base_url('backend/account/delete_group');?>" method="POST">
                <div class="box-header with-border">
                  <h3 class="box-title">Availiable Groups</h3>
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
                        <th>Group Title</th>
                        <th>Group Description</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php foreach($group as $key => $value):
                      echo '<tr>
                            <td width="1%"><input type="checkbox" name="selector[]" id="selector[]" value="'.$value->id. '"/>
                            <td>'.$value->name.'</td>
                            <td>'.$value->definition.'</td>';
                           endforeach; ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
                <div class="box-footer clearfix">
                <div class="btn-group">
                  <a href="#" data-toggle="modal"  data-target="#addGroup" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span>  New</a>
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
       <div id="addGroup" class="modal">
       <form method="POST" action="<?= base_url('backend/account/group');?>" autocomplete="off">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create New Role</h4>
                  </div>
                  <div class="modal-body">
                  <div class="form-group has-feedback">
                  <input type="text" name="name" class="form-control" placeholder="Role Title">
                     <span class="glyphicon glyphicon-group form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                  <?php 
                      $attributes = array(
                        'name'=>'definition',
                        'class'=>'form-control',
                        'placeholder'=> 'Role Definition'
                        );
                        echo form_textarea($attributes);?>
                  </div>
                  <div class="modal-footer">
                     <div class="modal-footer">
                     <input type="submit" name="create_group" value="Add New Group" class="btn btn-success">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </form>
            </div>
<?php
$this->load->view('themes/footer');
?>