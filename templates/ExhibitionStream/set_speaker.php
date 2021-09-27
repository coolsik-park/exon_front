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

<div class="wb-in-tab-cont">
    <div id="wbCon1" class="on">
        <h4 class="sr-only">연사자</h4>
        <ul class="ph-items">
            <li>
                <div class="ph-item">
                    <div class="photo"></div>
                    <div class="tx">전체</div>
                    <button type="button" class="btn-del">삭제</button>
                </div>
            </li>
            <li>
                <div class="ph-item">
                    <div class="photo"></div>
                    <div class="tx">유비 교수</div>
                    <button type="button" class="btn-del">삭제</button>
                </div>
            </li>
            <li>
                <div class="ph-item">
                    <div class="photo"></div>
                    <div class="tx">관우 교수</div>
                    <button type="button" class="btn-del">삭제</button>
                </div>
            </li>
            <li>
                <div class="ph-item">
                    <div class="photo"></div>
                    <div class="tx">장비 교수</div>
                    <button type="button" class="btn-del">삭제</button>
                </div>
            </li>
            <li>
                <div class="ph-item">
                    <div class="photo"></div>
                    <div class="tx">장비 교수</div>
                    <button type="button" class="btn-del">삭제</button>
                </div>
            </li>
            <li>
                <div class="ph-item">
                    <div class="photo"></div>
                    <div class="tx">장비 교수</div>
                    <button type="button" class="btn-del">삭제</button>
                </div>
            </li>
            <li>
                <div class="ph-item">
                    <div class="photo"></div>
                    <div class="tx">장비 교수</div>
                    <button type="button" class="btn-del">삭제</button>
                </div>
            </li>
            <li>
                <div class="ph-item-btn">
                    <button type="button" class="ph-item-add">추가</button>
                </div>                                                    
            </li>
        </ul>
    </div>
</div>
<script>  

$(document).ready(function(){
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