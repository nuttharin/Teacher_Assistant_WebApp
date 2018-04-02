<?php
    include('views/header/nav2.php');
?>
<style>
    .work{
        margin:auto;
        width:90%;
        height:300px;
        background-color:#ECEFF1;
        padding:20px;
    }
    .center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    }
</style>
<div class="content p-4" style="width:100%">
<div class="row">
        <div class="col-2">
            <img src="<?php echo $member->get_img_user() ?>" class="center" width="150" alt="<?php echo $member->get_username() ?>">
        </div>
        <div class="col-4">
            <h3> <?php echo $member->get_type()."</br>".$member->get_fname()." ".$member->get_lname() ?></h3>
        </div>
    </div>
    </br>
    <table  id="workTable" class="table  table-bordered"> 
        <thead>
            <tr align="center">
                <th>#</th>
                <th>รายละเอียด</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
        
        <?php
        $i = 1;
        if($workList !== FALSE)
        {
        foreach($workList as $key=>$work)
        {
            $objPatron = $work->get_objPatron();
            $objPerson = $work->get_objPerson();
            $submitwork = '';
            if($work->get_status() == 'waiting')
            {
                $color='badge badge-warning';
            }
            else if($work->get_status() == 'booked')
            {
                $color='badge badge-primary';
            }
            else
            {
               $color='badge badge-success';
            }
            echo "<tr>
                    
                    <td align='center'>$i</td>
                    <td>
                    <div class='row'>
                        <div class='col-6'>
                            <h4><a href='?controller=work&action=getWork&id_work=".$work->get_id_work()."'>".$work->get_title()."</a> $submitwork</h4>
                            <p><i class='fa fa-clock-o'></i>".$work->get_created_date()."</p>
                            <p>ผู้สั่งงาน : <img src='".$objPatron->get_img_user()."'  width='50' alt=''><a href='?controller=work&action=getAllWorkByMember&id_member=".$objPatron->get_id_member()."&type=".$objPatron->get_type()."'>   ".$objPatron->get_fname()." ".$objPatron->get_lname()."</a></p>
                            <p>ผู้รับงาน : <img src='".$objPerson->get_img_user()."'  width='50' alt=''><a href='?controller=work&action=getAllWorkByMember&id_member=".$objPerson->get_id_member()."&type=".$objPerson->get_type()."'>    ".$objPerson->get_fname()." ".$objPerson->get_lname()."</a></p>
                            <p>ระยะเวลาทำงาน : ".$work->get_time_start()." ถึง ".$work->get_time_stop()."</p>
                        </div>";
           ?>
                    <div class='col-6 ' >
                        <div class='btn-group float-right'>
                   
                            <a href="#"
                            data-id-work = '<?php echo $work->get_id_work()?>'
                            data-title = '<?php echo $work->get_title()?>'
                            data-detail = '<?php echo $work->get_detail()?>'
                            data-time-start = '<?php echo $work->get_time_start()?>'
                            data-time-stop  = '<?php echo $work->get_time_stop()?>'
                            class='btn btn-success btn-edit'><i class='fa fa-pencil'></i></a>
                            <a href="#"
                            data-id-work ='<?php echo $work->get_id_work() ?>'
                            data-title = '<?php echo $work->get_title()?>'
                            class='btn btn-danger btn-delete'><i class='fa fa-trash-o'></i></a>
                        </div>
                    </div>
                    <?php
             echo  "</div>
                    </td>   
                    <td align='center'>
                    <h4><span class='$color'>".$work->get_status()."</span></h4>
                    </td>
                  </tr>";
       $i++; }}
        ?>
        </tbody>
    </table>

</div>

<script>
    $(document).ready(function() {
    $('#workTable').DataTable();
} );
</script>
<script>
    $(document).ready(function(){
        $('.btn-edit').click(function(){
        // get data from edit btn
        var id_work = $(this).attr('data-id-work');
        var title = $(this).attr('data-title');
        var detail = $(this).attr('data-detail');
        var time_start = $(this).attr('data-time-start');
        var time_stop = $(this).attr('data-time-stop');        
        // set value to modal
        $("#data-id-work").val(id_work);
        $("#data-title").val(title);
        $("#data-detail").val(detail);
        $("#data-time-start").val(time_start);
        $("#data-time-stop").val(time_stop);
        $("#edit").modal('show');
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.btn-delete').click(function(){
        // get data from edit btn
        var id_work = $(this).attr('data-id-work');
        document.getElementById("title").innerHTML = $(this).attr('data-title');
        // set value to modal
        $("#data-id-work").val(id_work);
        $("#data-title").val(title);
        $("#delete").modal('show');
        });
    });
</script>

<div class="modal fade" id="edit">
<div class="modal-dialog modal-lg">
    <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
        <h4 class="modal-title">แก้ไขรายละเอียดงาน</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <!-- Modal body -->
    <div class="modal-body">
        <form method="POST">
        <input id="data-id-work" type="text" name="id_work" class="form-control" hidden>
            <div class="row">   
                <div class="col-6">
                    <label>หัวข้องาน</label><input id="data-title" type="text" name="title" class="form-control">
                    <label>รายละเอียดงาน</label><textarea id="data-detail" name="detail"cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="col-6">
                    <label>วันที่เริ่มงาน</label><input type="date" name="time_start" id="data-time-start" class="form-control" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
                    <label>วันที่ส่งงาน</label><input type="date" name="time_stop" id="data-time-stop" class="form-control" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
                </div>
            </div>
            <input type="hidden" name="controller" value="#">
            
        
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="submit" class="btn btn-success btn-block" name="action" value="#">แก้ไข</button>
        </form>
    </div>

    </div>
</div>
</div>


<div class="modal fade" id="delete">
<div class="modal-dialog modal-lg">
    <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
        <h4 class="modal-title">ต้องการลบงาน</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <!-- Modal body -->
    <div class="modal-body">
        <form method="POST">
        <input id="data-id-work" type="text" name="id_work" class="form-control" hidden>
            <div class="row">   
                <div class="col-6">
                    <label id="title"></label> 
                 </div>             
            </div>
            <input type="hidden" name="controller" value="#">
            
        
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="submit" class="btn btn-danger btn-block" name="action" value="#">ลบ</button>
        </form>
    </div>

    </div>
</div>
</div>
