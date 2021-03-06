<?php
    include('views/header/nav3.php');
?>
<style>
    .waiting ,.booked,.finish,.allshow  {
        cursor: pointer;
    }
</style>
<div class="banner-sec">
    <div class="container">

  
        <?php if($_SESSION['member']['type'] != "นิสิต"){?>
        <form method="POST">
            <label>ปีการศึกษา
            <select name="id_year" id="id_year" class="form-control" required>
                <option value="">--เลือกปีการศึกษา--</option>
                <?php
                    foreach($yearSchoolList as $yearSchool)
                    {
                        echo "<option>".$yearSchool->get_id_year()."</option>";
                    }
                ?>
            </select>
            </label>
            <input type="hidden" name="controller" value="work">
            <button type="submit" class="btn btn-success" name="action" value="searchWork"><i class="fas fa-search"></i> ค้นหา</button>
        </form>
        <?php } ?>
        <h4><span class="badge badge-pill badge-warning waiting">Waiting</span> <span class="badge badge-pill badge-primary booked">Booked</span> <span class="badge badge-pill badge-success finish">Finish</span> <span class="badge badge-pill badge-info allshow">แสดงงานทั้งหมด</span> </h4>
        <?php if($workList !== FALSE)
        {
            foreach($workList as $key=>$value)
            {
                echo "<h3>ตารางงานปีการศึกษา ".$value->get_objYearSchool()->get_id_year()."</h3>";
                break;
            }
        } 
        ?>
        <table  id="workTable" class="table table-bordered Tabledata" > 
            <thead>
                <tr align="center" class="table-light">
                    <th>#</th>
                    <th>รายละเอียด</th>
                    <th>ผู้สั่ง</th>
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
                $submitwork = '';
                if($work->get_status() == 'waiting')
                {
                    $color='badge badge-pill badge-warning';
                }
                else if($work->get_status() == 'booked')
                {
                    $color='badge badge-pill badge-primary';
                }
                else
                {
                    $color='badge badge-pill badge-success';
                }
                if($work->get_status() == 'waiting' && $_SESSION['member']['type'] == 'นิสิต')
                {
                // $submitwork = "<a href='?controller=work&action=submitWork&id_work=".$work->get_id_work()."' class='btn btn-success btn-sm'>รับงาน</a>";
                }
                echo "<tr class='table-light'>
                        
                        <td align='center'>$i</td>
                        <td>
                        <div class='row'>
                            <div class='col-9'>
                                <h5><a href='?controller=work&action=getWork&id_work=".$work->get_id_work()."'>".$work->get_title()."</a> $submitwork</h5>
                                <p><i class='far fa-clock'></i>    ".$work->DateTimeThai($work->get_created_date())."</p>
                                <p>ระยะเวลาทำงาน : ".$work->DateThai($work->get_time_start())." ถึง ".$work->DateThai($work->get_time_stop())."</p>
                            </div>";
                if($_SESSION['member']['type'] != 'นิสิต' && $_SESSION['member']['id_member'] == $objPatron->get_id_member())
                {
                ?>
                        <div class='col-3' >
                        <div class='dropdown'>
                            <button class='btn btn-sm  float-right dropdown-toggle' data-toggle='dropdown'>
                                <i class='fas fa-cog'></i>
                            </button>
                            <div class='dropdown-menu  dropdown-menu-right'>
                            <a class='dropdown-item edit-work' href="#"  data-id-work = '<?php echo $work->get_id_work()?>'
                                data-title = '<?php echo $work->get_title()?>'
                                data-detail = '<?php echo $work->get_detail()?>'
                                data-time-start = '<?php echo $work->get_time_start()?>'
                                data-time-stop  = '<?php echo $work->get_time_stop()?>'><i  class='fas fa-edit'></i> แก้ไข</a>
                            <a class='dropdown-item delete-work' href='#'
                                data-id-work = '<?php echo $work->get_id_work()?>'
                                data-title = '<?php echo $work->get_title()?>'><i class='far fa-trash-alt'></i> ลบงาน</a>
                            </div>
                        </div>
                        </div>
                        <?php
                }
                else
                {
                    echo "<div class='col-3'>
                    </div>";
                }
                echo  "</div>
                        </td>
                        <td align='center'><a href='?controller=work&action=getAllWorkByMember&id_member=".$objPatron->get_id_member()."&type=".$objPatron->get_type()."'><img src='".$objPatron->get_img_user()."'  width='50' alt=''>   ".$objPatron->get_fname()." ".$objPatron->get_lname()."</a></td>   
                        <td align='center'>
                            <h4><span class='$color'>".$work->get_status()."</span></h4>
                        </td>
                    </tr>";
                
        $i++; }}
            ?>
            </tbody>
        </table>

</div>

