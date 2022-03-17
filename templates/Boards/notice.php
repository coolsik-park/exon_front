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
                        <li>
                            <button type="button" class="b-tit b-noti-tit">
                                <span class="tit"><?= $board->title ?></span>
                                <span class="date"><?= date("Y.m.d", strtotime($board->created)); ?></span>
                            </button>
                            <div class="b-desc"><?= $board->content ?></div>
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
    ui.addOnAction('.board-lists>li');

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