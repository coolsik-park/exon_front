<style>
    .wb-stream-sect {
        /* margin-bottom: 70px; */
        margin-top: 0px;
    }

    .add--vod__1 {
        margin-top: 40px
    }

    .pay {
        width: 244px;
        margin: 0px 0px 0px 12px;
    }

    .stream-sect .row2-wp .row2 {
        width: 60%;
    }

    .payDiv {
        width: 60%;
    }

    .sett-btn {
        display: block;
        position: absolute;
        top: -3px;
        right: 10px;
        padding: 6px;
        color: white;
        width: 17%;
        background-color: black;
        border-radius: 6px;
    }

    .tab-alert {
        border: 1px solid red;
        border-radius: 4px;
        color: red;
        font-size: 16px;
        text-align: center;
        width: auto;
        padding: 10px;
    }

    .btn-alert {
        background-color: white;
        border: 1px solid black;
        color: black;
        position: absolute;
        width: auto;
        right: 3px;
        top: -70px;
        line-height: 130%;
        z-index: 9999;
        text-align: left;
        padding: 10px;
    }

    .chapter {
        font-size: 25px;
    }

    .vod-ul {
        margin: 2% 0 2% 3%;
        font-size: 20px;
    }

    .vod-li {
        margin-top: 1%;
    }

    .vod-time {
        float: right;
    }

    .plus {
        width: 30px;
    }

    .add-chapter-div {
        width: 100%;
        position: relative;
    }

    #add-chapter {
        cursor: pointer;
        position: absolute;
        top: -34px;
        right: 12px;
    }

    .p-noti2 {
        font-size: 1rem;
        color: #afafaf;
        line-height: 1.5;
        margin-top: 20px;
        padding: 10px;
        border-bottom: 1px solid;
        text-align: right;
    }

    .add-vod {
        cursor: pointer;
    }

    .btn-span {
        vertical-align: middle;
        font-size: 20px;
    }

    .col-td label {
        padding-bottom: 3px;
    }

    .c-name {
        font-weight: 700;
    }

    .chapter-title {
        margin-bottom: 10px;
    }

    .stream-ipt1 .vod-input {
        width: 100%;
        margin-bottom: 20px;
    }

    .stream-ipt1 textarea {
        margin-bottom: 20px;
    }

    .mouse-area {
        padding: 0;
    }

    .kb {
        display: block;
        margin-top: 20px;
    }

    .chapter-icon {
        width: 25px;
        float: right;
    }

    .vod-icon {
        width: 20px;
        float: right;
    }

    .delete {
        cursor: pointer;
    }

    .sect--border {
        border-radius: 0px;
        border: none;
        border-bottom: 1px solid;
    }

    .stream-sect .row2-wp .row2 {
        width: 100%;
    }

    .stream-sect .row2-wp {
        flex-wrap: wrap;
    }

    .date--style {
        margin-bottom: 45px;
    }

    /* .endDate--style {
            flex-direction: column;
        } */
    .endDate2--style {
        margin-left: 7.5em;
    }

    .row2 .col-td {
        margin-bottom: 20px;
    }

    .stream-sect {
        position: relative;
    }

    .add--vod__2 {
        position: absolute;
        top: -1%;
        right: 160px;
    }

    .delete--vod__1 {
        position: absolute;
        right: 105px;
    }

    .delete--vod__2 {
        position: absolute;
        right: 65px;
    }

    .view--vod__1 {
        position: absolute;
        right: 75px;
    }

    .view--vod__2 {
        position: absolute;
        right: 35px;
    }

    .move--vod__1 {
        position: absolute;
        right: 40px;
    }

    .move--vod__2 {
        position: absolute;
        right: 0px;
    }

    .set--vod__1 {
        position: absolute;
        right: 135px;
        top: 0;
    }

    .set--vod__2 {
        position: absolute;
        right: 95px;
        top: 0;
    }

    .arrow--vod__1 {
        position: absolute;
        right: 0px;
        top: 0;
    }

    .arrow--vod {
        transform: rotate(90deg);
    }

    .wb--stream__first {
        margin-bottom: 30px;
        padding: 40px 40px 100px 40px;
    }

    .disable {
        color: grey;
    }

    a.disabled {
        opacity: 0.5;
        pointer-events: none;
        cursor: default;
    }

    .stream-ipt1 input {
        color: black;
    }

    .vod-title {
        position: relative;
    }

    .vod--title__icon {
        font-size: 18px;
        position: absolute;
        left: 10px;
        top: 8px;
    }

    .vodTitle {
        margin-left: 30px;
        font-size: 1.6rem;
    }

    #sortable2 {
        display: none;
    }

    #sortable2>li {
        border-bottom: 1px solid black;
    }

    .itemBoxHighlight {
        border: solid 1px black;
        width: 100%;
        height: 200px;
        background-color: yellow;
    }

    .progress {
        position: relative;
        width: 100%;
        border: 1px solid #ddd;
        padding: 1px;
        border-radius: 3px;
    }

    .bar {
        background-color: #337ab7;
        width: 0%;
        height: 20px;
        border-radius: 3px;
    }

    .percent {
        position: absolute;
        display: inline-block;
        top: 1px;
        left: 48%;
    }

    .chapter--title__char {
        font-size: 16px;
        top: 8px;
        left: -24px;
        position: absolute;
    }

    .btn3 {
        font-size: 16px;
    }

    .vod--chapter__cancle {
        margin-left: 12px;
    }

    .chapter-name-btn {
        margin-left: 12px;
    }

    .updateChapter {
        margin-left: 12px;
    }

    @media screen and (max-width: 768px) {
        .stream-sect .row2-wp .row2 {
            width: 99%;
        }

        .pay {
            width: 100%;
        }

        .payDiv {
            width: 100%;
        }

        .stream-ipt1 {
            flex-direction: column;
        }

        .btn-ty2.bor {
            margin: 16px 0px 0px 0px;
        }

        .stream-sect .row2-wp .row2+.row2 .col-th {
            margin-bottom: 155px;
        }

        .btnDiv {
            align-items: flex-end;
        }

        .sub-menu {
            margin-top: 50px;
        }

        .vod--chapter__cancle {
            margin-left: 12px;
        }

        .chapter-name-btn {
            margin-left: 12px;
        }

        .wb-stream-sect {
            margin-top: 20px;
        }
    }
