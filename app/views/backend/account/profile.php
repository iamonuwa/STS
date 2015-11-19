     <?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('themes/navbar');
$this->load->view('themes/sidebar');
?>
                <section class="content-header">
          <h1>
            My profile
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?= base_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User profile</li>
          </ol>
        </section>

                <section class="content">

          <div class="row">
            <div class="col-md-3">

                            <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="<?= base_url('assets/default/dist/img/avatar.png');?>" alt="User profile picture">
                  <h3 class="profile-username text-center"><?= $this->aauth->get_user()->fullname; ?></h3>
                  <p class="text-muted text-center">Software Engineer</p>
                </div>              </div>            </div>            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li  class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
                <div class="tab-content">

                  <div class="active tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                          <input type="name" class="form-control" id="inputName" placeholder="Name" value="<?= $this->aauth->get_user()->fullname; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email" value="<?= $this->aauth->get_user()->email; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" placeholder="Phone Number" value="<?= $this->aauth->get_user()->phone; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">Skills</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"><?= $this->aauth->get_user()->about; ?></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>  
                                      </div>              </div>            </div>          </div>
        </section>      </div>
        <?php $this->load->view('themes/footer');?>