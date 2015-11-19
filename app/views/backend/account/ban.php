<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('themes/navbar');
$this->load->view('themes/sidebar');
?>
        <section class="content-header">
          <h1>
          Banned Accounts
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Accounts</li>
            <li class="active">Banned Accounts</li>
          </ol>
        </section>

        
       <section class="content">
          <div class="row">
            
            <div class="col-md-12">

              <div class="box box-info">
              <form action="<?= base_url('backend/account/unban');?>" method="POST">
                <div class="box-header with-border">
                  <h3 class="box-title">Banned Accounts</h3>
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
                        <th>Email Address</th>
                        <th>Phone Number</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php foreach($this->aauth->list_ban() as $key => $value):
                      echo '<tr>
                            <td width="1%"><input type="checkbox" name="selector[]" id="selector[]" value="'.$value->id. '"/>
                            <td>'.$value->fullname.'</td>
                            <td>'.$value->email.'</td>
                            <td>'.$value->phone.'</td>';
                           endforeach; ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
                <div class="box-footer clearfix">
                <div class="btn-group">
                 <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?');" name="delete"><span class="fa fa-user-times"></span> Unban Account(s)</button>
                </div>
                 <div class="pull-right"></div>
                </div>

              </div>
              </form>
            </div>
            </div>
        </section>
      </div>
<?php
$this->load->view('themes/footer');
?>