<div class="text-center" style="margin-top: 50px;">
  <h4>Add Post</h4>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <?php echo $this->Form->create($postEnt, ['name'=>'add_post', 'class'=>'was-validated', 'enctype'=>'multipart/form-data']) ?>
      <div class="form-group">
        <?php echo $this->Form->control('title', ['type'=>'text', 'class'=>'form-control','placeholder'=>'Enter title','required'=>true]);?>
      </div>
      <div class="form-group">
        <?php echo $this->Form->control('description', ['type'=>'text', 'class'=>'form-control','placeholder'=>'Enter description','required'=>true]);?>
      </div>
      <div class="form-group">
        <?= $this->Form->control('file_name', ['type'=>'file', 'class'=>'form-control','required'=>true]); ?>
      </div>
      <button type="submit" class="btn btn-success" style="float: right;">Save</button>
      <?php echo $this->Form->end() ?>
    </div>
  </div>
</div>