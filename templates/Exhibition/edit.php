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
        right: 0px;
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
    .section1 .sect-tit .btn-ty4 {
        width: 110px;
    }
    .sub-menu .tab > li > a {
        /* font-size: 1.5rem; */
        /* width: 15rem; */
    }
    .sub-menu-inner {
        width: 85%;
        margin: 0;
    }
    @media  screen and (max-width: 768px) {
        .sect1 .photo {
            height: 214px;
        }   
        .btn-wp {
            display: flex;
            justify-content: flex-end;
            margin-top: 6px;
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
        .sub-menu-inner {
            width: 100%;
            margin: 0;
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
        .sub-menu .tab > li > a {
        /* font-size: 0.9rem; */
            /* width: 15rem; */
        }
        .sub-menu-inner {
            width: 85%;
            margin: 0 auto;
        }
    }
    .apply-sect3-cont p{
        word-wrap:break-word;
    }
    .conts {
        text-align: center;
    }
    @media  screen and (max-width: 1300px) {
        /* .btnMove {
            position: fixed;
            z-index: 1;
            right: 0px;
            top: 45px;
        } */
        .sub-menu-inner {
            width: 115%;
            margin: 0;
        }
        .sub-menu .tab > li > a {
        font-size: 1.05rem;
            /* width: 15rem; */
        }
    }
</style>



<?= $this->Form->create($exhibition, ['id' => 'editForm', 'enctype' => 'multipart/form-data', 'autocomplete' => 'autocomplete_off_randString'])?>
    <div id="container">    
        <div class="sub-menu">
            <div class="sub-menu-inner">
                <ul class="tab" >
                    <li class ="active"><a href="">?????? ?????? ??????</a></li>
                    <li><a href="/exhibition/survey-data/<?= $id ?>">?????? ?????????</a></li>
                    <li><a href="/exhibition/manager-person/<?= $id ?>">????????? ??????</a></li>
                    <?php if ($exhibition->is_vod == 0) : ?> 
                    <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">????????? ?????? ??????(?????????)</a></li>
                    <?php elseif ($exhibition->is_vod == 1) : ?>
                    <li><a href="/exhibition-stream/set-exhibition-vod/<?= $id ?>">????????? ?????? ??????(VOD)</a></li>
                    <?php else : ?>
                    <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">????????? ?????? ??????(?????????)</a></li>
                    <li><a href="/exhibition-stream/set-exhibition-vod/<?= $id ?>">????????? ?????? ??????(VOD)</a></li>
                    <?php endif; ?>
                    <li><a href="/exhibition/exhibition-statistics-apply/<?= $id ?>">?????? ??????</a></li>
                </ul>
            </div>
        </div>        
        <div class="contents static">
            <h2 class="sr-only" >?????? ??????</h2>
            <div class="section1">
                <div class="sect-tit">
                    <h3 class="s-hty1">????????????</h3>
                    <div class="btn-wp">
                        <?php if ($exhibition->status == 4) : ?>
                        <button type="button" name="cancel" class="btn-ty4 red">??????</button>
                        <button type="button" name="save" class="btn-ty4">??????</button>
                        <button type="button" name="temp" class="btn-ty4">????????????</button>
                        <?php else : ?>
                        <button type="button" name="cancel" class="btn-ty4 red">??????</button>
                        <button type="button" name="save" class="btn-ty4">??????</button>
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
                            <label id="photos" class="conts" style="overflow: hidden;"for="image"><img class="noImg" src="../../images/img-no3.png" alt="???????????????" style="visibility: visible; height: 100%; width: 100%;"></p>
                            <?php endif; ?>
                        </div>
                        </div>
                        <p class="p-noti">???????????? ???????????? ???????????????.</p>
                        <input type="file" id="image" name="image" style="display:none">
                    </div>
                    <div class="sect1-col2">
                        <div class="row2 fir">
                            <div class="col-th"> <h4 class="s-hty2"><em class="st">*</em>????????????</h4></div>
                            <div class="col-td"><input type="text" id="title" name="title" class="ipt"></div>
                        </div>
                        <div class="row2">
                            <div class="col-th">????????? ?????? ??????</div>
                            <div class="col-td"><input type="text" id="description" name="description" class="ipt"></div>
                        </div>
                        <div class="row2">
                            <div class="col-th">?????? ?????? ??? ??????</div>
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
                    <h4 class="s-hty2"><em class="st">*</em>?????? ??????</h4>
                    <div class="date-sett-wp">
                        <div class="date-sett">
                            <div class="input-group date" id="apply_sdate" data-target-input="nearest">
                                <label for="data_apply_sdate">?????? ??????</label> 
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
                                <label for="data_apply_edate">?????? ??????</label>
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
                    <h4 class="s-hty2"><em class="st">*</em>?????? ??????</h4>
                    <div class="date-sett-wp">
                        <div class="date-sett">
                            <div class="input-group date" id="sdate" data-target-input="nearest">
                                <label for="data_sdate">?????? ??????</label>
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
                                <label for="data_edate">?????? ??????</label>
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
                    <h4 class="s-hty2">???????????? 1???</h4>
                    <p class="p-noti">???????????? 1??? ????????? ????????? ?????????????????????????</p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="is_event" id="is_event1" value="0" checked="checked"><label for="is_event1">????????????</label></span>
                    </div>
                    
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="is_event" id="is_event2" value="1"><label for="is_event2">??????</label></span>
                    </div>
                </div>
                <div id="member_div" class="sect6">
                    <div class="sect-tit">
                        <h4 class="s-hty2"><em class="st">*</em>????????? ??????</h4>
                    </div>
                    <div>
                        <input type="text" id="event_member" name="event_member" placeholder="?????????1, ?????????2??????." class="ipt">
                    </div>
                </div>
                <div class="sect3">
                    <div class="row2">
                        <div class="col-th"><h4 class="s-hty2">???????????????</h4></div>
                        <div class="col-td">
                            <span class="chk-dsg"><input type="radio" id="cost1" name="cost" value="free"><label for="cost1">??????</label></span>
                            <span class="chk-dsg"><input type="radio" id="cost2" name="cost" value="charged"><label for="cost2">??????</label></span>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="section2">
                <h3 class="s-hty1">?????? ??????</h3>
                <div class="sect4">
                    <h4 class="s-hty2">?????? ??????</h4>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="private" id="private1" value="0"><label for="private1">??????</label></span>
                        <p class="p-noti">????????? ??? ????????? ?????? ?????? ??? ??? ????????????.</p>
                    </div>
                    
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="private" id="private2" value="1"><label for="private2">?????????</label></span>
                        <p class="p-noti">?????? URL??? ?????? ????????? ????????? ?????? ??? ??? ????????????.</p>
                    </div>
                </div>
                <div id="group" class="sect5 mgtS1">
                    <h4 class="s-hty2">?????? ??????</h4>
                    <div class="ln-group">
                        <!-- <input id="group_name0" name="group_name0" type="text" class="ipt" placeholder="?????????"> -->
                        <div class="ln-group-wp">
                            <!-- <input id="group_amount0" name="group_amount0" type="text" class="ipt" placeholder="????????? ??????" style="margin-right:20px;">
                            <select class="select">
                                <option>?????? ???</option>
                            </select>
                            <select id="group_people0" name="group_people0" class="select">
                                <option>?????????</option>
                                <option>1,000</option>
                                <option>2,000</option>
                                <option>3,000</option>
                                <option>4,000</option>
                            </select> -->
                            
                        </div>
                    </div>
                    <!-- <p class="p-noti">????????? ??? ?????? ??? ???????????? ?????????????????? ?????????.</p> -->
                </div>
                <a id="addGroup" class="btn-ty3 md" style="margin-top:10px; cursor:pointer">????????????</a>
                <div class="sect4 mgtS1">
                    <h4 class="s-hty2">????????? ?????? ??????</h4>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="auto_approval" id="auto_approval1" value="0"><label for="auto_approval1">?????? ??????</label></span>
                        <p class="p-noti">???????????? ????????? ???????????? ????????? ???????????????.</p>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="auto_approval" id="auto_approval2" value="1"><label for="auto_approval2">?????? ??????</label></span>
                        <p class="p-noti">???????????? ?????? ?????? ????????? ?????? ???????????? ????????? ?????????.</p>
                    </div>
                </div>
                <div class="sect6 mgtS1">
                    <div class="sect-tit">
                        <h4 class="s-hty2">????????? ?????? ??????</h4>
                        <span class="chk-dsg"><input type="checkbox" id="getUser"><label for="getUser">????????? ????????? ????????? ?????? ??????</label></span>
                    </div>
                    <div>
                        <input type="text" id="name" name="name" placeholder="??????" class="ipt">
                        <input type="text" id="tel" name="tel" placeholder="?????????" class="ipt">
                        <input type="text" id="email" name="email" placeholder="?????????" class="ipt">
                        <div class="col-email-wp">
                            <!-- <input type="text" id="email" name="email" placeholder="?????????">
                            <span class="sp">@</span>
                            <select name="" id="">
                                <option value="">??????</option>
                            </select> -->
                        </div>
                    </div>
                </div>
                <div class="sect7 mgtS1">
                    <h4 class="s-hty2">????????? ??????</h4>
                    <p class="p-noti">????????? ????????? ????????? ???????????????.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" id="require_name" name="require_name" value="1" checked="checked" onclick="return false"><label for="require_name">??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_email" name="require_email" value="1" checked="checked" onclick="return false"><label for="require_email">?????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_tel" name="require_tel" value="1"><label for="require_tel">?????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_group" name="require_group" value="1"><label for="require_group">??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_sex" name="require_sex" value="1"><label for="require_sex">??????</label></span>
                    </div>
                </div>
                <div class="sect7 mgtS1">
                    <h4 class="s-hty2">????????? ?????? ??????</h4>
                    <p class="p-noti">????????? ????????? ?????? ????????? ???????????????.(?????? ?????? ??????)</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" id="live" class="is_vod"><label for="live">????????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="vod" class="is_vod"><label for="vod">VOD ??????</label></span>
                    </div>
                </div>
                <input type="hidden" id="live_tab" name="live_tab" value="0">
                <input type="hidden" id="vod_tab" name="vod_tab" value="0">
                <div class="sect7 mgtS1" id="live-tab-div">
                    <h4 class="s-hty2">????????? ??? ??????</h4>
                    <p class="p-noti">????????? ?????? ???????????????.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_9" name="1" checked="checked"><label for="live_9">????????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_5" name="16" checked="checked"><label for="live_5">????????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_8" name="2"><label for="live_8">??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_7" name="4"><label for="live_7">????????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_6" name="8"><label for="live_6">?????? ??????</label></span><br>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_4" name="32"><label for="live_4">????????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_3" name="64"><label for="live_3">????????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_2" name="128"><label for="live_2">????????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_1" name="256"><label for="live_1">?????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_0" name="512"><label for="live_0">??????</label></span>
                    </div>
                </div>
                <div class="sect7 mgtS1" id="vod-tab-div">
                    <h4 class="s-hty2">VOD ??? ??????</h4>
                    <p class="p-noti">????????? ?????? ???????????????.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_8" name="2"><label for="vod_8">??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_7" name="4"><label for="vod_7">????????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_6" name="8"><label for="vod_6">????????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_3" name="64"><label for="vod_3">????????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_2" name="128"><label for="vod_2">????????? ??????</label></span><br>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_1" name="256"><label for="vod_1">?????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_0" name="512"><label for="vod_0">??????</label></span>
                    </div>
                </div>
                <div class="sect7 mgtS1">
                    <h4 class="s-hty2">????????? ?????? ??? ?????? ??????</h4>
                    <p class="p-noti">????????? ?????? ??? ?????? ????????? ???????????????.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="radio" name="require_cert" id="require_cert1" value="1"><label for="require_cert1">????????????</label></span>
                        <span class="chk-dsg"><input type="radio" name="require_cert" id="require_cert2" value="0"><label for="require_cert2">????????????</label></span>
                    </div>
                </div>
                <div class="sect8 mgtS1">
                    <h4 class="s-hty2">?????? ??????</h4>
                    <input type="hidden" id="hidden_detail" value='<?=htmlspecialchars($exhibition->detail_html)?>'>
                    <textarea id="detail_html" name="detail_html" cols="30" rows="10"></textarea>               
                </div>
            </div>
            <div class="section4">
                <h3 class="s-hty1">?????? ??????</h3>
                <!-- <div class="sect9 mgtS1">
                    <h4 class="s-hty3">?????? ??????</h4>
                    <p class="p-noti2">?????? ?????? 1?????? ?????? ???????????? ?????? ?????? ????????? ????????????. </p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="email_notice" id="email_notice1" value="1"><label for="email_notice1">??????</label></span>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="email_notice" id="email_notice2" value="0"><label for="email_notice2">?????? ??????</label></span>
                    </div>
                </div> -->
                <div class="sect9 mgtS1">
                    <h4 class="s-hty3">?????? ??????</h4>
                    <p class="p-noti2">?????? ????????? ????????? ????????? ????????? ???????????????. ??? ??? ???????????? ???????????? ?????? ?????? ?????????.</p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="additional" id="additional1" value="1"><label for="additional1">??????</label></span>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="additional" id="additional2" value="0"><label for="additional2">?????? ??????</label></span>
                    </div>
                </div>
                <div class="sect10 mgtS1">
                    <div class="survey-tit">
                        <h4 class="s-hty3">??????</h4>
                    </div>   
                    <div id="survey">

                    </div>
                    <a id="surveyAdd" class="btn-ty3 md" style="margin-top:10px; cursor:pointer">????????????</a>
                </div>
            </div>

            <div class="section-btm3 mgtS1">
                <?php if ($exhibition->status == 4) : ?>
                <button type="button" name="cancel" class="btn-big red">??????</button>
                <button type="button" name="save" class="btn-big">??????</button>
                <button type="button" name="temp" class="btn-big">????????????</button>
                <?php else : ?>
                <button type="button" name="cancel" class="btn-big red">??????</button>
                <button type="button" name="save" class="btn-big">??????</button>
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
    //is_vod ?????????
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
    
    //?????? ?????? ?????? ?????? ????????? ?????? ?????? ??????
    let live_duration = "<?=$live_duration?>";
    let current_id = "<?=$exhibition->id?>";
    let tmp_ids = [295, 296, 297, 298, 1];
    if (live_duration != 0 && current_id != tmp_ids[0] && current_id != tmp_ids[1] && current_id != tmp_ids[2] && current_id != tmp_ids[3] && current_id != tmp_ids[4]) {
        $("#title").attr("readonly", true);
        $("#data_apply_sdate").attr("readonly", true);
        $("#data_apply_edate").attr("readonly", true);
        $("#data_sdate").attr("readonly", true);
        $("#data_edate").attr("readonly", true);
    }

    //?????? ?????? button scroll??? ?????? 
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

    //????????????
    // $("#require_tel").click(function() {
    //     if ($(this).prop("checked") == true) {
    //         $("#require_email").attr("onclick", "");
    //     } else {
    //         $("#require_email").prop("checked", true);
    //         $("#require_email").attr("onclick", "return false");
    //     }
    // });

    //DB ????????? ????????????
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

    //?????? ????????? ????????????
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
        html += '       <input name="group_name[]" type="text" class="ipt" value="<?=$exhibitionGroup->name?>" placeholder="?????????">';
        html += '       <div class="ln-group-wp">';
        html += '           <input name="group_amount[]" type="text" class="ipt" value="'+comma("<?=$exhibitionGroup->amount?>")+'" placeholder="????????? ??????" style="margin-right:20px;">';
        html += '           <select id="select' + groupIndex + '" name="group_people[]" class="select">';
        html += '               <option value="0">?????????</option>';
        html += '               <option value="50">50</option>';
        html += '               <option value="100">100</option>';
        html += '               <option value="200">200</option>';
        html += '               <option value="300">300</option>';
        html += '               <option value="400">400</option>';
        html += '               <option value="500">500</option>';
        html += '           </select>';
        html += '       </div>';
        html += '   </div>';
        html += '   <p class="p-noti">????????? ??? ?????? ??? ???????????? ?????????????????? ?????????.</p>';
        html += '</div>';
        <?php else : ?>
        var html = '';  
        html += '<div id=group_' + groupIndex + '>';
        html += '   <br>';
        html += '   <div class="ln-group">';
        html += '       <input name="group_id[]" type="hidden" class="ipt" value="<?=$exhibitionGroup->id?>">';
        html += '       <input name="group_name[]" type="text" class="ipt" value="<?=$exhibitionGroup->name?>" placeholder="?????????">';
        html += '       <div class="ln-group-wp">';
        html += '           <input name="group_amount[]" type="text" class="ipt" value="'+comma("<?=$exhibitionGroup->amount?>")+'" placeholder="????????? ??????" style="margin-right:20px;">';
        html += '           <select id="select' + groupIndex + '" name="group_people[]" class="select">';
        html += '               <option value="0">?????????</option>';
        html += '               <option value="50">50</option>';
        html += '               <option value="100">100</option>';
        html += '               <option value="200">200</option>';
        html += '               <option value="300">300</option>';
        html += '               <option value="400">400</option>';
        html += '               <option value="500">500</option>';
        html += '           </select>';
        html += '           <a onclick="deleteGroup(' + groupIndex + ',' + <?=$exhibitionGroup->id?> + ')" class="btn-ty3 md" style="cursor:pointer">??????</a>';
        html += '       </div>';
        html += '   </div>';
        html += '   <p class="p-noti">????????? ??? ?????? ??? ???????????? ?????????????????? ?????????.</p>';
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
        html += '       <input name="group_name[]" type="text" class="ipt" value="<?=$exhibitionGroup->name?>" placeholder="?????????">';
        html += '       <div class="ln-group-wp">';
        html += '           <input name="group_amount[]" type="hidden" class="ipt" value="'+comma("<?=$exhibitionGroup->amount?>")+'" placeholder="????????? ??????" style="margin-right:20px;">';
        html += '           <select id="select' + groupIndex + '" name="group_people[]" class="select">';
        html += '               <option value="0">?????????</option>';
        html += '               <option value="50">50</option>';
        html += '               <option value="100">100</option>';
        html += '               <option value="200">200</option>';
        html += '               <option value="300">300</option>';
        html += '               <option value="400">400</option>';
        html += '               <option value="500">500</option>';
        html += '           </select>';
        html += '       </div>';
        html += '   </div>';
        html += '   <p class="p-noti">????????? ??? ?????? ??? ???????????? ?????????????????? ?????????.</p>';
        html += '</div>';
        <?php else : ?>
        var html = '';  
        html += '<div id=group_' + groupIndex + '>';
        html += '   <br>';
        html += '   <div class="ln-group">';
        html += '       <input name="group_id[]" type="hidden" class="ipt" value="<?=$exhibitionGroup->id?>">';
        html += '       <input name="group_name[]" type="text" class="ipt" value="<?=$exhibitionGroup->name?>" placeholder="?????????">';
        html += '       <div class="ln-group-wp">';
        html += '           <input name="group_amount[]" type="hidden" class="ipt" value="'+comma("<?=$exhibitionGroup->amount?>")+'" placeholder="????????? ??????" style="margin-right:20px;">';
        html += '           <select id="select' + groupIndex + '" name="group_people[]" class="select">';
        html += '               <option value="0">?????????</option>';
        html += '               <option value="50">50</option>';
        html += '               <option value="100">100</option>';
        html += '               <option value="200">200</option>';
        html += '               <option value="300">300</option>';
        html += '               <option value="400">400</option>';
        html += '               <option value="500">500</option>';
        html += '           </select>';
        html += '           <a onclick="deleteGroup(' + groupIndex + ',' + <?=$exhibitionGroup->id?> + ')" class="btn-ty3 md" style="cursor:pointer">??????</a>';
        html += '       </div>';
        html += '   </div>';
        html += '   <p class="p-noti">????????? ??? ?????? ??? ???????????? ?????????????????? ?????????.</p>';
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

    //?????? ????????? ?????? 
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
                alert('????????? ????????? ?????????????????????.\n?????? ??? ?????? ????????? ?????????.');
            }
        });
    });

    //????????? ??????
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

    //?????? ??? ?????????
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

    //?????? ??????
    $(document).on("click", "#addGroup", function() {
        if ($("input[name='cost']:checked").val() == "free") {
            var html = '';
            html += '<div id=group_' + groupIndex + '>';
            html += '   <br>';
            html += '   <div class="ln-group">';
            html += '       <input name="group_id[]" type="hidden" class="ipt" value=0>';
            html += '       <input name="group_name[]" type="text" class="ipt" placeholder="?????????">';
            html += '       <div class="ln-group-wp">';
            html += '           <input name="group_amount[]" type="hidden" class="ipt" placeholder="????????? ??????" value="0" style="margin-right:20px;">';
            html += '           <select name="group_people[]" class="select">';
            html += '               <option value="0">?????????</option>';
            html += '               <option value="50">50</option>';
            html += '               <option value="100">100</option>';
            html += '               <option value="200">200</option>';
            html += '               <option value="300">300</option>';
            html += '               <option value="400">400</option>';
            html += '               <option value="500">500</option>';
            html += '           </select>';
            html += '           <a onclick="deleteGroup(' + groupIndex + ')" class="btn-ty3 md" style="cursor:pointer">??????</a>';
            html += '       </div>';
            html += '   </div>';
            html += '   <p class="p-noti">????????? ??? ?????? ??? ???????????? ?????????????????? ?????????.</p>';
            html += '</div>';
        } else {
            var html = '';
            html += '<div id=group_' + groupIndex + '>';
            html += '   <br>';
            html += '   <div class="ln-group">';
            html += '       <input name="group_id[]" type="hidden" class="ipt" value=0>';
            html += '       <input name="group_name[]" type="text" class="ipt" placeholder="?????????">';
            html += '       <div class="ln-group-wp">';
            html += '           <input name="group_amount[]" type="text" class="ipt" placeholder="????????? ??????" style="margin-right:20px;">';
            html += '           <select name="group_people[]" class="select">';
            html += '               <option value="0">?????????</option>';
            html += '               <option value="50">50</option>';
            html += '               <option value="100">100</option>';
            html += '               <option value="200">200</option>';
            html += '               <option value="300">300</option>';
            html += '               <option value="400">400</option>';
            html += '               <option value="500">500</option>';
            html += '           </select>';
            html += '           <a onclick="deleteGroup(' + groupIndex + ')" class="btn-ty3 md" style="cursor:pointer">??????</a>';
            html += '       </div>';
            html += '   </div>';
            html += '   <p class="p-noti">????????? ??? ?????? ??? ???????????? ?????????????????? ?????????.</p>';
            html += '</div>';
        }
        groupIndex += 1;
        $("#group").append(html);
    });

    //?????? ??????
    function deleteGroup(index, id) {
        var html = '';
        html += '<input name="group_del[]" type="hidden" class="ipt" value="' + id + '">';
        $("#group").append(html);
        $("#group_" + index).remove();
        groupIndex -= 1;
    };

    //????????? ????????? ????????? ????????? ??????
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
    
    //??????
    $(document).on("click", "button[name='save']", function() {
        //Validation
        // if ($("#mainImg").attr("src") == "../../images/img-no3.png") {
        //     alert("?????? ???????????? ??????????????????.");
        //     window.scrollTo(0,0);
        //     return false;
        // }

        if ($("#title").val().length == 0) {
            alert("??????????????? ??????????????????.");
            $("#title").focus();
            return false;
        }

        if ($("#data_apply_sdate").val().length == 0) {
            alert("?????? ??????????????? ??????????????????.");
            $("#apply_sdate").focus();
            return false;
        }

        if ($("#data_apply_edate").val().length == 0) {
            alert("?????? ??????????????? ??????????????????.");
            $("#apply_edate").focus();
            return false;
        }

        if ($("#data_sdate").val().length == 0) {
            alert("?????? ??????????????? ??????????????????.");
            $("#sdate").focus();
            return false;
        }

        if ($("#data_edate").val().length == 0) {
            alert("?????? ??????????????? ??????????????????.");
            $("#edate").focus();
            return false;
        }

        if ($("#name").val().length == 0) {
            alert("????????? ????????? ??????????????????.");
            $("#name").focus();
            return false;
        }

        if ($("#tel").val().length == 0) {
            alert("????????? ???????????? ??????????????????.");
            $("#tel").focus();
            return false;
        }

        if ($("#email").val().length == 0) {
            alert("????????? ???????????? ??????????????????.");
            $("#email").focus();
            return false;
        }

        var group_empty = 0;
        $("input[name='group_name[]']").each(function () {
            if ($(this).val() == '') {
                $(this).val('?????????');
            }
        });

        if ($("input:radio[name='cost']:checked").val() == "charged") {
            $("input[name='group_amount[]']").each(function () {
                if ($(this).val() == '' || $(this).val() == ',000') {
                    alert("?????? ????????? ?????? ????????? ????????? ??????????????????.");
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
                alert("?????? ???????????? ????????? ?????????.");
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
            alert('?????? ?????? ???????????? ?????? ????????? ?????? ??? ??? ????????????.\n?????? ??????????????????.');
            $("#data_apply_edate").focus();
            return false
        }

        if (sdate >= edate) {
            alert('?????? ?????? ???????????? ?????? ????????? ?????? ??? ??? ????????????.\n?????? ??????????????????.');
            $("#data_edate").focus();
            return false
        }

        if ($("#is_event2").prop("checked") == true) {
            if ($("#event_member").val().length == 0) {
                alert('????????? ????????? ??????????????????.');
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
                alert("??????????????? ????????? ???????????? ???????????? ?????? ??? ??? ????????????.\n???????????? ??????????????????.");
                window.location.reload();
                return false;
            }
            // if (data.status == 'success') {

            if (document.getElementById("image").files.length != 0) {
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
                        alert("?????? ???????????????.");
                        window.location.replace("/exhibition/index/all");
                    } else {
                        alert("????????? ?????????????????????. ?????? ??? ??????????????????.");
                    }
                });
            } else {
                alert("?????? ???????????????.");
                window.location.replace("/exhibition/index/all");
            }
            // } else if (data.status == 'exist') {
                // alert("??????????????? ????????? ???????????? ???????????? ?????? ??? ??? ????????????. ???????????? ??????????????????.");
                // window.location.reload();
            // } else {
                // alert("????????? ?????????????????????. ?????? ??? ??????????????????.");
            // }
        });
    });

    //??????
    $("button[name='cancel']").click(function () {
        window.location.replace("/exhibition/index/all");
    });

    //????????????
    $(document).on("click", "button[name='temp']", function() {
        //Validation
        if ($("#title").val().length == 0) {
            alert("??????????????? ??????????????????.");
            $("#title").focus();
            return false;
        }

        var group_empty = 0;
        $("input[name='group_name[]']").each(function () {
            if ($(this).val() == '') {
                $(this).val('?????????');
            }
        });

        if ($("input:radio[name='cost']:checked").val() == "charged") {
            $("input[name='group_amount[]']").each(function () {
                if ($(this).val() == '' || $(this).val() == ',000') {
                    alert("?????? ????????? ?????? ????????? ????????? ??????????????????.");
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
                alert("?????? ???????????? ????????? ?????????.");
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
                alert('?????? ?????? ???????????? ?????? ????????? ?????? ??? ??? ????????????.\n?????? ??????????????????.');
                $("#data_apply_edate").focus();
                return false
            }
        }

        if (sdate != 'Invalid Date') {
            if (sdate >= edate) {
                alert('?????? ?????? ???????????? ?????? ????????? ?????? ??? ??? ????????????.\n?????? ??????????????????.');
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
                if (document.getElementById("image").files.length != 0) {
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
                            alert("?????? ?????? ???????????????.");
                            window.location.replace("/exhibition/index/temp");
                        } else {
                            alert("????????? ?????????????????????. ?????? ??? ??????????????????.");
                        }
                    });
                } else {
                    alert("?????? ?????? ???????????????.");
                    window.location.replace("/exhibition/index/temp");
                }
            } else if (data.status == 'exist') {
                alert("??????????????? ????????? ???????????? ???????????? ?????? ??? ??? ????????????.\n???????????? ??????????????????.");
                window.location.reload();
            } else {
                alert("????????? ?????????????????????. ?????? ??? ??????????????????.");
            }
        });
    });
    
    //??????
    var i = 0; //?????? ?????????
    var j = 0; //?????? ?????????

    //?????? ????????? ????????????
    <?php foreach ($exhibitionSurveys as $exhibitionSurvey) : ?>
        <?php if ($exhibitionSurvey->is_multiple == 'Y' && $exhibitionSurvey->category == null) : ?>
            var html = '';
            html += '<div id="survey_'+i+'" class="survey-bx">';
            html += '    <div class="survey-bx-sect1">';
            html += '        <div class="tits">';
            html += '            <select id="is_multiple_'+i+'" name="is_multiple[]" class="<?=$exhibitionSurvey->id?>">';
            html += '                <option value="Y">?????????</option>';
            html += '                <option value="N">?????????</option>';
            html += '            </select>';
            html += '            <div class="chk-dsg-wp">';
            html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup_'+i+'" value="Y"><label for="dup_'+i+'">?????? ?????? ?????? ??????</label></span>';
            html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+i+'" value="N" checked="checked" style="display:none">';
            html += '                <span class="chk-dsg" id="req_span_'+i+'"><input type="checkbox" name="is_required[]" id="req_'+i+'" value="Y"><label for="req_'+i+'" class="essential">??????</label></span>';
            html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+i+'" value="N" checked="checked" style="display:none">';
            html += '            </div>';                                
            html += '        </div>';
            html += '        <div class="btns">';                                
            html += '            <button type="button" class="btn2" onclick="deleteSurvey('+i+', <?=$exhibitionSurvey->id?>)">??????</button>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="survey-bx-sect2">';
            html += '        <input name="text[]" type="text" class="ipt" placeholder="????????? ???????????????" value="<?=$exhibitionSurvey->text?>">';
            html += '        <input name="survey_id[]" type="hidden" value="<?=$exhibitionSurvey->id?>">'
            html += '        <select id="survey_type_'+i+'" name="survey_type[]">';
            html += '            <option value="N">????????????</option>';
            html += '            <option value="B">????????????</option>';
            html += '        </select>';
            html += '    </div>';
            html += '    <p id="type_noti_'+i+'" class="p-noti_1"></p>';
            html += '    <div id="rows_'+i+'" class="survey-bx-sect3">';
            // html += '        <div class="btns">';
            // html += '            <button type="button" onclick="addRow('+i+')">?????? ??????</button>';
            // html += '        </div>';
            <?php foreach ($exhibitionSurvey->child_exhibition_survey as $child) : ?>
            html += '        <div id="row_'+j+'" class="wrt-after">';
            html += '            <input name="child_text_'+i+'[]" type="text" class="ipt" placeholder="??????" value="<?=$child->text?>">';
            html += '            <input name="child_survey_id_'+i+'[]" type="hidden" value="<?=$child->id?>">'
            // html += '            <button type="button" class="btn-del" onclick="deleteRow('+j+', <?=$child->id?>)">?????? ??????</button>';
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
                $("#type_noti_" + i).html("?????????????????? ??????????????? ?????? ?????? ?????? ?????????????????? ????????? ????????? ??? ????????????.");
            <?php else : ?>
                $("#type_noti_" + i).html("?????????????????? ??????????????? ?????? ?????? ??? ?????????????????? ????????? ????????? ??? ????????????.");
            <?php endif; ?>

        <?php else : ?>
            var html = '';
            html += '<div id="survey_'+i+'" class="survey-bx">';
            html += '<div class="survey-bx-sect1">';
            html += '    <div class="tits">';
            html += '        <select id="is_multiple_'+i+'" name="is_multiple[]" class="<?=$exhibitionSurvey->id?>">';
            html += '            <option value="Y">?????????</option>';
            html += '            <option selected="selected" value="N">?????????</option>';
            html += '        </select>';
            html += '        <div class="chk-dsg-wp">';
            html += '            <span class="chk-dsg" id="req_span_'+i+'"><input type="checkbox" name="is_required[]" id="req_'+i+'" value="Y"><label for="req_'+i+'" class="essential">??????</label></span>';
            html += '            <input type="checkbox" name="is_required[]" id="req_hidden_'+i+'" value="N" checked="checked" style="display:none">';
            html += '        </div>';                           
            html += '    </div>';
            html += '    <div class="btns">';                          
            html += '       <button type="button" class="btn2" onclick="deleteSurvey('+i+', <?=$exhibitionSurvey->id?>)">??????</button>';
            html += '    </div>';
            html += '</div>';
            html += '<div class="survey-bx-sect2">';
            html += '    <input name="text[]" type="text" class="ipt" placeholder="????????? ???????????????" value="<?=$exhibitionSurvey->text?>">';
            html += '    <input name="survey_id[]" type="hidden" value="<?=$exhibitionSurvey->id?>">';
            html += '    <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+i+'" value="N" checked="checked" style="display:none">';
            html += '    <select id="survey_type_'+i+'" name="survey_type[]">';
            html += '        <option value="N">????????????</option>';
            html += '        <option value="B">????????????</option>';
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
                $("#type_noti_" + i).html("?????????????????? ??????????????? ?????? ?????? ?????? ?????????????????? ????????? ????????? ??? ????????????.");
            <?php else : ?>
                $("#type_noti_" + i).html("?????????????????? ??????????????? ?????? ?????? ??? ?????????????????? ????????? ????????? ??? ????????????.");
            <?php endif; ?>
        <?php endif; ?>
        i++;
    <?php endforeach; ?>

    //?????? ??????
    $("#surveyAdd").click(function () {
        var html = '';
        html += '<div id="survey_'+i+'" class="survey-bx">';
        html += '    <div class="survey-bx-sect1">';
        html += '        <div class="tits">';
        html += '            <select id="is_multiple_'+i+'" name="is_multiple[]" class="0">';
        html += '                <option value="Y">?????????</option>';
        html += '                <option value="N">?????????</option>';
        html += '                <option value="S">?????????</option>';
        html += '            </select>';
        html += '            <div class="chk-dsg-wp">';
        html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup_'+i+'" value="Y"><label for="dup_'+i+'">?????? ?????? ?????? ??????</label></span>';
        html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+i+'" value="N" checked="checked" style="display:none">';
        html += '                <span class="chk-dsg" id="req_span_'+i+'" style="display:none;"><input type="checkbox" name="is_required[]" id="req_'+i+'" value="Y"><label for="req_'+i+'" class="essential">??????</label></span>';
        html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+i+'" value="N" checked="checked" style="display:none">';
        html += '            </div>';                                
        html += '        </div>';
        html += '        <div class="btns">';                                
        html += '            <button type="button" class="btn2" onclick="deleteSurvey('+i+', 0)">??????</button>';
        html += '        </div>';
        html += '    </div>';
        html += '    <div class="survey-bx-sect2">';
        html += '        <input name="text[]" type="text" class="ipt" placeholder="????????? ???????????????">';
        html += '        <input name="survey_id[]" type="hidden" value="0">';
        html += '        <select id="survey_type_'+i+'" name="survey_type[]">';
        html += '            <option value="N">????????????</option>';
        html += '            <option value="B">????????????</option>';
        html += '        </select>';
        html += '    </div>';
        html += '    <p id="type_noti_'+i+'" class="p-noti_1">?????????????????? ??????????????? ?????? ?????? ?????? ?????????????????? ????????? ????????? ??? ????????????.</p>';
        html += '    <div id="rows_'+i+'" class="survey-bx-sect3">';
        html += '        <div class="btns">';
        html += '            <button type="button" onclick="addRow('+i+')">?????? ??????</button>';
        html += '        </div>';
        html += '        <div id="row_'+j+'" class="wrt-after">';
        html += '            <input name="child_text_'+i+'[]" type="text" class="ipt" placeholder="??????">';
        html += '            <input name="child_survey_id_'+i+'[]" type="hidden" value="0">'
        html += '            <button type="button" class="btn-del" onclick="deleteRow('+j+', 0)">?????? ??????</button>';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';
        i++;
        j++;
        $("#survey").append(html);
    });

    //?????? ??????
    function deleteSurvey(index, id) {
        var html = '';
        html += '<input name="survey_del[]" type="hidden" value="' + id + '">';
        $("#survey").append(html);
        $("#survey_" + index).remove();
        // i--;
    };

    //?????? ??????
    function addRow(index) {
        var html = '';
        html += '<div id="row_'+j+'" class="wrt-after">';
        html += '   <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="??????">';
        html += '   <input name="child_survey_id_'+i+'[]" type="hidden" value="0">'
        html += '   <button type="button" class="btn-del" onclick="deleteRow('+j+', 0)">?????? ??????</button>';
        html += '</div>';
        $("#rows_" + index).append(html);
        j++;
    };

    //?????? ??????
    function deleteRow(index, id) {
        // var html = '';
        // html += '<input name="child_survey_del[]" type="hidden" value="' + id + '">';
        // $("#survey").append(html);
        $("#row_" + index).remove();
        j--;
    };

    //?????????/????????? ??????
    $(document).on("click", "select[name='is_multiple[]']", function() {
    
    });
    
    $(document).on("change", "select[name='is_multiple[]']", function() {
        
        if ($(this).attr("class") != 0) {
            alert("????????? ????????? ?????????/????????? ????????? ?????????????????? ?????? ??? ?????? ????????? ?????????.");
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
            html += '            <option value="Y">?????????</option>';
            html += '            <option selected="selected" value="N">?????????</option>';
            html += '            <option value="S">?????????</option>';
            html += '        </select>';
            html += '        <div class="chk-dsg-wp">';
            html += '                <span class="chk-dsg" id="req_span_'+index+'" style="display:none;"><input type="checkbox" name="is_required[]" id="req_'+index+'" value="Y"><label for="req_'+index+'" class="essential">??????</label></span>';
            html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '        </div>';                           
            html += '    </div>';
            html += '    <div class="btns">';                          
            html += '       <button type="button" class="btn2" onclick="deleteSurvey('+index+', 0)">??????</button>';
            html += '    </div>';
            html += '</div>';
            html += '<div class="survey-bx-sect2">';
            html += '    <input name="text[]" type="text" class="ipt" placeholder="????????? ???????????????">';
            html += '    <input name="survey_id[]" type="hidden" value="0">';
            html += '    <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '    <select id="survey_type_'+index+'" name="survey_type[]">';
            html += '        <option value="N">????????????</option>';
            html += '        <option value="B">????????????</option>';
            html += '    </select>';
            html += '</div>';
            html += '<p id="type_noti_'+index+'" class="p-noti_1">?????????????????? ??????????????? ?????? ?????? ?????? ?????????????????? ????????? ????????? ??? ????????????.</p>';
            
            $("#survey_" + index).children().remove();
            $("#survey_" + index).append(html);
        
        } else if ($("option:selected", this).val() == 'Y') {
            var index = $(this).attr("id").substr($(this).attr("id"));
            index = index.split("_")[2]
            
            var html = '';
            html += '    <div class="survey-bx-sect1">';
            html += '        <div class="tits">';
            html += '            <select id="is_multiple_'+index+'" name="is_multiple[]" class="0">';
            html += '                <option value="Y">?????????</option>';
            html += '                <option value="N">?????????</option>';
            html += '                <option value="S">?????????</option>';
            html += '            </select>';
            html += '            <div class="chk-dsg-wp">';
            html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup_'+index+'" value="Y"><label for="dup_'+index+'">?????? ?????? ?????? ??????</label></span>';
            html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+index+'" value="N" checked="checked" style="display:none;">';
            html += '                <span class="chk-dsg" id="req_span_'+index+'" style="display:none;"><input type="checkbox" name="is_required[]" id="req_'+index+'" value="Y"><label for="req_'+index+'"class="essential">??????</label></span>';
            html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '            </div>';                                
            html += '        </div>';
            html += '        <div class="btns">';                                
            html += '            <button type="button" class="btn2" onclick="deleteSurvey('+index+', 0)">??????</button>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="survey-bx-sect2">';
            html += '        <input name="text[]" type="text" class="ipt" placeholder="????????? ???????????????">';
            html += '        <input name="survey_id[]" type="hidden" value="0">';
            html += '        <select id="survey_type_'+index+'" name="survey_type[]">';
            html += '            <option value="N">????????????</option>';
            html += '            <option value="B">????????????</option>';
            html += '        </select>';
            html += '    </div>';
            html += '    <p id="type_noti_'+index+'" class="p-noti_1">?????????????????? ??????????????? ?????? ?????? ?????? ?????????????????? ????????? ????????? ??? ????????????.</p>';
            html += '    <div id="rows_'+index+'" class="survey-bx-sect3">';
            html += '        <div class="btns">';
            html += '            <button type="button" onclick="addRow('+index+')">?????? ??????</button>';
            html += '        </div>';
            html += '        <div id="row_'+j+'" class="wrt-after">';
            html += '            <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="??????">';
            html += '            <input name="child_survey_id_'+index+'[]" type="hidden" value="0">'
            html += '            <button type="button" class="btn-del" onclick="deleteRow('+j+', 0)">?????? ??????</button>';
            html += '        </div>';
            html += '    </div>';

            j++;
            $("#survey_" + index).children().remove();
            $("#survey_" + index).append(html);
        } else if ($("option:selected", this).val() == 'S') {
            var index = $(this).attr("id").substr($(this).attr("id"));
            index = index.split("_")[2];
            var html = '';
            html += '    <div class="survey-bx-sect1">';
            html += '        <div class="tits">';
            html += '            <select id="is_multiple_'+index+'" name="is_multiple[]" class="0">';
            html += '                <option value="Y">?????????</option>';
            html += '                <option value="N">?????????</option>';
            html += '                <option selected="selected" value="S">?????????</option>';
            html += '            </select>';
            html += '            <div class="chk-dsg-wp">';
            html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup_'+index+'" value="Y"><label for="dup_'+index+'">?????? ?????? ?????? ??????</label></span>';
            html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+index+'" value="N" checked="checked" style="display:none;">';
            html += '                <span class="chk-dsg" id="req_span_'+index+'" style="display:none;"><input type="checkbox" name="is_required[]" id="req_'+index+'" value="Y"><label for="req_'+index+'" class="essential">??????</label></span>';
            html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '            </div>';                                
            html += '        </div>';
            html += '        <div class="btns">';                                
            html += '            <button type="button" class="btn2" onclick="deleteSurvey('+index+', 0)">??????</button>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="survey-bx-sect2">';
            html += '        <input name="text[]" type="text" class="ipt" placeholder="????????? ???????????????">';
            html += '        <input name="survey_id[]" type="hidden" value="0">';
            html += '        <select id="survey_type_'+index+'" name="survey_type[]">';
            html += '            <option value="N">????????????</option>';
            html += '            <option value="B">????????????</option>';
            html += '        </select>';
            html += '    </div>';
            html += '    <p id="type_noti_'+index+'" class="p-noti_1">?????????????????? ??????????????? ?????? ?????? ?????? ?????????????????? ????????? ????????? ??? ????????????.</p>';
            html += '    <div id="rows_'+index+'" class="survey-bx-sect3">';
            html += '        <div class="btns">';
            html += '            <button type="button" onclick="addRow('+index+')">?????? ??????</button>';
            html += '        </div>';
            html += '        <div id="row_'+j+'" class="wrt-after">';
            html += '            <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="??????" value="?????? ??????">';
            html += '            <input name="child_survey_id_'+index+'[]" type="hidden" value="0">'
            html += '            <button type="button" class="btn-del" onclick="deleteRow('+j+', 0)">?????? ??????</button>';
            html += '        </div>';
            html += '        <div id="row_'+(j+1)+'" class="wrt-after">';
            html += '            <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="??????" value="??????">';
            html += '            <input name="child_survey_id_'+index+'[]" type="hidden" value="0">'
            html += '            <button type="button" class="btn-del" onclick="deleteRow('+(j+1)+', 0)">?????? ??????</button>';
            html += '        </div>';
            html += '        <div id="row_'+(j+2)+'" class="wrt-after">';
            html += '            <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="??????" value="??????">';
            html += '            <input name="child_survey_id_'+index+'[]" type="hidden" value="0">'
            html += '            <button type="button" class="btn-del" onclick="deleteRow('+(j+2)+', 0)">?????? ??????</button>';
            html += '        </div>';
            html += '        <div id="row_'+(j+3)+'" class="wrt-after">';
            html += '            <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="??????" value="?????????">';
            html += '            <input name="child_survey_id_'+index+'[]" type="hidden" value="0">'
            html += '            <button type="button" class="btn-del" onclick="deleteRow('+(j+3)+', 0)">?????? ??????</button>';
            html += '        </div>';
            html += '        <div id="row_'+(j+4)+'" class="wrt-after">';
            html += '            <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="??????" value="?????? ?????????">';
            html += '            <input name="child_survey_id_'+index+'[]" type="hidden" value="0">'
            html += '            <button type="button" class="btn-del" onclick="deleteRow('+(j+4)+', 0)">?????? ??????</button>';
            html += '        </div>';
            html += '    </div>';

            j = j + 5;
            $("#survey_" + index).children().remove();
            $("#survey_" + index).append(html);
        } 
    });

    //is_duplicate ??????
    $(document).on("change", "input:checkbox[name='is_duplicate[]']", function() {
        var id = $(this).attr("id").substr($(this).attr("id"));
        id = id.split("_")[1]
        
        
        if (document.getElementById("dup_" + id).checked) {
            document.getElementById("dup_hidden_" + id).disabled = true;
        
        } else {
            document.getElementById("dup_hidden_" + id).disabled = false;
        }  
    });

    //is_required ??????
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
            $("#type_noti_"+id).html("?????????????????? ??????????????? ?????? ?????? ?????? ?????????????????? ????????? ????????? ??? ????????????.");
        } else {
            $("#req_span_"+id).show();
            $("#type_noti_"+id).html("?????????????????? ??????????????? ?????? ?????? ??? ?????????????????? ????????? ????????? ??? ????????????.");
        }
    });
</script>