<style>
    .y-chart ,#myChart2{
        display:none;
    }
</style>
    <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
            <a class="nav-link active" id="month_chart" href="#">สถิตการทำงานของนิสิตรายเดือน</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="year_chart" href="#">สถิตการทำงานของนิสิตรายปีการศึกษา</a>
        </li>
    </ul>
<script>
    $(document).ready(function(){
        $("#month_chart").click(function(){
            $("#work_std").show();
            $(".y-chart").hide();     
            $("#myChart2").hide();     
            $("#work_count").show();
            $("#work_count2").hide();
            $("#timeWork").show();
            $("#year_chart").removeClass('active');
            $(this).addClass('active');
            $("#myChart1").show();
            $(".m-chart").show();
        });
});
    $(document).ready(function(){
        $("#year_chart").click(function(){
            $("#work_std").hide();
            $(".m-chart").hide();
            $("#myChart1").hide();
            $("#work_count").hide();
            $("#work_count2").show();
            $("#timeWork").hide();
            $("#month_chart").removeClass('active');
            $(this).addClass('active');
            $("#myChart2").show(); 
            $(".y-chart").show();
        });
});

</script>