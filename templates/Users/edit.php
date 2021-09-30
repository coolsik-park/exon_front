<div id="container">
    <div class="contents static">
        <h2 class="s-hty">회원정보수정</h2>
        <div class="section3">
            <h3 class="s-hty1 fir">기본 정보</h3>
            <div class="mbr-form">
                <div class="item-row">
                  <div class="col-dt"><em>*</em>이메일 (아이디)</div>
                  <div class="col-dd">
                      <input type="text" readonly="readonly" class="full" value="<?= $user->email ?>" title="이메일 (아이디)">
                  </div>
                </div>
                <div class="item-row">
                    <div class="col-dt"><em>*</em>비밀번호</div>                      
                    <div class="col-dd">
                        <input type="password"  id="password" class="full" title="비밀번호">
                        <p id="lengthNoti" class="noti hc1"></p>
                    </div>
                </div>  
                <div class="item-row">
                    <div class="col-dt"><em>*</em>비밀번호 확인</div>
                    <div class="col-dd">
                        <input type="password"  id="passwordRe" class="full" title="비밀번호 확인">
                        <p id="ReNoti" class="noti hc1"></p>
                    </div>
                </div>
                <div class="item-row">
                  <div class="col-dt"><em>*</em>이름</div>                    
                  <div class="col-dd">
                      <input type="text" id="name" class="full" value="<?= $user->name ?>" title="이름">
                      <p id="nameNoti" class="noti hc1"></p>
                  </div>
                </div>    
                <div class="item-row" id="hp-row">
                  <?php
                    if ($user->hp_cert == 0) {
                  ?>
                        <div class="col-dt">휴대전화 번호</div>                    
                            <div class="col-dd col-cell">
                            <div class="col-cell-wp">
                                <select id="cellNumber">
                                    <option value="010">010</option>
                                </select>
                                <input type="text" id="cellNumber2" value="<?= substr($user->hp, 3) ?>" placeholder="'-' 없이 입력해 주세요" title="휴대전화 번호">
                            </div>
                            <button type="button" class="btn-ty3 md" id="hpCertifiedButton">휴대전화 인증</button>
                        </div>
                  <?php
                    } else {
                  ?>
                        <div class="col-dt">휴대전화 번호</div>                    
                          <div class="col-dd col-cell">
                          <div class="col-cell-wp">
                              <select id="cellNumber">
                                  <option value="010">010</option>
                              </select>
                              <input type="text" id="cellNumber2" value="<?= substr($user->hp, 3) ?>" placeholder="'-' 없이 입력해 주세요" title="휴대전화 번호">
                          </div>
                          <button type="button" class="btn-ty3 bor md" id="hpSaveButton">휴대전화 변경</button>
                        </div>
                  <?php
                    }
                  ?>
                  <p id="hpNoti" class="noti hc1"></p>
                </div>                    
            </div>
        </div>
        <div class="section4">
            <h3 class="s-hty1">부가 정보</h3>
            <div class="log-other">
                <label class="chk-box">
                    <input type="radio" name="logOther">
                    <span class="btn-kakao"><span>KaKao 연동하기</span></span>
                </label>
                <label class="chk-box">
                    <input type="radio" name="logOther">
                    <span class="btn-naver"><span>NAVER 연동하기</span></span>
                </label>
            </div>
            <div class="mbr-form mgtS1">
                <div class="item-row" id="image-row">
                    <div class="col-dt">프로필 사진</div>     
                    <div class="col-dd">
                        <div class="profile-photo">
                            <div class="photo">
                                <img src="/<?= $user->image_path ?>/<?= $user->image_name ?>" alt="이미지없음">
                            </div>
                            <div class="btns">
                                <form name="imgUpload" id="imgUpload">
                                    <label class="btn-ty3" for="imgSaveButton">불러오기</label>
                                    <input type="file" id="imgSaveButton" name="imgSaveButton" accept="image/*" style="display:none"/>
                                    <?php
                                    if ($user->image_name != null) {
                                    ?>
                                        <button type="button" class="btn-ty3 bor" id="imgDeleteButton">삭제</button>
                                    <?php
                                    }
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item-row">
                  <div class="col-dt">생년월일</div>
                  <div class="col-dd">
                        <div class="birth-wp" id="ymd">
                            <select class="yy" id="yy"></select>
                            <span>년</span>
                            <select class="mm" id="mm"></select>
                            <span>월</span>
                            <select class="dd" id="dd"></select>
                            <span>일</span>
                        </div>                            
                  </div>
                </div>
                <div class="item-row">
                    <div class="col-dt">성별</div>
                    <div class="col-dd">
                         <select class="gender" id="gender">
                            <?php
                              if ($user->sex == "F" || $user->sex == null) {
                            ?>
                                <option value="M">남성</option>
                                <option value="F" selected="selected">여성</option>
                            <?php
                              } else {
                            ?>
                                <option value="M" selected="selected">남성</option>
                                <option value="F">여성</option>
                            <?php
                              }
                            ?>
                         </select>              
                    </div>
                </div>
                <div class="item-row">
                    <div class="col-dt">소속/직함</div>
                    <div class="col-dd">
                        <div class="belong">
                            <input type="text" id="company" value="<?= $user->company ?>" title="소속">
                            <input type="text" id="title" value="<?= $user->title ?>" title="직함">
                        </div>                   
                    </div>
                </div>
            </div>
        </div>
        <div class="section-btm2 mgtS1">
            <a href="#" id="backButton" class="btn-big bor">취소</a>
            <a href="#" id="saveButton" class="btn-big" style="cursor:pointer;">저장</a>
        </div>
    </div>