</style>

<div class="contents">
    <div class="sub-menu">
        <div class="sub-menu-inner">
            <ul class="tab">
                <li><a href="/exhibition/edit/<?= $exhibition_id ?>">행사 설정 수정</a></li>
                <li><a href="/exhibition/survey-data/<?= $exhibition_id ?>">설문 데이터</a></li>
                <li><a href="/exhibition/manager-person/<?= $exhibition_id ?>">참가자 관리</a></li>
                <?php if ($exhibition->is_vod == 0) : ?>
                    <li><a href="/exhibition-stream/set-exhibition-stream/<?= $exhibition_id ?>">웨비나 송출 설정(라이브)</a></li>
                <?php elseif ($exhibition->is_vod == 1) : ?>
                    <li class="active"><a href="/exhibition-stream/set-exhibition-vod/<?= $exhibition_id ?>">웨비나 송출 설정(VOD)</a></li>
                <?php else : ?>
                    <li><a href="/exhibition-stream/set-exhibition-stream/<?= $exhibition_id ?>">웨비나 송출 설정(라이브)</a></li>
                    <li class="active"><a href="/exhibition-stream/set-exhibition-vod/<?= $exhibition_id ?>">웨비나 송출 설정(VOD)</a></li>
                <?php endif; ?>
                <li><a href="/exhibition/exhibition-statistics-apply/<?= $exhibition_id ?>">행사 통계</a></li>
            </ul>
        </div>
    </div>
    <div class="section-webinar4">
        <div class="webinar-cont">
            <div class="chapter-body">
            </div>
            <div class='wb-stream-sect wb--stream__first'>
                <div class="add-chapter-div">
                    <a id="add-chapter"><img src="/img/plus.png" class="plus"><span class="btn-span">챕터 추가</span></a>
                    <p class="p-noti2 noti">챕터를 추가하여 VOD들을 챕터별로 분류 할 수 있습니다.</p>
                    <ul id="sortable">
                        <?php if ($exhibitionVod != null) : ?>
                            <?php foreach ($exhibitionVod as $list) : ?>
                                <li class="ui-state-default">
                                    <div class='wb-stream-sect sect--border'>
                                        <div class="stream-sect">
                                            <?php if ($list['is_show'] == 0) : ?>
                                                <div class="chapter-title disable" style="font-size:1.8rem;"><span class="chapter--title__char">○</span><?= $list['title'] ?>
                                                <?php else : ?>
                                                    <div class="chapter-title" style="font-size:1.8rem;"><span class="chapter--title__char">○</span><?= $list['title'] ?>
                                                    <?php endif; ?>
                                                    <a style="" class="c set--vod__1" name="<?= $list['id'] ?>">
                                                        <img id="set--vod" class="chapter-icon set--vod" src="/img/setting.png">
                                                    </a>
                                                    <a style="" class="delete c delete--vod__1" name="<?= $list['id'] ?>">
                                                        <img class="chapter-icon" src="/img/trash_can-lov.png">
                                                    </a>
                                                    <?php if ($list['is_show'] == 0) : ?>
                                                        <a style="" class="c view--vod__1" name="<?= $list['id'] ?>">
                                                            <img id="view--vod__1" class="chapter-icon hidden" src="/img/hidden.png">
                                                        </a>
                                                    <?php else : ?>
                                                        <a style="" class="c view--vod__1" name="<?= $list['id'] ?>">
                                                            <img id="view--vod__1" class="chapter-icon" src="/img/view.png">
                                                        </a>
                                                    <?php endif; ?>
                                                    <a style="" class="c move--vod__1" name="<?= $list['id'] ?>">
                                                        <img id="move--vod__1" class="chapter-icon move--vod" src="/img/list.png">
                                                    </a>
                                                    <a style="" class="c arrow--vod__1" name="<?= $list['id'] ?>">
                                                        <img id="arrow--vod" class="chapter-icon arrow--vod" src="/img/arrow-down-sign-to-navigate.png">
                                                    </a>
                                                    </div>
                                                    <ul id="sortable2" class="<?= $list['id'] ?>">
                                                        <?php foreach ($list['child_exhibition_vod'] as $child) : ?>
                                                            <li class="ui-state-default">
                                                                <div class="vod-title" style="font-size:30px; margin:20px 0; padding-left:10px;">
                                                                    <?php if ($child['is_show'] == 0) : ?>
                                                                        <a class="vodTitle disabled" href="/exhibition-stream/watch-exhibition-vod/<?= $exhibition_id ?>/<?= $child['id'] ?>"><span class="vod--title__icon">◆</span><?= $child['title'] ?></a>
                                                                    <?php else : ?>
                                                                        <a class="vodTitle" href="/exhibition-stream/watch-exhibition-vod/<?= $exhibition_id ?>/<?= $child['id'] ?>"><span class="vod--title__icon">◆</span><?= $child['title'] ?></a>
                                                                    <?php endif; ?>
                                                                    <a style="" class="delete v delete--vod__2" name="<?= $child['id'] ?>"><img class="vod-icon" src="/img/trash_can-lov.png"></a>
                                                                    <?php if ($child['is_show'] == 0) : ?>
                                                                        <a style="" class="v view--vod__2" name="<?= $child['id'] ?>"><img id="view--vod__2" class="vod-icon hidden" src="/img/hidden.png"></a>
                                                                    <?php else : ?>
                                                                        <a style="" class="v view--vod__2" name="<?= $child['id'] ?>"><img id="view--vod__2" class="vod-icon" src="/img/view.png"></a>
                                                                    <?php endif; ?>
                                                                    <a style="" class="v move--vod__2 <?= $list['id'] ?>" name="<?= $child['id'] ?>"><img id="move--vod__2" class="vod-icon move--vod2" src="/img/list.png"></a>
                                                                    <a style="" class="v set--vod__2 <?= $list['id'] ?>" name="<?= $child['id'] ?>"><img id="set--vod__2" class="vod-icon set--vod2" src="/img/setting.png"></a>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>

                                                    <a id="<?= $list['id'] ?>" class="add-vod add--vod__2"><img src="/img/plus.png" class="plus"><span class="btn-span"></span></a>
                                                </div>
                                        </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <br><br>
                </div>
                <!-- <a id="" class="add-vod add--vod__1"><img src="/img/plus.png" class="plus"><span class="btn-span">VOD 추가</span></a> -->
            </div>
            <div class="modal fade" id="pleaseWaitDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>파일 업로드 중입니다. 잠시만 기다려주세요.</h3>
                        </div>
                        <div class="modal-body">
                            <!-- progress , bar, percent를 표시할 div 생성한다. -->
                            <div class="progress">
                                <div class="bar"></div>
                                <div class="percent">0%</div>
                            </div>
                            <div id="status"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wb-stream-sect">
                <h2 class="s-hty3">결제</h2>
                <div class="stream-sect">
                    <div class="row2">
                        <div class="col-th">프로모션 키</div>
                        <div class="col-td">
                            <div class="stream-ipt1">
                                <input type="text" id="coupon_code" name="coupon_code">
                                <button type="button" id="confirm_coupon" name="confirm_coupon" onclick="validateCoupon()" class="btn-ty2 bor">확인</button>
                            </div>
                        </div>
                    </div>
                    <div class="row2-wp">
                        <div class="row2">
                            <div class="col-th date--style">기간</div>
                            <div class="col-td">
                                <label for="vod_sdate">시작 일시</label>
                                <div class="date-sett-wp">
                                    <div class="date-sett">
                                        <div class="input-group date" id="vod_sdate" data-target-input="nearest">
                                            <div class="input-group date">
                                                <input type="text" value="<?= $exhibition->sdate ?>" id="data_vod_sdate" class="form-control datetimepicker-input" data-target="#vod_sdate" autocomplete="autocomplete_off_randString" />
                                                <div class="input-group-append" data-target="#vod_sdate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-td">
                                <label for="vod_duration">설정 기간</label>
                                <div class="stream-itp2">
                                    <input type="text" id="vod_duration" name="vod_duration" value="00시간 00분" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row2 endDate--style">
                            <div class="col-td endDate2--style">
                                <label for="vod_sdate">종료 일시</label>
                                <div class="date-sett-wp">
                                    <div class="date-sett">
                                        <div class="input-group date" id="vod_edate" data-target-input="nearest">
                                            <div class="input-group date">
                                                <input type="text" value="<?= $exhibition->edate ?>" id="data_vod_edate" class="form-control datetimepicker-input" data-target="#vod_edate" autocomplete="autocomplete_off_randString" />
                                                <div class="input-group-append" data-target="#vod_edate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-td">
                                <label for="left_duration">남은 기간</label>
                                <div class="stream-itp2">
                                    <input type="text" id="left_duration" name="left_duration" value="00시간 00분" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row2-wp">
                        <div class="row2">
                            <div class="col-th">영상 길이</div>
                            <div class="col-td">
                                <div class="stream-itp2">
                                    <input type="text" id="vod_size" name="vod_size" value="00:00:00 / 00:00:00" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row2-wp">
                        <div class="row2 payDiv">
                            <div class="col-th">금액</div>
                            <div class="col-td">
                                <div class="stream-ipt1 btnDiv">
                                    <input type="text" id="vod_amount" name="vod_amount" value="0" readonly>
                                    <input type="hidden" id="is_paid">
                                    <input type="hidden" id="vod_pay_id" name="vod_pay_id">
                                    <button type="button" id="payment-card" class="btn-ty2 bor pay" style="width: 100%;">결제(카드 결제)</button>
                                    <button type="button" id="payment-trans" class="btn-ty2 bor pay" style="width: 100%;">결제(계좌 이체)</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- webinar-tab -->
        <div class="webinar-tab" id="toggle">
            <div class="webinar-tab-top">
                <input type="hidden" id="tab" name="tab" value="0">
                <div class="w-tab-wrap">
                    <div class="w-tab-wrap-inner">
                        <ul class="w-tab">
                            <li id="li10" class=""><button type="button" id="btn_tab10" name="목록">목록</button></li>
                            <li id="li8" class=""><button type="button" id="btn_tab8" name="설문">설문</button></li>
                            <li id="li7" class=""><button type="button" id="btn_tab7" name="공지사항">공지사항</button></li>
                            <li id="li6" class=""><button type="button" id="btn_tab6" name="질의 응답">질의 응답</button></li>
                            <li id="li4" class=""><button type="button" id="btn_tab4" name="프로그램">프로그램</button></li>
                            <li id="li3" class=""><button type="button" id="btn_tab3" name="담당자 정보">담당자 정보</button></li>
                            <li id="li2" class=""><button type="button" id="btn_tab2" name="개설자 정보">개설자 정보</button></li>
                            <li id="li1" class=""><button type="button" id="btn_tab1" name="행사 정보">행사 정보</button></li>
                            <li id="li0" class=""><button type="button" id="btn_tab0" name="자료">자료</button></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- // top -->
            <div class="webinar-tab-body">
                <p class="tab-alert">[마이페이지] > [개설 행사 관리] > [행사 관리] 에서<br>사용할 탭을 설정할 수 있습니다.</p>
            </div>
            <!-- body -->
        </div>
        <!-- webinar-tab -->
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" />

