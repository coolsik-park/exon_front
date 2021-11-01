<div class="webinar-cont2">
    <h3 class="sr-only">공지사항</h3>
    <div class="webinar-cont-ty1">
        <div class="webinar-cont-ty1-body">
            <?php echo $this->Form->control('notice', ['type' => 'textarea', 'label' => false]); ?>
            <input type="hidden" id="hidden_notice" value="<?=$display?>">
        </div>
        <div class="webinar-cont-ty1-btm">
            <div class="poll-submit">                                        
                <button type="button" id="noticeAdd" class="btn-ty4 redbg">저장</button>
            </div>
        </div>
    </div>                               
</div>

<script>
    CKEDITOR.replace('notice');

    var notice = $("#hidden_notice").val();
    if (notice != '') {
        CKEDITOR.instances.notice.setData(notice);
    }

    $("#noticeAdd").click(function () {
        var notice = CKEDITOR.instances['notice'].getData();
        jQuery.ajax({
            url: "/exhibition-stream/set-notice/" + <?= $id ?>, 
            method: 'POST',
            type: 'json',
            data: {
                notice: notice
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("저장되었습니다.");
            }
        });
    });
</script>