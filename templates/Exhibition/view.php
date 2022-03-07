<style>
    .apply-sect1-cont .photos{
        background-color: transparent;
    }
    .photos {
        position: relative;
    }
    .photos img {
        position: absolute;
        visibility: hidden;
    }
    .apply-sect1-cont .conts h3{
        word-wrap:break-word;
    }
    .height {
        height: 300px;
    }
    .conts {
        text-align: center;
    }
    .apply-sect3-cont {
        word-break:break-all;
        white-space: pre;
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
    }

</style>

<div id="container" class="sub">
    <div class="sub-menu">
        <div class="sub-menu-inner">
            <ul class="tab">
                <li class="active"><a href="#applySect1">신청하기</a></li>
                <!-- <li><a href="#applySect2">개설자 정보</a></li> -->
                <li><a href="#applySect3">상세정보</a></li>
                <li><a href="#applySect4">취소 및 환불 안내</a></li>
                <li><a href="#applySect5">문의</a></li>
            </ul>
        </div>
    </div>
    <div class="contents static cont-wide">       
        <div class="apply-wrap">
            <div class="apply-section apply-sect1" id="applySect1">
                <h2 class="s-hty1">신청하기</h2>
                <div class="apply-sect1-cont">
                    <div id="photos" class="conts height" style="overflow: hidden">
                    <?php if ($exhibition->image_path != '') : ?>
                        <img style="width: 100%; height: 100%; visibility: visible;" src="<?= DS . $exhibition->image_path . DS . $exhibition->image_name ?>" id="photosImg">
                    <?php else : ?>
                        <img src="../../images/img-no3.png" alt="이미지없음" style="visibility: visible;">
                    <?php endif; ?>
                    </div>
                    <div class="conts">
                        <h3><?= $exhibition->title ?></h3>
                        <p class="tx"><?= $exhibition->description ?></p>
                        <ul class="info-list">
                            <li>
                                <span class="dt">모집 일시</span>
                                <span class="dd">
                                    <?php
                                        $weekday = array("(일)", "(월)", "(화)", "(수)", "(목)", "(금)", "(토)");

                                        $apply_sdate = date("m월 d일", strtotime($exhibition->apply_sdate));
                                        $apply_sweek = $weekday[date('w', strtotime($exhibition->apply_sdate))];
                                        $apply_shour = date("H", strtotime($exhibition->apply_sdate));
                                        $apply_smin = date("i", strtotime($exhibition->apply_sdate));

                                        if ($apply_shour > 12) {
                                            $apply_shour = $apply_shour-12;
                                            echo $apply_sdate . $apply_sweek . " 오후 " . sprintf("%02d", $apply_shour) . ":" . sprintf("%02d", $apply_smin) . " ~ ";
                                        } else {
                                            echo $apply_sdate . $apply_sweek . " 오전 " . sprintf("%02d", $apply_shour) . ":" . sprintf("%02d", $apply_smin) . " ~ ";
                                        }

                                        $apply_edate = date("m월 d일", strtotime($exhibition->apply_edate));
                                        $apply_eweek = $weekday[date('w', strtotime($exhibition->apply_edate))];
                                        $apply_ehour = date("H", strtotime($exhibition->apply_edate));
                                        $apply_emin = date("i", strtotime($exhibition->apply_edate));

                                        if ($apply_ehour > 12) {
                                            $apply_ehour = $apply_ehour-12;
                                            echo $apply_edate . $apply_eweek . " 오후 " . sprintf("%02d", $apply_ehour) . ":" . sprintf("%02d", $apply_emin);
                                        } else {
                                            echo $apply_edate . $apply_eweek . " 오전 " . sprintf("%02d", $apply_ehour) . ":" . sprintf("%02d", $apply_emin);
                                        }
                                    ?>
                                </span>
                            </li>
                            <li>
                                <span class="dt">행사 일시</span>
                                <span class="dd">
                                    <?php
                                        $weekday = array("(일)", "(월)", "(화)", "(수)", "(목)", "(금)", "(토)");

                                        $sdate = date("m월 d일", strtotime($exhibition->sdate));
                                        $sweek = $weekday[date('w', strtotime($exhibition->sdate))];
                                        $shour = date("H", strtotime($exhibition->sdate));
                                        $smin = date("i", strtotime($exhibition->sdate));

                                        if ($shour > 12) {
                                            $shour = $shour-12;
                                            echo $sdate . $sweek . " 오후 " . sprintf("%02d", $shour) . ":" . sprintf("%02d", $smin) . " ~ ";
                                        } else {
                                            echo $sdate . $sweek . " 오전 " . sprintf("%02d", $shour) . ":" . sprintf("%02d", $smin) . " ~ ";
                                        }

                                        $edate = date("m월 d일", strtotime($exhibition->edate));
                                        $eweek = $weekday[date('w', strtotime($exhibition->edate))];
                                        $ehour = date("H", strtotime($exhibition->edate));
                                        $emin = date("i", strtotime($exhibition->edate));

                                        if ($ehour > 12) {
                                            $ehour = $ehour-12;
                                            echo $edate . $eweek . " 오후 " . sprintf("%02d", $ehour) . ":" . sprintf("%02d", $emin);
                                        } else {
                                            echo $edate . $eweek . " 오전 " . sprintf("%02d", $ehour) . ":" . sprintf("%02d", $emin);
                                        }
                                    ?>
                                </span>
                            </li>
                            <li>
                                <span class="dt">비용</span>
                                <span class="dd">
                                    <?php if ($exhibition->cost == 'free') {
                                        echo '무료';
                                    } else {
                                        echo '유료';
                                    } ?>
                                </span>
                            </li>
                            <li>
                                <span class="dt">행사 분야 및 유형</span>
                                <span class="dd">
                                    <?php
                                        $catetory = array("문화/예술/여가", "과학/기술", "관광/여행", "사회", "기타", "세미나/컨퍼런스", "강의/교육". "강연", "이벤트/공연/축제", "기타");

                                        for ($i=0; $i<count($catetory); $i++) {
                                            if ($exhibition->category == $i+1) {
                                                echo $catetory[$i] . "  |  ";
                                            }
                                            if ($exhibition->type == $i+1) {
                                                echo $catetory[$i];
                                            }
                                        }
                                    ?>
                                </span>
                            </li>
                        </ul>
                        <div class="btns" id="btns">
                            <?php 
                                // $today = date('Y-m-d H:i:s', time()+32322);
                                // if (date('Y-m-d H:i:s', strtotime($exhibition->apply_sdate)) <= $today && $today <= date('Y-m-d H:i:s', strtotime($exhibition->apply_edate))):
                                    if ($exhibitionUsers == null): 
                            ?>
                                        <div class="group" id="group">
                                            <?= $this->Form->select('', $groups, ['id' => 'group']) ?>                                   
                                            <span class="tx" id="spanGroup"></span>
                                        </div>
                                        <a id="apply_button" href="" class="btn-join" id="btn-join">참가 신청</a>
                            <?php 
                                    else:
                                        if ($exhibitionUsers[0]->status == 4):
                                            if (date('Y-m-d H:i:s', strtotime($exhibition->edate)) >= date('Y-m-d H:i:s', time()+32400)):
                            ?>
                                            <a href="/exhibition-stream/watch-exhibition-stream/<?= $exhibition->id ?>/<?=$users_id?>" class="btn-join" id="btn-join">웨비나 접속</a>
                            <?php
                                            endif;
                                        else:
                            ?>
                                            <div class="group" id="group">
                                                <?= $this->Form->select('', $groups, ['id' => 'group']) ?>
                                                <span class="tx" id="spanGroup"></span>
                                            </div>
                                            <a id="apply_button" href="" class="btn-join" id="btn-join">참가 신청</a>
                            <?php
                                        endif;
                                    endif;
                                // else :
                                    // if ($exhibition->additional == 1):
                            ?>
                                        <!-- <div class="group" id="group">
                                            <?= $this->Form->select('', $groups, ['id' => 'group']) ?>
                                            <span class="tx" id="spanGroup"></span>
                                        </div>
                                        <a id="apply_button" href="" class="btn-join" id="btn-join">참가 신청</a> -->
                            <?php 
                                //     endif;
                                // endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="apply-section apply-sect2" id="applySect2">
                <h2 class="s-hty1">개설자 정보</h2>
                <div class="apply-sect2-cont">
                    <div class="photo">
                        <?php if ($user[0]->image_path != '') : ?>
                            <img src="<?= DS . $user[0]->image_path . DS . $user[0]->image_name ?>" style="width:130px; height:130px;">
                        <?php endif; ?>
                    </div>
                    <div class="info1">
                        <p><?= $user[0]->name ?></p>
                        <?php if ($user[0]->title != null): ?>
                            <p><?= $user[0]->title ?>입니다</p>
                        <?php endif; ?>
                    </div>
                    <div class="info2">
                        <p><?= $user[0]->email ?></p>
                        <p><?= substr($user[0]->hp, 0, 3) ?>-<?= substr($user[0]->hp, 3, 4) ?>-<?= substr($user[0]->hp, 7, 4) ?></p>
                    </div>
                </div>
            </div> -->
            <div class="apply-section apply-sect3" id="applySect3">
                <h2 class="s-hty1">상세 정보</h2>
                <div class="apply-sect3-cont">
                    <?= $exhibition->detail_html ?>
                </div>
                <!-- <div class="apply-sect3-photos">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="../images/@img_square.png" alt="">
                            </div>
                            <div class="swiper-slide">
                                <img src="../images/@img_square.png" alt="">
                            </div>
                            <div class="swiper-slide">
                                <img src="../images/@img_square.png" alt="">
                            </div>
                            <div class="swiper-slide">
                                <img src="../images/@img_square.png" alt="">
                            </div>
                            <div class="swiper-slide">
                                <img src="../images/@img_square.png" alt="">
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>             
                </div> -->
            </div>
            <div class="apply-section apply-sect4" id="applySect4">
                <h2 class="s-hty1">취소 및 환불 안내</h2>
                <div class="apply-sect4-cont">
                    <ul>
                        <li>행사의 신청, 취소, 변경, 환불은 참여신청 기간 내에만 가능합니다.</li>
                        <li>신청한 행사의 신청, 취소, 변경, 환불은 신청내역에서 할 수 있습니다.</li>
                        <li>결제 완료된 행사는 환불 시 결제 수단과 환불 시점에 따라 수수료가 부과될 수 있습니다.</li>
                        <li>신청 마감 이후의 신청 정보 취소, 변경, 환불은 행사 개설자에게 문의 부탁드립니다.</li>
                        <li>행사 그룹 설정, 정원 초과 여부에 따라 대기자로 선정될 수 있습니다.</li>
                        <li>EXON은 통신판매 중개자이며, 해당 행사의 개설자가 아닙니다. 행사 내용에 관한 사항은 개설자에게 문의 바랍니다.</li>
                    </ul>
                </div>
            </div>
            <div class="apply-section apply-sect5" id="applySect5">
                <h2 class="s-hty1">문의</h2>
                <div class="apply-sect5-cont">
                    <div class="info1">
                        <h3>담당자</h3>
                        <p><?= $exhibition->name ?></p>
                    </div>
                    <div class="info2">
                        <h3>이메일</h3>
                        <p><?= $exhibition->email ?></p>
                    </div>
                    <div class="info3">
                        <h3>연락처</h3>
                        <p><?= substr($exhibition->tel, 0, 3) ?>-<?= substr($exhibition->tel, 3, 4) ?>-<?= substr($exhibition->tel, 7, 4) ?></p>
                    </div>
                </div>
            </div>
        </div>        
    </div>        
