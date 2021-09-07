<div class="column-responsive column-80">
    <div class="exhibitionStream form content"> 
        <table class="table table-bordered" id="dynamic_field"> 
            <?php foreach($exhibitionUsers as $exhibitionUser) { ?>
            <?php
                $attend = null;
                switch ($exhibitionUser['attend']) {
                    case 1 : $attend = '-'; break;
                    case 2 : $attend = '참석'; break;
                    case 4 : $attend = '시청완료'; break;
                }
            ?>
            <tr>  
                <td><?php echo $exhibitionUser['users_name'] ?></td>
                <td><?php echo $exhibitionUser['users_email'] ?></td>
                <td><?php echo $attend ?></td>
            </tr> 
            <?php } ?> 
        </table>
    </div>
</div>