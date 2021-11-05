<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<body onkeydown="enterkey()">
    <div id="container">
        <div class="sub-menu">
            <div class="sub-menu-inner">
                <ul class="tab">
                    <li><a href="/exhibition/edit/<?= $id ?>">행사 설정 수정</a></li>
                    <li><a href="/exhibition/survey-data/<?=$id?>">설문 데이터</a></li>
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
                    <li><a href="/exhibition/manager-person/<?= $id ?>">참가자</a></li>
                    <li><a href="/exhibition/send-sms-to-participant/<?= $id ?>">문자</a></li>
                    <li class="active"><a href="">이메일</a></li>
                </ul>
                <h3 class="s-hty1">이메일</h3>      
            </div>
            <div class="pr3-section3">
                <form id="postForm">
                <div class="pr3-sect">                   
                    <div class="msg-editor">
                        <textarea name="email_content" id="email_content" cols="30" rows="10" placeholder="전송 내용을 입력해 주세요."><?=$text?></textarea>
                        <div class="btns">
                            <button type="button" id="textReset" class="btn-ss">내용 초기화</button>
                        </div>                    
                    </div>
                    <div class="msg-post">
                        <h4 class="s-hty2">보내는 사람</h4>
                        <input type="text" id="name" name="name" class="ipt" placeholder="담당자" value="<?=$name?>">
                        <!-- <input type="text" class="ipt" placeholder="이메일"> -->
                        <div class="btns">
                            <button type="button" id="urlCopy" class="btn-ty2 bor">행사 URL 복사</button>
                            <input type="hidden" id="url" value="<?=FRONT_URL?>/exhibition/view/<?=$id?>">
                            <button type="button" class="btn-ty2 bor" data-toggle="modal" data-target="#listModal">참가자 리스트</button>
                            <!-- bootstrap modal -->
                            <div class="modal list-modal-lg" id="listModal" tabindex="-1" role="dialog" aria-labelledby="listModalLabel" aria-hidden="true">
                                <div class="modal-dialog-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="popup-head">
                                                <h1>참가자 리스트</h1>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="search-box1">
                                                <div class="sel-wp">
                                                    <select id="status">
                                                        <option value=0>승인상태</option>
                                                        <option value=4>참가 확정</option>
                                                        <option value=2>참가 대기</option>
                                                    </select>
                                                    <select id="group">
                                                        <option value=0>그룹명</option>
                                                        <?php
                                                            foreach ($exhibitionGroups as $exhibitionGroup) {
                                                        ?>
                                                        <option value="<?= $exhibitionGroup->id ?>"><?= $exhibitionGroup->name ?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="ipt-search">
                                                    <form id="searchForm">
                                                        <input type="text" id="key" name="key" placeholder="이름">
                                                        <button type="button" id="searchButton"><span class="ico-sh">검색</span></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <br>
                                            <form id="listForm">
                                                <div id="appendWrap">
                                                    <div id="deleteWrap" class="table-type4">
                                                        <div class="th-row">
                                                            <div class="th-col col1">
                                                                <span class="chk-dsg"><input type="checkbox" id="all"><label for="all">전체선택</label></span>   
                                                            </div>                     
                                                            <div class="th-col col2">승인 상태</div>
                                                            <div class="th-col col3">그룹명</div>
                                                            <div class="th-col col4">이름</div>
                                                            <div class="th-col col5">이메일</div>
                                                        </div>
                                                        <?php
                                                            foreach ($listExhibitionUsers as $exhibitionUser) {
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
                                                                    <?php if ($exhibitionUser->exhibition_group != null) : ?>
                                                                    <?= $exhibitionUser->exhibition_group->name ?>
                                                                    <?php endif; ?>
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
                                                                    <?=$exhibitionUser->users_email?>
                                                                    </div>
                                                                </div>                    
                                                            </div>
                                                        </div>   
                                                        <?php
                                                            }
                                                        ?>           
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="close" class="btn-ty2 bor" data-dismiss="modal">취소</button>
                                            <button type="button" id="confirm" class="btn-ty2">확인</button>
                                        </div>
                                    </div>
                                </div>
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
                                $i = 0;
                                foreach ($exhibitionUsers as $exhibitionUser) {
                        ?>
                            <ul>
                                <li>
                                    <div id="number<?=$i?>" name="number" class="number">
                                        <span><?= $exhibitionUser['users_email'] ?></span>
                                        <input type="hidden" name="email" value="<?= $exhibitionUser['users_email'] ?>">
                                        <button type="button" id="<?=$i?>" name="delete" class="btn-x">삭제</button>
                                    </div>
                                </li>                       
                            </ul>
                        <?php 
                                    $i++;
                                }
                            } 
                        ?>
                        </div>
                        <div class="desc">
                            <p id="count" class="txt">받는 사람 : 
                                <?php 
                                    if (!empty($lists)) {
                                        echo count($lists);
                                    } else {
                                        echo 0;
                                    }
                                    
                                ?>
                            </p>
                            <div class="btns">
                                <button type="button" id="listReset" class="btn-ty2 red">목록 초기화</button>
                                <button type="button" id="send" class="btn-ty2">전송하기</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            
        </div>        
    </div>
