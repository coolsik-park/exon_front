<?php
$naver_client_id = getEnv('NAVER_CLIENT_ID');
$naver_redirectURI = urlencode("http://121.126.223.225:8765/users/naverLogin");
$_SESSION['state'] = md5(microtime()) . mt_rand();
$state = $_SESSION['state'];
$naver_apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=" . $naver_client_id . "&redirect_uri=" . $naver_redirectURI . "&state=" . $state;

$kakao_client_id = getEnv('KAKAO_CLIENT_ID');
$kakao_redirectURI = urlencode("http://121.126.223.225:8765/users/kakaoLogin");
$kakao_apiURL = "https://kauth.kakao.com/oauth/authorize?response_type=code&client_id=" . $kakao_client_id . "&redirect_uri=" . $kakao_redirectURI
?>

<div id="container">
    <div class="log-wrap">
        <div class="log-step-wrap">
            <h1><a href="/" class="h-logo">EXON</a></h1>
            <div class="log-step-page log log-step-03">
                <h2 class="h-ty2 fir">로그인</h2>
                <div class="mbr-form">
                    <?= $this->Form->create() ?>
                    <div class="item-row">
                        <div class="col-dt">이메일</div>
                        <div class="col-dd">
                            <?= $this->Form->control('email', ['type' => 'text', 'placeholder' => '최소 8자 이상', 'title' => '이메일', 'class' => 'full', 'label' => '']) ?>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="col-dt agt">비밀번호</div>
                        <div class="col-dd">
                            <?= $this->Form->control('password', ['type' => 'password', 'placeholder' => '최소 8자 이상', 'title' => '비밀번호', 'class' => 'full', 'label' => '']) ?>
                            <p id="noti" class="noti hc1"></p>
                        </div>
                    </div>
                </div>
                <div class="btn-btm">
                    <a class="btn-big" style="cursor:pointer;">로그인</a>
                </div>
                <?= $this->Form->end() ?>
                <div class="div-or"></div>
                <div class="log-other">
                    <a href="<?php echo $kakao_apiURL ?>" class="btn-kakao"><span>KaKao 연동하기</span></a>
                    <a href="<?php echo $naver_apiURL ?>" class="btn-naver"><span>NAVER 연동하기</span></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".btn-big").click(function () {
        jQuery.ajax({
            url: "/users/login", 
            method: 'POST',
            type: 'json',
            data: {
                email: $("#email").val(),
                password: $("#password").val()
            }
        }).done(function(data) {
            if (data.status == 'success') {
                $(location).attr('href', '/');
            } else {
                $("#noti").html("로그인 정보가 틀렸습니다.");
            }
        });
    });
</script>