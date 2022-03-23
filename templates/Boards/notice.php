<style>
    div.b-desc * {
        font-weight: revert;
        font-size: revert;
    }
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

    button:focus {
        outline: none;
    }
    
    #file-download-button {
        border:none;
        text-align: left;
    }
</style>

<div id="container">        
    <div class="contents static">
        <h2 class="s-hty0">고객센터</h2>            
        <div class="cs-tab">
            <ul class="s-tabs2">
                <li><a href="/boards/customer-service">자주 하는 질문</a></li>
                <li class="active"><a href="">공지사항</a></li>
                <li><a href="/boards/add">문의하기</a></li>
            </ul>
        </div>
        <div class="section-cs1" id="section-cs1">
            <div id="list">
                <h3 class="s-hty1">공지사항</h3>
                <ul class="board-lists" id="board-lists">
                    <?php foreach ($boards as $board): ?>
                        <li id="li">
                            <button type="button" class="b-tit b-noti-tit">
                                <span class="tit"><?= $board->title ?></span>
                                <span class="date"><?= date("Y.m.d", strtotime($board->created)); ?></span>
                            </button>
                            <div class="b-desc">
                                <?= $board->content ?><br>
                                <?php
                                    $file_dir = "/home/www/admin/webroot/";
                                    $file_path = $board->file_path;
                                    if ($file_path != null) {
                                        if (is_dir($file_dir . $file_path)) {
                                ?>
                                            <div class="tg-btns">
                                                <button type="button" class="btn-ty3 bor" id="file">첨부파일</button>
                                                <ul class="file-ul" style="display:none">
                                <?php
                                                    $file_name = explode(',', $board->file_name);
                                                    $file_count = count($file_name);
                                                    if ($file_count > 0) {
                                                        for ($i=0; $i<$file_count; $i++) {
                                                            $file = $file_dir . $file_path . "/" . $file_name[$i];
                                                            if (is_file($file)) {
                                ?>
                                                                <li><button type="button" class="btn-ty3 bor" id="file-download-button"><a href="/exhibition/file-down/<?= $board->id ?>"><img src="/img/file-icon.png" width="3%"><?= $file_name[$i] ?></a></button></li>
                                <?php
                                                            }
                                                        }
                                                    }
                                ?>
                                                </ul>
                                            </div>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        </li>     
                    <?php endforeach; ?>              
                </ul>
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->prev('< ' . __('이전')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('다음') . ' >') ?>
                    </ul>
                </div>
            </div>
            <div class="board-sh">
                <input type="text" id="search" placeholder="제목">
                <button type="button" class="ico-sh" id="searchButton">검색</button>
            </div>               
        </div>           
    </div>        
</div>

<script>
    // ui.addOnAction('.board-lists>li');
    $(document).on('click', '.board-lists>li>button', function() {
        if ($(this).parent().hasClass('on')) {
            $(this).parent().removeClass('on');
        } else {
            $(this).parent().addClass('on');
        }
    });

    $(document).on("click", ".tg-btns", function () {
        if ($(this).hasClass('open')) {
            $(".file-ul").show();
        } else {
            $(".file-ul").hide();
        }
    });

    $('#searchButton').on('click', function() {
        var search = $('#search').val();

        $.ajax({
            url: '/boards/searchTitle',
            method: 'POST',
            type: 'json',
            data: {
                search: search
            }
        }).done(function(data) {
            if (data.status == 'success') {
                var boards = data.data;

                var html = '';
                html += '<h3 class="s-htyl">공지사항</h3>';
                html += '<ul class="board-lists">';
                
                for (var i=0; i<boards.length; i++) {
                    var date = new Date(boards[i]['created']);
                    var year = date.getFullYear();
                    var month = date.getMonth();
                    var day = date.getDate();
                    html += '   <li>';
                    html += '       <button type="button" class="b-tit b-noti-tit">';
                    html += '           <span class="tit">' + boards[i]['title'] + '</span>';
                    html += '           <span class="date">' + year + '.' + month + '.' + day + '</span>';
                    html += '       </button>';
                    html += '   </li>';
                }
                html += '</ul>';

                $('#list').html(html);
            } else {
                alert("실패하였습니다.");
            }
        });
    });
</script>