<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$naver_client_id = "nruyRASkeHLeFK0ECeMz";
$naver_redirectURI = urlencode("http://121.126.223.225:8765/users/navercallback");
$_SESSION['state'] = md5(microtime()) . mt_rand();
$state = $_SESSION['state'];
$naver_apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$naver_client_id."&redirect_uri=".$naver_redirectURI."&state=".$state;

$kakao_client_id = "9d9c1b3134751cfe60d042ba0bc24c19";
$kakao_redirectURI = urlencode("http://121.126.223.225:8765/users/kakaocallback");
$kakao_apiURL = "https://kauth.kakao.com/oauth/authorize?response_type=code&client_id=".$kakao_client_id."&redirect_uri=".$kakao_redirectURI
?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Add User') ?></legend>
                <?php
                    echo $this->Form->control('email');
                    echo $this->Form->control('password');
                    echo $this->Form->control('confirm_password',['type' => 'password']);
                    echo $this->Form->control('name');
                    echo $this->Form->control('hp');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <a href="<?php echo $naver_apiURL ?>"><img height="50" width="200" src="/img/naver/btnG_완성형.png"/></a><br>
    <a href="<?php echo $kakao_apiURL ?>"><img height="50" width="200" src="/img/kakao/ko/kakao_login_medium_narrow.png"/></a>
</div>
