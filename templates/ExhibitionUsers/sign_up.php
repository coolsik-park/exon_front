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
    .photo {
        cursor: pointer;
    }
    .table-type .td-col .photo {
        border-radius:0;
    }
    .clickTitle {
        cursor: pointer;
    }
    .table-type .td-col .photo{
        background-color: transparent;
    }
    .photos {
        position: relative;
    }
    .photos img {
        position: absolute;
        visibility: hidden;
    }
    .apply-sect3-cont p{
        word-wrap:break-word;
    }
    .height {
        height: 300px;
    }
    .conts {
        text-align: center;
    }
    .btn-ty3 {
        padding-left:0;
        padding-right:0;
    }
    .table-type .td-col .tit {
        word-break:keep-all;
    }
    .sign--title {
        width: 25%;
        text-align: left;
    }
    .table-type .td-col .tit {
        width: 100%;
    }
    .tr-row {
        position: relative;
    }
    @media  screen and (max-width: 768px) {
        .photos img {
            position: absolute;
            margin-left: 0px;
            width: 100%;
        
        }  
        .apply-sect1-cont .photos {
            max-height: 40%;
        }
        .table-type .td-col .btn-ty3 {
            font-size: 0.85rem;
        }
        .table-type .col8 .con {
            flex-wrap: wrap;
        }
        .table-type .td-col .tit.fir {
            width: 25%;
            text-align: left;
        }
        .table-type1 .col3 .con .t1 {
            width: 23%;
        }
        .sign--title {
            width: 100%;
        }
        .table-type1 .col3 .con .tit-con {
            width: 65%;
        }
        .table-type1 .col3 .con {
            margin-top: 70px;
        }
        .sign--date {
            position: absolute;
            top: 215px;
        }
    }
    @media  screen and (min-width: 768px) {
        .photos img {
            
        }
        .photos {
            margin-left: 115px;
            margin-top: 20px;
        }
        .apply-sect1-cont .photos{
            max-width: 38%;
        }
        .titleM {
            display: none;
        }
       
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<div id="container">
    <div class="contents static">
        <div class="section-my">
            <h3 class="s-hty1">?????? ?????? ??????</h3>
            <ul class="s-tabs">
                <?php if ($_SERVER['REQUEST_URI'] == '/exhibition-users/sign-up/application') { ?>
                        <li class="active"><a href="/exhibition-users/sign-up/application">?????? ??????</a></li>
                        <li class=""><a href="/exhibition-users/sign-up/close">?????? ??????</a></li>
                        <li class=""><a href="/exhibition-users/sign-up/cancel">??????/??????</a></li>
                <?php } elseif ($_SERVER['REQUEST_URI'] == '/exhibition-users/sign-up/close') { ?>
                        <li class=""><a href="/exhibition-users/sign-up/application">?????? ??????</a></li>
                        <li class="active"><a href="/exhibition-users/sign-up/close">?????? ??????</a></li>
                        <li class=""><a href="/exhibition-users/sign-up/cancel">??????/??????</a></li>
                <?php } elseif ($_SERVER['REQUEST_URI'] == '/exhibition-users/sign-up/cancel') { ?>
                        <li class=""><a href="/exhibition-users/sign-up/application">?????? ??????</a></li>
                        <li class=""><a href="/exhibition-users/sign-up/close">?????? ??????</a></li>
                        <li class="active"><a href="/exhibition-users/sign-up/cancel">??????/??????</a></li>
                <?php } ?>
            </ul>
            <div class="table-type table-type1">
                <div class="th-row">
                    <div class="th-col col1">?????? ??????</div>
                    <div class="th-col col2">?????? ??????</div>
                    <div class="th-col col3">?????? ??????</div>
                    <div class="th-col col4">?????? ??????</div>
                    <div class="th-col col5">?????? ??????</div>
                    <div class="th-col col6">?????? ??????</div>
                    <div class="th-col col7">?????? ??????</div>
                    <div class="th-col col8"></div>
                </div>
                <?php 
                    foreach ($exhibition_users as $key => $exhibition_user): 
                        $d_today = strtotime(date('Y-m-d H:i:s', time()) . "+9 hours");
                        $sdate = strtotime($exhibition_user->exhibition['sdate']);
                        $sdate_before = strtotime("-1800 seconds" . $exhibition_user->exhibition['sdate']);
                        $edate = strtotime($exhibition_user->exhibition['edate']);
                        $apply_edate = strtotime($exhibition_user->exhibition['apply_edate']);
                        $method = '';
                        $same_day = 0;
                        if (!empty($exhibition_user->pay)) {
                            $method = $exhibition_user->pay['pay_method'];
                            $pay_date = date("Ymd", strtotime($exhibition_user->pay['created']));
                            $now_date = date("Ymd", strtotime(date('Y-m-d H:i:s', time()) . "+9 hours"));
                            if ($pay_date == $now_date) {
                                $same_day = 1;
                            }
                        }
                ?>
                    <div class="tr-row">
                        <div class="td-col col1 sign--date">
                        <p class="tit fir titleM">?????? ??????</p>
                            <div class="con">
                                <div class="date">
                                    <?= date("Y.m.d", strtotime($exhibition_user->created)) ?><br>
                                    <?php 
                                        $hour = date("A", strtotime($exhibition_user->created));
                                        $hour = date("H", strtotime($exhibition_user->created) + 32400);
                                        $min = date("i", strtotime($exhibition_user->created));
                                        $today = new DateTime();
                                        
                                        if ($hour > 12) {
                                            $hour = $hour-12;
                                            echo "?????? " . sprintf("%02d", $hour) . ":" . sprintf("%02d", $min);
                                        } else {
                                            echo "?????? " . sprintf("%02d", $hour) . ":" . sprintf("%02d", $min);
                                        }

                                        if ($d_today > $edate) {
                                            if ($exhibition_user->status == 8) {
                                    ?>
                                                <div class="state">?????? ??????</div>
                                    <?php   } else { ?>
                                                <div class="state">??????</div> 
                                    <?php   
                                            }
                                        } 
                                    ?>
                                </div>
                            </div>                            
                        </div>
                        <div class="td-col col2">
                            <div class="con ag-ty1">
                                <p class="tit tit-name clickTitle sign--title" onclick="window.location.href = '/exhibition/view/<?=$exhibition_user->exhibition['id']?>'"><?= $exhibition_user->exhibition['title'] ?></p>
                                <p id="photos" class="conts height photo" style="overflow: hidden">
                                    <?php if ($exhibition_user->exhibition['image_path'] == null) { ?>
                                        <img src="../../images/img-no3.png" onclick="window.location.href = '/exhibition/view/<?=$exhibition_user->exhibition['id']?>'"  id="photosImg">
                                    <?php } else { ?>
                                        <img style="width: 100%; height: 100%; visibility: visible;" src="<?= DS . $exhibition_user->exhibition['image_path'] . DS . $exhibition_user->exhibition['image_name'] ?>" onclick="window.location.href = '/exhibition/view/<?=$exhibition_user->exhibition['id']?>'" style="visibility: visible;">
                                    <?php } ?>
                                </p>
                            </div>
                        </div>
                        <div class="td-col col3">
                            <div class="con ag-ty1">
                                <p class="tit fir">??????</p>
                                <p class="tit-con">
                                    <?php
                                        $date = date("Y.m.d", strtotime($exhibition_user->exhibition['sdate']));
                                        $hour = date("H", strtotime($exhibition_user->exhibition['sdate']));
                                        $min = date("i", strtotime($exhibition_user->exhibition['sdate'])); 
                                        
                                        if ($hour > 12) {
                                            $hour = $hour-12;
                                            echo $date . " ?????? " . sprintf("%02d", $hour) . ":" . sprintf("%02d ~ ", $min);
                                        } else {
                                            echo $date . " ?????? " . sprintf("%02d", $hour) . ":" . sprintf("%02d ~ ", $min);
                                        }
                                    ?>
                                    <br>
                                    <?php
                                        $date = date("Y.m.d", strtotime($exhibition_user->exhibition['edate']));
                                        $hour = date("H", strtotime($exhibition_user->exhibition['edate']));
                                        $min = date("i", strtotime($exhibition_user->exhibition['edate'])); 
                                        
                                        if ($hour > 12) {
                                            $hour = $hour-12;
                                            echo "</br>" . $date . " ?????? " . sprintf("%02d", $hour) . ":" . sprintf("%02d", $min);
                                        } else {
                                            echo "</br>" . $date . " ?????? " . sprintf("%02d", $hour) . ":" . sprintf("%02d", $min);
                                        }
                                    ?>
                                </p>
                                <p class="tit">
                                    <span class="t1">?????????</span>
                                    <span class="t2"><?= $exhibition_user->exhibition['name'] ?></span>
                                </p>    
                            </div>
                        </div>
                        <div class="td-col col4">
                            <p class="tit fir titleM">?????????</p>
                            <div class="con">
                                <?php
                                    if ($exhibition_user->exhibition_group != null) {
                                        if(number_format(intval($exhibition_user->exhibition_group['amount'])) == 0){
                                            echo "??????";
                                        }
                                        else {
                                            echo number_format(intval($exhibition_user->exhibition_group['amount'])) . "???";
                                        }
                                    } else {
                                        echo '-';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="td-col col5">
                            <p class="tit fir titleM">?????? ??????</p>
                            <div class="con">
                                <?php
                                    if ($exhibition_user->status == 1) {
                                        echo '?????? ???';
                                    } elseif ($exhibition_user->status == 2) {
                                        echo '????????????<br>(????????????)';
                                    } elseif ($exhibition_user->status == 4) {
                                        echo '????????????';
                                    } elseif ($exhibition_user->status == 8) {
                                        echo '??????<br>(??????)';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="td-col col6">
                            <p class="tit fir titleM">?????? ??????</p>
                            <div class="con">
                                <?php
                                    $today = new DateTime();

                                    if ($exhibition_user->attend == 1) {
                                        // if ($d_today > $edate) {
                                        //     echo '??????';
                                        // } 
                                        // else {
                                        //     echo '-';
                                        // }
                                        echo "??????";
                                    } elseif ($exhibition_user->attend == 2) {
                                        echo '??????';
                                    } elseif ($exhibition_user->attend == 4) {
                                        echo '????????????';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="td-col col7">
                        <p class="tit fir titleM">?????????</p>
                            <div class="con">
                                <p><?= $exhibition_user->exhibition_group['name']; ?></p>
                            </div>
                        </div>
                        <div class="td-col col8">
                            <?php if ($exhibition_user->status != 8) : ?>
                                <div class="con">
                                    <?php                         
                                    if ($d_today > $edate):
                                    else:
                                        // if ($d_today >= $sdate):
                                            if ($exhibition_user->status == 4 && $d_today >= $sdate_before):
                                                // echo $d_today . "\n";
                                                // echo $sdate_before;
                                    ?>
                                                <?php if ($exhibition_user->exhibition['is_vod'] == 0) : ?>
                                                    <p><a href="/exhibition-stream/watch-exhibition-stream/<?= $exhibition_user->exhibition_id ?>/<?= $exhibition_user->id ?>" class="btn-ty3 bor" id="exhibitionSee">????????? ??????</a></p>
                                                <?php elseif ($exhibition_user->exhibition['is_vod'] == 1) : ?>
                                                    <p><a href="/exhibition-stream/vod-chapter/<?= $exhibition_user->exhibition_id ?>/<?= $exhibition_user->id ?>" class="btn-ty3 bor" id="exhibitionSee">VOD ??????</a></p>
                                                <?php else : ?>
                                                    <p><a href="/exhibition-stream/watch-exhibition-stream/<?= $exhibition_user->exhibition_id ?>/<?= $exhibition_user->id ?>" class="btn-ty3 bor" id="exhibitionSee">????????? ??????</a></p>
                                                    <p><a href="/exhibition-stream/vod-chapter/<?= $exhibition_user->exhibition_id ?>/<?= $exhibition_user->id ?>" class="btn-ty3 bor" id="exhibitionSee">VOD ??????</a></p>
                                                <?php endif; ?>
                                    <?php
                                            endif;
                                    endif; 
                                    ?>
                                    <p><a href="/exhibition-users/download-pdf/<?= $exhibition_user->exhibition['id'] ?>/<?= $exhibition_user->id ?>" class="btn-ty3 bor">??????</a></p>
                                    <?php                         
                                    if ($d_today > $edate):
                                    else:
                                    ?>
                                    <?php
                                        if ($d_today <= $apply_edate):
                                    ?>
                                        <p><button type="button" class="btn-ty3 red" style="cursor:pointer;" data-toggle="modal" data-target="#signUpCancelModal" data-backdrop="static" data-keyboard="false" onClick="signUpCancel(<?= $key ?>, '<?=$method?>', <?=$same_day?>)">
                                            ????????????
                                        </button></p>
                                    <?php 
                                            endif;
                                    endif;
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div id="popup"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->prev('< ' . __('??????')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('??????') . ' >') ?>
                </ul>
            </div>
        </div>
    </div>        
</div>

<script>
    function signUpCancel(key, method, same_day) {
        var html = '';
        if (method == 'card' || same_day == 1) {
            html += '<div class="modal fade" id="signUpCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
            html += '   <div class="modal-dialog" role="document">';
            html += '        <div class="modal-content" style="background-color:transparent; border:none;">';
            html += '            <div class="popup-wrap popup-ty2">';
            html += '                <div class="popup-head">';
            html += '                    <h1>????????? ?????? ??????</h1>';
            html += '                    <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">????????????</button>';
            html += '                </div>';
            html += '                <div class="popup-body">';
            html += '                    <div class="cert-sect4">';
            html += '                        <p>???????????? ????????? ????????? ?????? ???????????? ????????? ?????????<br class="br-mo">?????? ???????????????.<br>????????? ????????? ?????????????????????????</p>';
            html += '                    </div>';
            html += '                    <div class="popup-btm">';
            html += '                        <button type="button" class="btn-ty2 red" data-dismiss="modal" aria-label="Close">??????</button>';
            html += '                        <button type="button" class="btn-ty2" onClick="signUpCancleOK(' + key + ')">??????</button>';
            html += '                    </div>';
            html += '               </div>';
            html += '           </div>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
        } else {
            html += '<div class="modal fade" id="signUpCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
            html += '   <div class="modal-dialog" role="document">';
            html += '        <div class="modal-content" style="background-color:transparent; border:none;">';
            html += '            <div class="popup-wrap popup-ty2">';
            html += '                <div class="popup-head">';
            html += '                    <h1>????????? ?????? ??????</h1>';
            html += '                    <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">????????????</button>';
            html += '                </div>';
            html += '                <div class="popup-body">';
            html += '                    <div class="cert-sect4">';
            html += '                        <p>??????????????? ?????? ???????????? ??????,<br>????????? ?????? ?????? ??????????????? ???????????? ??????????????? ??????<br>?????? ???????????????. (????????????????????? ???????????????.)<br>?????? ????????? ????????? ??????????????? ???????????????.</p>';
            html += '                    </div>';
            html += '                    <div class="popup-btm">';
            html += '                        <button type="button" class="btn-ty2 red" data-dismiss="modal" aria-label="Close">??????</button>';
            html += '                        <button type="button" class="btn-ty2" onClick="signUpCancleTrans(' + key + ')">??????</button>';
            html += '                    </div>';
            html += '               </div>';
            html += '           </div>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
        }
        $("#popup").html(html);
    }

    function signUpCancleOK(index) {
        var exhibition_users = <?= json_encode($exhibition_users)  ?>;
        var id = exhibition_users[index]['id'];
        var exhibition_id = exhibition_users[index]['exhibition_id'];
        var users_name = exhibition_users[index]['users_name'];
        var users_email = exhibition_users[index]['users_email'];
        var pay_id = exhibition_users[index]['pay_id'];

        $.ajax({
            url: '/exhibition-users/exhibition-users-status',
            method: 'POST',
            type: 'json',
            data: {
                id: id,
                exhibition_id: exhibition_id,
                users_name: users_name,
                email: users_email,
                pay_id: pay_id
            }
        }).done(function(data) {
            if (data.status == 'success') {
                window.location.reload();
            } else {
                alert('?????????????????????. ?????? ??????????????????.');
            }
        });
    }

    function signUpCancleTrans(index) {
        var exhibition_users = <?= json_encode($exhibition_users)  ?>;
        var id = exhibition_users[index]['id'];
        var exhibition_id = exhibition_users[index]['exhibition_id'];
        var users_name = exhibition_users[index]['users_name'];
        var users_email = exhibition_users[index]['users_email'];
        var pay_id = exhibition_users[index]['pay_id'];

        $.ajax({
            url: '/exhibition-users/exhibition-users-status-trans',
            method: 'POST',
            type: 'json',
            data: {
                id: id,
                exhibition_id: exhibition_id,
                users_name: users_name,
                email: users_email,
                pay_id: pay_id
            }
        }).done(function(data) {
            if (data.status == 'success') {
                window.location.replace("/boards/add");
            } else {
                alert('????????? ?????????????????????. ?????? ??? ?????? ??????????????????.');
            }
        });
    }
</script>