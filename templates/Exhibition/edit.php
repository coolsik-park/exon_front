<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition $exhibition
 */
?>
<style>
    em {
        color:#e4342d;
        font-weight:700;
        position:absolute;
        top:-8px;
        left:-6px;
    }
    .date-sett label {
        padding-bottom:10px;
    }
    .s-hty2 {
        position: relative;
    }
    .selectDiv {
        display: flex;
        flex-direction: column;
    }
    .sect1 .photo {
        position: relative;
    }
    .sect1 .photo img {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .btnMove {
        position: fixed;
        z-index: 1;
        right: 170px;
        top: -25px;
    }
    .subMenuMove {
        position: fixed;
        z-index: 1;
        right: 0px;
        top: 0px;
    }
    .tabMenu {
        display: flex;
    }
    .btn_wpBg {       
    }
    #detail_html {
        width: 99%;
    }
    #member_div {
        margin-top: 20px;
    }
    @media  screen and (max-width: 768px) {
        .sect1 .photo {
            height: 214px;
        }   
        .btn-wp {
            display: flex;
            justify-content: flex-end;
        }
        .section1 .sect-tit .btn-ty4 {
            width: 29%;
            height: 40px;
            background-color: rgba(255,255,255,1);
            margin: 6px 5px 5px 13px;
        }
        .btnMove {
            position: fixed;
            z-index: 1;
            top: 46px;
            padding-top: 0;
            right: 10px;
            width: 100%;
        }
        .tabMenu {
            display: none;
        }

        .btn_wpBg {
            background-color: rgba(255,255,255,1);
            border-bottom: 1px solid #dbdbdb;
            height: 50px;
        }
    }
    @media  screen and (min-width: 768px) {
        .selectDiv {
            display: flex;
            flex-direction: row;
        }
        .essential{
            position: absolute;
            left: 400px;
        }
        .survey-bx-sect2 select {
            position: relative;
            right: 555px;
            bottom: 85px;
        }
        .survey-bx-sect2 .ipt {
            width: 100%;
            margin-top: 15px;
        }
        .p-noti_1 {
            position: relative;
            margin-left: 414px;
            bottom: 90px;
        }
    }
    .apply-sect3-cont p{
        word-wrap:break-word;
    }
    .conts {
        text-align: center;
    }
</style>