</body>
    
<script>
    //발송
    $("#send").click(function () {
        var queryString = $("#postForm").serialize();
        var users_email = new Array($("input[name=email]").length);
        
        for (var i = 0; i < $("input[name=email]").length; i++) {
            users_email[i] = $("input[name=email]").eq(i).val();
        }
        
        jQuery.ajax({
            url: "/exhibition/send-email-to-participant/" + <?= $id ?>,
            method: 'POST',
            type: 'json',
            data: queryString + '&users_email=' + users_email,
        }).done(function (data) {
            if (data.status == 'success') {
                alert("전송되었습니다.")
            } else {
                alert("전송에 실패하였습니다. 다시 시도해 주세요.");
            }
        });
    });
    
    //리스트 불러오기
    $("#confirm").click(function () {
        var lists = [];
        $("input[name='list']:checked").each(function(i) { 
            lists.push($(this).val());
        });
        var text = $("#email_content").val();
        var name = $("#name").val();
        
        jQuery.ajax({
            url: "/exhibition/participant-list/" + <?= $id ?>,
            method: 'POST',
            type: 'json',
            data: {
                data : lists,
                text : text,
                name : name
                }   
        }).done(function (data) {
            window.location.href = '/exhibition/send-email-to-participant/' + <?= $id ?>;
        });
    });

    //리스트 전체선택
    $("#all").click(function () {
        if ($("#all").prop("checked")) {
            $("input[name=list]").prop("checked",true);
        } else {
            $("input[name=list]").prop("checked",false);
        }
    });

    //리스트 초기화
    $("#listReset").click(function () {
        $("div[name='number']").each(function () {
            $(this).remove();
        });
        $("#count").html("받는 사람 : 0");
    });

    //리스트 개별 삭제
    $("button[name='delete']").click(function () {
        $("#number" + $(this).attr("id")).remove();
        var count = $("div[name='number']").length;
        $("#count").html("받는 사람 : " + count);
    });

    //입력 초기화
    $("#textReset").click(function() {
        $("#email_content").val("");
    });

    //행사 url 복사
    $("#urlCopy").click(function() {
        $("#url").attr("type", "text");
        var url = document.getElementById("url");
        url.select();
        document.execCommand("copy");
        $("#url").attr("type", "hidden");
        alert("복사되었습니다.");
    });

    //status change
    $("#status").change(function () {
        var status = $(this).val();

        jQuery.ajax({
            url: "/exhibition/sort-by-status/<?= $id ?>/" + status,
            method: 'POST',
            type: 'json',
        }).done(function (data) {
            if (data.status == 'success') {
                var exhibition_users = data.data;
                
                var html = '';
                html+='<div id="deleteWrap" class="table-type4">';
                html+='    <div class="th-row">';
                html+='        <div class="th-col col1">';
                html+='            <span class="chk-dsg"><input type="checkbox" id="all"><label for="all">전체선택</label></span>';   
                html+='        </div>';                     
                html+='        <div class="th-col col2">승인 상태</div>';
                html+='        <div class="th-col col3">그룹명</div>';
                html+='        <div class="th-col col4">이름</div>';
                html+='        <div class="th-col col5">이메일</div>';
                html+='    </div>';

                for (var i =0; i < exhibition_users.length; i++) {
                html+='    <div class="tr-row-wp">';
                html+='        <div class="tr-row">';
                html+='            <div class="td-col col1">';
                html+='                <div class="mo-only">선택</div>';
                html+='                <div class="con">';
                html+='                    <label class="chk-dsg2"><input type="checkbox" name="list" value="'+exhibition_users[i]['id']+'"><span>선택</span></label>';
                html+='                </div>';                  
                html+='            </div>';
                html+='            <div class="td-col col2">';
                html+='                <div class="mo-only">승인 상태</div>';
                html+='                <div class="con">';
                
                if (exhibition_users[i]['status'] == 1) {
                    html+='신청전';
                } else if (exhibition_users[i]['status'] == 2) {
                    html+='신청완료(참가대기)';
                } else if (exhibition_users[i]['status'] == 4) {
                    html+='참가확정';
                } else {
                    html+='취소(환불)';
                }

                html+='                </div>';
                html+='            </div>';
                html+='            <div class="td-col col3">';
                html+='                <div class="mo-only">그룹명</div>';
                html+='                <div class="con">';
                if (exhibition_users[i]['exhibition_group'] != null) {
                    html += exhibition_users[i]['exhibition_group']['name'];
                }
                html+='                </div>';
                html+='            </div>';
                html+='            <div class="td-col col4">';
                html+='                <div class="mo-only">이름</div>';
                html+='                <div class="con">';
                html+='                '+exhibition_users[i]['users_name'];
                html+='                </div>';
                html+='            </div>';
                html+='            <div class="td-col col5">';
                html+='                <div class="mo-only">연락처</div>';
                html+='                <div class="con">';
                html+='                '+exhibition_users[i]['users_email'];
                html+='                </div>';
                html+='            </div>';                    
                html+='        </div>';
                html+='    </div>';   
                }          
                html+='</div>';

                $("#deleteWrap").remove();
                
                $("#appendWrap").append(html);

            } else {
                alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
            }
        });
    });

    //group change
    $("#group").change(function () {
        var group = $(this).val();

        jQuery.ajax({
            url: "/exhibition/sort-by-group/<?= $id ?>/" + group,
            method: 'POST',
            type: 'json',
        }).done(function (data) {
            if (data.status == 'success') {
                var exhibition_users = data.data;
                
                var html = '';
                html+='<div id="deleteWrap" class="table-type4">';
                html+='    <div class="th-row">';
                html+='        <div class="th-col col1">';
                html+='            <span class="chk-dsg"><input type="checkbox" id="all"><label for="all">전체선택</label></span>';   
                html+='        </div>';                     
                html+='        <div class="th-col col2">승인 상태</div>';
                html+='        <div class="th-col col3">그룹명</div>';
                html+='        <div class="th-col col4">이름</div>';
                html+='        <div class="th-col col5">이메일</div>';
                html+='    </div>';

                for (var i =0; i < exhibition_users.length; i++) {
                html+='    <div class="tr-row-wp">';
                html+='        <div class="tr-row">';
                html+='            <div class="td-col col1">';
                html+='                <div class="mo-only">선택</div>';
                html+='                <div class="con">';
                html+='                    <label class="chk-dsg2"><input type="checkbox" name="list" value="'+exhibition_users[i]['id']+'"><span>선택</span></label>';
                html+='                </div>';                  
                html+='            </div>';
                html+='            <div class="td-col col2">';
                html+='                <div class="mo-only">승인 상태</div>';
                html+='                <div class="con">';
                
                if (exhibition_users[i]['status'] == 1) {
                    html+='신청전';
                } else if (exhibition_users[i]['status'] == 2) {
                    html+='신청완료(참가대기)';
                } else if (exhibition_users[i]['status'] == 4) {
                    html+='참가확정';
                } else {
                    html+='취소(환불)';
                }

                html+='                </div>';
                html+='            </div>';
                html+='            <div class="td-col col3">';
                html+='                <div class="mo-only">그룹명</div>';
                html+='                <div class="con">';
                if (exhibition_users[i]['exhibition_group'] != null) {
                    html += exhibition_users[i]['exhibition_group']['name'];
                }
                html+='                </div>';
                html+='            </div>';
                html+='            <div class="td-col col4">';
                html+='                <div class="mo-only">이름</div>';
                html+='                <div class="con">';
                html+='                '+exhibition_users[i]['users_name'];
                html+='                </div>';
                html+='            </div>';
                html+='            <div class="td-col col5">';
                html+='                <div class="mo-only">연락처</div>';
                html+='                <div class="con">';
                html+='                '+exhibition_users[i]['users_email'];
                html+='                </div>';
                html+='            </div>';                    
                html+='        </div>';
                html+='    </div>';   
                }          
                html+='</div>';

                $("#deleteWrap").remove();
                
                $("#appendWrap").append(html);

            } else {
                alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
            }
        });
    });

    //검색 
    $("#searchButton").click(function () {
        var key = $("#key").val();

        jQuery.ajax({
            url: "/exhibition/searchParticipant/<?= $id ?>/" + key,
            method: 'POST',
            type: 'json',
        }).done(function (data) {
            if (data.status == 'success') {
                var exhibition_users = data.data;
                
                var html = '';
                html+='<div id="deleteWrap" class="table-type4">';
                html+='    <div class="th-row">';
                html+='        <div class="th-col col1">';
                html+='            <span class="chk-dsg"><input type="checkbox" id="all"><label for="all">전체선택</label></span>';   
                html+='        </div>';                     
                html+='        <div class="th-col col2">승인 상태</div>';
                html+='        <div class="th-col col3">그룹명</div>';
                html+='        <div class="th-col col4">이름</div>';
                html+='        <div class="th-col col5">이메일</div>';
                html+='    </div>';

                for (var i =0; i < exhibition_users.length; i++) {
                html+='    <div class="tr-row-wp">';
                html+='        <div class="tr-row">';
                html+='            <div class="td-col col1">';
                html+='                <div class="mo-only">선택</div>';
                html+='                <div class="con">';
                html+='                    <label class="chk-dsg2"><input type="checkbox" name="list" value="'+exhibition_users[i]['id']+'"><span>선택</span></label>';
                html+='                </div>';                  
                html+='            </div>';
                html+='            <div class="td-col col2">';
                html+='                <div class="mo-only">승인 상태</div>';
                html+='                <div class="con">';
                
                if (exhibition_users[i]['status'] == 1) {
                    html+='신청전';
                } else if (exhibition_users[i]['status'] == 2) {
                    html+='신청완료(참가대기)';
                } else if (exhibition_users[i]['status'] == 4) {
                    html+='참가확정';
                } else {
                    html+='취소(환불)';
                }

                html+='                </div>';
                html+='            </div>';
                html+='            <div class="td-col col3">';
                html+='                <div class="mo-only">그룹명</div>';
                html+='                <div class="con">';
                if (exhibition_users[i]['exhibition_group'] != null) {
                    html += exhibition_users[i]['exhibition_group']['name'];
                }
                html+='                </div>';
                html+='            </div>';
                html+='            <div class="td-col col4">';
                html+='                <div class="mo-only">이름</div>';
                html+='                <div class="con">';
                html+='                '+exhibition_users[i]['users_name'];
                html+='                </div>';
                html+='            </div>';
                html+='            <div class="td-col col5">';
                html+='                <div class="mo-only">연락처</div>';
                html+='                <div class="con">';
                html+='                '+exhibition_users[i]['users_email'];
                html+='                </div>';
                html+='            </div>';                    
                html+='        </div>';
                html+='    </div>';   
                }          
                html+='</div>';

                $("#deleteWrap").remove();
                
                $("#appendWrap").append(html);

            } else {
                alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
            }
        });
    });

    //엔터키 입력 시
    function enterkey() {
        if (window.event.keyCode == 13) {
            $("#searchButton").click();
        }
    }
</script>  