<style>
    .paginator {
        text-align: center;
    }

    .pagination {
        display: inline-block;
        width: 100%;
    }

    .pagination li {
        display: inline;
    }

    .board-sh {
        margin: 0 auto;
    } 
    @media  screen and (min-width: 1100px) {
        .modal-dialog {
            margin: 25px auto;
        }
    }

    .pr3-section1 .col1 {
        width: 40%;
    }

    .pr3-section1 .col3 {
        width: 30%;
    }

    .pr3-section1 .col4 {
        width: 10%;
    }

    #vodWatchCheckModal .col1 {
        width: 20%;
    }
    
    #vod_title {
        word-break: break-all;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<div id="container">
    <div class="sub-menu">
        <div class="sub-menu-inner">
            <ul class="tab">
                <li><a href="/exhibition/edit/<?= $id ?>">행사 설정 수정</a></li>
                <li><a href="/exhibition/survey-data/<?= $id ?>">설문 데이터</a></li>
                <li class="active"><a href="">참가자 관리</a></li>
                <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정</a></li>
                <li><a href="/exhibition/exhibition-statistics-apply/<?= $id ?>">행사 통계</a></li>
            </ul>
        </div>
    </div>        
    <div class="contents static">
        <h2 class="sr-only">참가자 관리</h2>
        <div class="pr3-title">                            
            <ul class="s-tabs2">
                <li class="active"><a href="07_cs1.html">참가자</a></li>
                <li><a href="/exhibition/send-sms-to-participant/<?=$id?>">문자</a></li>
                <li><a href="/exhibition/send-email-to-participant/<?=$id?>">이메일</a></li>
                <li><a href="/exhibition/vod-watching/">vod</a></li>
            </ul>
            <h3 class="s-hty1">vod</h3>    
        </div>
        <div class="pr3-section1">
            <div class="table-type table-type3">
                <div class="th-row">
                    <div class="th-col col1">인적사항</div>
                    <div class="th-col col2">조회수</div>
                    <div class="th-col col3">시청 시간</div>
                    <div class="th-col col4">상세보기</div>
                </div>
                <div class="tr-row">
                    <div class="td-col col1">
                        <div class="con ag-ty1">
                            <p class="tit fir">aaa</p>
                            <div class="u-name">
                                <p class="name">이름</p>
                                <p class="age">나이</p>
                            </div>
                            <p>이메일</p>
                            <p>전화번호</p>
                        </div>                            
                    </div>
                    <div class="td-col col2">
                        <div class="con">
                        </div>
                    </div>
                    <div class="td-col col3">
                        <div class="con">
                            <progress value="20" min="0" max="100"></progress>
                            <b>20%</b>
                        </div>
                    </div>
                    <div class="td-col col4">
                        <div class="con">
                            <button type="button" class="btn-ty3 bor" sytle="cursor:pointer;" data-toggle="modal" data-target="#vodWatchCheckModal" data-backdrop="static" data-keyboard="false" onClick="vodWatchCheck()">상세보기</button>
                        </div>
                        <div id="vodCheckPopup"></div>
                    </div>
                </div>
            </div>
        </div>    
    </div>        
</div>
<footer id="footer"></footer>

<script>
    function vodWatchCheck() {
        var html = '';
        html += '<div class="modal fade" id="vodWatchCheckModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        html += '   <div class="modal-dialog" role="document">';
        html += '       <div class="modal-content" style="background-color:transparent; border:none;">';
        html += '           <div class="popup-wrap">';
        html += '               <div class="popup-head">';
        html += '                   <h1 style="text-align:center;">상세 보기</h1>';
        html += '                   <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>';
        html += '               </div>';
        html += '               <div class="popup-body">';
        html += '                   <div class="pop-poll-items-wrap">';
        html += '                       <div class="th-row">';
        html += '                           <div class="th-col col1">인적사항</div>';
        html += '                           <div class="th-col col2">총 조회수</div>';
        html += '                           <div class="th-col col3">총 시청 시간</div>';
        html += '                       </div>';
        html += '                       <div class="tr-row">';
        html += '                           <div class="td-col col1">';
        html += '                               <div class="con ag-ty1">';
        html += '                                   <p class="tit fir">aaa</p>';
        html += '                                  <div class="u-name">';
        html += '                                       <p class="name">이름</p>';
        html += '                                       <p class="age">나이</p>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                           <div class="td-col col2">';
        html += '                               <div class="con">';
        html += '                               </div>';
        html += '                           </div>';
        html += '                           <div class="td-col col3">';
        html += '                               <div class="con">';
        html += '                                   <progress value="20" min="0" max="100"></progress>';
        html += '                                  <b>20%</b>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                       </div>';
        html += '                       <br><br>';
        html += '                       <div class="th-row">';
        html += '                           <div class="th-col col1">VOD 제목</div>';
        html += '                          <div class="th-col col2">시청 여부</div>';
        html += '                           <div class="th-col col3">시청 시간</div>';
        html += '                       </div>';
        html += '                       <div class="tr-row">';
        html += '                           <div class="td-col col1">';
        html += '                               <div class="con">';
        html += '                                   <p id="vod_title"></p>';
        html += '                               </div>';
        html += '                          </div>';
        html += '                           <div class="td-col col2">';
        html += '                               <div class="con">';
        html += '                               </div>';
        html += '                           </div>';
        html += '                           <div class="td-col col3">';
        html += '                               <div class="con">';
        html += '                                   <progress value="20" min="0" max="100"></progress>';
        html += '                                   <b>20%</b>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                       </div>';
        html += '                   </div>';
        html += '               </div>';
        html += '           </div>';
        html += '       </div>';
        html += '   </div>';
        html += '</div>';
        $("#vodCheckPopup").html(html);
    }
</script>