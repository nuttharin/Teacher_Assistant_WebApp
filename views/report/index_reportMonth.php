<?php include('views/header/nav2.php')?>
<div  class="content p-4" style="width:100%">
    </br>
    <?php include('views/report/nav_report.php')?>
    <div class="row m-chart">
        <div class="col-4">
            <label>เลือกปี</label>
                <select  id="yearWork" class="form-control">
                    <option value="">--เลือกปี--</option>
                    <?php
                        foreach($yearList as $key=>$year)
                        {
                            $yearThai = $year['year'] + 543;
                            echo "<option value='$year[year]'>$yearThai</option>";
                        }
                    ?>
                </select>
            
            <!--<label for="">เลือกนิสิต</label>
            <div class="member">
                <form  method="GET">
                    <select style="display:none"  name="id_member" id="name_member" class="form-control" placeholder="--เลือกนิสิต--">
                        <option value="">--เลือกนิสิต--</option>
                        <?php
                        /*foreach($memberList as $member)
                        {
                            echo "<option value='".$member->get_id_member()."'>".$member->get_fname()." ".$member->get_lname()."</option>";
                        }*/
                        ?>
                    </select>         
            </div>-->
        </div>  
        <div class="col-4"> 
            <label>เลือกนิสิต</label>
            <select class="form-control" name="nameStd" id="std">
                    <option value="">--เลือกนิสิต--</option>
            </select>
            </form> 
        </div>
    </div>
    <div class="row y-chart">
        <div class="col-4">
            <label>เลือกปีการศึกษา</label>
            <select class="form-control" id="id_year">
                    <option value="" selected>--เลือกปีการศึกษา--</option>
                    <?php
                    foreach($yearListSchool as $year)
                    {
                        echo "<option>".$year->get_id_year()."</option>";
                    }
                    ?>
            </select>
            </form> 
        </div>
    </div>
    <div id="chart">
        <canvas id="myChart1"></canvas><br/>
        <span id="work_count"></span>
        <span id="timeWork"></span>
        <canvas id="myChart2"></canvas><br/>
    </div>   
</div>
</br>
<script src="js/ajax/report/reportMonth.js"></script>
<script src="js/ajax/report/reportYear.js"></script>
<script>
        $('.member').dropdown({
            readOnly: true,
            searchable: false
        });
</script>