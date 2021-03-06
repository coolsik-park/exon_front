<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$naver_client_id = getEnv('NAVER_CLIENT_ID');
$naver_redirectURI = urlencode(NAVER_CONNECT_URL);
$_SESSION['state'] = md5(microtime()) . mt_rand();
$state = $_SESSION['state'];
$naver_apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$naver_client_id."&redirect_uri=".$naver_redirectURI."&state=".$state;

$kakao_client_id = getEnv('KAKAO_CLIENT_ID');
$kakao_redirectURI = urlencode(KAKAO_CONNECT_URL);
$kakao_apiURL = "https://kauth.kakao.com/oauth/authorize?response_type=code&client_id=".$kakao_client_id."&redirect_uri=".$kakao_redirectURI
?>

<style>
.col-dd {
    /* pointer-events : none; */
}
.blueBtn {
    display: inline-block;
    padding: 8px 22px;
    border-radius: 3px;
    border: solid 1px #0071BC;
    background-color: #FFFFFF;
    font-size: 1rem;
    font-weight: 500;
    line-height: 1.5;
    color: #0071BC;
    text-align: center;
}
#emailText {
    width: 100%;
}
.emailBtn {
    width: 135px;
}

@media  screen and (min-width: 768px) {
    #delete {
        position: absolute;
        top: 100px;
        right: 10px;
    }
    .contents.static {
        position: relative;
    }
}
@media  screen and (max-width: 768px) {
    .emailBtn {
        width: 100%;
    }
}
@media  screen and (min-width: 1024px) {
    .profile-photo .photo img {
        width: 200px;
        height: 200px;
    }
    #imgUpload {
        margin-left: 66px;
    }
    .profile-photo .btns .btn-ty3 {
        width: 200%;
    }
    
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<div id="container">
    <div class="contents static">
        <h2 class="s-hty">??????????????????</h2>
        <div class="section3">
            <h3 class="s-hty1 fir">?????? ??????</h3>
            <div class="mbr-form">
                <div class="item-row">
                    <div class="col-dt"><em>*</em>????????? (?????????)</div>
                    <?php if ($user->email_cert != 1): ?>
                        <div class="col-dd col-cell">
                            <div class="col-cell-wp">
                                <input type="text" id="emailText" readonly="readonly" class="full" value="<?= $user->email ?>" title="????????? (?????????)">
                            </div>
                            <button type="button" class="btn-ty3 md emailBtn" data-toggle="modal" data-target="#emailModal">????????? ??????</button>
                        </div>
                        <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content" style="background-color:transparent; border:none;">
                                    <div class="popup-wrap">
                                        <div class="popup-head">
                                            <h4>????????? ??????</h4>
                                            <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">????????????</button>
                                        </div>
                                        <div class="popup-body">
                                            <div class="cert-sect1">
                                                <input id="email" type="text" placeholder="?????????" autocomplete="off" value="<?= $user->email ?>">
                                                <button id="emailSend" type="button" class="btn-ty2 btn-m-bor">???????????? ??????</button>
                                            </div>
                                            <p id="emailNoti" class="noti hc1"></p>
                                            <div class="cert-sect2">
                                                <div class="label-wp">
                                                    <label for="emailCode">????????????</label><input type="text" id="emailCode" placeholder="????????????" autocomplete="off">
                                                </div> 
                                                <button id="eamilResend" type="button" class="btn-ty2 gray">?????????</button>
                                            </div>
                                            <p id="emailCodeNoti" class="noti hc1"></p>
                                            <div class="popup-btm alone">
                                                <button id="emailConfirm" type="button" class="btn-ty2">??????</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-dd col-cell">
                            <div class="col-cell-wp">
                                <input type="text" id="emailText" readonly="readonly" class="full" value="<?= $user->email ?>" title="????????? (?????????)">
                            </div>
                            <button type="button" class="blueBtn md emailBtn" data-toggle="modal" style='cursor:default;'>?????? ??????</button>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="item-row">
                    <div class="col-dt"><em>*</em>????????????</div>                      
                    <div class="col-dd">
                        <input type="password"  id="password" class="full" title="????????????">
                        <p id="lengthNoti" class="noti hc1"></p>
                    </div>
                </div>  
                <div class="item-row">
                    <div class="col-dt"><em>*</em>???????????? ??????</div>
                    <div class="col-dd">
                        <input type="password"  id="passwordRe" class="full" title="???????????? ??????">
                        <p id="ReNoti" class="noti hc1"></p>
                    </div>
                </div>
                <div class="item-row">
                  <div class="col-dt"><em>*</em>??????</div>                    
                  <div class="col-dd">
                      <input type="text" id="name" class="full" value="<?= $user->name ?>" title="??????">
                      <p id="nameNoti" class="noti hc1"></p>
                  </div>
                </div>    
                <div class="item-row" id="hp-row">
                    <div class="col-dt">???????????? ??????</div>    
                        <?php if ($user->hp_cert == 0): ?>                
                            <div class="col-dd col-cell">
                            <div class="col-cell-wp">
                                <select id="cellNumber">
                                    <option value="010">010</option>
                                </select>
                                <input type="text" id="cellNumber2" value="<?= substr($user->hp, 3) ?>" placeholder="- ?????? ????????? ?????????" title="???????????? ??????">
                            </div>
                            <button type="button" class="btn-ty3 md" data-toggle="modal" id="smsButton" data-target="#smsModal">
                                ???????????? ??????
                            </button>
                            <div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="background-color:transparent; border:none;">
                                        <div class="popup-wrap">
                                            <div class="popup-head">
                                                <h4>????????? ??????</h4>
                                                <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">????????????</button>
                                            </div>
                                            <div class="popup-body"> 
                                                <div class="cert-sect1">
                                                    <input id="sms" type="text" placeholder="????????????">
                                                    <button id="smsSend" type="button" class="btn-ty2 btn-m-bor">???????????? ??????</button>
                                                </div>        
                                                <p id="smsNoti" class="noti hc1"></p>
                                                <div class="cert-sect2">
                                                    <div class="label-wp">
                                                        <label for="smsCode">????????????</label><input type="text" id="smsCode" placeholder="????????????">
                                                    </div> 
                                                    <button id="smsResend" type="button" class="btn-ty2 gray">?????????</button>
                                                </div>
                                                <p id="smsCodeNoti" class="noti hc1"></p>
                                                <div class="popup-btm alone">
                                                    <button id="smsConfirm" type="button" class="btn-ty2">??????</button>
                                                </div>        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>                    
                            <div class="col-dd col-cell">
                                <div class="col-cell-wp" style="width: 100%;">
                                    <select id="cellNumber">
                                        <option value="010">010</option>
                                    </select>
                                    <input type="text" id="cellNumber2" value="<?= substr($user->hp, 3) ?>" placeholder="- ?????? ????????? ?????????" title="???????????? ??????">
                                </div>
                        <?php endif; ?>
                    </div>
                  <p id="hpNoti" class="noti hc1"></p>
                </div>
            </div>
        </div>
        <div class="section4">
            <h3 class="s-hty1">?????? ??????</h3>
            <div class="log-other">
                <label class="chk-box">
                    <input id="kakao-connect" type="radio" name="logOther">
                    <span class="btn-kakao"><span>KaKao ????????????</span></span>
                </label>
                <label class="chk-box">
                    <input id="naver-connect" type="radio" name="logOther">
                    <span class="btn-naver"><span>NAVER ????????????</span></span>
                </label>
            </div>
            <div class="mbr-form mgtS1">
                <div class="item-row" id="image-row">
                    <div class="col-dt">????????? ??????</div>     
                    <div class="col-dd">
                        <div class="profile-photo">
                            <?php if ($user->image_name == null) { ?>
                                    <div class="mouse-area" id="dropZone">
                                        <!-- <label for="imgSaveButton"><span class="ico-plus-c">+</span></label>
                                        <input type="file" id="imgSaveButton" name="imgSaveButton" accept="image/*" style="display:none"> -->
                                        <p>???????????? ????????? ???????????????</p>
                                    </div>
                            <?php } else { ?>
                                    <div class="photo">
                                        <img src="/<?= $user->image_path ?>/<?= $user->image_name ?>">
                                    </div>
                            <?php } ?>
                            <div class="btns">
                                <form name="imgUpload" id="imgUpload">
                                    <label class="btn-ty3" for="imgSaveButton">????????????</label>
                                    <input type="file" id="imgSaveButton" name="imgSaveButton" accept="image/*" style="display:none"/>
                                    <?php if ($user->image_name != null) { ?>
                                        <button type="button" class="btn-ty3 bor" id="imgDeleteButton">??????</button>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item-row">
                  <div class="col-dt">????????????</div>
                  <div class="col-dd">
                        <div class="birth-wp" id="ymd">
                            <select class="yy" id="yy"></select>
                            <span>???</span>
                            <select class="mm" id="mm"></select>
                            <span>???</span>
                            <select class="dd" id="dd"></select>
                            <span>???</span>
                        </div>                            
                  </div>
                </div>
                <div class="item-row">
                    <div class="col-dt">??????</div>
                    <div class="col-dd">
                         <select class="gender" id="gender">
                            <?php
                              if ($user->sex == "F" || $user->sex == null) {
                            ?>
                                <option value="M">??????</option>
                                <option value="F" selected="selected">??????</option>
                            <?php
                              } else {
                            ?>
                                <option value="M" selected="selected">??????</option>
                                <option value="F">??????</option>
                            <?php
                              }
                            ?>
                         </select>              
                    </div>
                </div>
                <div class="item-row">
                    <div class="col-dt">??????/??????</div>
                    <div class="col-dd">
                        <div class="belong">
                            <input type="text" id="company" value="<?= $user->company ?>" title="??????">
                            <input type="text" id="title" value="<?= $user->title ?>" title="??????">
                        </div>                   
                    </div>
                </div>
                <div class="item-row">
                    <button type="button" class="btn-ty3 bor md" id="delete">?????? ??????</button>
                </div>
            </div>
        </div>
        <div class="section-btm2 mgtS1">
            <a href="javascript:history.back();" id="backButton" class="btn-big bor">??????</a>
            <a href="#" id="saveButton" class="btn-big" style="cursor:pointer;">??????</a>
        </div>
    </div>
</div>

<script>
    //????????????
    $(document).on("click", "#delete", function () {
        if (confirm("?????? ????????? ???????????? ?????? ??? ?????? ????????? ?????? ???????????????.\n?????????????????????????")) {
            jQuery.ajax({
                url: "/users/delete/<?=$user->id?>", 
                method: 'DELETE',
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("??????????????? ?????????????????????.");
                    window.location.replace("/users/logout");
                } else if(data.status == 'fail') {
                    alert("????????? ?????????????????????. ?????? ????????? ?????????.");
                } else {
                    alert("????????? ????????? ?????? ?????? ??????????????? ??? ??? ????????????.\n?????? ?????? ??? ?????? ??????????????????.");
                }
            });
        }
    });

    $(document).on("change", "#email", function () {
        $("#emailNoti").html("");
    });

    $(document).on("change", "#emailCode", function () {
        $("#emailCodeNoti").html("");
    });
    
    $("#emailSend").click(function () {
        if ($("#email").val() == "") {
            $("#emailNoti").html("???????????? ????????? ?????????.");
            $("#email").focus();
            return false;
        }

        jQuery.ajax({
            url: "/users/send-email-certification", 
            method: 'POST',
            type: 'json',
            data: {
                email: $("#email").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("??????????????? ?????????????????????.");
                last_id = data.id;
                $("#emailSend").html("<span id='timer'></span>");
                $("#emailSend").attr("disabled", "disabled");

                var AuthTimer = new $ComTimer()
                AuthTimer.comSecond = 180;
                AuthTimer.fnCallback = function(){alert("??????????????? ??????????????????.")}
                AuthTimer.timer =  setInterval(function(){AuthTimer.fnTimer()},1000);
                AuthTimer.domId = document.getElementById("timer");
            } else {
                alert("????????? ?????????????????????. ?????? ????????? ?????????.");
            }
        });
    });

    $("#emailResend").click(function () {
        if ($("#email").val() == "") {
            $("#emailNoti").html("???????????? ????????? ?????????.");
            $("#email").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/send-email-certification", 
            method: 'POST',
            type: 'json',
            data: {
                email: $("#email").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("??????????????? ?????????????????????.");
                last_id = data.id;

                $("#emailSend").html("<span id='timer'></span>");
                $("#emailSend").attr("disabled", "disabled");

                var AuthTimer = new $ComTimer()
                AuthTimer.comSecond = 180;
                AuthTimer.fnCallback = function(){alert("??????????????? ??????????????????.")}
                AuthTimer.timer =  setInterval(function(){AuthTimer.fnTimer()},1000);
                AuthTimer.domId = document.getElementById("timer");
            } else {
                alert("????????? ?????????????????????. ?????? ????????? ?????????.");
            }
        });
    });

    $("#emailConfirm").click(function () {
        var user_id = '<?=$user->id?>';

        if ($("#emailCode").val() == "") {
            $("#emailCodeNoti").html("??????????????? ????????? ?????????.");
            $("#emailCode").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/confirm-email/" + last_id, 
            method: 'POST',
            type: 'json',
            data: {
                code: $("#emailCode").val(),
                user_id: user_id,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("????????? ?????????????????????.");
                window.location.replace("/");
            } else if (data.status == 'fail') {
                alert("??????????????? ?????? ??????????????????.");
                $("#emailCode").val("");
            } else {
                alert("????????? ?????????????????????. ????????? ????????????.");
                $("#emailCode").val("");
            }
        });
    });

    last_id = 0;

    $(document).on("change", "#sms", function() {
        $("#smsNoti").html("");
    });

    $(document).on("change", "#smsCode", function () {
        $("#smsCodeNoti").html("");
    });

    $(document).on("click", "#smsButton", function () {
        $("#sms").attr('value', $("#cellNumber").val()+$("#cellNumber2").val());
    });

    $(document).on('click', "#smsSend", function () {
        if ($("#sms").val() == "") {
            $("#smsNoti").html("??????????????? ????????? ?????????.");
            $("#sms").focus();
            return false;
        }

        jQuery.ajax({
            url: "/users/send-sms-certification", 
            method: 'POST',
            type: 'json',
            data: {
                hp: $("#sms").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("??????????????? ?????????????????????.");
                last_id = data.id;
                $("#smsSend").html("<span id='timer'></span>");
                $("#smsSend").attr("disabled", "disabled");

                var AuthTimer = new $ComTimer()
                AuthTimer.comSecond = 180;
                AuthTimer.fnCallback = function(){alert("??????????????? ??????????????????.")}
                AuthTimer.timer =  setInterval(function(){AuthTimer.fnTimer()},1000);
                AuthTimer.domId = document.getElementById("timer");
            } else {
                alert("????????? ?????????????????????. ?????? ????????? ?????????.");
            }
        });
    });

    $("#reSend").click(function () {
        if ($("#sms").val() == "") {
            $("#smsNoti").html("??????????????? ????????? ?????????.");
            $("#sms").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/send-sms-certification", 
            method: 'POST',
            type: 'json',
            data: {
                hp: $("#sms").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("??????????????? ????????????????????????.");
                last_id = data.id;

                $("#smsSend").html("<span id='timer'></span>");
                $("#smsSend").attr("disabled", "disabled");

                var AuthTimer = new $ComTimer()
                AuthTimer.comSecond = 180;
                AuthTimer.fnCallback = function(){alert("??????????????? ??????????????????.")}
                AuthTimer.timer =  setInterval(function(){AuthTimer.fnTimer()},1000);
                AuthTimer.domId = document.getElementById("timer");
            } else {
                alert("????????? ?????????????????????. ?????? ????????? ?????????.");
            }
        });
    });

    // $("#smsConfirm").click(function () {
    $(document).on('click', "#smsConfirm", function () {
        console.log("aaaaa");
        var user_id = '<?=$user->id?>';

        if ($("#smsCode").val() == "") {
            $("#smsCodeNoti").html("??????????????? ????????? ?????????.");
            $("#smsCode").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/confirm-sms/" + last_id, 
            method: 'POST',
            type: 'json',
            data: {
                code: $("#smsCode").val(),
                user_id: user_id,
                hp: $("#cellNumber").val()+$("#cellNumber2").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("????????? ?????????????????????.");
                // $('#hp-row').load(location.href+" #hp-row");
                $('#smsModal').modal('hide');
            } else if (data.status == 'fail') {
                alert("??????????????? ?????? ??????????????????.");
                $("#smsCode").val("");
            } else {
                alert("????????? ?????????????????????. ????????? ????????????.");
                $("#smsCode").val("");
            }
        });
    });

    function $ComTimer(){
    //prototype extend
    }

    $ComTimer.prototype = {
        comSecond : ""
        , fnCallback : function(){}
        , timer : ""
        , domId : ""
        , fnTimer : function(){
            var m = Math.floor(this.comSecond / 60) + "??? " + (this.comSecond % 60) + "???";	// ?????? ?????? ??????
            this.comSecond--;					// 1?????? ??????
            this.domId.innerText = m;
            if (this.comSecond < 0) {			// ????????? ?????? ????????????..
                clearInterval(this.timer);		// ????????? ??????
                alert("??????????????? ?????????????????????. ?????? ?????????????????? ????????????.")
            }
        }
        ,fnStop : function(){
            clearInterval(this.timer);
        }
    }

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

            var img = e.originalEvent.dataTransfer.files;

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
                        alert("?????????????????????.");
                    }
                });
            } else {
                alert('????????? ???????????????.');
            }
        });
    });

    $(document).on('change', '#imgSaveButton', function() {
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
                    alert("?????????????????????.");
                }
            });
        } else {
            alert("?????????????????????.");
        }
    });

    $(document).on('click', '#imgDeleteButton', function() {
        var id = <?= $user->id ?>;
        
        if (confirm("????????? ?????????????????????????")) {
            $.ajax({
                url: '/users/img-delete/<?= $user->id ?>',
                method: 'POST',
                type: 'json',
            }).done(function(data) {
                if (data.status == 'success') {
                    $('#image-row').load(location.href+" #image-row");
                } else {
                    alert("?????????????????????.");
                }
            });
        } else {
            alert("?????????????????????.");
        }
    });

    $(document).ready(function() {
        var dt = new Date();
        var com_year = dt.getFullYear();

        for (var y=(com_year-100); y<=(com_year); y++) {
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
        var getName = RegExp(/^[???-???]+$/);
        var getHp = RegExp(/^[0-9]*$/);

        if ($('#password').val().length < 8) {
            $('#lengthNoti').html("??????????????? 8??? ???????????? ????????? ?????????.");
            $('#password').focus();
            return false;
        } else {
            $('#lengthNoti').html('');
        }
        
        if ($('#password').val() != $('#passwordRe').val()) {
            $('#ReNoti').html('??????????????? ????????????.\n?????? ????????? ?????????.');
            $('#passwordRe').focus();
            return false;
        } else {
            $('#ReNoti').html('');
        }

        if ($('#name').val() == '') {
            $('#nameNoti').html('????????? ????????? ?????????.');
            $('#name').focus();
            return false;
        } else {
            $('#nameNoti').html('');
        }

        if ($('#cellNumber2').val().length < 4) {
            $('#hpNoti').html('??????????????? ?????? ?????? ????????? ?????????.');
            $('#cellNumber').focus();
            return false;
        } else {
            $('#hpNoti').html('');
        }

        if (!getHp.test($('#cellNumber2').val())) {
            $('#hpNoti').html('??????????????? ?????? ?????? ????????? ?????????.');
            $('#cellNumber').focus();
            return false;
        } else {
            $('#hpNoti').html('');
        }

        $.ajax({
            url: '/users/edit/<?= $user->id ?>',
            method: 'POST',
            type: 'json',
            data: {
                password: $('#password').val(),
                name: $('#name').val(),
                hp: $("#cellNumber").val()+$("#cellNumber2").val(),
                birthday: $('#yy').val() + "-" + $('#mm').val() + "-" + $('#dd').val(),
                sex: $('#gender').val(),
                company: $('#company').val(),
                title: $('#title').val(),
            }
        }).done(function (data) {
            if (data.status == 'success') {
                alert("?????????????????????.");
                location.replace('https://exon.live/');
            } else {
                alert("???????????? ???????????????.");
            }
        });
    });

    //?????? ?????? ??? ??????
    $(document).ready(function () {
        var msg = "<?=$msg?>";
        var refer = "<?=$user->refer?>";

        if (msg != '') {
            alert(msg);
        }

        if (refer == 'naver') {
            $("#naver-connect").prop("checked", "checked");
            $("#naver-connect").prop("disabled", "disabled");
            $("#kakao-connect").prop("disabled", "disabled");
        }

        if (refer == 'kakao') {
            $("#kakao-connect").prop("checked", "checked");
            $("#naver-connect").prop("disabled", "disabled");
            $("#kakao-connect").prop("disabled", "disabled");
        }
    });

    //????????? ??????
    $("#naver-connect").click(function () {
        <?php $this->request->getSession()->write('user_id', $user->id) ?>

        var url = "<?=$naver_apiURL?>";
        window.location.replace(url);
    });

    //????????? ??????
    $("#kakao-connect").click(function () {
        <?php $this->request->getSession()->write('user_id', $user->id) ?>

        var url = "<?=$kakao_apiURL?>";
        window.location.replace(url);
    });
</script>