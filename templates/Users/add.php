<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$naver_client_id = getEnv('NAVER_CLIENT_ID');
$naver_redirectURI = urlencode("http://121.126.223.225:8765/users/naverJoin");
$_SESSION['state'] = md5(microtime()) . mt_rand();
$state = $_SESSION['state'];
$naver_apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$naver_client_id."&redirect_uri=".$naver_redirectURI."&state=".$state;

$kakao_client_id = getEnv('KAKAO_CLIENT_ID');
$kakao_redirectURI = urlencode("http://121.126.223.225:8765/users/kakaoJoin");
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
    <a href="<?php echo $naver_apiURL ?>"><img src="/img/naver/네이버아이디로로그인.png"/></a><br>
    <a href="<?php echo $kakao_apiURL ?>"><img src="/img/kakao/ko/카카오아이디로로그인.png"/></a>
</div>

<div id="container">
      <div class="log-wrap">
          <div class="log-step-wrap">
            <h1><a href="#" class="h-logo">EXON</a></h1>
            <div class="log-step-page log-step-02">
                <h2 class="h-ty2 fir">간편 회원가입</h2>
                <div class="log-other">
                    <a href="<?php echo $kakao_apiURL ?>" class="btn-kakao"><span>KaKao 연동하기</span></a>
                    <a href="<?php echo $naver_apiURL ?>" class="btn-naver"><span>NAVER 연동하기</span></a>
                </div>
                <div class="div-or"></div>
                <h2 class="h-ty2">회원가입</h2>
                <div class="mbr-form">
                    <div class="item-row">
                      <div class="col-dt"><em class="st">*</em>이메일 (아이디)</div>
                      <div class="col-dd">
                          <div class="col-email-wp">
                            <input type="text" id="email" placeholder="이메일" title="이메일 (아이디)"><span class="sp">@</span>
                            <select name="" id="">
                              <option value="">선택</option>
                            </select>
                          </div>
                          <p class="noti"><span class="hc1">이미 회원 가입된 이메일입니다. 다시 입력해주세요</span> or <span class="hc1">올바른 이메일 형식을 입력해 주세요.</span></p>
                      </div>
                    </div>
                    <div class="item-row">
                        <div class="col-dt"><em class="st">*</em>비밀번호</div>                      
                        <div class="col-dd">
                            <input type="password" placeholder="최소 8자 이상 영어 + 숫자" class="full" title="비밀번호">
                        </div>
                    </div>  
                    <div class="item-row">
                        <div class="col-dt"><em class="st">*</em>비밀번호 확인</div>
                        <div class="col-dd">
                            <input type="password" placeholder="최소 8자 이상" class="full" title="비밀번호 확인">
                            <p class="noti hc1">비밀번호가 다릅니다. 다시 입력해 주세요</p>
                        </div>
                    </div>
                    <div class="item-row">
                      <div class="col-dt"><em class="st">*</em>이름</div>                    
                      <div class="col-dd">
                          <input type="text" placeholder="최소 2자 이상" class="full" title="이름">
                      </div>
                    </div>    
                    <div class="item-row">
                      <div class="col-dt">휴대전화 번호</div>                    
                      <div class="col-dd">
                          <div class="col-cell-wp">
                              <select id="cellNumber">
                                  <option value="">010</option>
                              </select>
                              <input type="text" placeholder="'-' 없이 입력해 주세요" title="휴대전화 번호">
                          </div>
                      </div>
                    </div>   
                </div>
                <h2 class="h-ty2">이용약관 / 개인정보 수집 및 이용 동의</h2>
                <div class="agree-wp">
                    <div>
                      <span class="chk-dsg"><input type="checkbox" id="agree1"><label for="agree1">전체동의</label></span>
                    </div>
                    <div>
                      <span class="chk-dsg"><input type="checkbox" id="agree2"><label for="agree2">(필수) 이용약관</label></span><a href="#" class="btn-ss">약관동의</a>
                    </div>
                    <div>
                      <span class="chk-dsg"><input type="checkbox" id="agree3"><label for="agree3">(필수) 개인정보 수집 및 이용 동의</label></span><a href="#" class="btn-ss">약관보기</a>
                    </div>  
                    <div>
                      <span class="chk-dsg"><input type="checkbox" id="agree4"><label for="agree4">(선택) 이메일 수신</label></span>
                      <p class="noti">단, 행사와 관련된 정보는 수신 동의 여부 관계없이 발송됩니다.</p>
                    </div>                  
                </div>
                <div class="btn-btm">
                    <a href="#" class="btn-big">가입완료</a>
                </div>
            </div>
          </div>   
      </div>
    </div>
   
 </div>  
