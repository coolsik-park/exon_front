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
        word-break:keep-all;
    }
    .height {
        height: 300px;
    }
    .conts {
        /* text-align: center; */
    }
    .apply-sect3-cont {
        word-break:keep-all;
    }
    table {
            table-layout: auto;
    }
    .apply-sect1-cont .conts .btns {
        justify-content: space-around;
    }
    .apply-sect3-cont {
        width: 100%;
    }
    .apply-sect3-cont > p > img {
        width: 100%;
    }
    .info-list {
        text-align: left;
    }
    .apply-sect1-cont .conts .btns .group .tx {
        padding-right: 17px;
    }
    .apply-sect1-cont .conts .btns .group select {
        width: 72%;
    }
    .btns {
        display: flex;
        height: 100px;
        flex-direction: column;
        align-items: flex-start;
    }
    .apply-sect1-cont .conts .btns {
        align-items: flex-start;
    }
    .btn__join {
        /* margin-top: 30%; */
    }
    .btn__join2 {
    }
    .apply_btn_div {
        margin-top: 5%;
    }
    .apply-sect1-cont .conts .btns .group {
        width: 350px;
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
        .apply-sect1-cont .conts .btns .btn-join {
            /* margin: 0 auto; */
            width:100%;
        }
        #apply_button {
            width:100%;
        }
        .apply_btn_div {
            display: flex;
            width: 98%;
        }
        .apply_btn_div {
            margin-top: 2%;
            width: 100%;
        }
        .apply-sect1-cont .conts .btns {
            height: 16%;
            align-items: center;
        }
        .btn__join2 {
            margin-left: 2%;
        }
        .btn-live {
            display: flex;
            width: 100%;
        }
        .apply-sect1-cont .conts .btns .group .tx {
            width: 40%;
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
                <li class="active"><a href="#applySect1">????????????</a></li>
                <!-- <li><a href="#applySect2">????????? ??????</a></li> -->
                <li><a href="#applySect3">????????????</a></li>
                <li><a href="#applySect4">?????? ??? ?????? ??????</a></li>
                <li><a href="#applySect5">??????</a></li>
            </ul>
        </div>
    </div>
    <div class="contents static cont-wide">       
        <div class="apply-wrap">
            <div class="apply-section apply-sect1" id="applySect1">
                <h2 class="s-hty1">????????????</h2>
                <div class="apply-sect1-cont">
                    <div id="photos" class="conts height" style="overflow: hidden">
                    <?php if ($exhibition->image_path != '') : ?>
                        <img style="width: 100%; height: 100%; visibility: visible;" src="<?= DS . $exhibition->image_path . DS . $exhibition->image_name ?>" id="photosImg">
                    <?php else : ?>
                        <img src="../../images/img-no3.png" alt="???????????????" style="visibility: visible;">
                    <?php endif; ?>
                    </div>
                    <div class="conts">
                        <h3><?= $exhibition->title ?></h3>
                        <p class="tx" style=" word-break:keep-all;"><?= $exhibition->description ?></p>
                        <ul class="info-list">
                            <li>
                                <span class="dt">?????? ??????</span>
                                <span class="dd">
                                    <?php
                                        $weekday = array("(???)", "(???)", "(???)", "(???)", "(???)", "(???)", "(???)");

                                        $apply_sdate = date("m??? d???", strtotime($exhibition->apply_sdate));
                                        $apply_sweek = $weekday[date('w', strtotime($exhibition->apply_sdate))];
                                        $apply_shour = date("H", strtotime($exhibition->apply_sdate));
                                        $apply_smin = date("i", strtotime($exhibition->apply_sdate));

                                        if ($apply_shour > 12) {
                                            $apply_shour = $apply_shour-12;
                                            echo $apply_sdate . $apply_sweek . " ?????? " . sprintf("%02d", $apply_shour) . ":" . sprintf("%02d", $apply_smin) . " ~ ";
                                        } else {
                                            echo $apply_sdate . $apply_sweek . " ?????? " . sprintf("%02d", $apply_shour) . ":" . sprintf("%02d", $apply_smin) . " ~ ";
                                        }

                                        $apply_edate = date("m??? d???", strtotime($exhibition->apply_edate));
                                        $apply_eweek = $weekday[date('w', strtotime($exhibition->apply_edate))];
                                        $apply_ehour = date("H", strtotime($exhibition->apply_edate));
                                        $apply_emin = date("i", strtotime($exhibition->apply_edate));

                                        if ($apply_ehour > 12) {
                                            $apply_ehour = $apply_ehour-12;
                                            echo $apply_edate . $apply_eweek . " ?????? " . sprintf("%02d", $apply_ehour) . ":" . sprintf("%02d", $apply_emin);
                                        } else {
                                            echo $apply_edate . $apply_eweek . " ?????? " . sprintf("%02d", $apply_ehour) . ":" . sprintf("%02d", $apply_emin);
                                        }
                                    ?>
                                </span>
                            </li>
                            <li>
                                <span class="dt">?????? ??????</span>
                                <span class="dd">
                                    <?php
                                        $weekday = array("(???)", "(???)", "(???)", "(???)", "(???)", "(???)", "(???)");

                                        $sdate = date("m??? d???", strtotime($exhibition->sdate));
                                        $sweek = $weekday[date('w', strtotime($exhibition->sdate))];
                                        $shour = date("H", strtotime($exhibition->sdate));
                                        $smin = date("i", strtotime($exhibition->sdate));

                                        if ($shour > 12) {
                                            $shour = $shour-12;
                                            echo $sdate . $sweek . " ?????? " . sprintf("%02d", $shour) . ":" . sprintf("%02d", $smin) . " ~ ";
                                        } else {
                                            echo $sdate . $sweek . " ?????? " . sprintf("%02d", $shour) . ":" . sprintf("%02d", $smin) . " ~ ";
                                        }

                                        $edate = date("m??? d???", strtotime($exhibition->edate));
                                        $eweek = $weekday[date('w', strtotime($exhibition->edate))];
                                        $ehour = date("H", strtotime($exhibition->edate));
                                        $emin = date("i", strtotime($exhibition->edate));

                                        if ($ehour > 12) {
                                            $ehour = $ehour-12;
                                            echo $edate . $eweek . " ?????? " . sprintf("%02d", $ehour) . ":" . sprintf("%02d", $emin);
                                        } else {
                                            echo $edate . $eweek . " ?????? " . sprintf("%02d", $ehour) . ":" . sprintf("%02d", $emin);
                                        }
                                    ?>
                                </span>
                            </li>
                            <li>
                                <span class="dt">??????</span>
                                <span class="dd">
                                    <?php if ($exhibition->cost == 'free') {
                                        echo '??????';
                                    } else {
                                        echo '??????';
                                    } ?>
                                </span>
                            </li>
                            <li>
                                <span class="dt">?????? ?????? ??? ??????</span>
                                <span class="dd">
                                    <?php
                                        $catetory = array("??????/??????/??????", "??????/??????", "??????/??????", "??????", "??????", "?????????/????????????", "??????/??????". "??????", "?????????/??????/??????", "??????");

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
                        <div class="btns btns-join" id="btns">
                            <?php 
                                // $today = date('Y-m-d H:i:s', time()+32322);
                                // if (date('Y-m-d H:i:s', strtotime($exhibition->apply_sdate)) <= $today && $today <= date('Y-m-d H:i:s', strtotime($exhibition->apply_edate))):
                                    if ($exhibitionUsers == null): 
                            ?>
                                        <div class="group" id="group">
                                            <?= $this->Form->select('', $groups, ['id' => 'group']) ?>                                   
                                            <span class="tx" id="spanGroup"></span>
                                        </div>
                                        <div class="apply_btn_div">
                                                <a id="apply_button" href="" class="btn-join btn__join" id="btn-join" style="margin-right: 2%;">?????? ??????</a>
                                                <a id="apply_button" href="/exhibition-users/sign-up/application" class="btn-join btn__join2">?????? ??????</a>
                                        </div>
                            <?php 
                                    else:
                                        if ($exhibitionUsers[0]->status == 4):
                                            if (date('Y-m-d H:i:s', strtotime($exhibition->edate)) >= date('Y-m-d H:i:s', time()+32400) && date('Y-m-d H:i:s', strtotime($exhibition->sdate)) <= date('Y-m-d H:i:s', time()+34200)):
                            ?>
                                            <?php if ($exhibition->is_vod == 0) : ?>
                                                <a href="/exhibition-stream/watch-exhibition-stream/<?= $exhibition->id ?>/<?=$users_id?>" class="btn-join" id="btn-join">????????? ??????</a>
                                            <?php elseif($exhibition->is_vod == 1) : ?>
                                                <a href="/exhibition-stream/vod-chapter/<?= $exhibition->id ?>/<?=$users_id?>" class="btn-join" id="btn-join">VOD ??????</a>
                                            <?php else : ?>
                                                <div class="btn-live">
                                                    <a href="/exhibition-stream/watch-exhibition-stream/<?= $exhibition->id ?>/<?=$users_id?>" class="btn-join" id="btn-join">????????? ??????</a>
                                                    <a href="/exhibition-stream/vod-chapter/<?= $exhibition->id ?>/<?=$users_id?>" class="btn-join" id="btn-join" style="margin-left:30px;">VOD ??????</a>
                                                </div>
                                            <?php endif; ?>
                            <?php
                                            else:
                            ?>
                                            <a class="btn-join" id="btn-join" style="color:white;">????????? ?????? ???</a>
                            <?php
                                            endif;
                                        else:
                            ?>
                                            <div class="group" id="group">
                                                <?= $this->Form->select('', $groups, ['id' => 'group']) ?>
                                                <span class="tx" id="spanGroup"></span>
                                            </div>
                                            <div class="apply_btn_div">
                                                <a id="apply_button" href="" class="btn-join btn__join" id="btn-join" style="margin-right: 2%;">?????? ??????</a>
                                                <a id="apply_button" href="/exhibition-users/sign-up/application" class="btn-join btn__join2">?????? ??????</a>
                                            </div>
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
                                        <a id="apply_button" href="" class="btn-join" id="btn-join">?????? ??????</a> -->
                            <?php 
                                //     endif;
                                // endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="apply-section apply-sect2" id="applySect2">
                <h2 class="s-hty1">????????? ??????</h2>
                <div class="apply-sect2-cont">
                    <div class="photo">
                        <?php if ($user[0]->image_path != '') : ?>
                            <img src="<?= DS . $user[0]->image_path . DS . $user[0]->image_name ?>" style="width:130px; height:130px;">
                        <?php endif; ?>
                    </div>
                    <div class="info1">
                        <p><?= $user[0]->name ?></p>
                        <?php if ($user[0]->title != null): ?>
                            <p><?= $user[0]->title ?>?????????</p>
                        <?php endif; ?>
                    </div>
                    <div class="info2">
                        <p><?= $user[0]->email ?></p>
                        <p><?= substr($user[0]->hp, 0, 3) ?>-<?= substr($user[0]->hp, 3, 4) ?>-<?= substr($user[0]->hp, 7, 4) ?></p>
                    </div>
                </div>
            </div> -->
            <div class="apply-section apply-sect3" id="applySect3">
                <h2 class="s-hty1">?????? ??????</h2>
                <div class="apply-sect3-cont" style="width: 100%;">
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
                <h2 class="s-hty1">?????? ??? ?????? ??????</h2>
                <div class="apply-sect4-cont">
                    <ul>
                        <li>????????? ??????, ??????, ??????, ????????? ???????????? ?????? ????????? ???????????????.</li>
                        <li>????????? ????????? ??????, ??????, ??????, ????????? ?????????????????? ??? ??? ????????????.</li>
                        <li>?????? ????????? ????????? ?????? ??? ?????? ????????? ?????? ????????? ?????? ???????????? ????????? ??? ????????????.</li>
                        <li>?????? ?????? ????????? ?????? ?????? ??????, ??????, ????????? ?????? ??????????????? ?????? ??????????????????.</li>
                        <li>?????? ?????? ??????, ?????? ?????? ????????? ?????? ???????????? ????????? ??? ????????????.</li>
                        <li>EXON??? ???????????? ???????????????, ?????? ????????? ???????????? ????????????. ?????? ????????? ?????? ????????? ??????????????? ?????? ????????????.</li>
                    </ul>
                </div>
            </div>
            <div class="apply-section apply-sect5" id="applySect5">
                <h2 class="s-hty1">??????</h2>
                <div class="apply-sect5-cont">
                    <div class="info1">
                        <h3>?????????</h3>
                        <p><?= $exhibition->name ?></p>
                    </div>
                    <div class="info2">
                        <h3>?????????</h3>
                        <p><?= $exhibition->email ?></p>
                    </div>
                    <div class="info3">
                        <h3>?????????</h3>
                        <?php if (strlen($exhibition->tel) == 11) : ?>
                            <p><?= substr($exhibition->tel, 0, 3) ?>-<?= substr($exhibition->tel, 3, 4) ?>-<?= substr($exhibition->tel, 7, 4) ?></p>
                        <?php else : ?>
                            <p><?= substr($exhibition->tel, 0, 2) ?>-<?= substr($exhibition->tel, 2, 4) ?>-<?= substr($exhibition->tel, 6, 4) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>        
    </div>        
</div>

<script>
    $(document).on('click', '.tg-menu', function () {
        $('.sub-menu-inner').hide();
        $('#btns').hide();
    });

    $(document).on('click', '.tg-close', function () {
        $('.sub-menu-inner').show();
        $('#btns').show();
    });

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
            $('#spanGroup').replaceWith('<span class="tx" id="spanGroup">' + amount + '???</span>');
        } else {
            $('#spanGroup').replaceWith('<span class="tx" id="spanGroup">??????</span>');
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
                    $('#apply_button').replaceWith('<a href="" class="btn-join" id="#apply_button">?????? ??????</a>');
                } else {
                    $('#apply_button').replaceWith('<a id="apply_button" href="/exhibition-users/add/<?= $exhibition->id ?>/'+group_id+'" class="btn-join" id="btn-join">?????? ??????</a>');
                }
            } else {
                alert("????????? ?????????????????????. ?????? ??? ?????? ??????????????????.");
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