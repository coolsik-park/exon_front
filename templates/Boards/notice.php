<div id="container">        
    <div class="contents static">
        <h2 class="s-hty0">고객센터</h2>            
        <div class="cs-tab">
            <ul class="s-tabs2">
                <li><a href="/boards/faqs-by-category">자주 하는 질문</a></li>
                <li class="active"><a href="">공지사항</a></li>
                <li><a href="">문의하기</a></li>
            </ul>
        </div>
        <div class="section-cs1">
            <h3 class="s-hty1">공지사항</h3>
            <ul class="board-lists">
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
            <div class="board-sh">
                <input type="text" placeholder="제목">
                <button type="button" class="ico-sh">검색</button>
            </div>               
        </div>           
    </div>        
</div>
<footer id="footer"></footer>

 <script>
    ui.addOnAction('.board-lists>li');
 </script>