<div id="container">        
    <div class="contents static">
        <h2 class="s-hty0">고객센터</h2>            
        <div class="cs-tab">
            <ul class="s-tabs2">
                <li><a href="/boards/customer-service">자주 하는 질문</a></li>
                <li><a href="/boards/notice">공지사항</a></li>
                <li class="active"><a href="">문의하기</a></li>
            </ul>
        </div>
        <div class="section-cs3">
            <h3 class="s-hty1">문의하기</h3>
            <div class="cs-contact">
                <div class="cate">
                    <?= $this->Form->select('', $categories, ['id' => 'categories']) ?>
                </div>
                <div class="item-row">
                    <div class="col-dt"><h4>제목</h4></div>
                    <div class="col-dd">
                        <input type="text" id="title" placeholder="제목을 입력해주세요" title="제목" class="ipt">
                    </div>
                </div>
                <div class="item-row">
                    <div class="col-dt"><h4>이름</h4></div>
                    <div class="col-dd">
                        <input type="text" id="name" placeholder="홍길동" title="이름" class="ipt">
                    </div>
                </div>
                <div class="item-row">
                    <div class="col-dt"><h4>연락처</h4></div>
                    <div class="col-dd">
                        <input type="text" id="hp" placeholder="01012345678" title="연락처" class="ipt">
                        <p id="hpNoti" class="noti hc1"></p>
                    </div>
                </div>
                <div class="item-row">
                    <div class="col-dt"><h4>이메일</h4></div>
                    <div class="col-dd">
                        <input type="text" id="email" placeholder="이메일" title="이메일" class="ipt">
                        <p class="p-noti">답변은 이메일을 통해 보내드립니다</p>
                        <p id="emailNoti" class="noti hc1"></p>
                    </div>
                </div>
                <div class="item-textar">
                    <h4>내용</h4>
                    <textarea name="question" id="question" cols="30" rows="10" placeholder="내용을 입력해주세요"></textarea>
                </div>
                <div class="item-row item-row-file">
                    <div class="col-dt"><h4>파일첨부</h4></div>
                    <div class="col-dd">
                        <form name="imgUpload" id="imgUpload">
                            <label class="btn-ty2 bor" for="fileSaveButton">파일선택</label>
                            <input type="file" id="fileSaveButton" name="fileSaveButton" style="display:none"/>
                        </form>
                        <!-- <button type="button" class="btn-ty2 bor">파일선택</button> -->
                    </div>
                </div>
                <div class="add-files" id="dropZone">
                    <label for="fileSaveButton"></label>
                    <input type="file" id="fileSaveButton" name="fileSaveButton" multiple="multiple" style="display:none">
                    <p class="tx">마우스로 자료를 끌어오세요</p>
                </div>  
                <div id="fileTableTbody" class="data-itmes">

                </div>
                <div class="agree-wp">
                    <span class="chk-dsg"><input type="checkbox" name="rdo3" id="rdo3-1"><label for="rdo3-1">개인정보 수집 및 이용 동의</label></span>
                </div>
            </div>    
            <div class="section-btm2 mgtS1">                    
                <button type="submit" id="btn-big" class="btn-big">1:1 문의하기</button>
            </div>
        </div>     
    </div>        
</div>

<script>
    ui.addOnAction('.board-lists>li');

    var fileIndex = 0;
    var totalFileSize = 0;
    var fileList = new Array();
    var fileSizeList = new Array();
    var uploadSize = 50;
    var maxUploadSize = 500;

    $(function() {
        var dropZone = $('#dropZone');

        dropZone.on('dragenter', function(e) {
            e.stopPropagation();
            e.preventDefault();
            dropZone.css('background-color', '#E3F2FC');
        });

        dropZone.on('dragleave', function(e) {
            e.stopPropagation();
            e.preventDefault();
            dropZone.css('background-color', '#FFFFFF');
        });

        dropZone.on('dragover', function(e) {
            e.stopPropagation();
            e.preventDefault();
            dropZone.css('background-color', '#E3F2FC');
        });

        dropZone.on('drop', function(e) {
            e.preventDefault();
            dropZone.css('background-color', '#FFFFFF');

            var file = e.originalEvent.dataTransfer.files;
            selectFile(file);
        });
    });

    $('#fileSaveButton').on('change', function() {
        var file = document.getElementById('fileSaveButton').files;
        selectFile(file);
    });

    function selectFile(files) {
        if (files !=null) {
            for (var i=0; i<files.length; i++) {
                var fileName = files[i].name;
                var fileNameArr = fileName.split("\.");
                var ext = fileNameArr[fileNameArr.length - 1];

                fileList[fileIndex] = files[i];
                addFileList(fileIndex, fileName);
                fileIndex++;
            }
        } else {
            alert("ERROR");
        }
    }

    function addFileList(fIndex, fileName){
        var html = "<br>";
        html += "<a id='fileTr_" + fIndex + "' class='data-itme edit'>";
        html += "<span class='tx'>" + fileName + "</span>";
        html += "<button type='button' onclick='deleteFile(" + fIndex + "); return false;' class='btn-del'>삭제</button>";
        html += "</a>";

        $('#fileTableTbody').append(html);
    }

    function deleteFile(fIndex){
        totalFileSize -= fileSizeList[fIndex];
        delete fileList[fIndex];
        delete fileSizeList[fIndex];
        $("#fileTr_" + fIndex).remove();
    }

    $('#btn-big').on('click', function() {
        var uploadFileList = Object.keys(fileList);

        var getHp = RegExp(/^[0-9]*$/);
        var getEmail = RegExp(/^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/);
        var faqCategoryId = $('#categories option:selected').val();

        if (!getHp.test($('#hp').val())) {
            $('#hpNoti').html("전화번호를 제대로 입력해 주세요.");
            $('#hp').focus();
            return false;
        } else {
            $('#hpNoti').html("");
        }

        if ($('#hp').val().length < 11) {
            $('#hpNoti').html("전화번호를 제대로 입력해 주세요.");
            $('#hp').focus();
            return false;
        } else {
            $('#hpNoti').html("");
        }

        if (!getEmail.test($('#email').val())) {
            $('#emailNoti').html('이메일을 제대로 입력해 주세요.');
            $('#email').focus();
            return false;
        } else {
            $('#emailNoti').html('');
        }

        if ($('#rdo3-1').prop('checked') == false) {
            alert("개인정보 수집 및 이용 동의를 확인해주세요.");
            return false;
        }

        $.ajax({
            url: '/boards/add',
            method: 'POST',
            type: 'json',
            data: {
                faq_category_id: $('#categories option:selected').val(),
                title: $('#title').val(),
                users_name: $('#name').val(),
                users_hp: $('#hp').val(),
                users_email: $('#email').val(),
                question: $('#question').val(),
            }
        }).done(function (data) {
            if (data.status == 'success') {
                if (uploadFileList.length == 0) {
                    alert('성공하였습니다.'); 
                    location.href='/';
                } else {
                    var formData = new FormData();

                    for (var i=0; i<uploadFileList.length; i++) {
                        formData.append('file[]', fileList[uploadFileList[i]]);
                    }

                    $.ajax({
                        url: '/boards/file-upload/' + data.users_question_id,
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        type: 'POST',
                    }).done(function(data) {
                        if (data.status == 'success') {
                           alert('파일 저장까지 성공하였습니다.'); 
                           location.href='/';
                        } else {
                            console.log(data.status);
                            alert('파일 저장은 실패하였습니다.');
                        }
                    });
                }
            } else {
                alert('실패하였습니다.');
            }
        });
    });
 </script>
