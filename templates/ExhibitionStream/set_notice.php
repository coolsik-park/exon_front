<div class="webinar-cont2">
    <h3 class="sr-only">공지사항</h3>
    <div class="webinar-cont-ty1">
        <div class="webinar-cont-ty1-body">
            <?php echo $this->Form->control('notice', ['type' => 'textarea', 'label' => false]); ?>
        </div>
        <div class="webinar-cont-ty1-btm">
            <div class="poll-submit">                                        
                <button id="noticeAdd" class="btn-ty4 redbg">저장</button>
            </div>
        </div>
    </div>                               
</div>

<script>
    CKEDITOR.replace('notice');

    $("button#noticeAdd").click(function () {
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