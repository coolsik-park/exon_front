<div>
    <?= $this->Form->create()?>
    <?php echo $this->Form->control('notice', ['type' => 'textarea']); ?>
    <?= $this->Form->end() ?>
    <?= $this->Form->button('저장', ['id' => 'noticeAdd']) ?>
</div>

<script>
    CKEDITOR.replace('notice');

    $("#noticeAdd").click(function () {
        var notice = CKEDITOR.instances['notice'].getData();
        jQuery.ajax({
            url: "/exhibition-stream/notice/" + <?= $id ?>, 
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