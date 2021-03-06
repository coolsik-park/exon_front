<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition $exhibition
 * 
 */
?>
<style>
    .date-sett label {
        padding-bottom:10px;
    }

    em {
        color:#e4342d;
        font-weight:700;
        position:absolute;
        top:-8px;
        left:-6px;
    }

    .col-th { 
        vertical-align: top;
        position: relative;
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
    .survey-bx {
        position: relative;
    }
    #detail_html {
        width: 99%;
    }
    #member_div {
        margin-top: 20px;
    }
    .sect1 .photo {
        width: 384px;
        height: 216px;
    }
    @media  screen and (max-width: 768px) {
        .sect1 .photo {
            height: 214px;
        }  
    }

    @media  screen and (min-width: 1024px) {
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
    @media  screen and (min-width: 768px) {
        .apply-sect1-cont .photos{
            max-width: 38%;
        }
    }
</style>

<?= $this->Form->create($exhibition, ['id' => 'createForm', 'enctype' => 'multipart/form-data', 'autocomplete' => 'autocomplete_off_randString'])?>
    <div id="container">    
        <div class="contents static">
            <h2 class="sr-only">?????? ??????</h2>
            <div class="section1">
                <div class="sect-tit">
                    <h3 class="s-hty1">????????????</h3>
                    <!-- <div class="btn-wp">
                        <button type="button" name="cancel" class="btn-ty4 red">??????</button>
                        <button type="button" name="save" class="btn-ty4">??????</button>
                        <button type="button" name="temp" class="btn-ty4">????????????</button>
                    </div> -->
                </div>
                
                <div class="sect1">
                    <div class="sect1-col1">
                        <div class="product-title">
                            <div class="product-img-div photo" style="overflow: hidden;">
                                <label class="conts"style="width: 100%; height: 100%; visibility: visible;"for="image"><img class="product-img mainImg" src="../images/img-no3.png" alt="???????????????" >
                                <input type="file" id="image" name="image" style="display:none">
                            </div>
                        </div>
                        <p class="p-noti">???????????? ???????????? ???????????????.</p>
                    </div>
                    <div class="sect1-col2">
                        <div class="row2 fir">
                            <div class="col-th"><em class="st">*</em>????????????</div>
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
                                <label for="data_apply_edate">?????? ??????</label>
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
                            <span class="chk-dsg"><input type="radio" id="cost1" name="cost" value="free" checked="checked"><label for="cost1">??????</label></span>
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
                        <span class="chk-dsg"><input type="radio" name="private" id="private1" value="0" checked="checked"><label for="private1">??????</label></span>
                        <p class="p-noti">????????? ??? ????????? ?????? ?????? ??? ??? ????????????.</p>
                    </div>
                    
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="private" id="private2" value="1"><label for="private2">?????????</label></span>
                        <p class="p-noti">?????? URL??? ?????? ????????? ????????? ?????? ??? ??? ????????????.</p>
                    </div>
                </div>
                <div id="group" class="sect5 mgtS1">
                    <h4 class="s-hty2">?????? ??????</h4>
                    <div id="group_0">
                    <br>
                        <div class="ln-group">
                            <input name="group_name[]" type="text" class="ipt" placeholder="?????????">
                            <div class="ln-group-wp">
                                <input name="group_amount[]" type="hidden" class="ipt" placeholder="????????? ??????" value="0" style="margin-right:20px;">
                                <select name="group_people[]" class="select">
                                    <option value="0">?????????</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400</option>
                                    <option value="500">500</option>
                                </select>
                            </div>
                        </div>
                    <p class="p-noti">????????? ??? ?????? ??? ???????????? ?????????????????? ?????????.</p>
                    </div>
                </div>
                <a id="addGroup" class="btn-ty3 md" style="margin-top:10px; cursor:pointer">????????????</a>
                <div class="sect4 mgtS1">
                    <h4 class="s-hty2">????????? ?????? ??????</h4>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="auto_approval" id="auto_approval1" value="0" checked="checked"><label for="auto_approval1">?????? ??????</label></span>
                        <p class="p-noti">???????????? ????????? ???????????? ????????? ???????????????.</p>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="auto_approval" id="auto_approval2" value="1"><label for="auto_approval2">?????? ??????</label></span>
                        <p class="p-noti">???????????? ?????? ?????? ????????? ?????? ???????????? ????????? ?????????.</p>
                    </div>
                </div>
                <div class="sect6 mgtS1">
                    <div class="sect-tit">
                        <h4 class="s-hty2"><em class="st">*</em>????????? ?????? ??????</h4>
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
                        <!-- <span class="chk-dsg"><input type="checkbox" id="require_age" name="require_age" value="1"><label for="require_age">??????</label></span> -->
                        <span class="chk-dsg"><input type="checkbox" id="require_group" name="require_group" value="1"><label for="require_group">??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_sex" name="require_sex" value="1"><label for="require_sex">??????</label></span>
                    </div>
                </div>
                <div class="sect7 mgtS1">
                    <h4 class="s-hty2">????????? ?????? ??????</h4>
                    <p class="p-noti">????????? ????????? ?????? ????????? ???????????????.(?????? ?????? ??????)</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" id="live" checked="checked" class="is_vod"><label for="live">????????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="vod" class="is_vod"><label for="vod">VOD ??????</label></span>
                    </div>
                </div>
                <input type="hidden" id="live_tab" name="live_tab" value="0">
                <input type="hidden" id="vod_tab" name="vod_tab" value="0">
                <div class="sect7 mgtS1" id="live-tab-div">
                    <h4 class="s-hty2">????????? ??? ??????</h4>
                    <p class="p-noti">????????? ?????? ???????????????.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_1" name="1" checked="checked"><label for="live_1">????????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_16" name="16" checked="checked"><label for="live_16">????????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_2" name="2"><label for="live_2">??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_4" name="4"><label for="live_4">????????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_8" name="8"><label for="live_8">?????? ??????</label></span><br>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_32" name="32"><label for="live_32">????????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_64" name="64"><label for="live_64">????????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_128" name="128"><label for="live_128">????????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_256" name="256"><label for="live_256">?????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="live_tab_box" id="live_512" name="512"><label for="live_512">??????</label></span>
                    </div>
                </div>
                <div class="sect7 mgtS1" id="vod-tab-div">
                    <h4 class="s-hty2">VOD ??? ??????</h4>
                    <p class="p-noti">????????? ?????? ???????????????.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_2" name="2"><label for="vod_2">??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_4" name="4"><label for="vod_4">????????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_8" name="8"><label for="vod_8">????????????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_64" name="64"><label for="vod_64">????????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_128" name="128"><label for="vod_128">????????? ??????</label></span><br>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_256" name="256"><label for="vod_256">?????? ??????</label></span>
                        <span class="chk-dsg"><input type="checkbox" class="vod_tab_box" id="vod_512" name="512"><label for="vod_512">??????</label></span>
                    </div>
                </div>
                <div class="sect7 mgtS1">
                    <h4 class="s-hty2">????????? ?????? ??? ?????? ??????</h4>
                    <p class="p-noti">????????? ?????? ??? ?????? ????????? ???????????????.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="radio" name="require_cert" id="require_cert1" value="1" checked="checked"><label for="require_cert1">????????????</label></span>
                        <span class="chk-dsg"><input type="radio" name="require_cert" id="require_cert2" value="0"><label for="require_cert2">????????????</label></span>
                    </div>
                </div>
                <div class="sect8 mgtS1">
                    <h4 class="s-hty2">?????? ??????</h4>
                    <textarea id="detail_html" name="detail_html" cols="30" rows="10"></textarea>                    
                </div>
            </div>
            <div class="section4">
                <h3 class="s-hty1">?????? ??????</h3>
                <!-- <div class="sect9 mgtS1">
                    <h4 class="s-hty3">?????? ??????</h4>
                    <p class="p-noti2">?????? ?????? 1?????? ?????? ???????????? ?????? ?????? ????????? ????????????. </p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="email_notice" id="email_notice1" value="1" checked="checked"><label for="email_notice1">??????</label></span>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="email_notice" id="email_notice2" value="0"><label for="email_notice2">?????? ??????</label></span>
                    </div>
                </div> -->
                <div class="sect9 mgtS1">
                    <h4 class="s-hty3">?????? ??????</h4>
                    <p class="p-noti2">?????? ????????? ????????? ????????? ????????? ???????????????. ??? ??? ???????????? ???????????? ?????? ?????? ?????????.</p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="additional" id="additional1" value="1" checked="checked"><label for="additional1">??????</label></span>
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
                        <!-- <div id="survey_0" class="survey-bx">
                            <div class="survey-bx-sect1">
                                <div class="tits">
                                    <select id="is_multiple_0" name="is_multiple[]">
                                        <option value="Y">?????????</option>
                                        <option value="N">?????????</option>
                                    </select>
                                    <div class="chk-dsg-wp">
                                        <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup0" value="Y"><label for="dup0">?????? ?????? ?????? ??????</label></span>
                                        <input type="checkbox" name="is_duplicate[]" id="dup_hidden_0" value="N" checked="checked" style="display:none">
                                    </div>                                
                                </div>
                                <div class="btns">                                
                                    <button type="button" class="btn2" onclick="deleteSurvey(0)">??????</button>
                                </div>
                            </div>
                            <div class="survey-bx-sect2">
                                <input name="text[]" type="text" class="ipt" placeholder="??????">
                                <select name="survey_type[]">
                                    <option value="N">????????????</option>
                                    <option value="B">????????????</option>
                                </select>
                            </div>
                            <div id="rows_0" class="survey-bx-sect3">
                                <div class="btns">
                                    <button type="button" onclick="addRow(0)">?????? ??????</button>
                                </div>
                                <div id="row_0" class="wrt-after">
                                    <input name="child_text_0[]" type="text" class="ipt" placeholder="??????">
                                    <button type="button" class="btn-del" onclick="deleteRow(0)">?????? ??????</button>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <a id="surveyAdd" class="btn-ty3 md" style="margin-top:10px; cursor:pointer">????????????</a>
                </div>
            </div>
            <div class="section-btm3 mgtS1">
                <button type="button" name="cancel" class="btn-big red">??????</button>
                <button type="button" name="save" class="btn-big">??????</button>
                <button type="button" name="temp" class="btn-big bor">????????????</button>
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
    //is_event ?????????
    $("#member_div").hide();
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

    //is_vod ?????????
    $(".is_vod").on("change", function() {
        if ($(this).attr("id") == "live" && $("#live").prop("checked") == false && $("#vod").prop("checked") == false) {
            $("#vod").prop("checked", true);
        }
        if ($(this).attr("id") == "vod" && $("#live").prop("checked") == false && $("#vod").prop("checked") == false) {
            $("#live").prop("checked", true);
        }
    });
    
    $("#vod-tab-div").hide();

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
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "detail_html",
        sSkinURI: "/se2/SmartEditor2Skin.html",
        fCreator: "createSEditor2"
    });

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
                alert('????????? ????????? ?????????????????????. ?????? ??? ?????? ????????? ?????????.');
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

    //????????????
    // $("#require_tel").click(function() {
    //     if ($(this).prop("checked") == true) {
    //         $("#require_email").attr("onclick", "");
    //     } else {
    //         $("#require_email").prop("checked", true);
    //         $("#require_email").attr("onclick", "return false");
    //     }
    // });

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
    var groupIndex = 1;
    $(document).on("click", "#addGroup", function() {
        if ($("input[name='cost']:checked").val() == "free") {
            var html = '';
            html += '<div id=group_' + groupIndex + '>';
            html += '   <br>';
            html += '   <div class="ln-group">';
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
    function deleteGroup(index) {
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
    $("button[name='save']").click(function() {
        //Validation
        // if (!$("#image").val()) {
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
            if ($(this).val() == '0') {
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
        var formData = $("#createForm").serialize();
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
            url: "/exhibition/add/",
            method: 'POST',
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
                        alert("????????? ?????????????????????.");
                        window.location.replace("/exhibition/index/all");
                    } else {
                        alert("????????? ?????????????????????. ?????? ??? ??????????????????.");
                    }
                });
            }else {
                alert("????????? ?????????????????????. ?????? ??? ??????????????????.");
            }
        });
    });

    //??????
    $("button[name='cancel']").click(function () {
        window.location.replace("/");
    });

    //????????????
    $("button[name='temp']").click(function() {
        //Validation
        if ($("#title").val().length == 0) {
            alert("??????????????? ??????????????????.");
            $("#title").focus();
            return false
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
            if ($(this).val() == '0') {
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
        var formData = $("#createForm").serialize();
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
            url: "/exhibition/add/",
            method: 'POST',
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
                        alert("????????? ???????????? ???????????????.");
                        window.location.replace("/exhibition/index/temp");
                    } else {
                        alert("????????? ?????????????????????. ?????? ??? ??????????????????.");
                    }
                });
            }else {
                alert("????????? ?????????????????????. ?????? ??? ??????????????????.");
            }
        });
    });
    
    //??????
    var i = 0; //?????? ?????????
    var j = 0; //?????? ?????????

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
    function deleteSurvey(index) {
        $("#survey_" + index).remove();
        // i--;
    };

    //?????? ??????
    function addRow(index) {
        var html = '';
        html += '<div id="row_'+j+'" class="wrt-after">';
        html += '   <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="??????">';
        html += '   <button type="button" class="btn-del" onclick="deleteRow('+j+')">?????? ??????</button>';
        html += '</div>';
        $("#rows_" + index).append(html);
        j++;
    };

    //?????? ??????
    function deleteRow(index) {
        $("#row_" + index).remove();
        j--;
    };

    //?????????/????????? ??????
    $(document).on("change", "select[name='is_multiple[]']", function() {
        if ($("option:selected", this).val() == 'N') {
            var index = $(this).attr("id").substr($(this).attr("id"));
            index = index.split("_")[2];
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
            index = index.split("_")[2];
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
        id = id.split("_")[1];

        if (document.getElementById("dup_" + id).checked) {
            document.getElementById("dup_hidden_" + id).disabled = true;
        
        } else {
            document.getElementById("dup_hidden_" + id).disabled = false;
        }  
    });

    //is_required ??????
    $(document).on("change", "input:checkbox[name='is_required[]']", function() {
        var id = $(this).attr("id").substr($(this).attr("id"));
        id = id.split("_")[1];

        if (document.getElementById("req_" + id).checked) {
            document.getElementById("req_hidden_" + id).disabled = true;
        
        } else {
            document.getElementById("req_hidden_" + id).disabled = false;
        }  
    });

    //???????????? ??????
    $(document).on("change", "select[name='survey_type[]']", function () {
        var id = $(this).attr("id").substr($(this).attr("id"));
        id = id.split("_")[2];

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