</div>
<footer id="footer"></footer>

<script>
    $('#hpSaveButton').on('click', function() {
        var getHp = RegExp(/^[0-9]*$/);
        var result = [];

        if ($('#cellNumber2').val().length < 4) {
            $('#hpNoti').html('전화번호를 제대로 입력해 주세요.');
            $('#celNumber2').focus();
            result.push('false');
        } else {
            $('#hpNoti').html('');
            result.push('true');
        }

        if (!getHp.test($('#cellNumber2').val())) {
            $('#hpNoti').html('전화번호를 제대로 입력해 주세요.');
            $('#celNumber2').focus();
            result.push('false');
        } else {
            $('#hpNoti').html('');
            result.push('true');
        }

        if (!result.includes('false')) {
            $.ajax({
                url: '/users/hpUpdate/<?= $user->id ?>',
                method: 'POST',
                type: 'json',
                data: {
                    hp: $('#cellNumber').val() + $('#cellNumber2').val(),
                }
            }).done(function (data) {
                if (data.status == 'success') {
                    $('#hp-row').load(location.href+" #hp-row");
                } else {
                    alert("성공되지 않았습니다.");
                }
            });
        }
    });

    $('#hpCertifiedButton').on('click', function() {
        var getHp = RegExp(/^[0-9]*$/);
        var result = [];

        if ($('#cellNumber2').val().length < 4) {
            $('#hpNoti').html('전화번호를 제대로 입력해 주세요.');
            $('#celNumber2').focus();
            result.push('false');
        } else {
            $('#hpNoti').html('');
            result.push('true');
        }

        if (!getHp.test($('#cellNumber2').val())) {
            $('#hpNoti').html('전화번호를 제대로 입력해 주세요.');
            $('#celNumber2').focus();
            result.push('false');
        } else {
            $('#hpNoti').html('');
            result.push('true');
        }

        if (!result.includes('false')) {
            $.ajax({
                url: '/users/hpUpdate/<?= $user->id ?>',
                method: 'POST',
                type: 'json',
                data: {
                    hp: $('#cellNumber').val() + $('#cellNumber2').val(),
                }
            }).done(function (data) {
                if (data.status == 'success') {
                    popup = window.open('/users/sendSmsCertified/' + <?= $user->id ?>, '휴대전화 인증', 'width=800px,height=500px,left=800px,top=300px');
                    window.setInterval(function() {
                        try {
                            if (popup == null || popup.closed) {
                                $('#hp-row').load(location.href+" #hp-row");
                                return false;
                            }
                        } catch (e) {}
                    }, 500);
                } else {
                    alert("성공되지 않았습니다.");
                }
            });
        }
    });

    $('#imgSaveButton').on('change', function() {
        var existence = '<?= $user->image_name ?>';

        if (existence != null) {
            $.ajax({
                url: '/users/img-delete/<?= $user->id ?>',
                method: 'POST',
                type: 'json',
            });
        }

        var img = document.getElementById('imgSaveButton').files;

        if (img.length == 1) {
            var formData = new FormData();
            formData.append('imgSaveButton', img[0]);

            $.ajax({
                url: '/users/img-update/<?= $user->id ?>',
                processData: false,
                contentType: false,
                cache: false,
                method: 'POST',
                data: formData,
            }).done(function(data) {
                if (data.status == 'success') {
                    $('#image-row').load(location.href+" #image-row");
                } else {
                    alert("실패하였습니다.");
                }
            });
        } else {
            alert("취소하였습니다.");
        }
    });

    $('#imgDeleteButton').on('click', function() {
        var id = <?= $user->id ?>;
        
        if (confirm("사진을 삭제하시겠습니까?")) {
            $.ajax({
                url: '/users/img-delete/<?= $user->id ?>',
                method: 'POST',
                type: 'json',
            }).done(function(data) {
                if (data.status == 'success') {
                    $('#image-row').load(location.href+" #image-row");
                } else {
                    alert("실패하였습니다.");
                }
            });
        } else {
            alert("취소되었습니다.");
        }
    });

    $(document).ready(function() {
        var dt = new Date();
        var com_year = dt.getFullYear();

        for (var y=(com_year-50); y<=(com_year+5); y++) {
            if (y == <?= date("Y", strtotime($user->birthday)) ?>) {
                $('#yy').append('<option value='+y+' selected="selected">'+y+'</option>');
            } else {
                $('#yy').append('<option value='+y+'>'+y+'</option>');
            }
        }

        for (var m=1; m<=12; m++) {
            if (m == <?= date("m", strtotime($user->birthday)) ?>) {
                $('#mm').append('<option value='+m+' selected="selected">'+m+'</option>');
            } else {
                $('#mm').append('<option value='+m+'>'+m+'</option>');
            }
        }

        for (var d=1; d<=31; d++) {
            if (d == <?= date("d", strtotime($user->birthday)) ?>) {
                $('#dd').append('<option value='+d+' selected="selected">'+d+'</option>');
            } else {
                $('#dd').append('<option value='+d+'>'+d+'</option>');
            }
        }
    });
    
    $('#saveButton').on('click', function() {
        var getName = RegExp(/^[가-힣]+$/);
        var result = [];

        if ($('#password').val().length < 8) {
            $('#lengthNoti').html("비밀번호는 8자 이상으로 입력해 주세요.");
            $('#password').focus();
            result.push('false');
        } else {
            $('#lengthNoti').html('');
            result.push('true');
        }
        
        if ($('#password').val() != $('#passwordRe').val()) {
            $('#ReNoti').html('비밀번호가 다릅니다. 다시 입력해 주세요.');
            $('passwordRe').focus();
            result.push('false');
        } else {
            $('#ReNoti').html('');
            result.push('true');
        }

        if ($('#name').val() == '') {
            $('#nameNoti').html('이름을 입력해 주세요.');
            $('#name').focus();
            result.push('false');
        } else {
            $('#nameNoti').html('');
            result.push('true');
        }
        
        if (!getName.test($("#name").val())) {
            $('#nameNoti').html('이름을 올바르게 입력해 주세요.');
            $('#name').focus();
            result.push('false');
        } else {
            $('#nameNoti').html('');
            result.push('true');
        }

        if (!result.includes('false')) {
            $.ajax({
                url: '/users/edit/<?= $user->id ?>',
                method: 'POST',
                type: 'json',
                data: {
                    password: $('#password').val(),
                    name: $('#name').val(),
                    birthday: $('#yy').val() + "-" + $('#mm').val() + "-" + $('#dd').val(),
                    sex: $('#gender').val(),
                    company: $('#company').val(),
                    title: $('#title').val(),
                }
            }).done(function (data) {
                if (data.status == 'success') {
                    window.location.reload();
                } else {
                    alert("성공되지 않았습니다.");
                }
            });
        }
    });
</script>