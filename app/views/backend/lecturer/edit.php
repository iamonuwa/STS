<div id="preview" class="modal">
       <?= form_open(base_url('backend/room/index'));?>
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $this->lang->line('preview_lecturer');?></h4>
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
                    <?= btn_delete('backend/lecturer/delete');?>
                    </div>
              </div>
            </div>
            <?= form_close();?>
            </div>