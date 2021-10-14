<div id="container">        
    <div class="contents static">
        <h2 class="s-hty0">고객센터</h2>            
        <div class="cs-tab">
            <ul class="s-tabs2">
                <li><a href="/boards/faqs-by-category">자주 하는 질문</a></li>
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
                            <label class="btn-ty2 bor" for="imgSaveButton">파일선택</label>
                            <input type="file" id="imgSaveButton" name="imgSaveButton" style="display:none"/>
                        </form>
                        <!-- <button type="button" class="btn-ty2 bor">파일선택</button> -->
                    </div>
                </div>
                <div class="add-files">
                    <label for="imgSaveButton"></label>
                    <input type="file" id="imgSaveButton" name="imgSaveButton" multiple="multiple" style="display:none">
                    <p class="tx">마우스로 자료를 끌어오세요</p>
                </div>  
                <div class="agree-wp">
                    <span class="chk-dsg"><input type="radio" name="rdo3" id="rdo3-1"><label for="rdo3-1">개인정보 수집 및 이용 동의</label></span>
                </div>
            </div>    
            <div class="section-btm2 mgtS1">                    
                <button type="submit" id="btn-big" class="btn-big">1:1 문의하기</button>
            </div>
        </div>     
    </div>        
</div>
<footer id="footer"></footer>

<script>
    ui.addOnAction('.board-lists>li');

    // $(function() {
    //     var dropZone = $('#dropZone');

    //     dropZone.on('dragenter', function(e) {
    //         e.stopPropagation();
    //         e.preventDefault();
    //         dropZone.css('background-color', '#E3F2FC');
    //     });

    //     dropZone.on('dragleave', function(e) {
    //         e.stopPropagation();
    //         e.preventDefault();
    //         dropZone.css('background-color', '#FFFFFF');
    //     });

    //     dropZone.on('dragover', function(e) {
    //         e.stopPropagation();
    //         e.preventDefault();
    //         dropZone.css('background-color', '#E3F2FC');
    //     });

    //     dropZone.on('drop', function(e) {
    //         e.preventDefault();
    //         dropZone.css('background-color', '#FFFFFF');

    //         var img = e.originalEvent.dataTransfer.files;
    //         var formData = new FormData();
    //         formData.append('imgSaveButton', img[0]);
    //     });
    // });

    // $('#imgSaveButton').on('change', function() {
    //     var img = document.getDlementById('imgSaveButton').files;
    //     var formData = new FormData();
    //     formData.append('imgSaveButton', img[0]);
    // });

    $('#btn-big').on('click', function() {
        var getHp = RegExp(/^[0-9]*$/);
        var getEmail = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;
        var result = [];
        var faqCategoryId = $('#categories option:selected').val();

        if ($('#hp').val().length < 4) {
            $('#hpNoti').html('전화번호를 제대로 입력해 주세요.');
            $('#hp').focus();
            result.push('false');
        } else {
            $('#hpNoti').html('');
            result.push('true');
        }

        if (!getHp.test($('#hp').val())) {
            $('#hpNoti').html('전화번호를 제대로 입력해 주세요.');
            $('#hp').focus();
            result.push('false');
        } else {
            $('#hpNoti').html('');
            result.push('true');
        }

        if (!getEmail.test($('#email').val())) {
            $('#emailNoti').html('이메일을 제대로 입력해 주세요.');
            $('#email').focus();
            result.push('false');
        } else {
            $('#emailNoti').html('');
            result.push('true');
        }

        if (!result.include('false')) {
            $.ajax({
                url: '/boards/add',
                method: 'POST',
                type: 'json',
                data: {
                    faq_category_id: faqCategoryId,
                    title: $('#title').val(),
                    users_name: $('#name').val(),
                    users_hp: $('#hp').val(),
                    users_email: $('#email').val(),
                    question: $('#question').val(),
                }
            }).done(function (data) {
                if (data.status == 'success') {
                    alert('성공하였습니다.');
                } else {
                    alert('실패하였습니다.');
                }
            });
        }
    });
 </script>
