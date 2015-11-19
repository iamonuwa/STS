<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="login-box">
      <div class="login-logo">
        <a href="<?= base_url();?>"><b>STEMS</b> CPanel</a>
      </div>
         <?php if($this->session->flashdata('msg') != ''){?>
         <div class="callout callout-danger">
              <h4>Login Failure</h4>
              <?php echo $this->session->flashdata('msg');?>
        </div><?php  }?>
      <div class="login-box-body">
        <form action="<?= base_url();?>" method="post" autocomplete="off">
          <div class="form-group has-feedback">
            <input type="text" name="email" class="form-control" placeholder="Login ID">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class=" has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Login PIN">
            <span class="glyphicon glyphicon-pushpin form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8 ">
              <div class="checkbox icheck">
                <label> <input type="checkbox"> Remember Me </label>
              </div>
            </div>
            <div class="col-xs-4">
              <button type="submit" class="btn btn-success btn-block btn-flat">Sign In</button>
            </div>
          </div>
        </form>
        <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Go to API Docs</a>
        </div>
      </div>
    </div>
