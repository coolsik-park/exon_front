<div class="column-responsive column-80">
    <div class="exhibitionStream form content"> 
        <?= $this->Form->create(null, ['enctype' => 'multipart/form-data']) ?>
        <table class="table table-bordered" id="dynamic_field">  
            <tr>  
                <td><?php echo $this->Form->control('image0', ['type' => 'file']); ?></td>
                <td><?php echo $this->Form->control('0.exhibition_id', ['type' => 'hidden', 'value' => $id]); ?></td>          
                <td><?php echo $this->Form->control('0.name'); ?></td>
                 					 
                <td><button type="button" name="add" id="add" class="btn btn-outline-primary btn-flat">add<i class="fas fa-plus"></i></button></td>  
            </tr>  
        </table> 

        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<script>  
<<<<<<< HEAD
<<<<<<< HEAD
$(document).ready(function(){  
=======
$(document).ready(function(){
>>>>>>> 85afc0d88a36c121135fb9ada89efc86f4771676
=======
$(document).ready(function(){
>>>>>>> master
    var i=1;  
    $('#add').click(function(){  
        $('#dynamic_field').append(
        '<tr id="row'+i+'">'+
        '<td><label for="image'+i+'">image'+i+'</label><input id="image'+i+'" name="image'+i+'" label="abc" type="file"></td>'+ 
        '<td><input id="'+i+'-exhibition_id" name="'+i+'[exhibition_id]" type="hidden" value="<?=$id?>"></td>'+
        '<td><label for="'+i+'-name">Name</label><input id="'+i+'-name" name="'+i+'[name]" type="text"></td>'+
        '<td><button type="button" name="remove" id="'+i+'" class="btn btn-outline-danger btn-flat btn_remove">remove<i class="fas fa-times"></i></button></td>'+
        '</tr>'
        );  
        i++;  
    });  
    $(document).on('click', '.btn_remove', function(){  
        var button_id = $(this).attr("id");   
        $('#row'+button_id+'').remove();  
    });  
});  
</script>