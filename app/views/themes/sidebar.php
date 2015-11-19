 <aside class="main-sidebar">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?= base_url('assets/default/dist/img/avatar.png');?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?= $this->aauth->get_user()->fullname;?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <ul class="sidebar-menu treeview-menu">
            <li class="header"><?= $this->lang->line('main_nav');?></li>
            <li class="treeview <?= $this->uri->segment(3) ==='dashboard' ? 'active' : ''?>"><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/dashboard');?>"><i class="fa fa-dashboard"></i> <?= $this->lang->line('dashboard');?> </a></li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span><?= $this->lang->line('subsys');?></span>
                <i class="fa fa-angle-left pull-right"></i>
                  </a>
                 <ul class="treeview-menu">
                <li class="<?= $this->uri->segment(3) ==='building' ? 'active' : ''?>" ><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/building');?>"><i class="glyphicon glyphicon-home"></i>   <?= $this->lang->line('building_module');?> </a></li>
                <li class="<?= $this->uri->segment(3) ==='room' ? 'active' : ''?>" ><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/room');?>"><i class="glyphicon glyphicon-edit"></i> <?= $this->lang->line('room_module');?></a></li>
                <li class="<?= $this->uri->segment(3) ==='class' ? 'active' : ''?>" ><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/class');?>"><i class="fa fa-laptop"></i> <?= $this->lang->line('class_module');?></a></li>
                <li class="<?= $this->uri->segment(3) ==='course' ? 'active' : ''?>" ><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/course');?>"><i class="glyphicon glyphicon-book"></i> <?= $this->lang->line('course_module');?></a></li>
                <li class="<?= $this->uri->segment(3) ==='lecturer' ? 'active' : ''?>" ><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/lecturer');?>"><i class=" glyphicon glyphicon-blackboard"></i> <?= $this->lang->line('lecturer_module');?> </a></li>
               </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="glyphicon glyphicon-user"></i>
                <span><?= $this->lang->line('acct_mgr');?></span>
                <i class="fa fa-angle-left pull-right"></i>
                  </a>
                 <ul class="treeview-menu">
                <li class="treeview <?= $this->uri->segment(3) ==='dashboard' ? 'active' : ''?>"><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/user-mgr');?>"><i class="fa fa-users"></i> <?= $this->lang->line('users');?> </a></li>
                <li class="treeview <?= $this->uri->segment(3) ==='dashboard' ? 'active' : ''?>"><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/user-mgr/groups');?>"><i class="fa fa-user"></i> <?= $this->lang->line('role_users');?> </a></li>
                <li class="treeview <?= $this->uri->segment(3) ==='dashboard' ? 'active' : ''?>"><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/user-mgr/ban');?>"><i class="fa fa-user-times"></i> <?= $this->lang->line('ban_users');?> </a></li>
                </ul>
            </li>       

            <li class="treeview">
              <a href="#">
                <i class="fa-calendar"></i>
                <span>Timetable Manager</span>
                <i class="fa fa-angle-left pull-right"></i>
                  </a>
                 <ul class="treeview-menu">
                <li class="treeview <?= $this->uri->segment(3) ==='timetable' ? 'active' : ''?>"><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/timetable');?>"><i class="fa fa-gear"></i> Timetable</a></li>
                <li class="treeview <?= $this->uri->segment(3) ==='timetable' ? 'active' : ''?>"><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/timetable');?>"><i class="fa fa-gear"></i> Saved Timetable</a></li>
                </ul>
            </li>        

            <li class="treeview">
              <a href="#">
                <i class="fa-internet-explorer"></i>
                <span><?= $this->lang->line('site_mgr');?></span>
                <i class="fa fa-angle-left pull-right"></i>
                  </a>
                 <ul class="treeview-menu">
                <li class="treeview <?= $this->uri->segment(3) ==='dashboard' ? 'active' : ''?>"><a href="<?= base_url('backend/'.$this->aauth->get_user()->name.'/settings/backup');?>"><i class="fa fa-gear"></i> <?= $this->lang->line('database_backup');?> </a></li>
                </ul>
            </li>                
             </ul>
        </section>
      </aside>

<div class="content-wrapper">
<?php  if($this->session->flashdata('msg') != ''){?>
  <div id="alert-msg" class="alert alert-danger alert-dismissable">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
   <i class="icon fa fa-bullhorn"></i><?= $this->session->flashdata('msg');?>
  </div>
                <?php }
                  if($this->session->flashdata('success') != ''){?>
   <div id="alert-success" class="alert alert-success alert-dismissable">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
   <i class="icon fa fa-bullhorn"></i><?= $this->session->flashdata('success');?>
  </div> <?php }?>
                  