<script>
    $(document).ready(function() {
        $("#btn_tab10").click();
    });

    //setting chapter
    $(".set--vod__1").click(function() {
        $(this).children().css("display", "none");
        var html = "";
        html += "<div class='wb-stream-sect' style='border: none;'>";
        html += "    <div class='stream-ipt1'>";
        html += "        <input type='text' class='c-name' placeholder='챕터 제목을 입력해주세요.'><button type='button' class='btn-ty2 bor updateChapter' name='"+$(this).attr('name')+"'>확인</button><button type='button' class='btn-ty2 bor vod--chapter__cancle'>취소</button>";
        html += "    </div>";
        html += "</div>";


        $(this).parent().append(html);
    });

    $(document).on('click', '.updateChapter', function () {
        let chapter_id = $(this).attr('name');
        let title = $(this).prev().val();

        $.ajax({
            url: "/exhibition-vod/update-chapter/" + chapter_id,
            method: 'POST',
            type: 'json',
            data: {
                title: title
            },
            success: function () {
                alert('수정되었습니다.');
                location.reload();
            },
            error: function() {
                alert('오류가 발생하였습니다. 잠시 후 다시 시도해주세요.');
                return false;
            }
        });
    });

    //setting chapter cancle btn
    $(document).on("click", ".vod--chapter__cancle", function() {
        $(this).parent().parent().prev().prev().prev().prev().prev().children().css("display", "block");
        $(this).parent().parent().remove();
    });

    // setting vod 
    $(document).on("click", ".set--vod__2", function() {
        $(this).hide();
        var html = '';
        html += '<div class="webinar-cont-ty2">';
        html += '    <form name="uploadForm" id="uploadForm">';
        html += '        <div class="stream-sect">';
        html += '           <div class="row2">';
        html += '               <div class="col-th">VOD 제목</div>';
        html += '                   <div class="col-td">';
        html += '                       <div class="stream-ipt1">';
        html += '                           <input type="text" class="vod-input">';
        html += '                       </div>';
        html += '                   </div>';
        html += '               </div>';
        html += '               <div class="row2">';
        html += '                  <div class="col-th">VOD 설명</div>';
        html += '                      <div class="col-td">';
        html += '                  <div class="stream-ipt1">';
        html += '                      <textarea class="vod-input"></textarea>';
        html += '                  </div>';
        html += '               </div>';
        html += '           </div>';
        html += '        </div>';
        html += '        <div class="wb10-btn">';
        html += '            <button type="button" class="btn3 vod--vod__cancle">취소하기</button>';
        html += '            <button type="button" class="btn3 add-file updateVod" name="'+$(this).attr('name')+'">수정하기</button>';
        html += '        </div>';
        html += '    </form>';
        html += '</div>';
        $(this).parent().append(html);
    });

    //setting vod cancle btn
    $(document).on("click", ".vod--vod__cancle", function() {
        $(this).parent().parent().parent().prev().show();
        $(this).parent().parent().parent().remove();
    });

    //toggle show
    $(document).on("click", ".arrow--vod", function() {
        if ($(this).parent().parent().next().is(":visible")) {
            $(this).parent().parent().next().slideUp();
            $(this).css("transform", "rotate(90deg)");
            $(this).parent().prev().children('.move--vod').css("display", "block");
            $(this).parent().parent().css("margin-bottom", "10px");
        } else {
            $(this).parent().parent().next().slideDown();
            $(this).css("transform", "rotate(0deg)");
            $(this).parent().prev().children('.move--vod').css("display", "none");
            $(this).parent().parent().css("margin-bottom", "60px");
        }
    });

    // window.onload = function() {
    //     if($('.arrow--vod').parent().parent().next().length > 0){
    //         $(this).prev().childern('.arrow--vod__1').children('.arrow--vod').css("display", "none");
    //     }
    //     else {
    //         $(this).css("display", "none");
    //     }
    // };

    //view--vod__1 
    $(document).on("click", "#view--vod__1", function() {
        if ($(this).hasClass('hidden') == false) {
            $.ajax({
                url: "/exhibition-vod/hide-vod/" + $(this).parent().attr('name'),
                method: 'POST',
                type: 'json',
                data: {
                    action: 'hide'
                },
                error: function() {
                    alert('오류가 발생하였습니다. 잠시 후 다시 시도해주세요.');
                    return false;
                }
            });
            $(this).attr("src", "/img/hidden.png");
            $(this).addClass('hidden');
            $(this).parent().parent().addClass('disable');
            $(this).parent().parent().next().children('li.ui-state-default').children('.vod-title').children('.view--vod__2').children('#view--vod__2').attr("src", "/img/hidden.png");
            $(this).parent().parent().next().children('li.ui-state-default').children('.vod-title').children('.vodTitle').addClass('disabled');
        } else if ($(this).hasClass('hidden') == true) {
            $.ajax({
                url: "/exhibition-vod/hide-vod/" + $(this).parent().attr('name'),
                method: 'POST',
                type: 'json',
                data: {
                    action: 'show'
                },
                error: function() {
                    alert('오류가 발생하였습니다. 잠시 후 다시 시도해주세요.');
                    return false;
                }
            });
            $(this).attr("src", "/img/view.png");
            $(this).removeClass('hidden');
            $(this).parent().parent().removeClass('disable');
            $(this).parent().parent().next().children('li.ui-state-default').children('.vod-title').children('.view--vod__2').children('#view--vod__2').attr("src", "/img/view.png");
            $(this).parent().parent().next().children('li.ui-state-default').children('.vod-title').children('.vodTitle').removeClass('disabled');
        }
    });

    //view--vod__2 
    $(document).on("click", "#view--vod__2", function() {
        if ($(this).hasClass('hidden') == false) {
            $.ajax({
                url: "/exhibition-vod/hide-vod/" + $(this).parent().attr('name'),
                method: 'POST',
                type: 'json',
                data: {
                    action: 'hide'
                },
                error: function() {
                    alert('오류가 발생하였습니다. 잠시 후 다시 시도해주세요.');
                    return false;
                }
            });
            $(this).attr("src", "/img/hidden.png");
            $(this).addClass('hidden');
            // $(this).parent().prev().prev().addClass('disable');
            $(this).parent().prev().prev().addClass('disabled');
        } else if ($(this).hasClass('hidden') == true) {
            $.ajax({
                url: "/exhibition-vod/hide-vod/" + $(this).parent().attr('name'),
                method: 'POST',
                type: 'json',
                data: {
                    action: 'show'
                },
                error: function() {
                    alert('오류가 발생하였습니다. 잠시 후 다시 시도해주세요.');
                    return false;
                }
            });
            $(this).attr("src", "/img/view.png");
            $(this).removeClass('hidden');
            // $(this).parent().prev().prev().removeClass('disable');
            $(this).parent().prev().prev().removeClass('disabled');
        }
    });

    //move Div
    $("#sortable").sortable({
        // placeholder:"itemBoxHighlight", /* 이동할 위치 css 적용 */ 
        containment: '.wb--stream__first', //부모 요소 안에서만 이동 범위 제한
        // items: '.ui-state-default',
        handle: '.move--vod',
        cancel: '',
        start: function(event, ui) { // 드래그 시작 시 호출 
        },
        stop: function(event, ui) { // 드래그 종료 시 호출
            let chapters = document.getElementsByClassName('move--vod__1');
            let chapter_ids = [];
            for (let i = 0; i < chapters.length; i++) {
                chapter_ids[i] = chapters[i].name;
            }
            $.ajax({
                url: "/exhibition-vod/sort",
                method: 'POST',
                type: 'json',
                data: {
                    ids: chapter_ids
                }
            });
        }
    });

    $("#sortable2").sortable({
        // placeholder:"itemBoxHighlight", /* 이동할 위치 css 적용 */ 
        containment: '.wb--stream__first', //부모 요소 안에서만 이동 범위 제한
        handle: '.move--vod2',
        cancel: '',
        start: function(event, ui) { // 드래그 시작 시 호출 
        },
        stop: function(event, ui) { // 드래그 종료 시 호출 
            let vods = document.getElementsByClassName($(this)[0].classList[0]);
            let vod_ids = [];
            let j = 1;
            for (let i = 0; i < vods.length - 1; i++) {
                vod_ids[i] = vods[j].name;
                j++;
            }
            $.ajax({
                url: "/exhibition-vod/sort",
                method: 'POST',
                type: 'json',
                data: {
                    ids: vod_ids
                }
            });
        }
    });

    //go top when open tab
    $(document).on("click", ".webinar-tab-tg", function() {
        if (!$("#toggle").hasClass("close")) {
            window.scrollTo(0, 0);
        }
    });

    //button alert  
    $(".btn-alert").hide();
    $("#setting_btn").mouseover(function() {
        $(".btn-alert").show();
    });
    $("#setting_btn").mouseleave(function() {
        $(".btn-alert").hide();
    });

    //datetimepicker
    $(function() {
        $('#vod_sdate').datetimepicker({
            stepping: 30,
            useCurrent: false,
            sideBySide: true
        });
        $('#vod_edate').datetimepicker({
            stepping: 30,
            useCurrent: false,
            sideBySide: true
        });
    });

    //시간 계산
    var date1 = new Date($("#data_vod_sdate").val())
    var date2 = new Date($("#data_vod_edate").val())
    var msec = date2.getTime() - date1.getTime()
    var min = msec / 1000 / 60 % 60
    var hour = msec / 1000 / 60 / 60 % 24
    var day = msec / 1000 / 60 / 60 / 24
    $("#vod_duration").val(Math.floor(day) + " 일 " + Math.floor(hour) + " 시간 " + Math.floor(min) + " 분")

    $('#vod_sdate').on('change.datetimepicker', function(e) {
        var date1 = new Date($("#data_vod_sdate").val())
        var date2 = new Date($("#data_vod_edate").val())
        var msec = date2.getTime() - date1.getTime()
        var min = msec / 1000 / 60 % 60
        var hour = msec / 1000 / 60 / 60 % 24
        var day = msec / 1000 / 60 / 60 / 24
        $("#vod_duration").val(Math.floor(day) + " 일 " + Math.floor(hour) + " 시간 " + Math.floor(min) + " 분")
    });

    $('#vod_edate').on('change.datetimepicker', function(e) {
        var date1 = new Date($("#data_vod_sdate").val())
        var date2 = new Date($("#data_vod_edate").val())
        var msec = date2.getTime() - date1.getTime()
        var min = msec / 1000 / 60 % 60
        var hour = msec / 1000 / 60 / 60 % 24
        var day = msec / 1000 / 60 / 60 / 24
        $("#vod_duration").val(Math.floor(day) + " 일 " + Math.floor(hour) + " 시간 " + Math.floor(min) + " 분")
    });

    var amount = 0;
    var coupon_id = 0;
    var discount_rate = 0;
    var coupon_amount = 0;

    //쿠폰 검증
    function validateCoupon() {
        if (coupon_amount != 0) {
            alert("프로모션이 이미 적용되어 있습니다.");
            return false
        }
        var coupon_code = $("#coupon_code").val();
        $.ajax({
            url: "/exhibition-stream/validate-coupon/",
            method: 'POST',
            type: 'json',
            data: {
                coupon_code: coupon_code,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                if (data.discount_rate != 100) {
                    alert("프로모션이 적용되었습니다.");
                    $("#coupon_code").attr("readonly", true);
                    vod_coupon_amount = removeComma($('input#vod_amount').val()) * data.discount_rate / 100;
                    var cal = removeComma($('input#vod_amount').val()) - (removeComma($('input#vod_amount').val()) * data.discount_rate / 100);
                    $("#vod_amount").val(cal.toLocaleString());

                } else {
                    if (confirm("프로모션 적용으로 무료로 진행되는 행사입니다.\n결제 과정 없이 VOD 송출 설정이 완료되오니 다시한번 확인해주시기 바랍니다.\n사용된 프로모션 키는 재사용이 불가합니다.")) {
                        $("#is_paid").val(1);
                        $("#pay_id").val(0);
                        coupon_id = data.coupon_id;
                        coupon_amount = removeComma($('input#vod_amount').val());
                    }
                }
            } else {
                alert("이미 사용되거나 잘못된 프로모션 키 입니다.\n프로모션 키 번호를 다시 확인해주세요.");
            }
        });
    }




    //파일 컨트롤
    // 파일 리스트 번호
    var fileIndex = 0;
    // 등록할 전체 파일 사이즈
    var totalFileSize = 0;
    // 파일 리스트
    var fileList = new Array();
    // 파일 사이즈 리스트
    var fileSizeList = new Array();
    // 등록 가능한 파일 사이즈 MB
    var uploadSize = 2048;
    // 등록 가능한 총 파일 사이즈 MB
    var maxUploadSize = 10240;

    let check = 0;
    //파일 불러오기
    $(document).on("change", "input[type=file]", function(e) {
        e.preventDefault();
        var file = $(this).prop('files')[0];

        if (file != null) {
            // 업로드 영상 재생시간(db 추가 부분 만들어야됨)
            var video = document.createElement('video');
            video.preload = 'metadata';
            video.onloadedmetadata = function() {
                window.URL.revokeObjectURL(video.src);
                var video_duration = Math.floor(video.duration);
                // console.log(Math.floor(video.duration));
            }
            video.src = URL.createObjectURL(file);

            selectFile(file)
            var html = "<span class='kb'>파일명 : " + file.name + " / 파일 사이즈 : " + (file.size / 1024 / 1024).toFixed(1) + "MB</span>";
            $(this).parent().parent().children(".kb").remove();
            if (check == 0) {
                $(this).parent().parent().append(html);
            }
        }
    });

    // 파일 선택시
    function selectFile(file) {
        // 파일 이름
        var fileName = file.name;
        var fileNameArr = fileName.split("\.");
        // 확장자
        var ext = fileNameArr[fileNameArr.length - 1];
        // 파일 사이즈(단위 :MB)
        var fileSize = file.size / 1024 / 1024;

        if ($.inArray(ext, ['mp4']) < 0) {
            // 확장자 체크
            alert("mp4 형식의 VOD만 등록 가능합니다. 파일 확장자를 확인해주세요.");
            check = 1;
            return false;
        } else if (fileSize > uploadSize) {
            // 파일 사이즈 체크
            alert("용량 초과\n업로드 가능 용량 : " + uploadSize / 1024 + " GB");
            check = 1;
            return false;
        }
    }

    //파일 등록               
    $(document).on("click", ".add-file", function() {
        if ($(this).parent().prev().children().children().children().children().first().val().length == 0) {
            alert("VOD 제목을 입력해주세요.");
            return false;
        }

        if ($(this).parent().prev().prev().prev().prev().prev().children().children(".file").prop("files")[0] == null) {
            alert("VOD를 등록해주세요.");
            return false;
        }

        // 등록할 파일 리스트를 formData로 데이터 입력
        var formData = new FormData();
        var exhibition_id = "<?= $exhibition_id ?>";

        formData.append('file', $(this).parent().prev().prev().prev().prev().prev().children().children(".file").prop("files")[0]);
        formData.append('exhibition_id', exhibition_id);
        formData.append('title', $(this).parent().prev().children().children().children().children().first().val());
        formData.append('description', $(this).parent().prev().children().children().children().children().last().val());
        formData.append('file_size', ($(this).parent().prev().prev().prev().prev().prev().children().children(".file").prop("files")[0].size / 1024 / 1024).toFixed(0));
        formData.append('parent_id', $(this).parent().parent().parent().parent().find(".add-vod").attr("id"));

        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');

        jQuery.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.floor((evt.loaded / evt.total) * 100);

                        /* Do something with upload progress here */
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal);
                        percent.html(percentVal);

                    }
                }, false);
                return xhr;
            },
            url: 'https://orcaexon.co.kr/vod',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            type: 'POST',
            beforeSend: function() {
                // progress Modal 열기
                $("#pleaseWaitDialog").modal('show');

                status.empty();
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);

            },
            complete: function() {
                // progress Modal 닫기
                $("#pleaseWaitDialog").modal('hide');

            },
            error: function(request, status, error) {
                alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
            },

            success: function() {
                alert('저장되었습니다.');
                location.reload();
            }
        });
    });

    //챕터 컨트롤
    $("#add-chapter").click(function() {
        var html = "";
        html += "<div class='wb-stream-sect' style='border: none'>";
        html += "    <div class='stream-ipt1'>";
        html += "        <input type='text' class='c-name' placeholder='챕터 제목을 입력해주세요.'><button type='button' class='btn-ty2 bor chapter-name-btn'>확인</button><button type='button' class='btn-ty2 bor vod--chapter__cancle'>취소</button>";
        html += "    </div>";
        html += "</div>";

        $(".noti").append(html);
    });

    $(document).on("click", ".chapter-name-btn", function() {
        jQuery.ajax({
            url: "/exhibition-vod/add-chapter/<?= $exhibition_id ?>",
            method: 'POST',
            type: 'json',
            data: {
                title: $(this).prev().val(),
            },
            success: function(data) {
                location.reload();
            },
            error: function() {
                alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
            }
        });
    });

    //vod 컨트롤
    $(document).on("click", ".add--vod__2", function() {
        $(this).hide();
        var html = '';
        html += '<div class="webinar-cont-ty2">';
        html += '    <form name="uploadForm" id="uploadForm">';
        html += '        <div class="mouse-area">';
        html += '            <label><span class="ico-plus-c">+</span></button>';
        html += '            <input name="file" type="file" class="file" style="display:none">';
        html += '            <p>클릭하여 VOD를 업로드하세요.</p></label>';
        html += '        </div>';
        html += '        <br><br>';
        html += '        <div id="fileTableTbody" class="data-itmes">';
        html += '        </div>';
        html += '        <div class="stream-sect">';
        html += '           <div class="row2">';
        html += '               <div class="col-th">VOD 제목</div>';
        html += '                   <div class="col-td">';
        html += '                       <div class="stream-ipt1">';
        html += '                           <input type="text" class="vod-input">';
        html += '                       </div>';
        html += '                   </div>';
        html += '               </div>';
        html += '               <div class="row2">';
        html += '                  <div class="col-th">VOD 설명</div>';
        html += '                      <div class="col-td">';
        html += '                  <div class="stream-ipt1">';
        html += '                      <textarea class="vod-input"></textarea>';
        html += '                  </div>';
        html += '               </div>';
        html += '           </div>';
        html += '        </div>';
        html += '        <div class="wb10-btn">';
        html += '            <button type="button" class="btn3 cancel-file">취소하기</button>';
        html += '            <button type="button" class="btn3 add-file">저장하기</button>';
        html += '        </div>';
        html += '    </form>';
        html += '</div>';
        $(this).parent().append(html);
    });

    $(document).on("click", ".add--vod__1", function() {
        $(this).hide();
        var html = '';
        html += '<div class="webinar-cont-ty2">';
        html += '    <form name="uploadForm" id="uploadForm">';
        html += '        <div class="mouse-area">';
        html += '            <label><span class="ico-plus-c">+</span></button>';
        html += '            <input name="file" type="file" id="file_add" class="file" style="display:none">';
        html += '            <p>클릭하여 VOD를 업로드하세요.</p></label>';
        html += '        </div>';
        html += '        <br><br>';
        html += '        <div id="fileTableTbody" class="data-itmes">';
        html += '        </div>';
        html += '        <div class="stream-sect">';
        html += '           <div class="row2">';
        html += '               <div class="col-th">VOD 제목</div>';
        html += '                   <div class="col-td">';
        html += '                       <div class="stream-ipt1">';
        html += '                           <input type="text" class="vod-input">';
        html += '                       </div>';
        html += '                   </div>';
        html += '               </div>';
        html += '               <div class="row2">';
        html += '                  <div class="col-th">VOD 설명</div>';
        html += '                      <div class="col-td">';
        html += '                  <div class="stream-ipt1">';
        html += '                      <textarea class="vod-input"></textarea>';
        html += '                  </div>';
        html += '               </div>';
        html += '           </div>';
        html += '        </div>';
        html += '        <div class="wb10-btn">';
        html += '            <button type="button" class="btn3 cancel-file">취소하기</button>';
        html += '            <button type="button" class="btn3 add-file">저장하기</button>';
        html += '        </div>';
        html += '    </form>';
        html += '</div>';
        $('.add-chapter-div').append(html);
    });

    $(document).on("click", ".cancel-file", function() {
        $(this).parent().parent().parent().parent().parent().find(".add-vod").show();
        $(this).parent().parent().parent().parent().find(".webinar-cont-ty2").remove();
    });

    //삭제
    $(".delete").on("click", function() {
        var id = $(this).attr("name");
        if ($(this).hasClass("c")) {
            if (confirm("챕터 삭제 시 챕터에 포함된 VOD도 삭제됩니다.\n정말 삭제하시겠습니까?")) {
                jQuery.ajax({
                    url: "/exhibition-vod/delete/" + id,
                    method: 'DELETE',
                    type: 'json',
                    success: function(data) {
                        location.reload();
                    },
                    error: function() {
                        alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
                    }
                });
            }
        } else {
            if (confirm("VOD를 삭제하시겠습니까?")) {
                jQuery.ajax({
                    url: "/exhibition-vod/delete/" + id,
                    method: 'DELETE',
                    type: 'json',
                    success: function(data) {
                        location.reload();
                    },
                    error: function() {
                        alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
                    }
                });
            }
        }
    });

    //탭 컨트롤    
    $("#li10").attr("class", "active");

    $("#tab").val("<?= $exhibition->vod_tab ?>");
    var dec = $("#tab").val();
    dec = parseInt(dec);
    var bin = dec.toString(2);
    if (bin.length < 10) {
        var zero = '';
        for (i = 0; i < 10 - bin.length; i++) {
            zero += '0';
        }
        bin = zero + bin;
    }
    for (i = 0; i < bin.length; i++) {
        var result = bin.substring(i, i + 1);
        if (parseInt(result) == 1) {
            $("#li" + i).attr("class", "active");
        }
    }

    $("#btn_tab0").click(function() {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li0").attr("class") == "") {
                $("#li0").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 512);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 활성화되었습니다.');
            } else {
                $("#li0").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 512);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-exhibition-files/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab1").click(function() {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li1").attr("class") == "") {
                $("#li1").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 256);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 활성화되었습니다.');
            } else {
                $("#li1").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 256);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/exhibition-info/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab2").click(function() {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li2").attr("class") == "") {
                $("#li2").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 128);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 활성화되었습니다.');
            } else {
                $("#li2").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 128);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/founder/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab3").click(function() {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li3").attr("class") == "") {
                $("#li3").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 64);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 활성화되었습니다.');
            } else {
                $("#li3").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 64);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/person-in-charge/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab4").click(function() {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li4").attr("class") == "") {
                $("#li4").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 32);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 활성화되었습니다.');
            } else {
                $("#li4").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 32);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-program/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab5").click(function() {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li5").attr("class") == "") {
                $("#li5").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 16);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 활성화되었습니다.');
            } else {
                $("#li5").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 16);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/attendance/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab6").click(function() {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li6").attr("class") == "") {
                $("#li6").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 8);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 활성화되었습니다.');
            } else {
                $("#li6").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 8);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/vod-question-menu/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab7").click(function() {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li7").attr("class") == "") {
                $("#li7").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 4);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 활성화되었습니다.');
            } else {
                $("#li7").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 4);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-notice/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab8").click(function() {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li8").attr("class") == "") {
                $("#li8").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 2);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 활성화되었습니다.');
            } else {
                $("#li8").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 2);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-survey/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab9").click(function() {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li9").attr("class") == "") {
                $("#li9").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 1);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 활성화되었습니다.');
            } else {
                $("#li9").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 1);
                $(".wb-alert2").css({
                    "display": "none"
                });
                $(".wb-alert").html($(this).attr('name') + ' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream-chat-log/chat-not-exist/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab10").click(function() {
        $(".webinar-tab-body").load("/exhibition-stream/vod-chapter-tab/<?= $exhibition->id ?>/");
        $("#li0").attr("class", "");
        $("#li1").attr("class", "");
        $("#li2").attr("class", "");
        $("#li3").attr("class", "");
        $("#li4").attr("class", "");
        $("#li5").attr("class", "");
        $("#li6").attr("class", "");
        $("#li7").attr("class", "");
        $("#li8").attr("class", "");
        $("#li9").attr("class", "");

    });
</script>