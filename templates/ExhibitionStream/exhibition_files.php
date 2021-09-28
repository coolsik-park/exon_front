<!-- <div>
    <table class="table" width="100%" border="1px">
        <tbody id="fileTableTbody">
        <?php
            foreach ($exhibitionFiles as $exhibitionFile) {
        ?>
            <tr>
                <td id = <?= $exhibitionFile['id'] ?> class = "download" style="cursor:pointer">
                <?php
                    $destination = WWW_ROOT . $exhibitionFile['file_path'] . DS . $exhibitionFile['file_name'];
                    $fileSize = fileSize($destination) / 1024 / 1024;
                    echo $exhibitionFile['name'] . ' / ' .  $fileSize . 'MB';
                ?>
                </td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div> -->

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