<?= $this->Form->create($exhibition, ['id' => 'editForm', 'enctype' => 'multipart/form-data', 'autocomplete' => 'autocomplete_off_randString'])?>
    <div id="container">    
        <div class="sub-menu">
            <div class="sub-menu-inner">
                <ul class="tab" >
                    <li class ="active"><a href="">행사 설정 수정</a></li>
                    <li><a href="/exhibition/survey-data/<?= $id ?>">설문 데이터</a></li>
                    <li><a href="/exhibition/manager-person/<?= $id ?>">참가자 관리</a></li>
                    <?php if ($exhibition->is_vod == 0) : ?> 
                    <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정(라이브)</a></li>
                    <?php elseif ($exhibition->is_vod == 1) : ?>
                    <li><a href="/exhibition-stream/set-exhibition-vod/<?= $id ?>">웨비나 송출 설정(VOD)</a></li>
                    <?php else : ?>
                    <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정(라이브)</a></li>
                    <li><a href="/exhibition-stream/set-exhibition-vod/<?= $id ?>">웨비나 송출 설정(VOD)</a></li>
                    <?php endif; ?>
                    <li><a href="/exhibition/exhibition-statistics-apply/<?= $id ?>">행사 통계</a></li>
                </ul>
            </div>
        </div>        
        <div class="contents static">
            <h2 class="sr-only" >행사 개설</h2>
            <div class="section1">
                <div class="sect-tit">
                    <h3 class="s-hty1">기본설정</h3>
                    <div class="btn-wp">
                        <?php if ($exhibition->status == 4) : ?>
                        <button type="button" name="cancel" class="btn-ty4 red">취소</button>
                        <button type="button" name="save" class="btn-ty4">개설</button>
                        <button type="button" name="temp" class="btn-ty4">임시저장</button>
                        <?php else : ?>
                        <button type="button" name="cancel" class="btn-ty4 red">취소</button>
                        <button type="button" name="save" class="btn-ty4">저장</button>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="sect1">
                    <div class="sect1-col1">
                    <div class="product-title">
                        <div class="product-img-div photo" style="overflow: hidden;">
                            <?php if ($exhibition->image_path != '') : ?>
                            <label id="photos" style="width: 100%; height: 100%; visibility: visible;" class="conts" for="image"><img class="product-img mainImg" src="<?= DS . $exhibition->image_path . DS . $exhibition->image_name ?>"></p>
                            <?php else : ?>
                            <label id="photos" class="conts" style="overflow: hidden;"for="image"><img class="noImg" src="../../images/img-no3.png" alt="이미지없음" style="visibility: visible; height: 100%; width: 100%;"></p>
                            <?php endif; ?>
                        </div>
                        </div>
                        <p class="p-noti">클릭하여 이미지를 변경하세요.</p>
                        <input type="file" id="image" name="image" style="display:none">
                    </div>
                    <div class="sect1-col2">
                        <div class="row2 fir">
                            <div class="col-th"> <h4 class="s-hty2"><em class="st">*</em>행사이름</h4></div>
                            <div class="col-td"><input type="text" id="title" name="title" class="ipt"></div>
                        </div>
                        <div class="row2">
                            <div class="col-th">간단한 행사 소개</div>
                            <div class="col-td"><input type="text" id="description" name="description" class="ipt"></div>
                        </div>
                        <div class="row2">
                            <div class="col-th">행사 분야 및 유형</div>
                                <div class="col-td sel-bx">
                                <div class="selectDiv">
                                    <?php echo $this->Form->control('category', ['empty' => false, 'label' => false, 'class' => 'select', 'style' => 'width:274.36px; height:48.52px']); ?>
                                    <?php echo $this->Form->control('type', ['empty' => false, 'label' => false, 'class' => 'select', 'style' => 'width:274.36px; height:48.52px']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sect2">
                    <h4 class="s-hty2"><em class="st">*</em>모집 일시</h4>
                    <div class="date-sett-wp">
                        <div class="date-sett">
                            <div class="input-group date" id="apply_sdate" data-target-input="nearest">
                                <label for="data_apply_sdate">시작 일시</label> 
                                <div class="input-group date">
                                    <input type="text" value="<?=$exhibition->apply_sdate?>" id="data_apply_sdate" class="form-control datetimepicker-input" data-target="#apply_sdate" autocomplete="autocomplete_off_randString"/>
                                    <div class="input-group-append" data-target="#apply_sdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="date-sett">
                            <div class="input-group date" id="apply_edate" data-target-input="nearest">
                                <label for="data_apply_edate">종료 일시</label>
                                <div class="input-group date">
                                    <input type="text" value="<?=$exhibition->apply_edate?>" id="data_apply_edate" class="form-control datetimepicker-input" data-target="#apply_edate" autocomplete="autocomplete_off_randString"/>
                                    <div class="input-group-append" data-target="#apply_edate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>            
                    </div>
                </div>
                <div class="sect2">
                    <h4 class="s-hty2"><em class="st">*</em>행사 일시</h4>
                    <div class="date-sett-wp">
                        <div class="date-sett">
                            <div class="input-group date" id="sdate" data-target-input="nearest">
                                <label for="data_sdate">시작 일시</label>
                                <div class="input-group date">
                                    <input type="text" value="<?=$exhibition->sdate?>" id="data_sdate" class="form-control datetimepicker-input" data-target="#sdate" autocomplete="autocomplete_off_randString"/>
                                    <div class="input-group-append" data-target="#sdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="date-sett">
                            <div class="input-group date" id="edate" data-target-input="nearest">
                                <label for="data_edate">종료 일시</label>
                                <div class="input-group date">
                                    <input type="text" value="<?=$exhibition->edate?>" id="data_edate" class="form-control datetimepicker-input" data-target="#edate" autocomplete="autocomplete_off_randString"/>
                                    <div class="input-group-append" data-target="#edate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>              
                    </div>
                </div>
                <div class="sect3" style="display:none;">
                    <h4 class="s-hty2">온포터즈 1기</h4>
                    <p class="p-noti">온포터즈 1기 웨비나 행사로 등록하시겠습니까?</p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="is_event" id="is_event1" value="0" checked="checked"><label for="is_event1">등록안함</label></span>
                    </div>
                    
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="is_event" id="is_event2" value="1"><label for="is_event2">등록</label></span>
                    </div>
                </div>
                <div id="member_div" class="sect6">
                    <div class="sect-tit">
                        <h4 class="s-hty2"><em class="st">*</em>참가자 명단</h4>
                    </div>
                    <div>
                        <input type="text" id="event_member" name="event_member" placeholder="참가자1, 참가자2···." class="ipt">
                    </div>
                </div>
                <div class="sect3">
                    <div class="row2">
                        <div class="col-th"><h4 class="s-hty2">행사유료화</h4></div>
                        <div class="col-td">
                            <span class="chk-dsg"><input type="radio" id="cost1" name="cost" value="free"><label for="cost1">무료</label></span>
                            <span class="chk-dsg"><input type="radio" id="cost2" name="cost" value="charged"><label for="cost2">유료</label></span>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="section2">
                <h3 class="s-hty1">상세 설정</h3>
                <div class="sect4">
                    <h4 class="s-hty2">공개 여부</h4>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="private" id="private1" value="0"><label for="private1">공개</label></span>
                        <p class="p-noti">누구나 이 행사를 보고 참여 할 수 있습니다.</p>
                    </div>
                    
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="private" id="private2" value="1"><label for="private2">비공개</label></span>
                        <p class="p-noti">행사 URL을 얻은 사람만 행사에 참여 할 수 있습니다.</p>
                    </div>
                </div>
                <div id="group" class="sect5 mgtS1">
                    <h4 class="s-hty2">그룹 설정</h4>
                    <div class="ln-group">
                        <!-- <input id="group_name0" name="group_name0" type="text" class="ipt" placeholder="그룹명"> -->
                        <div class="ln-group-wp">
                            <!-- <input id="group_amount0" name="group_amount0" type="text" class="ipt" placeholder="그룹별 금액" style="margin-right:20px;">
                            <select class="select">
                                <option>인원 수</option>
                            </select>
                            <select id="group_people0" name="group_people0" class="select">
                                <option>인원수</option>
                                <option>1,000</option>
                                <option>2,000</option>
                                <option>3,000</option>
                                <option>4,000</option>
                            </select> -->
                            
                        </div>
                    </div>
                    <!-- <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p> -->
                </div>
                <a id="addGroup" class="btn-ty3 md" style="margin-top:10px; cursor:pointer">그룹추가</a>
                <div class="sect4 mgtS1">
                    <h4 class="s-hty2">참가자 승인 방법</h4>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="auto_approval" id="auto_approval1" value="0"><label for="auto_approval1">수동 승인</label></span>
                        <p class="p-noti">개설자가 승인한 참가자만 참여가 가능합니다.</p>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="auto_approval" id="auto_approval2" value="1"><label for="auto_approval2">자동 승인</label></span>
                        <p class="p-noti">참가자가 행사 참여 신청을 하면 자동으로 승인이 됩니다.</p>
                    </div>
                </div>
                <div class="sect6 mgtS1">
                    <div class="sect-tit">
                        <h4 class="s-hty2">담당자 정보 입력</h4>
                        <span class="chk-dsg"><input type="checkbox" id="getUser"><label for="getUser">개설자 정보로 담당자 정보 입력</label></span>
                    </div>
                    <div>
                        <input type="text" id="name" name="name" placeholder="이름" class="ipt">
                        <input type="text" id="tel" name="tel" placeholder="연락처" class="ipt">
                        <input type="text" id="email" name="email" placeholder="이메일" class="ipt">
                        <div class="col-email-wp">
                            <!-- <input type="text" id="email" name="email" placeholder="이메일">
                            <span class="sp">@</span>
                            <select name="" id="">
                                <option value="">선택</option>
                            </select> -->
                        </div>
                    </div>
                </div>
                <div class="sect7 mgtS1">
                    <h4 class="s-hty2">참가자 정보</h4>
                    <p class="p-noti">필요한 참가자 정보를 선택합니다.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" id="require_name" name="require_name" value="1" checked="checked" onclick="return false"><label for="require_name">이름</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_email" name="require_email" value="1" checked="checked" onclick="return false"><label for="require_email">이메일</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_tel" name="require_tel" value="1"><label for="require_tel">연락처</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_group" name="require_group" value="1"><label for="require_group">소속</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_sex" name="require_sex" value="1"><label for="require_sex">성별</label></span>
                    </div>
                </div>
                <div class="sect7 mgtS1">
                    <h4 class="s-hty2">웨비나 송출 설정</h4>
                    <p class="p-noti">원하는 웨비나 송출 방법을 선택합니다.(중복 선택 가능)</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" id="live" class="is_vod"><label for="live">라이브 송출</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="vod" class="is_vod"><label for="vod">VOD 송출</label></span>
                    </div>
                </div>
                <input type="hidden" id="live_tab" name="live_tab" value="0">
                <input type="hidden" id="vod_tab" name="vod_tab" value="0">
                <div class="sect7 mgtS1" id="live-tab-div">
                    <h4 class="s-hty2">라이브 탭 설정</h4>
                    <p class="p-noti">표시할 탭을 선택합니다.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_9" name="1" checked="checked"><label for="live_9">실시간 채팅</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_5" name="16" checked="checked"><label for="live_5">출석체크</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_8" name="2"><label for="live_8">설문</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_7" name="4"><label for="live_7">공지사항</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_6" name="8"><label for="live_6">질의 응답</label></span><br>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_4" name="32"><label for="live_4">프로그램</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_3" name="64"><label for="live_3">담당자 정보</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_2" name="128"><label for="live_2">개설자 정보</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_1" name="256"><label for="live_1">행사 정보</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_0" name="512"><label for="live_0">자료</label></span>
                    </div>
                </div>
                <div class="sect7 mgtS1" id="vod-tab-div">
                    <h4 class="s-hty2">VOD 탭 설정</h4>
                    <p class="p-noti">표시할 탭을 선택합니다.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_8" name="2"><label for="vod_8">설문</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_7" name="4"><label for="vod_7">공지사항</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_6" name="8"><label for="vod_6">질의응답</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_3" name="64"><label for="vod_3">담당자 정보</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_2" name="128"><label for="vod_2">개설자 정보</label></span><br>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_1" name="256"><label for="vod_1">행사 정보</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_0" name="512"><label for="vod_0">자료</label></span>
                    </div>
                </div>
                <div class="sect7 mgtS1">
                    <h4 class="s-hty2">웨비나 접속 시 본인 인증</h4>
                    <p class="p-noti">웨비나 접속 시 인증 절차를 진행합니다.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="radio" name="require_cert" id="require_cert1" value="1"><label for="require_cert1">인증하기</label></span>
                        <span class="chk-dsg"><input type="radio" name="require_cert" id="require_cert2" value="0"><label for="require_cert2">건너뛰기</label></span>
                    </div>
                </div>
                <div class="sect8 mgtS1">
                    <h4 class="s-hty2">행사 설명</h4>
                    <input type="hidden" id="hidden_detail" value='<?=htmlspecialchars($exhibition->detail_html)?>'>
                    <textarea id="detail_html" name="detail_html" cols="30" rows="10"></textarea>               
                </div>
            </div>
            <div class="section4">
                <h3 class="s-hty1">부가 정보</h3>
                <!-- <div class="sect9 mgtS1">
                    <h4 class="s-hty3">확인 메일</h4>
                    <p class="p-noti2">행사 시작 1시간 전에 이메일로 행사 시작 시간을 알립니다. </p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="email_notice" id="email_notice1" value="1"><label for="email_notice1">사용</label></span>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="email_notice" id="email_notice2" value="0"><label for="email_notice2">사용 안함</label></span>
                    </div>
                </div> -->
                <div class="sect9 mgtS1">
                    <h4 class="s-hty3">추가 신청</h4>
                    <p class="p-noti2">모집 일시가 종료된 후에도 신청이 가능합니다. 이 때 신청자는 자동으로 대기 처리 됩니다.</p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="additional" id="additional1" value="1"><label for="additional1">사용</label></span>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="additional" id="additional2" value="0"><label for="additional2">사용 안함</label></span>
                    </div>
                </div>
                <div class="sect10 mgtS1">
                    <div class="survey-tit">
                        <h4 class="s-hty3">설문</h4>
                    </div>   
                    <div id="survey">

                    </div>
                    <a id="surveyAdd" class="btn-ty3 md" style="margin-top:10px; cursor:pointer">설문추가</a>
                </div>
            </div>

            <div class="section-btm3 mgtS1">
                <?php if ($exhibition->status == 4) : ?>
                <button type="button" name="cancel" class="btn-big red">취소</button>
                <button type="button" name="save" class="btn-big">개설</button>
                <button type="button" name="temp" class="btn-big">임시저장</button>
                <?php else : ?>
                <button type="button" name="cancel" class="btn-big red">취소</button>
                <button type="button" name="save" class="btn-big">저장</button>
                <?php endif; ?>
            </div>
        </div>        
    </div>
<?= $this->Form->end() ?>

<script type="text/javascript" src="/se2/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" />

<script>
    //is_vod 컨트롤
    $(".is_vod").on("change", function() {
        if ($(this).attr("id") == "live" && $("#live").prop("checked") == false && $("#vod").prop("checked") == false) {
            $("#vod").prop("checked", true);
        }
        if ($(this).attr("id") == "vod" && $("#live").prop("checked") == false && $("#vod").prop("checked") == false) {
            $("#live").prop("checked", true);
        }
    });

    $(document).on("ready", function () {
        if ($("#live").prop("checked") == true) {
            $("#live-tab-div").show();
        } else {
            $("#live-tab-div").hide();
        }
        if ($("#vod").prop("checked") == true) {
            $("#vod-tab-div").show();
        } else {
            $("#vod-tab-div").hide();
        }
    });

    $(".is_vod").on("change", function() {
        if ($("#live").prop("checked") == true) {
            $("#live-tab-div").show();
        } else {
            $("#live-tab-div").hide();
        }
        if ($("#vod").prop("checked") == true) {
            $("#vod-tab-div").show();
        } else {
            $("#vod-tab-div").hide();
        }
    });

    //naver editor
    var oEditors = [];
    var detail = $("#hidden_detail").val();
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "detail_html",
        sSkinURI: "/se2/SmartEditor2Skin.html",
        fOnAppLoad : function(){
            oEditors.getById["detail_html"].exec("PASTE_HTML", [detail]);
        },
        fCreator: "createSEditor2"
    });
    
    //방송 송출 시작 이후 행사명 변경 불가 처리
    var live_duration = "<?=$live_duration?>";
    if (live_duration != 0) {
        $("#title").attr("readonly", true);
        $("#data_apply_sdate").attr("readonly", true);
        $("#data_apply_edate").attr("readonly", true);
        $("#data_sdate").attr("readonly", true);
        $("#data_edate").attr("readonly", true);
    }

    //기본 설정 button scroll시 이동 
    const btn_wp = document.querySelector('.btn-wp');
    const subMenu = document.querySelector('.sub-menu');
    const subMenuHeight = subMenu.getBoundingClientRect().height;
    document.addEventListener('scroll', ()=>{
        if(window.scrollY >= 72) {
            btn_wp.classList.add('btnMove');
            btn_wp.classList.add('btn_wpBg');
            subMenu.classList.add('subMenuMove');
            subMenu.classList.add('tabMenu');
        } else {
            btn_wp.classList.remove('btnMove');
            btn_wp.classList.remove('btn_wpBg');
            subMenu.classList.remove('subMenuMove');
            subMenu.classList.remove('tabMenu');
        }
    });

    //datetimepicker
    $(function () {
        $('#apply_sdate').datetimepicker({
            stepping : 30,
            useCurrent : false,
            sideBySide : true
        });
        $('#apply_edate').datetimepicker({
            stepping : 30,
            useCurrent : false,
            sideBySide : true
        });
        $('#sdate').datetimepicker({
            stepping : 30,
            useCurrent : false,
            sideBySide : true
        });
        $('#edate').datetimepicker({
            stepping : 30,
            useCurrent : false,
            sideBySide : true
        });
    });

    //필수정보
    // $("#require_tel").click(function() {
    //     if ($(this).prop("checked") == true) {
    //         $("#require_email").attr("onclick", "");
    //     } else {
    //         $("#require_email").prop("checked", true);
    //         $("#require_email").attr("onclick", "return false");
    //     }
    // });

    //DB 데이터 불러오기
    var img = "<?=$exhibition->image_name?>";
    if (img != '') {
        $("#mainImg").attr("src", "/<?=$exhibition->image_path?>/<?=$exhibition->image_name?>");
    } else {
        $("#mainImg").attr("src", "../../images/img-no3.png");
    }

    $("#title").val("<?=$exhibition->title?>");
    $("#description").val("<?=$exhibition->description?>");
    $("#title").val("<?=$exhibition->title?>");
    $("input:radio[name='cost']:radio[value='<?=$exhibition->cost?>']").prop("checked", true);
    $("input:radio[name='private']:radio[value='<?=$exhibition->private?>']").prop("checked", true);
    $("input:radio[name='auto_approval']:radio[value='<?=$exhibition->auto_approval?>']").prop("checked", true);
    $("#name").val("<?=$exhibition->name?>");
    $("#tel").val("<?=$exhibition->tel?>");
    $("#email").val("<?=$exhibition->email?>");
    $("#event_member").val("<?=$exhibition->event_member?>");
    if ($('input:checkbox[name="require_name"]').val() == "<?=$exhibition->require_name?>") { 
        $('input:checkbox[name="require_name"]').prop("checked", true); 
    }
    if ($('input:checkbox[name="require_email"]').val() == "<?=$exhibition->require_email?>") { 
        $('input:checkbox[name="require_email"]').prop("checked", true); 
    }
    if ($('input:checkbox[name="require_tel"]').val() == "<?=$exhibition->require_tel?>") { 
        $('input:checkbox[name="require_tel"]').prop("checked", true); 
    }
    if ($('input:checkbox[name="require_age"]').val() == "<?=$exhibition->require_age?>") { 
        $('input:checkbox[name="require_age"]').prop("checked", true); 
    }
    if ($('input:checkbox[name="require_group"]').val() == "<?=$exhibition->require_group?>") { 
        $('input:checkbox[name="require_group"]').prop("checked", true); 
    }
    if ($('input:checkbox[name="require_sex"]').val() == "<?=$exhibition->require_sex?>") { 
        $('input:checkbox[name="require_sex"]').prop("checked", true); 
    }
    $("input:radio[name='require_cert']:radio[value='<?=$exhibition->require_cert?>']").prop("checked", true);
    $("input:radio[name='email_notice']:radio[value='<?=$exhibition->email_notice?>']").prop("checked", true);
    $("input:radio[name='additional']:radio[value='<?=$exhibition->additional?>']").prop("checked", true);
    $("input:radio[name='is_event']:radio[value='<?=$exhibition->is_event?>']").prop("checked", true);
    var vod_val = "<?=$exhibition->is_vod?>";
    if (vod_val == 0) {
        $("#live").prop("checked", true);
    } else if (vod_val == 1) {
        $("#vod").prop("checked", true);
    } else {
        $("#live").prop("checked", true);
        $("#vod").prop("checked", true);
    }

    if ($("#is_event1").prop("checked") == true) {
        $("#member_div").hide();
    }
    $("#is_event1").on("change", function () {
        if ($(this).prop("checked") == true) {
            $("#member_div").hide();
        }
    });
    $("#is_event2").on("change", function () {
        if ($(this).prop("checked") == true) {
            $("#member_div").show();
        }
    });

    var dec = "<?=$exhibition->live_tab?>";
    dec = parseInt(dec);
    var bin = dec.toString(2);
    if (bin.length < 10) {
        var zero = '';
        for (i=0; i<10-bin.length; i++) {
            zero += '0';
        }
        bin = zero+bin;
    }
    for (i=0; i<bin.length; i++) {
        var result = bin.substring(i,i+1);
        if (parseInt(result) == 1) {
            $("#live_" + i).prop("checked", true);
        }
    }

    var dec = "<?=$exhibition->vod_tab?>";
    dec = parseInt(dec);
    var bin = dec.toString(2);
    if (bin.length < 10) {
        var zero = '';
        for (i=0; i<10-bin.length; i++) {
            zero += '0';
        }
        bin = zero+bin;
    }
    for (i=0; i<bin.length; i++) {
        var result = bin.substring(i,i+1);
        if (parseInt(result) == 1) {
            $("#vod_" + i).prop("checked", true);
        }
    }

    //그룹 데이터 불러오기
    var groupIndex = 0;
    <?php $i = 0; ?>
    <?php if ($exhibition->cost == 'charged') : ?>
    <?php foreach ($exhibitionGroups as $exhibitionGroup) : ?>
        <?php if ($i == 0) : ?>
        var html = '';  
        html += '<div id=group_' + groupIndex + '>';
        html += '   <br>';
        html += '   <div class="ln-group">';
        html += '       <input name="group_id[]" type="hidden" class="ipt" value="<?=$exhibitionGroup->id?>">';
        html += '       <input name="group_name[]" type="text" class="ipt" value="<?=$exhibitionGroup->name?>" placeholder="그룹명">';
        html += '       <div class="ln-group-wp">';
        html += '           <input name="group_amount[]" type="text" class="ipt" value="'+comma("<?=$exhibitionGroup->amount?>")+'" placeholder="그룹별 금액" style="margin-right:20px;">';
        html += '           <select id="select' + groupIndex + '" name="group_people[]" class="select">';
        html += '               <option value="0">인원수</option>';
        html += '               <option value="50">50</option>';
        html += '               <option value="100">100</option>';
        html += '               <option value="200">200</option>';
        html += '               <option value="300">300</option>';
        html += '               <option value="400">400</option>';
        html += '               <option value="500">500</option>';
        html += '           </select>';
        html += '       </div>';
        html += '   </div>';
        html += '   <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>';
        html += '</div>';
        <?php else : ?>
        var html = '';  
        html += '<div id=group_' + groupIndex + '>';
        html += '   <br>';
        html += '   <div class="ln-group">';
        html += '       <input name="group_id[]" type="hidden" class="ipt" value="<?=$exhibitionGroup->id?>">';
        html += '       <input name="group_name[]" type="text" class="ipt" value="<?=$exhibitionGroup->name?>" placeholder="그룹명">';
        html += '       <div class="ln-group-wp">';
        html += '           <input name="group_amount[]" type="text" class="ipt" value="'+comma("<?=$exhibitionGroup->amount?>")+'" placeholder="그룹별 금액" style="margin-right:20px;">';
        html += '           <select id="select' + groupIndex + '" name="group_people[]" class="select">';
        html += '               <option value="0">인원수</option>';
        html += '               <option value="50">50</option>';
        html += '               <option value="100">100</option>';
        html += '               <option value="200">200</option>';
        html += '               <option value="300">300</option>';
        html += '               <option value="400">400</option>';
        html += '               <option value="500">500</option>';
        html += '           </select>';
        html += '           <a onclick="deleteGroup(' + groupIndex + ',' + <?=$exhibitionGroup->id?> + ')" class="btn-ty3 md" style="cursor:pointer">삭제</a>';
        html += '       </div>';
        html += '   </div>';
        html += '   <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>';
        html += '</div>';
        <?php endif; ?>
        groupIndex += 1;
        $("#group").append(html);
        $("#select<?=$i?>").val("<?=$exhibitionGroup->people?>").prop("selected", true);
        <?php $i++; ?>
    <?php endforeach; ?>
    <?php else : ?>
    <?php foreach ($exhibitionGroups as $exhibitionGroup) : ?>
        <?php if ($i == 0) : ?>
        var html = '';  
        html += '<div id=group_' + groupIndex + '>';
        html += '   <br>';
        html += '   <div class="ln-group">';
        html += '       <input name="group_id[]" type="hidden" class="ipt" value="<?=$exhibitionGroup->id?>">';
        html += '       <input name="group_name[]" type="text" class="ipt" value="<?=$exhibitionGroup->name?>" placeholder="그룹명">';
        html += '       <div class="ln-group-wp">';
        html += '           <input name="group_amount[]" type="hidden" class="ipt" value="'+comma("<?=$exhibitionGroup->amount?>")+'" placeholder="그룹별 금액" style="margin-right:20px;">';
        html += '           <select id="select' + groupIndex + '" name="group_people[]" class="select">';
        html += '               <option value="0">인원수</option>';
        html += '               <option value="50">50</option>';
        html += '               <option value="100">100</option>';
        html += '               <option value="200">200</option>';
        html += '               <option value="300">300</option>';
        html += '               <option value="400">400</option>';
        html += '               <option value="500">500</option>';
        html += '           </select>';
        html += '       </div>';
        html += '   </div>';
        html += '   <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>';
        html += '</div>';
        <?php else : ?>
        var html = '';  
        html += '<div id=group_' + groupIndex + '>';
        html += '   <br>';
        html += '   <div class="ln-group">';
        html += '       <input name="group_id[]" type="hidden" class="ipt" value="<?=$exhibitionGroup->id?>">';
        html += '       <input name="group_name[]" type="text" class="ipt" value="<?=$exhibitionGroup->name?>" placeholder="그룹명">';
        html += '       <div class="ln-group-wp">';
        html += '           <input name="group_amount[]" type="hidden" class="ipt" value="'+comma("<?=$exhibitionGroup->amount?>")+'" placeholder="그룹별 금액" style="margin-right:20px;">';
        html += '           <select id="select' + groupIndex + '" name="group_people[]" class="select">';
        html += '               <option value="0">인원수</option>';
        html += '               <option value="50">50</option>';
        html += '               <option value="100">100</option>';
        html += '               <option value="200">200</option>';
        html += '               <option value="300">300</option>';
        html += '               <option value="400">400</option>';
        html += '               <option value="500">500</option>';
        html += '           </select>';
        html += '           <a onclick="deleteGroup(' + groupIndex + ',' + <?=$exhibitionGroup->id?> + ')" class="btn-ty3 md" style="cursor:pointer">삭제</a>';
        html += '       </div>';
        html += '   </div>';
        html += '   <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>';
        html += '</div>';
        <?php endif; ?>
        groupIndex += 1;
        $("#group").append(html);
        $("#select<?=$i?>").val("<?=$exhibitionGroup->people?>").prop("selected", true);
        <?php $i++; ?>
    <?php endforeach; ?>
    <?php endif; ?>

    function comma(str) {
        str = String(str);
        return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    }

    //메인 이미지 삽입 
    $("#image").change(function() {
        var formData = new FormData();
        var image = document.getElementById("image").files;
        formData.append('image', image[0]);
        formData.append('action', 'image');
        jQuery.ajax({
            url: '/exhibition/add/',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            type: 'POST',
        }).done(function (data) {
            if (data.status == 'success') {
                $(".mainImg").attr("src", "/" + data.path + "/" + data.imgName);
            } else {
                alert('이미지 등록에 실패하였습니다.\n잠시 후 다시 시도해 주세요.');
            }
        });
    });

    //유무료 전환
    $(document).on("click", "input[name='cost']", function () {
        if ($("input[name='cost']:checked").val() == "free") {
            $("input[name='group_amount[]']").each(function () {
                $(this).attr("type", "hidden");
                $(this).val(0);
            });
        } else {
            $("input[name='group_amount[]']").each(function () {
                $(this).attr("type", "text");
                $(this).val('');
            });
        }
    });

    //커서 맨 앞으로
    $(document).on("click", "input[name='group_amount[]']", function () {
        $(this).val(",000");
        $(this).selectRange(0,0);
    });

    $.fn.selectRange = function(start, end) {
        return this.each(function() {
            if(this.setSelectionRange) {
                this.focus();
                this.setSelectionRange(start, end);
            } else if(this.createTextRange) {
                var range = this.createTextRange();
                range.collapse(true);
                range.moveEnd('character', end);
                range.moveStart('character', start);
                range.select();
            }
        });
    }; 

    //그룹 추가
    $(document).on("click", "#addGroup", function() {
        if ($("input[name='cost']:checked").val() == "free") {
            var html = '';
            html += '<div id=group_' + groupIndex + '>';
            html += '   <br>';
            html += '   <div class="ln-group">';
            html += '       <input name="group_id[]" type="hidden" class="ipt" value=0>';
            html += '       <input name="group_name[]" type="text" class="ipt" placeholder="그룹명">';
            html += '       <div class="ln-group-wp">';
            html += '           <input name="group_amount[]" type="hidden" class="ipt" placeholder="그룹별 금액" value="0" style="margin-right:20px;">';
            html += '           <select name="group_people[]" class="select">';
            html += '               <option value="0">인원수</option>';
            html += '               <option value="50">50</option>';
            html += '               <option value="100">100</option>';
            html += '               <option value="200">200</option>';
            html += '               <option value="300">300</option>';
            html += '               <option value="400">400</option>';
            html += '               <option value="500">500</option>';
            html += '           </select>';
            html += '           <a onclick="deleteGroup(' + groupIndex + ')" class="btn-ty3 md" style="cursor:pointer">삭제</a>';
            html += '       </div>';
            html += '   </div>';
            html += '   <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>';
            html += '</div>';
        } else {
            var html = '';
            html += '<div id=group_' + groupIndex + '>';
            html += '   <br>';
            html += '   <div class="ln-group">';
            html += '       <input name="group_id[]" type="hidden" class="ipt" value=0>';
            html += '       <input name="group_name[]" type="text" class="ipt" placeholder="그룹명">';
            html += '       <div class="ln-group-wp">';
            html += '           <input name="group_amount[]" type="text" class="ipt" placeholder="그룹별 금액" style="margin-right:20px;">';
            html += '           <select name="group_people[]" class="select">';
            html += '               <option value="0">인원수</option>';
            html += '               <option value="50">50</option>';
            html += '               <option value="100">100</option>';
            html += '               <option value="200">200</option>';
            html += '               <option value="300">300</option>';
            html += '               <option value="400">400</option>';
            html += '               <option value="500">500</option>';
            html += '           </select>';
            html += '           <a onclick="deleteGroup(' + groupIndex + ')" class="btn-ty3 md" style="cursor:pointer">삭제</a>';
            html += '       </div>';
            html += '   </div>';
            html += '   <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>';
            html += '</div>';
        }
        groupIndex += 1;
        $("#group").append(html);
    });

    //그룹 제거
    function deleteGroup(index, id) {
        var html = '';
        html += '<input name="group_del[]" type="hidden" class="ipt" value="' + id + '">';
        $("#group").append(html);
        $("#group_" + index).remove();
        groupIndex -= 1;
    };

    //개설자 정보를 담당자 정보로 등록
    $("#getUser").change(function() {
        if ($("#getUser").is(":checked")) {
            jQuery.ajax({
                url: "/exhibition/get-user-info/",
                method: 'POST',
                type: 'json',
            }).done(function (data) {
                if (data.status == 'success') {
                    $("#name").val(data.name);
                    $("#tel").val(data.tel);
                    $("#email").val(data.email);
                }
            });
        } else {
            $("#name").val(null);
            $("#tel").val(null);
            $("#email").val(null);
        }
    });
    
    //저장
    $(document).on("click", "button[name='save']", function() {
        //Validation
        if ($("#mainImg").attr("src") == "../../images/img-no3.png") {
            alert("행사 이미지를 등록해주세요.");
            window.scrollTo(0,0);
            return false;
        }

        if ($("#title").val().length == 0) {
            alert("행사이름을 입력해주세요.");
            $("#title").focus();
            return false;
        }

        if ($("#data_apply_sdate").val().length == 0) {
            alert("모집 시작일시를 입력해주세요.");
            $("#apply_sdate").focus();
            return false;
        }

        if ($("#data_apply_edate").val().length == 0) {
            alert("모집 종료일시를 입력해주세요.");
            $("#apply_edate").focus();
            return false;
        }

        if ($("#data_sdate").val().length == 0) {
            alert("행사 시작일시를 입력해주세요.");
            $("#sdate").focus();
            return false;
        }

        if ($("#data_edate").val().length == 0) {
            alert("행사 종료일시를 입력해주세요.");
            $("#edate").focus();
            return false;
        }

        if ($("#name").val().length == 0) {
            alert("담당자 이름을 입력해주세요.");
            $("#name").focus();
            return false;
        }

        if ($("#tel").val().length == 0) {
            alert("담당자 연락처를 입력해주세요.");
            $("#tel").focus();
            return false;
        }

        if ($("#email").val().length == 0) {
            alert("담당자 이메일을 입력해주세요.");
            $("#email").focus();
            return false;
        }

        var group_empty = 0;
        $("input[name='group_name[]']").each(function () {
            if ($(this).val() == '') {
                $(this).val('참가자');
            }
        });

        if ($("input:radio[name='cost']:checked").val() == "charged") {
            $("input[name='group_amount[]']").each(function () {
                if ($(this).val() == '' || $(this).val() == ',000') {
                    alert("유료 행사인 경우 그룹별 금액을 입력해주세요.");
                    group_empty = 1;
                    return false
                }
            });
        }

        if (group_empty == 1) {
            return false
        }

        $("select[name='group_people[]']").each(function () {
            if ($(this).val() == "0") {
                alert("그룹 인원수를 선택해 주세요.");
                $(this).focus();
                group_empty = 1;
            }
        });
        
        if (group_empty == 1) {
            return false
        }

        var live_tab = 0;
        var vod_tab = 0;
        $(".live_tab_box").each(function () {
            if ($(this).prop("checked") == true) {
                live_tab += parseInt($(this).attr("name"));
            }
        });

        $(".vod_tab_box").each(function () {
            if ($(this).prop("checked") == true) {
                vod_tab += parseInt($(this).attr("name"));
            }
        });

        $("#live_tab").val(live_tab);
        $("#vod_tab").val(vod_tab);
        
        oEditors.getById["detail_html"].exec("UPDATE_CONTENTS_FIELD", []);
        var formData = $("#editForm").serialize();
        formData = formData + '&status=1';
        formData = formData + '&action=add';

        var apply_sdate = new Date($("#data_apply_sdate").val());
        apply_sdate.setHours(apply_sdate.getHours()+9);
        formData = formData + '&apply_sdate=' + apply_sdate.toISOString();

        var apply_edate = new Date($("#data_apply_edate").val());
        apply_edate.setHours(apply_edate.getHours()+9);
        formData = formData + '&apply_edate=' + apply_edate.toISOString();

        var sdate = new Date($("#data_sdate").val());
        sdate.setHours(sdate.getHours()+9);
        formData = formData + '&sdate=' + sdate.toISOString();

        var edate = new Date($("#data_edate").val());
        edate.setHours(edate.getHours()+9);
        formData = formData + '&edate=' + edate.toISOString();

        if (apply_sdate >= apply_edate) {
            alert('시작 일시 이전으로 종료 일시를 설정 할 수 없습니다.\n다시 확인해주세요.');
            $("#data_apply_edate").focus();
            return false
        }

        if (sdate >= edate) {
            alert('시작 일시 이전으로 종료 일시를 설정 할 수 없습니다.\n다시 확인해주세요.');
            $("#data_edate").focus();
            return false
        }

        if ($("#is_event2").prop("checked") == true) {
            if ($("#event_member").val().length == 0) {
                alert('참가자 명단을 입력해주세요.');
                $("#event_member").focus();
                return false
            } 
        }

        var is_vod = 0;
        if ($("#vod").prop("checked") == true && $("#live").prop("checked") == false) {
            is_vod = 1;
        }
        if ($("#live").prop("checked") == true && $("#vod").prop("checked") == true) {
            is_vod = 2;
        }
        formData = formData + '&is_vod=' + is_vod;

        jQuery.ajax({
            url: "/exhibition/edit/<?=$id?>",
            method: 'PUT',
            type: 'json',
            data: formData
        }).done(function (data) {
            if (data.status == 'exist') {
                alert("삭제하려는 그룹에 참가자가 존재하여 삭제 할 수 없습니다.\n참가자를 확인해주세요.");
                window.location.reload();
                return false;
            }
            // if (data.status == 'success') {
            var imageData = new FormData();
            var image = document.getElementById("image").files;
            imageData.append('image', image[0]);
            
            jQuery.ajax({
                url: '/exhibition/save-img/' + data.id,
                processData: false,
                contentType: false,
                cache: false,
                data: imageData,
                type: 'POST',
            }).done(function (data) {
                if (data.status == 'success') {
                    alert("저장 되었습니다.");
                    window.location.replace("/exhibition/index/all");
                } else {
                    alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
                }
            });
            // } else if (data.status == 'exist') {
                // alert("삭제하려는 그룹에 참가자가 존재하여 삭제 할 수 없습니다. 참가자를 확인해주세요.");
                // window.location.reload();
            // } else {
                // alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
            // }
        });
    });

    //취소
    $("button[name='cancel']").click(function () {
        window.location.replace("/exhibition/index/all");
    });

    //임시저장
    $(document).on("click", "button[name='temp']", function() {
        //Validation
        if ($("#title").val().length == 0) {
            alert("행사이름을 입력해주세요.");
            $("#title").focus();
            return false;
        }

        var group_empty = 0;
        $("input[name='group_name[]']").each(function () {
            if ($(this).val() == '') {
                $(this).val('참가자');
            }
        });

        if ($("input:radio[name='cost']:checked").val() == "charged") {
            $("input[name='group_amount[]']").each(function () {
                if ($(this).val() == '' || $(this).val() == ',000') {
                    alert("유료 행사인 경우 그룹별 금액을 입력해주세요.");
                    group_empty = 1;
                    return false
                }
            });
        }

        if (group_empty == 1) {
            return false
        }

        $("select[name='group_people[]']").each(function () {
            if ($(this).val() == "0") {
                alert("그룹 인원수를 선택해 주세요.");
                $(this).focus();
                group_empty = 1;
                return false
            }
        });
        
        if (group_empty == 1) {
            return false
        }

        var live_tab = 0;
        var vod_tab = 0;
        $(".live_tab_box").each(function () {
            if ($(this).prop("checked") == true) {
                live_tab += parseInt($(this).attr("name"));
            }
        });

        $(".vod_tab_box").each(function () {
            if ($(this).prop("checked") == true) {
                vod_tab += parseInt($(this).attr("name"));
            }
        });

        $("#live_tab").val(live_tab);
        $("#vod_tab").val(vod_tab);

        oEditors.getById["detail_html"].exec("UPDATE_CONTENTS_FIELD", []);
        var formData = $("#editForm").serialize();
        formData = formData + '&status=4';
        formData = formData + '&action=add';

        var apply_sdate = new Date($("#data_apply_sdate").val());
        if (apply_sdate != 'Invalid Date') {
            apply_sdate.setHours(apply_sdate.getHours()+9);
            formData = formData + '&apply_sdate=' + apply_sdate.toISOString();
        }

        var apply_edate = new Date($("#data_apply_edate").val());
        if (apply_edate != 'Invalid Date') {
            apply_edate.setHours(apply_edate.getHours()+9);
            formData = formData + '&apply_edate=' + apply_edate.toISOString();
        }
        

        var sdate = new Date($("#data_sdate").val());
        if (sdate != 'Invalid Date') {
            sdate.setHours(sdate.getHours()+9);
            formData = formData + '&sdate=' + sdate.toISOString();
        }
        
        var edate = new Date($("#data_edate").val());
        if (edate != 'Invalid Date') {
            edate.setHours(edate.getHours()+9);
            formData = formData + '&edate=' + edate.toISOString();
        }

        if (apply_sdate != 'Invalid Date') {
            if (apply_sdate >= apply_edate) {
                alert('시작 일시 이전으로 종료 일시를 설정 할 수 없습니다.\n다시 확인해주세요.');
                $("#data_apply_edate").focus();
                return false
            }
        }

        if (sdate != 'Invalid Date') {
            if (sdate >= edate) {
                alert('시작 일시 이전으로 종료 일시를 설정 할 수 없습니다.\n다시 확인해주세요.');
                $("#data_edate").focus();
                return false
            }
        }

        var is_vod = 0;
        if ($("#vod").prop("checked") == true && $("#live").prop("checked") == false) {
            is_vod = 1;
        }
        if ($("#live").prop("checked") == true && $("#vod").prop("checked") == true) {
            is_vod = 2;
        }
        formData = formData + '&is_vod=' + is_vod;
        
        jQuery.ajax({
            url: "/exhibition/edit/<?=$id?>",
            method: 'PUT',
            type: 'json',
            data: formData
        }).done(function (data) {
            if (data.status == 'success') {
                var imageData = new FormData();
                var image = document.getElementById("image").files;
                imageData.append('image', image[0]);
                
                jQuery.ajax({
                    url: '/exhibition/save-img/' + data.id,
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: imageData,
                    type: 'POST',
                }).done(function (data) {
                    if (data.status == 'success') {
                        alert("임시 저장 되었습니다.");
                        window.location.replace("/exhibition/index/temp");
                    } else {
                        alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
                    }
                });
            } else if (data.status == 'exist') {
                alert("삭제하려는 그룹에 참가자가 존재하여 삭제 할 수 없습니다.\n참가자를 확인해주세요.");
                window.location.reload();
            } else {
                alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
            }
        });
    });
    
    //설문
    var i = 0; //설문 인덱스
    var j = 0; //보기 인덱스

    //설문 데이터 불러오기
    <?php foreach ($exhibitionSurveys as $exhibitionSurvey) : ?>
        <?php if ($exhibitionSurvey->is_multiple == 'Y') : ?>
            var html = '';
            html += '<div id="survey_'+i+'" class="survey-bx">';
            html += '    <div class="survey-bx-sect1">';
            html += '        <div class="tits">';
            html += '            <select id="is_multiple_'+i+'" name="is_multiple[]" class="<?=$exhibitionSurvey->id?>">';
            html += '                <option value="Y">객관식</option>';
            html += '                <option value="N">주관식</option>';
            html += '            </select>';
            html += '            <div class="chk-dsg-wp">';
            html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup_'+i+'" value="Y"><label for="dup_'+i+'">보기 중복 선택 가능</label></span>';
            html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+i+'" value="N" checked="checked" style="display:none">';
            html += '                <span class="chk-dsg" id="req_span_'+i+'"><input type="checkbox" name="is_required[]" id="req_'+i+'" value="Y"><label for="req_'+i+'" class="essential">필수</label></span>';
            html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+i+'" value="N" checked="checked" style="display:none">';
            html += '            </div>';                                
            html += '        </div>';
            html += '        <div class="btns">';                                
            html += '            <button type="button" class="btn2" onclick="deleteSurvey('+i+', <?=$exhibitionSurvey->id?>)">삭제</button>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="survey-bx-sect2">';
            html += '        <input name="text[]" type="text" class="ipt" placeholder="질문을 입력하세요" value="<?=$exhibitionSurvey->text?>">';
            html += '        <input name="survey_id[]" type="hidden" value="<?=$exhibitionSurvey->id?>">'
            html += '        <select id="survey_type_'+i+'" name="survey_type[]">';
            html += '            <option value="N">일반설문</option>';
            html += '            <option value="B">사전설문</option>';
            html += '        </select>';
            html += '    </div>';
            html += '    <p id="type_noti_'+i+'" class="p-noti_1"></p>';
            html += '    <div id="rows_'+i+'" class="survey-bx-sect3">';
            // html += '        <div class="btns">';
            // html += '            <button type="button" onclick="addRow('+i+')">보기 추가</button>';
            // html += '        </div>';
            <?php foreach ($exhibitionSurvey->child_exhibition_survey as $child) : ?>
            html += '        <div id="row_'+j+'" class="wrt-after">';
            html += '            <input name="child_text_'+i+'[]" type="text" class="ipt" placeholder="보기" value="<?=$child->text?>">';
            html += '            <input name="child_survey_id_'+i+'[]" type="hidden" value="<?=$child->id?>">'
            // html += '            <button type="button" class="btn-del" onclick="deleteRow('+j+', <?=$child->id?>)">보기 삭제</button>';
            html += '        </div>';
            j++;
            <?php endforeach; ?>
            html += '    </div>';
            html += '</div>';
            $("#survey").append(html);
            <?php if ($exhibitionSurvey->is_duplicate == 'Y') : ?>
                $("#dup_" + i).prop("checked", true);
                document.getElementById("dup_hidden_" + i).disabled = true;
            <?php else: ?>
                $("#dup_" + i).prop("checked", false);
                document.getElementById("dup_hidden_" + i).disabled = false;
            <?php endif; ?>
            <?php if ($exhibitionSurvey->is_required == 'Y') : ?>
                $("#req_" + i).prop("checked", true);
                document.getElementById("req_hidden_" + i).disabled = true;
            <?php else: ?>
                $("#req_" + i).prop("checked", false);
                document.getElementById("req_hidden_" + i).disabled = false;
            <?php endif; ?>
            $("#survey_type_" + i).val("<?=$exhibitionSurvey->survey_type?>").prop("selected", true);
            <?php if ($exhibitionSurvey->survey_type == 'N') : ?>
                $("#type_noti_" + i).html("일반설문으로 설정하시면 행사 진행 중에 참가자분들이 설문에 참여할 수 있습니다.");
            <?php else : ?>
                $("#type_noti_" + i).html("사전설문으로 설정하시면 행사 신청 때 참가자분들이 설문에 참여할 수 있습니다.");
            <?php endif; ?>


        
        <?php else : ?>
            var html = '';
            html += '<div id="survey_'+i+'" class="survey-bx">';
            html += '<div class="survey-bx-sect1">';
            html += '    <div class="tits">';
            html += '        <select id="is_multiple_'+i+'" name="is_multiple[]" class="<?=$exhibitionSurvey->id?>">';
            html += '            <option value="Y">객관식</option>';
            html += '            <option selected="selected" value="N">주관식</option>';
            html += '        </select>';
            html += '        <div class="chk-dsg-wp">';
            html += '            <span class="chk-dsg" id="req_span_'+i+'"><input type="checkbox" name="is_required[]" id="req_'+i+'" value="Y"><label for="req_'+i+'" class="essential">필수</label></span>';
            html += '            <input type="checkbox" name="is_required[]" id="req_hidden_'+i+'" value="N" checked="checked" style="display:none">';
            html += '        </div>';                           
            html += '    </div>';
            html += '    <div class="btns">';                          
            html += '       <button type="button" class="btn2" onclick="deleteSurvey('+i+', <?=$exhibitionSurvey->id?>)">삭제</button>';
            html += '    </div>';
            html += '</div>';
            html += '<div class="survey-bx-sect2">';
            html += '    <input name="text[]" type="text" class="ipt" placeholder="질문을 입력하세요" value="<?=$exhibitionSurvey->text?>">';
            html += '    <input name="survey_id[]" type="hidden" value="<?=$exhibitionSurvey->id?>">';
            html += '    <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+i+'" value="N" checked="checked" style="display:none">';
            html += '    <select id="survey_type_'+i+'" name="survey_type[]">';
            html += '        <option value="N">일반설문</option>';
            html += '        <option value="B">사전설문</option>';
            html += '    </select>';
            html += '</div>';
            html += '<p id="type_noti_'+i+'" class="p-noti_1"></p>';
            html += '</div>';
            $("#survey").append(html);
            <?php if ($exhibitionSurvey->is_required == 'Y') : ?>
                $("#req_" + i).prop("checked", true);
                document.getElementById("req_hidden_" + i).disabled = true;
            <?php else: ?>
                $("#req_" + i).prop("checked", false);
                document.getElementById("req_hidden_" + i).disabled = false;
            <?php endif; ?>
            $("#survey_type_" + i).val("<?=$exhibitionSurvey->survey_type?>").prop("selected", true);
            <?php if ($exhibitionSurvey->survey_type == 'N') : ?>
                $("#type_noti_" + i).html("일반설문으로 설정하시면 행사 진행 중에 참가자분들이 설문에 참여할 수 있습니다.");
            <?php else : ?>
                $("#type_noti_" + i).html("사전설문으로 설정하시면 행사 신청 때 참가자분들이 설문에 참여할 수 있습니다.");
            <?php endif; ?>
        <?php endif; ?>
        i++;
    <?php endforeach; ?>

    //설문 추가
    $("#surveyAdd").click(function () {
        var html = '';
        html += '<div id="survey_'+i+'" class="survey-bx">';
        html += '    <div class="survey-bx-sect1">';
        html += '        <div class="tits">';
        html += '            <select id="is_multiple_'+i+'" name="is_multiple[]" class="0">';
        html += '                <option value="Y">객관식</option>';
        html += '                <option value="N">주관식</option>';
        html += '            </select>';
        html += '            <div class="chk-dsg-wp">';
        html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup_'+i+'" value="Y"><label for="dup_'+i+'">보기 중복 선택 가능</label></span>';
        html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+i+'" value="N" checked="checked" style="display:none">';
        html += '                <span class="chk-dsg" id="req_span_'+i+'" style="display:none;"><input type="checkbox" name="is_required[]" id="req_'+i+'" value="Y"><label for="req_'+i+'" class="essential">필수</label></span>';
        html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+i+'" value="N" checked="checked" style="display:none">';
        html += '            </div>';                                
        html += '        </div>';
        html += '        <div class="btns">';                                
        html += '            <button type="button" class="btn2" onclick="deleteSurvey('+i+', 0)">삭제</button>';
        html += '        </div>';
        html += '    </div>';
        html += '    <div class="survey-bx-sect2">';
        html += '        <input name="text[]" type="text" class="ipt" placeholder="질문을 입력하세요">';
        html += '        <input name="survey_id[]" type="hidden" value="0">';
        html += '        <select id="survey_type_'+i+'" name="survey_type[]">';
        html += '            <option value="N">일반설문</option>';
        html += '            <option value="B">사전설문</option>';
        html += '        </select>';
        html += '    </div>';
        html += '    <p id="type_noti_'+i+'" class="p-noti_1">일반설문으로 설정하시면 행사 진행 중에 참가자분들이 설문에 참여할 수 있습니다.</p>';
        html += '    <div id="rows_'+i+'" class="survey-bx-sect3">';
        html += '        <div class="btns">';
        html += '            <button type="button" onclick="addRow('+i+')">보기 추가</button>';
        html += '        </div>';
        html += '        <div id="row_'+j+'" class="wrt-after">';
        html += '            <input name="child_text_'+i+'[]" type="text" class="ipt" placeholder="보기">';
        html += '            <input name="child_survey_id_'+i+'[]" type="hidden" value="0">'
        html += '            <button type="button" class="btn-del" onclick="deleteRow('+j+', 0)">보기 삭제</button>';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';
        i++;
        j++;
        $("#survey").append(html);
    });

    //설문 삭제
    function deleteSurvey(index, id) {
        var html = '';
        html += '<input name="survey_del[]" type="hidden" value="' + id + '">';
        $("#survey").append(html);
        $("#survey_" + index).remove();
        // i--;
    };

    //보기 추가
    function addRow(index) {
        var html = '';
        html += '<div id="row_'+j+'" class="wrt-after">';
        html += '   <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="보기">';
        html += '   <input name="child_survey_id_'+i+'[]" type="hidden" value="0">'
        html += '   <button type="button" class="btn-del" onclick="deleteRow('+j+', 0)">보기 삭제</button>';
        html += '</div>';
        $("#rows_" + index).append(html);
        j++;
    };

    //보기 삭제
    function deleteRow(index, id) {
        // var html = '';
        // html += '<input name="child_survey_del[]" type="hidden" value="' + id + '">';
        // $("#survey").append(html);
        $("#row_" + index).remove();
        j--;
    };

    //주관식/객관식 전환
    $(document).on("change", "select[name='is_multiple[]']", function() {
        
        if ($(this).attr("class") != 0) {
            alert("저장된 설문의 객관식/주관식 항목을 수정하시려면 삭제 후 다시 등록해 주세요.");
            if ($("option:selected", this).val() == 'N') {
                $(this).val("Y").prop("selected", true);
            } else {
                $(this).val("N").prop("selected", true);
            }
            return false;
        }

        if ($("option:selected", this).val() == 'N') {
            var index = $(this).attr("id").substr($(this).attr("id"));
            index = index.split("_")[2]
            
            var html = '';
            html += '<div class="survey-bx-sect1">';
            html += '    <div class="tits">';
            html += '        <select id="is_multiple_'+index+'" name="is_multiple[]" class="0">';
            html += '            <option value="Y">객관식</option>';
            html += '            <option selected="selected" value="N">주관식</option>';
            html += '        </select>';
            html += '        <div class="chk-dsg-wp">';
            html += '                <span class="chk-dsg" id="req_span_'+index+'" style="display:none;"><input type="checkbox" name="is_required[]" id="req_'+index+'" value="Y"><label for="req_'+index+'" class="essential">필수</label></span>';
            html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '        </div>';                           
            html += '    </div>';
            html += '    <div class="btns">';                          
            html += '       <button type="button" class="btn2" onclick="deleteSurvey('+index+', 0)">삭제</button>';
            html += '    </div>';
            html += '</div>';
            html += '<div class="survey-bx-sect2">';
            html += '    <input name="text[]" type="text" class="ipt" placeholder="질문을 입력하세요">';
            html += '    <input name="survey_id[]" type="hidden" value="0">';
            html += '    <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '    <select id="survey_type_'+index+'" name="survey_type[]">';
            html += '        <option value="N">일반설문</option>';
            html += '        <option value="B">사전설문</option>';
            html += '    </select>';
            html += '</div>';
            html += '<p id="type_noti_'+index+'" class="p-noti_1">일반설문으로 설정하시면 행사 진행 중에 참가자분들이 설문에 참여할 수 있습니다.</p>';
            
            $("#survey_" + index).children().remove();
            $("#survey_" + index).append(html);
        
        } else {
            var index = $(this).attr("id").substr($(this).attr("id"));
            index = index.split("_")[2]
            
            var html = '';
            html += '    <div class="survey-bx-sect1">';
            html += '        <div class="tits">';
            html += '            <select id="is_multiple_'+index+'" name="is_multiple[]" class="0">';
            html += '                <option value="Y">객관식</option>';
            html += '                <option value="N">주관식</option>';
            html += '            </select>';
            html += '            <div class="chk-dsg-wp">';
            html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup_'+index+'" value="Y"><label for="dup_'+index+'">보기 중복 선택 가능</label></span>';
            html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+index+'" value="N" checked="checked" style="display:none;">';
            html += '                <span class="chk-dsg" id="req_span_'+index+'" style="display:none;"><input type="checkbox" name="is_required[]" id="req_'+index+'" value="Y"><label for="req_'+index+'"class="essential">필수</label></span>';
            html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '            </div>';                                
            html += '        </div>';
            html += '        <div class="btns">';                                
            html += '            <button type="button" class="btn2" onclick="deleteSurvey('+index+', 0)">삭제</button>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="survey-bx-sect2">';
            html += '        <input name="text[]" type="text" class="ipt" placeholder="질문을 입력하세요">';
            html += '        <input name="survey_id[]" type="hidden" value="0">';
            html += '        <select id="survey_type_'+index+'" name="survey_type[]">';
            html += '            <option value="N">일반설문</option>';
            html += '            <option value="B">사전설문</option>';
            html += '        </select>';
            html += '    </div>';
            html += '    <p id="type_noti_'+index+'" class="p-noti_1">일반설문으로 설정하시면 행사 진행 중에 참가자분들이 설문에 참여할 수 있습니다.</p>';
            html += '    <div id="rows_'+index+'" class="survey-bx-sect3">';
            html += '        <div class="btns">';
            html += '            <button type="button" onclick="addRow('+index+')">보기 추가</button>';
            html += '        </div>';
            html += '        <div id="row_'+j+'" class="wrt-after">';
            html += '            <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="보기">';
            html += '            <input name="child_survey_id_'+index+'[]" type="hidden" value="0">'
            html += '            <button type="button" class="btn-del" onclick="deleteRow('+j+', 0)">보기 삭제</button>';
            html += '        </div>';
            html += '    </div>';

            j++;
            $("#survey_" + index).children().remove();
            $("#survey_" + index).append(html);
        }
    });

    //is_duplicate 제어
    $(document).on("change", "input:checkbox[name='is_duplicate[]']", function() {
        var id = $(this).attr("id").substr($(this).attr("id"));
        id = id.split("_")[1]
        
        
        if (document.getElementById("dup_" + id).checked) {
            document.getElementById("dup_hidden_" + id).disabled = true;
        
        } else {
            document.getElementById("dup_hidden_" + id).disabled = false;
        }  
    });

    //is_required 제어
    $(document).on("change", "input:checkbox[name='is_required[]']", function() {
        var id = $(this).attr("id").substr($(this).attr("id"));
        id = id.split("_")[1]
        
        
        if (document.getElementById("req_" + id).checked) {
            document.getElementById("req_hidden_" + id).disabled = true;
        
        } else {
            document.getElementById("req_hidden_" + id).disabled = false;
        }  
    });

    $("select[name='survey_type[]']").each(function () {
        if ($(this).val() == 'N') {
            var id = $(this).attr("id").substr($(this).attr("id"));
            id = id.split("_")[1]
            
            $("#req_span_"+id).hide();
        }
    });

    $(document).on("change", "select[name='survey_type[]']", function () {
        var id = $(this).attr("id").substr($(this).attr("id"));
        id = id.split("_")[2]
        
        if ($(this).val() == 'N') {
            $("#req_span_"+id).hide();
            $("#req_"+id).prop("checked", false);
            $("#req_hidden_"+id).attr("disabled", false);
            $("#type_noti_"+id).html("일반설문으로 설정하시면 행사 진행 중에 참가자분들이 설문에 참여할 수 있습니다.");
        } else {
            $("#req_span_"+id).show();
            $("#type_noti_"+id).html("사전설문으로 설정하시면 행사 신청 때 참가자분들이 설문에 참여할 수 있습니다.");
        }
    });
</script>