</div>
<footer id="footer"></footer>

<script>
    ui.slider.photoSlider();

    var tabArea = $('.tab');
    var navBtn = $('.tab li a');
    var tabOffset = $('.tab').offset();
    var tabHeight = $('.tab').outerHeight();

    navBtn.on('click',function(event){
        event.preventDefault();
        $('html,body').stop().animate({scrollTop:$(this.hash).offset().top - tabHeight - 25}, 500);			
    });

    $(window).on('scroll', function(){
        var scltop = $(window).scrollTop();	
        navBtn.each(function(){
            var btn = $(this);
            if(scltop >= $(this.hash).offset().top - tabHeight - 100){
                btn.parent().addClass('active').siblings().removeClass('active');					
            }
        });
        $(window).scrollTop() > 80 ? $('.sub-menu').addClass('sticky') : $('.sub-menu').removeClass('sticky');
    });

    function group() {
        var value = $('#group option:selected').val();
        var group_id = value.split(';')[0];
        var amount = value.split(';')[1];
        amount = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var people_count = value.split(';')[2];

        if (amount != 0) {
            $('#spanGroup').replaceWith('<span class="tx" id="spanGroup">' + amount + '</span>');
        } else {
            $('#spanGroup').replaceWith('<span class="tx" id="spanGroup">무료</span>');
        }
        
        $.ajax({
            url: '/exhibition/group-people-count',
            method: 'POST',
            type: 'json',
            data: {
                group_id: group_id
            }
        }).done(function(data) {
            if (data.status == 'success') {
                if (data.test.length >= people_count) {
                    $('#btn-join').replaceWith('<a href="" class="btn-join" id="btn-join">신청 만료</a>');
                } else {
                    $('#apply_button').replaceWith('<a id="apply_button" href="/exhibition-users/add/<?= $exhibition->id ?>/'+group_id+'" class="btn-join" id="btn-join">참가 신청</a>');
                }
            } else {
                alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
            }
        });
    }

    $(function() {
        group();
    });

    $('#group').on('change', function() {
        group();
    });
</script>