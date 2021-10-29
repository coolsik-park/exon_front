<div class="webinar-cont2">
    <h3 class="sr-only">자료</h3>
    <div class="webinar-cont-ty2">
        <?php
            foreach ($exhibitionFiles as $exhibitionFile) {
                $destination = WWW_ROOT . $exhibitionFile['file_path'] . DS . $exhibitionFile['file_name'];
                $fileSize = round((fileSize($destination) / 1024), 1);
        ?>
        <a href="/exhibition-stream/exhibition-files/<?=$id?>/<?=$exhibitionFile['id']?>" class="data-itme">
            <span class="tx"><?= $exhibitionFile['name'] ?></span>
            <span class='kb'><?= $fileSize ?> KB</span>
        </a>
        <?php
            }
        ?>
    </div>                               
</div>

<script>
    ui.addOnAction('.board-lists>li');
</script>