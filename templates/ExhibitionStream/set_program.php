<div class="webinar-cont2">
    <h3 class="sr-only">프로그램</h3>
    <div class="webinar-cont-ty1">
        <div class="webinar-cont-ty1-body">
            <?php echo $this->Form->control('program', ['type' => 'textarea', 'label' => false]); ?>
            <input type="hidden" id="hidden_program" value="<?=htmlspecialchars($program)?>">
        </div>
        <div class="webinar-cont-ty1-btm">
            <div class="poll-submit">                                        
                <button type="button" id="programAdd" class="btn-ty4 redbg">저장</button>
            </div>
        </div>
    </div>                            
</div>

<script type="text/javascript" src="/se2_small/js/HuskyEZCreator.js" charset="utf-8"></script>
<script>        
    //naver editor
    var oEditors = [];
    var program = $("#hidden_program").val();
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "program",
        sSkinURI: "/se2_small/SmartEditor2Skin.html",
        fOnAppLoad : function(){
            oEditors.getById["program"].exec("PASTE_HTML", [program]);
        },
        fCreator: "createSEditor2"
    });

    $("#programAdd").click(function () {
        oEditors.getById["program"].exec("UPDATE_CONTENTS_FIELD", []);
        var program = $("#program").val();
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
                $(".webinar-tab-body").load("/exhibition-stream/set-program/" + <?= $id ?>);
            } else {
                alert("저장에 실패하였습니다. 잠시후 다시 시도해주세요.");
            }
        });
    });
</script>
