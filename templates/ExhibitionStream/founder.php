<div class="column-responsive column-80">
    <div class="exhibitionStream form content"> 
        <table class="table table-bordered" id="dynamic_field">  
            <tr>
                <td> <?php echo $this->Html->image(DS . $user['image_path'] . DS . $user['image_name']); ?></td>
            </tr>
            <tr>  
                <td><?php echo $user['name'] ?></td>
            </tr>
            <tr>
                <td><?php echo $user['email'] ?></td>
            </tr>
            <tr>
                <td><?php echo $user['hp'] ?></td>
            </tr>
        </table>
    </div>
</div>