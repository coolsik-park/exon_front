<div class="webinar-cont2">
    <h3 class="sr-only">프로그램</h3>
    <div class="webinar-cont-ty1">
        <div class="webinar-cont-ty1-body">
            <?php echo $this->Form->control('program', ['type' => 'textarea', 'label' => false]); ?>
        </div>
        <div class="webinar-cont-ty1-btm">
            <div class="poll-submit">                                        
                <button id="programAdd" class="btn-ty4 redbg">저장</button>
            </div>
        </div>
    </div>                            
</div>

<script>
    CKEDITOR.replace('program');

    $("button#programAdd").click(function () {
        var program = CKEDITOR.instances['program'].getData();
        jQuery.ajax({
            url: "/exhibition-stream/set-program/" + <?= $id ?>, 
            method: 'POST',
            type: 'json',
            data: {
                program: program
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("저장되었습니다.");
            } else {
                alert("저장에 실패하였습니다. 잠시후 다시 시도해주세요.");
            }
        });
    });
</script>
