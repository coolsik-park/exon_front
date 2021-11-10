<style>
    .poll-item-wrap::-webkit-scrollbar {
        width: 10px;
    }
    .poll-item-wrap::-webkit-scrollbar-thumb {
        background-color: #2f3542;
        border-radius: 10px;
        background-clip: padding-box;
        border: 2px solid transparent;
    }
    .poll-item-wrap::-webkit-scrollbar-track {
        background-color: grey;
        border-radius: 10px;
        box-shadow: inset 0px 0px 5px white;
    }
</style>

<div class="webinar-cont2">
    <h3 class="sr-only">공지사항</h3>
    <div class="webinar-cont-ty2" style="overflow: auto; height:659px;">
        <div class="notice-item">
            <?= $this->Text->autoParagraph($notice) ?>
        </div>
    </div>                               
</div>