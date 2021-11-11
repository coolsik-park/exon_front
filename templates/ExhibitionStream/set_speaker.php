<form id="speakerForm" enctype="multipart/form-data">
    <div class="wb-in-tab-cont">
        <div id="wbCon1" class="on">
            <h4 class="sr-only">연사자</h4>
            <ul id="speakerUl" class="ph-items">
                <li>
                    <div class="ph-item-btn">
                        <button id="add" type="button" class="ph-item-add">추가</button>
                    </div>                                                    
                </li>
                <?php $displayIndex = 0; ?>
                <?php if (!empty($displays)) : ?>
                <?php foreach ($displays as $display) : ?>
                <li id="speaker_<?=$displayIndex?>">
                    <div class="ph-item">
                        <?php if ($display->image_name == '') : ?>
                        <div class="photo"><img id="speakerImg_<?=$displayIndex?>" src="/images/img-no.png"></div>
                        <?php else : ?>
                        <div class="photo"><img id="speakerImg_<?=$displayIndex?>" src="/<?=$display->image_path?>/<?=$display->image_name?>"></div>
                        <?php endif; ?>
                        <div class="tx"><input type="text" style="width:90px; height:24px;" value="<?=$display->name?>" readonly></div>
                        <button type="button" class="btn-del" onclick="deleteSpeaker(<?=$displayIndex?>, <?=$display->id?>)">삭제</button>
                    </div>
                </li>
                <?php $displayIndex++; ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="webinar-cont-ty1-btm">
        <div class="poll-submit">                                        
            <button type="button" id="saveSpeaker" class="btn-ty4 redbg">저장</button>
        </div>
    </div>
</form>

<script> 
    //발표자 추가
    var speakerIndex = <?=$displayIndex?>;
    $("#add").click(function () {
        var html = '';
        html += '<li id="speaker_'+speakerIndex+'">';
        html += '   <div class="ph-item">';
        html += '       <label for="'+speakerIndex+'"><div class="photo"><img id="speakerImg_'+speakerIndex+'"></div>';
        html += '       <input type="file" id="'+speakerIndex+'" name="image[]" style="display:none">';
        html += '       <div class="tx"><input type="text" name="name[]" style="width:90px; height:24px;"></div>';
        html += '       <button type="button" class="btn-del" onclick="deleteSpeaker('+speakerIndex+', 0)">삭제</button>';
        html += '   </div>';
        html += '</li>'
        $("#speakerUl").append(html);
        speakerIndex += 1;
    });

    //발표자 삭제
    function deleteSpeaker(index, id) {
        var html = '';
        html += '<input type="hidden" name="speaker_del[]" value="'+id+'">';
        $("#speakerUl").append(html);
        $("#speaker_" + index).remove();
        speakerIndex -= 1;
    };

    //사진 추가
    $(document).on("change", "input[name='image[]']", function() {
        var id = $(this).attr("id");
        var formData = new FormData();
        var image = document.getElementById(id).files;
        formData.append('image', image[0]);
        formData.append('action', 'image');
        
        jQuery.ajax({
            url: '/exhibition-stream/set-speaker/<?=$id?>',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            type: 'POST',
        }).done(function (data) {
            if (data.status == 'success') {
                $("#speakerImg_" + id).attr("src", "/" + data.path + "/" + data.imgName);
            } else {
                alert('이미지 등록에 실패하였습니다. 잠시 후 다시 시도해 주세요.');
            }
        });
    });

    //저장
    $("#saveSpeaker").click(function () {
        var is_empty = 0;
        $("input[name='name[]']").each(function () {
            if ($(this).val() == '') {
                alert('발표자 이름을 입력해주세요.');
                $(this).focus();
                is_empty = 1;
            }
        });

        if (is_empty == 1) {
            return false;
        }

        var formData = new FormData();
        var images = document.getElementsByName('image[]');
        for (var i = 0; i < images.length; i++) {
            formData.append('images[]', images[i].files[0]);
        }
        var names = document.getElementsByName('name[]');
        for (var i = 0; i < names.length; i++) {
            formData.append('names[]', names[i].value);
        }

        var speaker_dels = document.getElementsByName('speaker_del[]');
        if (speaker_dels.length != 0) {
            for (var i = 0; i < speaker_dels.length; i++) {
                formData.append('speaker_dels[]', speaker_dels[i].value);
            }
        }
        
        jQuery.ajax({
            url: '/exhibition-stream/set-speaker/<?=$id?>',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            type: 'POST',
        }).done(function (data) {
            if (data.status == 'success') {
                alert('저장되었습니다.');
                $("#questionContent").load("/exhibition-stream/set-speaker/" + <?= $id ?>);
            } else {
                alert('저장에 실패하였습니다. 잠시 후 다시 시도해주세요.');
            }
        });   
    });
</script>