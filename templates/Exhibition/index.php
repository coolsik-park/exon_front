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
</style>

<div id="container">        
    <div class="contents static">
        <div class="section-my">
            <h3 class="s-hty1">개설 행사 관리</h3>
            <ul class="s-tabs">
                <?php if ($_SERVER['REQUEST_URI'] == '/exhibition/index/all') { ?>
                    <li class="active"><a href="">개설행사</a></li>
                    <li><a href="/exhibition/index/ongoing">진행중 행사</a></li>
                    <li><a href="/exhibition/index/temp">임시저장 행사</a></li>
                    <li><a href="/exhibition/index/ended">종료 행사</a></li>
                <?php } elseif ($_SERVER['REQUEST_URI'] == '/exhibition/index/ongoing') { ?>
                    <li><a href="/exhibition/index/all">개설행사</a></li>
                    <li class="active"><a href="">진행중 행사</a></li>
                    <li><a href="/exhibition/index/temp">임시저장 행사</a></li>
                    <li><a href="/exhibition/index/ended">종료 행사</a></li>
                <?php } elseif ($_SERVER['REQUEST_URI'] == '/exhibition/index/temp') { ?>
                    <li><a href="/exhibition/index/all">개설행사</a></li>
                    <li><a href="/exhibition/index/ongoing">진행중 행사</a></li>
                    <li class="active"><a href="">임시저장 행사</a></li>
                    <li><a href="/exhibition/index/ended">종료 행사</a></li>
                <?php } else { ?>
                    <li><a href="/exhibition/index/all">개설행사</a></li>
                    <li><a href="/exhibition/index/ongoing">진행중 행사</a></li>
                    <li><a href="/exhibition/index/temp">임시저장 행사</a></li>
                    <li class="active"><a href="">종료 행사</a></li>
                <?php } ?>
            </ul>
            <div class="table-type table-type2" id="table-type table-type2">  
                <?php foreach ($exhibitions as $key => $exhibition): ?>                  
                    <div class="tr-row">
                        <div class="td-col col1">
                            <?php if ($exhibition->image_path != '') : ?>
                            <p class="photo"><img src="<?= DS . $exhibition->image_path . DS . $exhibition->image_name ?>"></p>
                            <?php else : ?>
                            <p class="photo"><img src="../../images/img-no3.png" alt="이미지없음"></p>
                            <?php endif; ?>
                        </div>
                        <div class="td-col col2">
                            <div class="creative">
                                <p class="tit"><?= $exhibition->title ?></p>
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
                                                if ($exhibition->sdate <= $today && $exhibition->edate >= $today) {
                                                    echo '진행중';
                                                } else if($exhibition->edate <= $today) {
                                                    echo '종료';
                                                } else if($exhibition->sdate >= $today) {
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
                        <div class="td-col col5">                           
                            <div class="con">
                                <?php if ($exhibition->status != 4 && $exhibition->edate > $today) : ?>
                                    <p><button type="button" id="urlCopy<?=$exhibition->id?>" name="urlCopy" class="btn-ty3 bor">URL 복사</button></p>
                                <?php else : ?>
                                <p class="btn-ty3 gray">URL 복사</p>
                                <?php endif; ?>    
                                <p><a href="/exhibition/edit/<?= $exhibition->id ?>" class="btn-ty3 bor" id="exhibitionEdit">행사 관리</a></p>
                                <div class="tg-btns">
                                    <button type="button" class="btn-ty3 bor" id="menu">메뉴</button>
                                    <ul>
                                        <?php if ($exhibition->status==4 || ($exhibition->apply_edate>$today && $exhibition_user[$key] == 0)): ?>
                                                <li><button type="button" id="delete<?=$exhibition->id?>" name="deleteExhibition" class="btn-ty3 bor">행사 삭제</button></li>
                                        <?php endif; ?>
                                        <li><button type="button" id="copy<?=$exhibition->id?>" name="copyExhibition" class="btn-ty3 bor">행사 복사</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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
    $(document).on("click", "button[name='deleteExhibition']", function() {
        var id = $(this).attr("id").substr(6, $(this).attr("id").length - 6);

        if (confirm('행사를 삭제하시겠습니까?') == true) {
            $.ajax({
                url: '/exhibition/delete/' + id,
                method: 'POST',
                type: 'json',
                data: {}
            }).done(function(data) {
                if (data.status == 'success') {
                    window.location.reload();
                } else {
                    alert("삭제에 실패하였습니다. 잠시 후 다시 시도해주세요.");
                }
            });   
        } else {
            alert("취소하였습니다.");
        }
    });

    $(document).on("click", "button[name='copyExhibition']", function () {
        var id = $(this).attr("id").substr(4, $(this).attr("id").length - 4);
        
        if (confirm('행사를 복사하시겠습니까?')) {
            $.ajax({
                url: '/exhibition/copy/' + id,
                method: 'POST',
                type: 'json',
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("복사되었습니다.");
                    window.location.replace("/exhibition/index/temp");
                } else {
                    alert("복사에 실패하였습니다. 잠시 후 다시 시도해주세요.");
                }
            });   
        } else {
            alert("취소하였습니다.");
        }
    });

    //url 복사
    $(document).on("click", "button[name='urlCopy']", function () {
        var id = $(this).attr("id").substr(7, $(this).attr("id").length - 7);
        var url = "<?=$front_url?>/exhibition/view/" + id
        const textArea = document.createElement('textarea');
        document.body.appendChild(textArea); 
        textArea.value = "<?=$front_url?>/exhibition/view/" + id;
        
        textArea.select();
        document.execCommand("copy");
        document.body.removeChild(textArea);
        
        alert('복사되었습니다.');
    });
</script>