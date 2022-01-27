<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$naver_client_id = getEnv('NAVER_CLIENT_ID');
$naver_redirectURI = urlencode(NAVER_JOIN_URL);
$_SESSION['state'] = md5(microtime()) . mt_rand();
$state = $_SESSION['state'];
$naver_apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$naver_client_id."&redirect_uri=".$naver_redirectURI."&state=".$state;

$kakao_client_id = getEnv('KAKAO_CLIENT_ID');
$kakao_redirectURI = urlencode(KAKAO_JOIN_URL);
$kakao_apiURL = "https://kauth.kakao.com/oauth/authorize?response_type=code&client_id=".$kakao_client_id."&redirect_uri=".$kakao_redirectURI
?>

<div id="container">
    <div class="log-wrap">
        <div class="log-step-wrap">
            <h1><a href="/" class="h-logo">EXON</a></h1>
            <div class="log-step-page log-step-02">
                <h2 class="h-ty2 fir">간편 회원가입</h2>
                <div class="log-other">
                    <a href="<?php echo $kakao_apiURL ?>" class="btn-kakao"><span>KAKAO 연동하기</span></a>
                    <a href="<?php echo $naver_apiURL ?>" class="btn-naver"><span>NAVER 연동하기</span></a>
                </div>
                <div class="div-or"></div>
                <h2 class="h-ty2">회원가입</h2>
                <div class="mbr-form">
                    <div class="item-row">
                        <div class="col-dt"><em class="st">*</em>이메일 (아이디)</div>
                        <div class="col-dd">
                            <div class="col-email-wp">
                                <input type="text" id="email" placeholder="이메일" title="이메일 (아이디)" autocomplete="off" readonly onclick="$(this).attr('readonly', false)" onfocus="$(this).attr('readonly', false)" onblur="$(this).attr('readonly', true)">
                                <span class="sp">@</span>
                                <input type="text" id="emailTail" list="list" onmousedown="value = '';" autocomplete="off" readonly onclick="$(this).attr('readonly', false)" onfocus="$(this).attr('readonly', false)" onblur="$(this).attr('readonly', true)">
                                <datalist id="list">
                                    <option value="naver.com" label="네이버">
                                    <option value="gmail.com" label="구글">
                                    <option value="daum.net" label="다음">
                                </datalist>
                            </div>
                            <p id="emailNoti" class="noti hc1"></p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="col-dt"><em class="st">*</em>비밀번호</div>
                        <div class="col-dd">
                            <input type="password" id="password" placeholder="최소 8자 이상" class="full" title="비밀번호" autocomplete="off" readonly onclick="$(this).attr('readonly', false)" onfocus="$(this).attr('readonly', false)" onblur="$(this).attr('readonly', true)">
                            <p id="lengthNoti" class="noti hc1"></p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="col-dt"><em class="st">*</em>비밀번호 확인</div>
                        <div class="col-dd">
                            <input type="password" id="confirm" placeholder="최소 8자 이상" class="full" title="비밀번호 확인" autocomplete="off" readonly onclick="$(this).attr('readonly', false)" onfocus="$(this).attr('readonly', false)" onblur="$(this).attr('readonly', true)">
                            <p id="confirmNoti" class="noti hc1"></p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="col-dt"><em class="st">*</em>이름</div>
                        <div class="col-dd">
                            <input type="text" id="name" placeholder="최소 2자 이상" class="full" title="이름" autocomplete="off" readonly onclick="$(this).attr('readonly', false)" onfocus="$(this).attr('readonly', false)" onblur="$(this).attr('readonly', true)">
                            <p id="nameNoti" class="noti hc1"></p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="col-dt">휴대전화 번호</div>
                        <div class="col-dd">
                            <div class="col-cell-wp">
                                <select id="cellNumber">
                                    <option value="010">010</option>
                                </select>
                                <input type="text" id="cellNumber2" placeholder="'-' 없이 입력해 주세요" title="휴대전화 번호" autocomplete="off" readonly onclick="$(this).attr('readonly', false)" onfocus="$(this).attr('readonly', false)" onblur="$(this).attr('readonly', true)">
                            </div>
                            <p id="cellNoti" class="noti hc1"></p>
                        </div>
                    </div>
                </div>
                <h2 class="h-ty2">이용약관 / 개인정보 수집 및 이용 동의</h2>
                <div class="agree-wp">
                    <div>
                        <span class="chk-dsg"><input type="checkbox" id="agree1"><label for="agree1">전체동의</label></span>
                    </div>
                    <div>
                        <span class="chk-dsg"><input type="checkbox" id="agree2"><label for="agree2">(필수)
                                이용약관</label></span><a href="/pages/terms-of-service" target="_blank" class="btn-ss">약관보기</a>
                    </div>
                    <div>
                        <span class="chk-dsg"><input type="checkbox" id="agree3"><label for="agree3">(필수) 개인정보 수집 및 이용
                                동의</label></span><a href="/pages/personal-info-agreement" target="_blank" class="btn-ss">약관보기</a>
                    </div>
                    <div>
                        <span class="chk-dsg"><input type="checkbox" id="agree4"><label for="agree4">(선택) 이메일
                                수신</label></span>
                        <p class="noti">단, 행사와 관련된 정보는 수신 동의 여부 관계없이 발송됩니다.</p>
                    </div>
                </div>
                <div class="btn-btm">
                    <a href="#" class="btn-big" style="cursor:pointer;">가입완료</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var msg = "<?=$msg?>";

        if (msg != '') {
            alert(msg);
        }
    });

    //전체동의
    $("#agree1").click(function () {
        if ($("#agree1").prop("checked")) {
            $("#agree2").prop("checked", true);
            $("#agree3").prop("checked", true);
            $("#agree4").prop("checked", true);
        } else {
            $("#agree2").prop("checked", false);
            $("#agree3").prop("checked", false);
            $("#agree4").prop("checked", false);
        }
    });

    $("#agree2").click(function () {
        $("#agree1").prop("checked", false);
    });

    $("#agree3").click(function () {
        $("#agree1").prop("checked", false);
    });

    $("#agree4").click(function () {
        $("#agree1").prop("checked", false);
    });

    $(document).on("change", function () {
        if ($("#agree2").prop("checked") && $("#agree3").prop("checked") && $("#agree4").prop("checked")) {
            $("#agree1").prop("checked", true);
        }
    });
    
    $(".btn-big").click(function () {
        var getMail = RegExp(/^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/);
        var getCheck = RegExp(/^[a-zA-Z0-9]{4,12}$/);
        var getName = RegExp(/^[가-힣]+$/);
        var result = [];

        if ($("#email").val() == "") {
            $("#emailNoti").html("이메일 주소를 입력해 주세요.");
            result.push('false');
        } else {
            $("#emailNoti").html("");
            result.push('true');
        }

        if (!getMail.test($("#email").val() + "@" + $("#emailTail").val())) {
            $("#emailNoti").html("올바른 이메일 형식을 입력해 주세요.");
            result.push('false');
        } else {
            $("#emailNoti").html("");
            result.push('true');
        }

        if ($("#name").val() == "") {
            $("#nameNoti").html("이름을 입력해 주세요.");
            result.push('false');
        } else {
            $("#nameNoti").html("");
            result.push('true');
        }

        // if (!getName.test($("#name").val())) {
        //     $("#nameNoti").html("이름을 올바르게 입력해 주세요.");
        //     result.push('false');
        // } else {
        //     $("#nameNoti").html("");
        //     result.push('true');
        // }

        if ($("#password").val().length < 8) {
            $("#lengthNoti").html("비밀번호는 8자 이상으로 입력해 주세요.");
            result.push('false');
        } else {
            $("#lengthNoti").html("");
            result.push('true');
        }

        if ($("#password").val() != $("#confirm").val()) {
            $("#confirmNoti").html("비밀번호가 다릅니다.\n다시 입력해 주세요.");
            result.push('false');
        } else {
            $("#confirmNoti").html("");
            result.push('true');
        }

        // if ($("#cellNumber2").val().length < 8 || isNaN($("#cellNumber2").val())) {
        //     $("#cellNoti").html("휴대전화 번호를 올바르게 입력해주세요.");
        //     result.push('false');
        // } else {
        //     $("#cellNoti").html("");
        //     result.push('true');
        // }

        if ($("#agree2").prop("checked") == false || $("#agree3").prop("checked") == false) {
            alert("필수 이용약관 및 개인정보 수집/이용 동의를 확인해주세요.");
            result.push('false');
        }

        if (!result.includes('false')) {
            jQuery.ajax({
                url: "/users/add",
                method: 'POST',
                type: 'json',
                data: {
                    email: $("#email").val() + "@" + $("#emailTail").val(),
                    password: $("#password").val(),
                    name: $("#name").val(),
                    hp: $("#cellNumber").val() + $("#cellNumber2").val()
                }
            }).done(function (data) {
                if (data.status == 'success') {
                    $(location).attr('href', '/users/certification/' + data.id);
                } else {
                    $("#emailNoti").html("이미 회원 가입된 이메일입니다.\n다시 입력해 주세요.");
                    $("#email").focus();
                }
            });
        }
    });
</script>