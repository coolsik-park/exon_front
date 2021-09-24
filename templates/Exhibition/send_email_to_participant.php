<script src="//cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<?= $this->Html->link(__('행사 설정 수정'), ['controller' => 'Exhibition', 'action' => 'edit', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('설문 데이터'), ['controller' => 'Exhibition', 'action' => 'surveyData', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('참가자 관리'), ['controller' => 'Exhibition', 'action' => 'managerPerson',$id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('웨비나 송출 설정'), ['controller' => 'ExhibitionStream', 'action' => 'setExhibitionStream', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 통계'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsApply', $id, 'class' => 'side-nav-item']) ?>
<br><br>
<?= $this->Html->link(__('참가자'), ['controller' => 'Exhibition', 'action' => 'managerPerson', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('이메일 발송'), ['controller' => 'Exhibition', 'action' => 'sendEmailToParticipant', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('문자 발송'), ['controller' => 'Exhibition', 'action' => 'sendSmsToParticipant', $id, 'class' => 'side-nav-item']) ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?php
                if (count($exhibitionUsers) > 0 ) { 
                    echo $this->Html->link(__('참가자리스트'), ['action' => 'participantList', $exhibitionUsers[0]['exhibition_id'], 'email', 'class' => 'side-nav-item']);
                } else {
                    echo $this->Html->link(__('참가자리스트'), ['action' => 'participantList', 0, 'email', 'class' => 'side-nav-item']);
                } 
            ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibition form content">
            <?= $this->Form->create($exhibitionUsers)?>
            <fieldset>
                <legend><?= __('Send Emails') ?></legend>
                <?php 
                    echo $this->Form->control('name');
                    echo $this->Form->control('email_content', ['type' => 'textarea']);
                ?>
                <?php
                    $data[] = '';
                    $count = count($exhibitionUsers);
                    
                    if (count($exhibitionUsers) > 0 && $exhibitionUsers[0]['users_email']) {
                        for ($i = 0; $i < $count; $i++) {
                            $data[$i] = $exhibitionUsers[$i]['users_email'];
                        }
                        echo $this->Form->select('users_email', $data, ['multiple' => 'checkbox']);
                    }
                ?>
            </fieldset>
            <?= $this->Form->button(__('Send')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<div id="container">
    <div class="sub-menu">
        <div class="sub-menu-inner">
            <ul class="tab">
                <li><a href="http://121.126.223.225:8765/exhibition/edit/<?= $id ?>">행사 설정 수정</a></li>
                <li class="active"><a href="#">설문 데이터</a></li>
                <li><a href="http://121.126.223.225:8765/exhibition/manager-person/<?= $id ?>">참가자 관리</a></li>
                <li><a href="http://121.126.223.225:8765/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출
                        설정</a></li>
                <li><a href="http://121.126.223.225:8765/exhibition/exhibition-statistics-apply/<?= $id ?>">행사 통계</a>
                </li>
            </ul>
        </div>
    </div>        
    <div class="contents static">
        <h2 class="sr-only">참가자 관리</h2>
        <div class="pr3-title">                          
            <ul class="s-tabs2">
                <li><a href="http://121.126.223.225:8765/exhibition/manager-person/<?= $id ?>">참가자</a></li>
                <li><a href="http://121.126.223.225:8765/exhibition/send-sms-to-participant/<?= $id ?>">문자</a></li>
                <li class="active"><a href="">이메일</a></li>
            </ul>
            <h3 class="s-hty1">이메일</h3>      
        </div>
        <div class="pr3-section3">
            <div class="pr3-sect">                   
                <div class="msg-editor">
                    <textarea name="email_content" id="email_content" cols="30" rows="10" placeholder="전송 내용을 입력해 주세요."></textarea>
                    <div class="btns">
                        <button type="button" id="reset" class="btn-ss">내용 초기화</button>
                    </div>                    
                </div>
                <div class="msg-post">
                    <h4 class="s-hty2">보내는 사람</h4>
                    <input type="text" id="name" name="name" class="ipt" placeholder="담당자">
                    <!-- <input type="text" class="ipt" placeholder="이메일"> -->
                    <div class="btns">
                        <button type="button" class="btn-ty2 bor">행사 URL 복사</button>
                        <button type="button" id="participantList" class="btn-ty2 bor">참가자 리스트</button>
                    </div>
                    <div class="msg-numbers-lists-wp">
                        <div class="msg-numbers-lists" id="list" style="width:100%; margin-top:10px;">
                        </div>
                    </div>
                </div>
            </div>

            

            <div class="pr3-sect2">
                <h4 class="s-hty2">이메일</h4>
                <div class="msg-numbers-lists-wp">
                    <div class="msg-numbers-lists">
                    <?php
                        if (count($exhibitionUsers) > 0 && $exhibitionUsers[0]['users_email']) {
                            foreach ($exhibitionUsers as $exhibitionUser) {
                    ?>
                        <ul>
                            <li>
                                <div class="number">
                                    <span id="users_email" name="users_email"><?= $exhibitionUser['users_email'] ?></span>
                                    <button type="button" class="btn-x">삭제</button>
                                </div>
                            </li>                       
                        </ul>
                    <?php 
                            }
                        } 
                    ?>
                    </div>
                    <div class="desc">
                        <p class="txt">받는 사람 : <?php count($exhibitionUsers) ?></p>
                        <div class="btns">
                            <button type="button" class="btn-ty2 red">목록 초기화</button>
                            <button type="button" class="btn-ty2">전송하기</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>        
</div>
    
<script>
    $("#participantList").click(function () {
        $("#list").load("http://121.126.223.225:8765/exhibition/participant-list/<?= $id ?>/email");
    });
</script>  