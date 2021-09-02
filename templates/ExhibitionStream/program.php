
<div>
    <?= $this->Form->create()?>
    <?php echo $this->Form->control('program', ['type' => 'textarea']); ?>
    <?= $this->Form->end() ?>
    <?= $this->Form->button('저장', ['id' => 'add']) ?>
</div>

<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('program');

    $("#add").click(function () {
        var program = CKEDITOR.instances['program'].getData();
        jQuery.ajax({
            url: "http://121.126.223.225:8765/exhibition-stream/program/" + <?= $id ?>, 
            method: 'POST',
            type: 'json',
            data: {
                program: program
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("저장되었습니다.");
            }
        });
    });
</script>
