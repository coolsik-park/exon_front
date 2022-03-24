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

    .board-lists .b-tit {
        font-size: 1.1rem;
    }

    .board-lists .b-desc {
        background-color: #E8E8E8;
        font-size: 1rem;
    }
</style>

<div id="container">
    <div class="contents static">
            <h2 class="s-hty0">고객센터</h2>            
            <div class="cs-tab">
                <ul class="s-tabs2">
                    <li class="active"><a href="">자주 하는 질문</a></li>
                    <li><a href="/boards/notice">공지사항</a></li>
                    <li><a href="/boards/add">문의하기</a></li>
                </ul>
            </div>
            <div class="section-cs1">
                <h3 class="s-hty1">가장 자주하는 질문</h3>
                <ul class="board-lists">
                    <?php foreach ($faqs_main as $faq_main): ?>
                        <li>
                            <button type="button" class="b-tit"><?= $faq_main->title ?></button>
                            <div class="b-desc"><?= $faq_main->content ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>               
            </div>           
            <div class="section-cs2">
            <h3 class="s-hty1">카테고리 별 질문</h3>
            <div class="cs-cate">
                <ul>
                    <li class="active">
                        <button type="button" id="all">
                            <span>전체</span>
                            <span><?= $this->Paginator->counter(__('{{count}}')) ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="create">
                            <span>행사개설</span>
                            <span><?= $count[0] ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="apply">
                            <span>행사신청</span>
                            <span><?= $count[1] ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="user">
                            <span>회원관련</span>
                            <span><?= $count[2] ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="pay">
                            <span>결제</span>
                            <span><?= $count[3] ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="receipt">
                            <span>정산</span>
                            <span><?= $count[4] ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="refund">
                            <span>환불</span>
                            <span><?= $count[5] ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="besides">
                            <span>기타</span>
                            <span><?= $count[6] ?></span>
                        </button>
                    </li>
                </ul>
            </div>
            <div id="category-list">
                <h4 class="s-hty3" id="s-hty3">전체</h4>
                <div>
                    <ul class="board-lists">
                        <?php foreach ($faqs as $faq): ?>
                            <li>
                                <button type="button" class="b-tit"><?= $faq->title ?></button>
                                <div class="b-desc"><?= $faq->content ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->prev('< ' . __('이전')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('다음') . ' >') ?>
                    </ul>
                </div>
                <div class="board-sh">
                    <input type="text" id="search" placeholder="제목">
                    <button type="button" class="ico-sh" id="ico-sh">검색</button>
                </div> 
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
            $('.board-lists>li>button').each(function () {
                $(this).parent().removeClass('on');
            });
            $(this).parent().addClass('on');
        }
    });

    $('#all').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category/0',
            method: 'POST',
            type: 'json',
            data: {}
        }).done(function(data) {
            if (data.status == 'success') {
                var faqs = data.data;

                var html = '';
                html += '<h4 class="s-hty3" id="s-hty3">전체</h4>';
                html += '<div>';
                html += '   <ul class="board-lists">';
                for (var i=0; i<faqs.length; i++) {
                    html += '   <li>';
                    html += '       <button type="button" class="b-tit">' + faqs[i]['title'] + '</button>';
                    html += '       <div class="b-desc">' + faqs[i]['content'] + '</div>';
                    html += '   </li>';
                }
                html += '   </ul>';
                html += '</div>';

                $('#category-list').html(html);
            } else {
                alert("실패하였습니다.");
            }
        });
    });

    $('#create').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category/1',
            method: 'POST',
            type: 'json',
            data: {}
        }).done(function(data) {
            if (data.status == 'success') {
                var faqs = data.data;

                var html = '';
                html += '<h4 class="s-hty3" id="s-hty3">행사개설</h4>';
                html += '<div>';
                html += '   <ul class="board-lists">';
                for (var i=0; i<faqs.length; i++) {
                    html += '   <li>';
                    html += '       <button type="button" class="b-tit">' + faqs[i]['title'] + '</button>';
                    html += '       <div class="b-desc">' + faqs[i]['content'] + '</div>';
                    html += '   </li>';
                }
                html += '   </ul>';
                html += '</div>';

                $('#category-list').html(html);
            } else {
                alert("실패하였습니다.");
            }
        });
    });
    
    $('#apply').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category/2',
            method: 'POST',
            type: 'json',
            data: {}
        }).done(function(data) {
            if (data.status == 'success') {
                var faqs = data.data;

                var html = '';
                html += '<h4 class="s-hty3" id="s-hty3">행사신청</h4>';
                html += '<div>';
                html += '   <ul class="board-lists">';
                for (var i=0; i<faqs.length; i++) {
                    html += '   <li>';
                    html += '       <button type="button" class="b-tit">' + faqs[i]['title'] + '</button>';
                    html += '       <div class="b-desc">' + faqs[i]['content'] + '</div>';
                    html += '   </li>';
                }
                html += '   </ul>';
                html += '</div>';

                $('#category-list').html(html);
            } else {
                alert("실패하였습니다.");
            }
        });
    });

    $('#user').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category/3',
            method: 'POST',
            type: 'json',
            data: {}
        }).done(function(data) {
            if (data.status == 'success') {
                var faqs = data.data;

                var html = '';
                html += '<h4 class="s-hty3" id="s-hty3">회원관련</h4>';
                html += '<div>';
                html += '   <ul class="board-lists">';
                for (var i=0; i<faqs.length; i++) {
                    html += '   <li>';
                    html += '       <button type="button" class="b-tit">' + faqs[i]['title'] + '</button>';
                    html += '       <div class="b-desc">' + faqs[i]['content'] + '</div>';
                    html += '   </li>';
                }
                html += '   </ul>';
                html += '</div>';

                $('#category-list').html(html);
            } else {
                alert("실패하였습니다.");
            }
        });
    });
    
    $('#pay').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category/4',
            method: 'POST',
            type: 'json',
            data: {}
        }).done(function(data) {
            if (data.status == 'success') {
                var faqs = data.data;

                var html = '';
                html += '<h4 class="s-hty3" id="s-hty3">결제</h4>';
                html += '<div>';
                html += '   <ul class="board-lists">';
                for (var i=0; i<faqs.length; i++) {
                    html += '   <li>';
                    html += '       <button type="button" class="b-tit">' + faqs[i]['title'] + '</button>';
                    html += '       <div class="b-desc">' + faqs[i]['content'] + '</div>';
                    html += '   </li>';
                }
                html += '   </ul>';
                html += '</div>';

                $('#category-list').html(html);
            } else {
                alert("실패하였습니다.");
            }
        });
    });

    $('#receipt').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category/5',
            method: 'POST',
            type: 'json',
            data: {}
        }).done(function(data) {
            if (data.status == 'success') {
                var faqs = data.data;

                var html = '';
                html += '<h4 class="s-hty3" id="s-hty3">정산</h4>';
                html += '<div>';
                html += '   <ul class="board-lists">';
                for (var i=0; i<faqs.length; i++) {
                    html += '   <li>';
                    html += '       <button type="button" class="b-tit">' + faqs[i]['title'] + '</button>';
                    html += '       <div class="b-desc">' + faqs[i]['content'] + '</div>';
                    html += '   </li>';
                }
                html += '   </ul>';
                html += '</div>';

                $('#category-list').html(html);
            } else {
                alert("실패하였습니다.");
            }
        });
    });
    
    $('#refund').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category/6',
            method: 'POST',
            type: 'json',
            data: {}
        }).done(function(data) {
            if (data.status == 'success') {
                var faqs = data.data;

                var html = '';
                html += '<h4 class="s-hty3" id="s-hty3">환불</h4>';
                html += '<div>';
                html += '   <ul class="board-lists">';
                for (var i=0; i<faqs.length; i++) {
                    html += '   <li>';
                    html += '       <button type="button" class="b-tit">' + faqs[i]['title'] + '</button>';
                    html += '       <div class="b-desc">' + faqs[i]['content'] + '</div>';
                    html += '   </li>';
                }
                html += '   </ul>';
                html += '</div>';

                $('#category-list').html(html);
            } else {
                alert("실패하였습니다.");
            }
        });
    });

    $('#besides').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category/7',
            method: 'POST',
            type: 'json',
            data: {}
        }).done(function(data) {
            if (data.status == 'success') {
                var faqs = data.data;

                var html = '';
                html += '<h4 class="s-hty3" id="s-hty3">기타</h4>';
                html += '<div>';
                html += '   <ul class="board-lists">';
                for (var i=0; i<faqs.length; i++) {
                    html += '   <li>';
                    html += '       <button type="button" class="b-tit">' + faqs[i]['title'] + '</button>';
                    html += '       <div class="b-desc">' + faqs[i]['content'] + '</div>';
                    html += '   </li>';
                }
                html += '   </ul>';
                html += '</div>';

                $('#category-list').html(html);
            } else {
                alert("실패하였습니다.");
            }
        });
    });

    $('#ico-sh').on('click', function() {
        var word = document.getElementById("search").value;

        $.ajax({
            url: '/boards/title-search',
            method: 'POST',
            type: 'json',
            data: {
                word: word,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                console.log(data.data);
                var faqs = data.data;
                
                var html = '';
                html += '<div>';
                html += '   <ul class="board-lists">';
                for (var i=0; i<faqs.length; i++) {
                    html += '   <li>';
                    html += '       <button type="button" class="b-tit">' + faqs[i]['title'] + '</button>';
                    html += '       <div class="b-desc">' + faqs[i]['content'] + '</div>';
                    html += '   </li>';
                }
                html += '   </ul>';
                html += '</div>';

                $('#category-list').html(html);
                ui.addOnAction('.board-lists>li');
            } else {
                alert("실패하였습니다.");
            }
        });
    });
</script>