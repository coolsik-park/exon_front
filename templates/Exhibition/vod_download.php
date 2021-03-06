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
    .clickTitle {
        cursor: pointer;
    }
    .menu-ul {
        z-index: 100;
    }
    .table-type .td-col .photo img {
        width:100%;
    }

    
</style>

<div id="container">        
    <div class="contents static">
        <div class="section-my">
            <h3 class="s-hty1">개설 행사 관리</h3>
            <ul class="s-tabs">
                <?php if (explode('?', $_SERVER['REQUEST_URI'])[0] == '/exhibition/index/all') { ?>
                    <li class="active"><a href="">개설행사</a></li>
                    <li><a href="/exhibition/index/ongoing">진행중 행사</a></li>
                    <li><a href="/exhibition/index/temp">임시저장 행사</a></li>
                    <li><a href="/exhibition/index/ended">종료 행사</a></li>
                    <li><a href="/exhibition/vod-download">VOD 다운로드</a></li>
                <?php } elseif (explode('?', $_SERVER['REQUEST_URI'])[0] == '/exhibition/index/ongoing') { ?>
                    <li><a href="/exhibition/index/all">개설행사</a></li>
                    <li class="active"><a href="">진행중 행사</a></li>
                    <li><a href="/exhibition/index/temp">임시저장 행사</a></li>
                    <li><a href="/exhibition/index/ended">종료 행사</a></li>
                    <li><a href="/exhibition/vod-download">VOD 다운로드</a></li>
                <?php } elseif (explode('?', $_SERVER['REQUEST_URI'])[0] == '/exhibition/index/temp') { ?>
                    <li><a href="/exhibition/index/all">개설행사</a></li>
                    <li><a href="/exhibition/index/ongoing">진행중 행사</a></li>
                    <li class="active"><a href="">임시저장 행사</a></li>
                    <li><a href="/exhibition/index/ended">종료 행사</a></li>
                    <li><a href="/exhibition/vod-download">VOD 다운로드</a></li>
                <?php } elseif (explode('?', $_SERVER['REQUEST_URI'])[0] == '/exhibition/index/ended') { ?>
                    <li><a href="/exhibition/index/all">개설행사</a></li>
                    <li><a href="/exhibition/index/ongoing">진행중 행사</a></li>
                    <li><a href="/exhibition/index/temp">임시저장 행사</a></li>
                    <li class="active"><a href="">종료 행사</a></li>
                    <li><a href="/exhibition/vod-download">VOD 다운로드</a></li>
                <?php } else { ?>
                    <li><a href="/exhibition/index/all">개설행사</a></li>
                    <li><a href="/exhibition/index/ongoing">진행중 행사</a></li>
                    <li><a href="/exhibition/index/temp">임시저장 행사</a></li>
                    <li><a href="/exhibition/index/ended">종료 행사</a></li>
                    <li class="active"><a href="">VOD 다운로드</a></li>
                <?php } ?>
            </ul>
            <div class="table-type table-type2" id="table-type table-type2">  
                <p style="color:red; font-size:15px;">※ VOD 인코딩이 진행중인 행사는 표시되지 않습니다. 잠시 후 새로고침 해주세요.</p>
                <?php 
                    foreach ($exhibitions as $key => $exhibition): 
                        $i = 0;
                        $today = strtotime(date('Y-m-d H:i:s', time() + 32400));
                        $sdate = strtotime($exhibition->sdate);
                        $edate = strtotime($exhibition->edate);
                        $apply_edate = strtotime($exhibition->apply_edate);
                ?>             
                <?php if (!empty($exhibition['exhibition_stream']) && $exhibition['exhibition_stream'][0]['live_duration'] != 0 && $exhibition['exhibition_stream'][0]['vod_index'] != 0) : ?>     
                    <div class="tr-row" onclick="">
                        <div class="clickDiv">
                            <div class="td-col col1">
                                <?php if ($exhibition->image_path != '') : ?>
                                <p class="photo"><img src="<?= DS . $exhibition->image_path . DS . $exhibition->image_name ?>" onclick="window.location.href = '/exhibition/view/<?=$exhibition['id']?>'"></p>
                                <?php else : ?>
                                <p class="photo"><img src="../../images/img-no3.png" alt="이미지없음" onclick="window.location.href = '/exhibition/view/<?=$exhibition['id']?>'"></p>
                                <?php endif; ?>
                            </div>
                            <div class="td-col col2">
                                <div class="creative">
                                    <p class="tit clickTitle" onclick="window.location.href = '/exhibition/view/<?=$exhibition['id']?>'"><?= $exhibition['title'] ?></p>
                                    <p class="ells3"><?= $exhibition->description ?></p>
                                </div>                            
                            </div>
                            <div class="td-col col3">
                                <div class="con">
                                    <p class="tit">
                                        <span class="st1">
                                            <?php
                                                if ($exhibition->status == 4) {
                                                    echo '임시저장';
                                                } else {
                                                    if ($sdate <= $today && $edate >= $today) {
                                                        echo '진행중';
                                                    } else if($edate <= $today) {
                                                        echo '종료';
                                                    } else if($sdate >= $today) {
                                                        echo '행사 시작 전';
                                                    }
                                                }
                                            ?>
                                        </span>
                                    </p>
                                    <p class="tx-1">
                                        <?php
                                            if ($exhibition->cost == 'free') {
                                                echo '무료';
                                            } else {
                                                echo '유료';
                                            }
                                        ?>
                                    </p>
                                </div>                            
                            </div>
                            <div class="td-col col4">
                                <div class="con ag-ty1">
                                    <p class="tit fir">모집 일시</p>
                                    <p class="tx-1">
                                        <?php
                                            if ($exhibition->apply_sdate != '') :
                                                $apply_sdate = date("Y.m.d", strtotime($exhibition->apply_sdate));
                                                $apply_shour = date("H", strtotime($exhibition->apply_sdate));
                                                $apply_smin = date("i", strtotime($exhibition->apply_sdate));
                                            else :
                                                $apply_sdate = '';
                                                $apply_shour = '';
                                                $apply_smin = '';
                                            endif;

                                            if ($exhibition->apply_edate != '') :
                                                $apply_edate = date("Y.m.d", strtotime($exhibition->apply_edate));
                                                $apply_ehour = date("H", strtotime($exhibition->apply_edate));
                                                $apply_emin = date("i", strtotime($exhibition->apply_edate));
                                            else :
                                                $apply_edate = '';
                                                $apply_ehour = '';
                                                $apply_emin = '';
                                            endif;

                                            if ($exhibition->apply_sdate != '') :
                                                if ($apply_shour > 12) {
                                                    $apply_shour = $apply_shour-12;
                                                    echo $apply_sdate . " 오후 " . sprintf("%02d", $apply_shour) . ":" . sprintf("%02d", $apply_smin) . " ~ ";
                                                } else {
                                                    echo $apply_sdate . " 오전 " . sprintf("%02d", $apply_shour) . ":" . sprintf("%02d", $apply_smin) . " ~ ";
                                                }
                                            endif;
                                            
                                            if ($exhibition->apply_edate != '') :
                                                if ($apply_ehour > 12) {
                                                    $apply_ehour = $apply_ehour-12;
                                                    echo $apply_edate . " 오후 " . sprintf("%02d", $apply_ehour) . ":" . sprintf("%02d", $apply_emin);
                                                } else {
                                                    echo $apply_edate . " 오전 " . sprintf("%02d", $apply_ehour) . ":" . sprintf("%02d", $apply_emin);
                                                }
                                            endif;
                                        ?>
                                    </p>
                                    <p class="tit">행사 일시</p>
                                    <p class="tx-1">
                                        <?php
                                            if ($exhibition->sdate != '') :
                                                $sdate = date("Y.m.d", strtotime($exhibition->sdate));
                                                $shour = date("H", strtotime($exhibition->sdate));
                                                $smin = date("i", strtotime($exhibition->sdate));
                                            else :
                                                $sdate = '';
                                                $shour = '';
                                                $smin = '';
                                            endif;

                                            if ($exhibition->edate != '') :
                                                $edate = date("Y.m.d", strtotime($exhibition->edate));
                                                $ehour = date("H", strtotime($exhibition->edate));
                                                $emin = date("i", strtotime($exhibition->edate));
                                            else :
                                                $edate = '';
                                                $ehour = '';
                                                $emin = '';
                                            endif;

                                            if ($exhibition->sdate != '') :
                                                if ($shour > 12) {
                                                    $shour = $shour-12;
                                                    echo $sdate . " 오후 " . sprintf("%02d", $shour) . ":" . sprintf("%02d", $smin) . " ~ ";
                                                } else {
                                                    echo $sdate . " 오전 " . sprintf("%02d", $shour) . ":" . sprintf("%02d", $smin) . " ~ ";
                                                }
                                            endif;

                                            if ($exhibition->edate != '') :
                                                if ($ehour > 12) {
                                                    $ehour = $ehour-12;
                                                    echo $edate . " 오후 " . sprintf("%02d", $ehour) . ":" . sprintf("%02d", $emin);
                                                } else {
                                                    echo $edate . " 오전 " . sprintf("%02d", $ehour) . ":" . sprintf("%02d", $emin);
                                                }
                                            endif;
                                        ?>
                                    </p>
                                </div>                           
                            </div>
                        </div>                            
                        <div class="td-col col5">                           
                            <div class="con">
                                <div class="tg-btns">
                                    <a id="download" name="<?=$i?>" href="https://orcaexon.co.kr/videos/<?=$exhibition['exhibition_stream'][0]['stream_key']?>/EXON_VOD.mp4" class="btn-ty3 bor">다운로드</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
                <?php $i++; ?>
                <?php endforeach; ?>
            </div>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->prev('< ' . __('이전')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('다음') . ' >') ?>
                </ul>
            </div>
        </div>
    </div>        
</div>
<footer id="footer"></footer>

<script>
    //다른 메뉴 클릭 시 열린 메뉴 숨기기 
    $(document).on("click", "#menu", function(){
        if($('.tg-btns').hasClass('open') == true){
            $('.tg-btns').removeClass('open');
            $(this).parent().addClass('open');
        }
    });
    
    //메뉴 버튼 제외하고 영역 클릭시 열린 메뉴 숨기기 
    $('#container').click(function(e){
        if(!$('.section-my').has(e.target).length){
            $('.tg-btns').removeClass('open');
        }
    });

</script>