<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('themes/navbar');
$this->load->view('themes/sidebar');
?>
        <section class="content-header">
          <h1>
          Users Module
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-user"></i> Accounts</a></li>
            <li class="active"> Users</li>
          </ol>
        </section>

        
       <section class="content">
          <div class="row">
            
            <div class="col-md-12">

              <div class="box box-info">
               <form action="<?= base_url('backend/account/ban');?>" method="POST">
                <div class="box-header with-border">
                  <h3 class="box-title">Current Users</h3>
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
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Email Address</th>
                        <th>Last Login</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php foreach($this->aauth->list_users() as $key => $value):
                      echo '<tr>
                            <td width="1%"><input type="checkbox" name="selector[]" id="selector[]" value="'.$value->id. '"/>
                            <td>'.$value->fullname.'</td>
                            <td>'.$value->name.'</td>
                            <td>'.$value->email.'</td>
                            <td>'.$value->last_login.'</td>';
                             endforeach; ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
                <div class="box-footer clearfix">
                <div class="btn-group">
                  <a href="#" data-toggle="modal"  data-target="#addUser" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span>  New</a>
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');" name="delete"><span class="fa fa-user-times"></span> Ban Account(s)</button>
                </div>
                 <div class="pull-right"></div>
                </div>

              </div>
              </form>
            </div>
            </div>
        </section>
      </div>

      <div id="addUser" class="modal">
       <form method="POST" action="<?= base_url('backend/account/index');?>" autocomplete="off">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create New Account</h4>
                  </div>
                  <div class="modal-body">
                  <div class="form-group has-feedback">
                  <input type="text" name="fullname" class="form-control" placeholder="Fullname">
                     <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="row">
                  <div class="col-xs-6 ">
                   <div class="form-group has-feedback">
                  <input type="text" name="id_number" class="form-control" placeholder="Login ID">
                     <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>  
                  </div>
                  <div class="col-xs-6 ">
                   <div class="form-group has-feedback">
                  <input type="password" name="password" class="form-control" placeholder="Login PIN">
                     <span class="glyphicon glyphicon-pushpin form-control-feedback"></span>
                  </div>  
                  </div>
                  </div> 
                   <div class="form-group has-feedback">
                  <input type="email" name="email" class="form-control" placeholder="Email Address">
                     <span class="glyphicon glyphicon-inbox form-control-feedback"></span>
                  </div> 
                  <div class="row">
                  <div class="col-xs-6 ">
                   <div class="form-group has-feedback">
                  <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                     <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                  </div>  
                  </div>
                  <div class="col-xs-6 ">
                    <select name="gender" class="form-control">
                      <option value="1">MALE</option>
                      <option value="2">FEMALE</option>
                    </select>
                  </div>
                  </div> 
                  <div class="modal-footer">
                     <div class="modal-footer">
                     <input type="submit" name="create_user" value="Add New User" class="btn btn-success">
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