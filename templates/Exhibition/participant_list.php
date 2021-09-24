<style>
    #header, footer {
        display: none!important;
    }
</style>

<!-- <div class="row">
    <aside class="column">
        <div class="side-nav">
            
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibition form content">
            <?php
                $count = count($exhibitionUsers); 
                if ($count > 0 ) { 
            ?>
            <?= $this->Form->create($exhibitionUsers)?>
            <fieldset>
                <legend><?= __('Participant List') ?></legend>
                <?php
                    for ($i = 0; $i < $count; $i++) {
                        
                    }
                    if (count($exhibitionUsers) > 0) {
                        echo $this->Form->select('data', $exhibitionUsers, ['multiple' => 'checkbox']);
                    }
                ?>
            </fieldset>
            <?= $this->Form->button('Confirm') ?>
            <?= $this->Form->end() ?>
            <?php 
                } else { 
                    echo('신청자가 아직 없습니다.'); 
                } 
            ?>
        </div>
    </div>
</div> -->

<div class="popup-wrap popup-ty3">
    <div class="popup-head">
        <h1>참가자 리스트</h1>
        <button type="button" class="popup-close">팝업닫기</button>
    </div>
    <div class="popup-body">  
        <div class="search-box1">
            <div class="sel-wp">
                <select>
                    <option>승인상태</option>
                    <option>참가 확정</option>
                    <option>참가 대기</option>
                </select>
                <select>
                    <option>그룹명</option>
                    <option>Group1</option>
                    <option>Group2</option>
                </select>
            </div>
            <div class="ipt-search">
                <input type="text" placeholder="이름,이메일">
                <button type="button"><span class="ico-sh">검색</span> </button>
            </div>
        </div>

        <form id="postForm">
            <div class="table-type4">
                <div class="th-row">
                    <div class="th-col col1">
                        <span class="chk-dsg"><input type="checkbox" id="all"><label for="all">전체선택</label></span>   
                    </div>                     
                    <div class="th-col col2">승인 상태</div>
                    <div class="th-col col3">그룹명</div>
                    <div class="th-col col4">이름</div>
                    <div class="th-col col5">연락처</div>
                </div>
                <?php
                    foreach ($exhibitionUsers as $exhibitionUser) {
                ?>
                <div class="tr-row-wp">
                    <div class="tr-row">
                        <div class="td-col col1">
                            <div class="mo-only">선택</div>
                            <div class="con">
                                <label class="chk-dsg2"><input type="checkbox" name="list" value="<?= $exhibitionUser->id ?>"><span>선택</span></label>
                            </div>                        
                        </div>
                        <div class="td-col col2">
                            <div class="mo-only">승인 상태</div>
                            <div class="con">
                                <?php
                                    switch ($exhibitionUser->status) {
                                        case '1' : echo '신청전'; break;
                                        case '2' : echo '신청완료(참가대기)'; break;
                                        case '4' : echo '참가확정'; break;
                                        case '8' : echo '취소(환불)'; break;
                                    } 
                                ?>
                            </div>
                        </div>
                        <div class="td-col col3">
                            <div class="mo-only">그룹명</div>
                            <div class="con">
                            <?= $exhibitionUser->exhibition_group->name ?>
                            </div>
                        </div>
                        <div class="td-col col4">
                            <div class="mo-only">이름</div>
                            <div class="con">
                            <?= $exhibitionUser->users_name ?>
                            </div>
                        </div>
                        <div class="td-col col5">
                            <div class="mo-only">연락처</div>
                            <div class="con">
                            <?php echo substr($exhibitionUser->users_hp, 0, 3) . '-' . substr($exhibitionUser->users_hp, 3, 4) . '-' . substr($exhibitionUser->users_hp, 7, 4); ?>
                            </div>
                        </div>                    
                    </div>
                </div>   
                <?php
                    }
                ?>           
            </div>
        </form>
        
        <div class="popup-btm">           
            <button type="button" id="close" class="btn-ty2 bor">취소</button>
            <button type="button" id="send" class="btn-ty2">확인</button>
        </div>        
    </div>
</div>

<script>
    $("#close").click(function () {
        window.close();
    });

    $("#send").click(function () {
        var lists = [];
        $("input[name='list']:checked").each(function(i) { 
            lists.push($(this).val());
        });

        jQuery.ajax({
            url: "/exhibition/participant-list/" + <?= $id ?> + "/" + "<?= $type ?>",
            method: 'POST',
            type: 'json',
            data: {
                data : lists,
                }   
        }).done(function (data) {
            if (data.type == 'email') {
                window.location.href = 'http://121.126.223.225:8765/exhibition/send-email-to-participant/' + <?= $id ?> + '/' + data.data;
            } else {
                window.location.href = 'http://121.126.223.225:8765/exhibition/send-sms-to-participant/' + <?= $id ?> + '/' + data.data;
            }
        });
    });
</script>