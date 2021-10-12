<div id="container">
    <div class="contents static">
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
                            <span>21</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="refund">
                            <span>환불</span>
                            <span>14</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="pay">
                            <span>결제</span>
                            <span>15</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="exhibitionParticipation">
                            <span>행사 참여</span>
                            <span>11</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="exhibitionAdd">
                            <span>행사 개설</span>
                            <span>110</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="webinar">
                            <span>웨비나</span>
                            <span>11</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" id="besides">
                            <span>기타</span>
                            <span>18</span>
                        </button>
                    </li>
                </ul>
            </div>
            <h4 class="s-hty3" id="s-hty3">전체</h4>
            <?php foreach ($faqs as $faq): ?>
                <div id="board-lists">
                    <ul class="board-lists">
                        <li>
                            <button type="button" class="b-tit"><?= $faq->title ?></button>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
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
    $('#all').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category',
            method: 'POST',
            type: 'json',
            data: {
                FaqCategoryId: 'null'
            }
        }).done(function(data) {
            $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">전체</h4>');
            $('#board-lists').load(location.href+" #board-lists");
        });
    });

    $('#user').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category',
            method: 'POST',
            type: 'json',
            data: {
                FaqCategoryId: 1
            }
        }).done(function(data) {
            $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">회원</h4>');
            $('#board-lists').load(location.href+" #board-lists");
        });
    });
    
    $('#refund').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category',
            method: 'POST',
            type: 'json',
            data: {
                FaqCategoryId: 2
            }
        }).done(function(data) {
            $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">환불</h4>');
            $('#board-lists').load(location.href+" #board-lists");
        });
    });

    $('#pay').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category',
            method: 'POST',
            type: 'json',
            data: {
                FaqCategoryId: 3
            }
        }).done(function(data) {
            $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">결제</h4>');
            $('#board-lists').load(location.href+" #board-lists");
        });
    });
    
    $('#exhibitionParticipation').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category',
            method: 'POST',
            type: 'json',
            data: {
                FaqCategoryId: 4
            }
        }).done(function(data) {
            $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">행사 참여</h4>');
            $('#board-lists').load(location.href+" #board-lists");
        });
    });

    $('#exhibitionAdd').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category',
            method: 'POST',
            type: 'json',
            data: {
                FaqCategoryId: 5
            }
        }).done(function(data) {
            $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">행사 개설</h4>');
            $('#board-lists').load(location.href+" #board-lists");
        });
    });
    
    $('#webinar').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category',
            method: 'POST',
            type: 'json',
            data: {
                FaqCategoryId: 6
            }
        }).done(function(data) {
            $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">웨비나</h4>');
            $('#board-lists').load(location.href+" #board-lists");
        });
    });

    $('#besides').on('click', function() {
        $.ajax({
            url: '/boards/faqs-by-category',
            method: 'POST',
            type: 'json',
            data: {
                FaqCategoryId: 7
            }
        }).done(function(data) {
            $('#s-hty3').replaceWith('<h4 class="s-hty3" id="s-hty3">기타</h4>');
            $('#board-lists').load(location.href+" #board-lists");
        });
    });
</script>


<!-- <div class="userquestion index content">
    <h3><?= __('FAQs by Category') ?></h3>
    <div>
        <?= $this->Html->link(__('전체'), ['action' => 'faqsByCategory']) ?>
        <?= $this->Html->link(__('회원'), ['action' => 'faqsByCategory', '1']) ?>
        <?= $this->Html->link(__('환불'), ['action' => 'faqsByCategory', '2']) ?>
        <?= $this->Html->link(__('결제'), ['action' => 'faqsByCategory', '3']) ?>
        <?= $this->Html->link(__('행사 참여'), ['action' => 'faqsByCategory', '4']) ?>
        <?= $this->Html->link(__('행사 개설'), ['action' => 'faqsByCategory', '5']) ?>
        <?= $this->Html->link(__('웨비나'), ['action' => 'faqsByCategory', '6']) ?>
        <?= $this->Html->link(__('기타'), ['action' => 'faqsByCategory', '7']) ?>
    </div>
    <div class="table-responsive">
        <table>
            <tbody>
                <?php foreach ($faqs as $faq): ?>
                <tr>
                    <td><?= $this->Number->format($faq->id) ?></td>
                    <td><?= h($faq->title) ?></td>
                </tr>   
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div> -->