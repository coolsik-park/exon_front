<<<<<<< HEAD
<<<<<<< HEAD
answered
=======
<div class="column-responsive column-80">
    <div class="exhibitionStream form content"> 
        <table class="table table-bordered" id="dynamic_field"> 
            <?php foreach($exhibitionQuestions as $exhibitionQuestion) { ?>
            <tr>  
                <td><?php echo $exhibitionQuestion['exhibition_user']['users_name'] ?></td>
                <td>-></td>
                <td><?php echo $exhibitionQuestion['target_users_name'] ?></td>
            </tr> 
            <tr>
=======
<div class="column-responsive column-80">
    <div class="exhibitionStream form content"> 
        <table class="table table-bordered" id="dynamic_field"> 
            <?php 
                foreach($exhibitionQuestions as $exhibitionQuestion) { 
            ?>
            <tr>  
                <td><?php echo $exhibitionQuestion['exhibition_user']['users_name'] ?></td>
                <td>-></td>
                <?php
                    if ($exhibitionQuestion['target_users_name'] == null) {
                ?>
                        <td><?php echo '전체'; ?></td>
                <?php
                    } else {
                ?>
                        <td><?php echo $exhibitionQuestion['target_users_name'] ?></td>
                <?php
                    }
                ?>
>>>>>>> master
                <td><?php echo $exhibitionQuestion['contents'] ?></td>
            </tr>
            <?php } ?> 
        </table>
    </div>
</div>
<<<<<<< HEAD
>>>>>>> 85afc0d88a36c121135fb9ada89efc86f4771676
=======
>>>>>>> master
