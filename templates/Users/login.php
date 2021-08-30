<?php
$naver_client_id = getEnv('NAVER_CLIENT_ID');
$naver_redirectURI = urlencode("http://121.126.223.225:8765/users/naverLogin");
$_SESSION['state'] = md5(microtime()) . mt_rand();
$state = $_SESSION['state'];
$naver_apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$naver_client_id."&redirect_uri=".$naver_redirectURI."&state=".$state;

$kakao_client_id = getEnv('KAKAO_CLIENT_ID');
$kakao_redirectURI = urlencode("http://121.126.223.225:8765/users/kakaoLogin");
$kakao_apiURL = "https://kauth.kakao.com/oauth/authorize?response_type=code&client_id=".$kakao_client_id."&redirect_uri=".$kakao_redirectURI
?>

<div class="users form content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <?= $this->Form->button(__('Login')); ?>
    <?= $this->Form->end() ?>
</div>  

<a href="<?php echo $naver_apiURL ?>"><img src="/img/naver/네이버아이디로로그인.png"/></a><br>
<a href="<?php echo $kakao_apiURL ?>"><img src="/img/kakao/ko/카카오아이디로로그인.png"/></a>