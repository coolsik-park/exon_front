<div>
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
</div>

<script>
    $(".download").click(function () {
        window.open('/exhibition-stream/exhibition-files/' + <?= $id ?> + '/' + $(this).attr('id'), '다운로드', 'width=460px,height=140px');
    });
</script>