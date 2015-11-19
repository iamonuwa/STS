<div role="dialog" class="modal show">
            <form method="POST" action="<?= base_url('backend/building/edit/'.$building->id);?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $this->lang->line('preview_lecturer');?></h4>
                  </div>
                  <div class="modal-body">
                  <div class="form-group has-feedback">
                  <input type="text" name="name" id="building_name" class="form-control" placeholder="<?= $this->lang->line('building'); ?>" value="<?= $building->name;?>">
                      <span class="glyphicon glyphicon-home form-control-feedback"></span>
                  </div>
                  </div>
                 <div class="modal-footer">
                     <?php echo form_submit('submit', $this->lang->line('update_building'), "class='btn btn-primary'"); ?>
                  </div>
              </div>
            </div>
            <?= form_close();?>
            </div>