<!-- แก้ไขงาน -->
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
        <form method="POST" id="form-edit">
        <input id="data-id-work-edit" type="text" name="id_work" class="form-control" hidden>
            <div class="row">   
                <div class="col-6">
                    <label><span class="red">* </span> หัวข้องาน</label><input id="data-title-edit" maxlength="70" type="text" name="title" class="form-control" required>
                    <label><span class="red">* </span> รายละเอียดงาน</label><textarea maxlength="200" id="data-detail-edit" name="detail"cols="30" rows="10" class="form-control" required></textarea>
                </div>
                <div class="col-6">
                    <label><span class="red">* </span>วันที่เริ่มงาน</label><input type="date" name="time_start" id="data-time-start-edit" class="form-control date_year" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required>
                    <label><span class="red">* </span>วันที่ส่งงาน</label><input type="date" name="time_stop" id="data-time-stop-edit" class="form-control date_year" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required>
                </div>
            </div>
            <input type="hidden" name="controller" value="work">
            
        
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="submit" class="btn btn-success btn-block" name="action" value="editWork">แก้ไข</button>
        </form>
    </div>

    </div>
</div>
</div>
<!-- ลบงาน -->
<div class="modal fade" id="delete">
<div class="modal-dialog">
    <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
        <h4 class="modal-title">ยืนยันการลบงาน</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <!-- Modal body -->
    <div class="modal-body">
        <form method="POST">
            <input id="data-id-work-delete" type="text" name="id_work" class="form-control" hidden> 
            <h5 id="data-title-delete"></h5>         
            <input type="hidden" name="controller" value="work">
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">

    <div style="width :50%">
        <button type="submit" class="btn btn-danger btn-block" name="action" value="deleteWork">ใช่</button>
    </div>
    <div style="width :50%">    
        <button type="button" class="btn btn-success btn-block" data-dismiss="modal">ไม่</button>
    </div> 
 
        </form>
    </div>

    </div>
</div>
</div>

<!-- ตรวจสอบวันที่ --> 
<script>
$(document).ready(function() {
    $("#add_work").submit(function( event ) {
        var check = data_check('#data-time-start-edit','#data-time-stop-edit')
        if(check && remove_f_e("input[type=text],textarea"))
        {
            $('.alert').remove();
            return;
        }
        else
        {
            $('.alert').remove();
            $("#txtToDate").after("<span class='alert red'>วันที่ส่งงานน้อยกว่าวันที่เริ่มงาน</span>");
        }
        event.preventDefault();
    });
});
</script>

<!-- แก้ไขงาน -->
<script>
    $(document).ready(function(){
        $('.edit-work').click(function(){
        $('.alert').remove();
        // get data from edit btn
        var id_work = $(this).attr('data-id-work');
        var title = $(this).attr('data-title');
        var detail = $(this).attr('data-detail');
        var time_start = $(this).attr('data-time-start');
        var time_stop = $(this).attr('data-time-stop');        
        // set value to modal
        $("#data-id-work-edit").val(id_work);
        $("#data-title-edit").val(title);
        $("#data-detail-edit").val(detail);
        $("#data-time-start-edit").val(time_start);
        $("#data-time-stop-edit").val(time_stop);
        $("#edit").modal('show');
        });
    });
</script>
<!-- ลบงาน -->
<script>
    $(document).ready(function(){
        $('.delete-work').click(function(){
        // get data from edit btn
        var id_work = $(this).attr('data-id-work');
        document.getElementById("data-title-delete").innerHTML = "คุณต้องการลบงาน " +$(this).attr('data-title') + " ใช่หรือไม่";
        // set value to modal
        $("#data-id-work-delete").val(id_work);
        $("#delete").modal('show');
        });
    });
</script>

<script>
    $(document).ready(function() {
    $("#form-edit").submit(function( event ) {
        var check = data_check('#data-time-start-edit','#data-time-stop-edit')
        console.log(check);
        if(check)
        {
            $('.alert').remove();
            return;
        }
        else
        {
            $('.alert').remove();
            $("#data-time-stop-edit").after("<span class='alert red'>วันที่ส่งงานน้อยกว่าวันที่เริ่มงาน</br></span>");
        }
        event.preventDefault();
    });
} );
</script>

<script>
    $(document).ready(function(){
        $(".waiting").click(function(){
            $(":input[type='search']").val('waiting');
            $(":input[type='search']").keyup();
        })
        $(".booked").click(function(){
            $(":input[type='search']").val('booked');
            $(":input[type='search']").keyup();
        })
        $(".finish").click(function(){
            $(":input[type='search']").val('finish');
            $(":input[type='search']").keyup();
        })
        $(".allshow").click(function(){
            $(":input[type='search']").val('');
            $(":input[type='search']").keyup();
        })

    })
</script>