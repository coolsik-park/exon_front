<div id="container">
    <div class="contents static">
            <h2 class="s-hty0">고객센터</h2>            
            <div class="cs-tab">
                <ul class="s-tabs2">
                    <li class="active"><a href="">자주 하는 질문</a></li>
                    <li><a href="/boards/notice">공지사항</a></li>
                    <li><a href="">문의하기</a></li>
                </ul>
            </div>
            <div class="section-cs1">
                <h3 class="s-hty1">가장 자주하는 질문 10</h3>
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
                        <button type="button" id="user">
                            <span>회원</span>
                            <span><?= $count[0] ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="refund">
                            <span>환불</span>
                            <span><?= $count[1] ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="pay">
                            <span>결제</span>
                            <span><?= $count[2] ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="exhibitionParticipation">
                            <span>행사 참여</span>
                            <span><?= $count[3] ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="exhibitionAdd">
                            <span>행사 개설</span>
                            <span><?= $count[4] ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="webinar">
                            <span>웨비나</span>
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
            <h4 class="s-hty3" id="s-hty3">전체</h4>
            <div id="board-lists">
                <ul class="board-lists">
                    <?php foreach ($faqs as $faq): ?>
                        <li>
                            <button type="button" class="b-tit"><?= $faq->title ?></button>
                            <div class="b-desc"><?= $faq->content ?></div>
                            </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="paginator" >
                <ul class="pagination">
                    <?= $this->Paginator->prev('< ' . __('이전')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('다음') . ' >') ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>   
    ui.addOnAction('.board-lists>li');

    // $('#all').on('click', function() {
    //     $.ajax({
    //         url: '/boards/faqsByCategory',
    //         method: 'POST',
    //         type: 'json',
    //         data: {
    //             categoryId: 0
    //         }
    //     }).done(function(data) {
    //         $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">전체</h4>');
    //         $('#board-lists').load(location.href+" #board-lists");
    //     });
    // });

    // $('#user').on('click', function() {
    //     $.ajax({
    //         url: '/boards/faqsByCategory/user',
    //         method: 'POST',
    //         type: 'json'
    //     }).done(function() {
    //         $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">회원</h4>');
    //         // $('#board-lists').replaceWith('<div><ul><li>a</li></ul></div>');
    //         $('#board-lists').load(location.href+" #board-lists");
    //     });
    // });
    
    // $('#refund').on('click', function() {
    //     $.ajax({
    //         url: '/boards/faqs-by-category',
    //         method: 'POST',
    //         type: 'json',
    //         data: {
    //             FaqCategoryId: 2
    //         }
    //     }).done(function(data) {
    //         $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">환불</h4>');
    //         $('#board-lists').load(location.href+" #board-lists");
    //     });
    // });

    // $('#pay').on('click', function() {
    //     $.ajax({
    //         url: '/boards/faqs-by-category',
    //         method: 'POST',
    //         type: 'json',
    //         data: {
    //             FaqCategoryId: 3
    //         }
    //     }).done(function(data) {
    //         $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">결제</h4>');
    //         $('#board-lists').load(location.href+" #board-lists");
    //     });
    // });
    
    // $('#exhibitionParticipation').on('click', function() {
    //     $.ajax({
    //         url: '/boards/faqs-by-category',
    //         method: 'POST',
    //         type: 'json',
    //         data: {
    //             FaqCategoryId: 4
    //         }
    //     }).done(function(data) {
    //         $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">행사 참여</h4>');
    //         $('#board-lists').load(location.href+" #board-lists");
    //     });
    // });

    // $('#exhibitionAdd').on('click', function() {
    //     $.ajax({
    //         url: '/boards/faqs-by-category',
    //         method: 'POST',
    //         type: 'json',
    //         data: {
    //             FaqCategoryId: 5
    //         }
    //     }).done(function(data) {
    //         $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">행사 개설</h4>');
    //         $('#board-lists').load(location.href+" #board-lists");
    //     });
    // });
    
    // $('#webinar').on('click', function() {
    //     $.ajax({
    //         url: '/boards/faqs-by-category',
    //         method: 'POST',
    //         type: 'json',
    //         data: {
    //             FaqCategoryId: 6
    //         }
    //     }).done(function(data) {
    //         $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">웨비나</h4>');
    //         $('#board-lists').load(location.href+" #board-lists");
    //     });
    // });

    // $('#besides').on('click', function() {
    //     $.ajax({
    //         url: '/boards/faqs-by-category',
    //         method: 'POST',
    //         type: 'json',
    //         data: {
    //             FaqCategoryId: 7
    //         }
    //     }).done(function(data) {
    //         $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">기타</h4>');
    //         $('#board-lists').load(location.href+" #board-lists");
    //     });
    // });
</script>