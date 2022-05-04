<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $type = $_SESSION["type"];

    $n_year = 2564;
    $n_group = 1;
    $r_term = 1;
    //id=1&n_year=2564&n_group=1
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>โปรแกรมคำนวณ</title>

        <script type='text/javascript'>
            function nStr() {
                var int1 = document.getElementById('r_ework').value;
                var int2 = document.getElementById('r_ecompany').value;
                var int3 = document.getElementById('r_esupervision').value;
                var n1 = parseInt(int1);
                var n2 = parseInt(int2);
                var n3 = parseInt(int3);
                var show = document.getElementById('show');

                if (isNaN(n1)) {
                    document.getElementById("show").setAttribute("color", "red");
                    show.innerHTML = ""
                    if (int2.length > 0) {
                        if (isNaN(int1)) {
                            document.getElementById("show").setAttribute("color", "red");
                            //show.innerHTML = ""
                            $total = show.innerHTML = n1 + n3;
                        } else if (isNaN(int2)) {
                            document.getElementById("show").setAttribute("color", "red");
                            //show.innerHTML = ""
                            $total = show.innerHTML = n2 + n3;
                        } else if (int1.length > 0) {
                            document.getElementById("show").setAttribute("color", "Blue");
                            $total = show.innerHTML = n1 + n2 + n3;
                        } else if (int2.length > 0) {
                            document.getElementById("show").setAttribute("color", "Blue");
                            $total = show.innerHTML = n2 + n3;
                        }
                    }
                } else if (int1.length > 0) {
                    if (isNaN(int2)) {
                        document.getElementById("show").setAttribute("color", "red");
                        //show.innerHTML = ""
                        $total = show.innerHTML = n2 + n3;
                    } else if (int2.length > 0) {
                        document.getElementById("show").setAttribute("color", "Blue");
                        $total = show.innerHTML = n1 + n2 + n3;
                    } else if (int1.length > 0) {
                        document.getElementById("show").setAttribute("color", "Blue");
                        $total = show.innerHTML = n1 + n3;
                    }
                }
            }

            function addCommas(nStr) //ฟังชั่้นเพิ่ม คอมม่าในการแสดงเลข
            {
                nStr += '';
                x = nStr.split('.');
                show = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    show = show.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }
        </script>
    </head>

    <body>
        <table class="table table-bordered " style="border-color: black;" id="data" style="width: 100%;">
            <thead>
                <tr style="text-align: center;background-color:#DFF3F7;" class="text-dark">
                    <td width="15%">#</td>
                    <td width="20%">ชื่อสกุล</td>
                    <td width="15%">คะแนนจากสมุด</td>
                    <td width="25%">คะแนนจากสถานประกอบการ</td>
                    <td width="15%">คะแนนนิเทศ</td>
                    <td width="10%">รวม</td>
                    <td width="10%">รวม</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT branch.*,student.*,petition.*,results.*
                FROM student  
                LEFT JOIN branch ON student.br_id  = branch.br_id
                LEFT JOIN petition ON petition.s_id  = student.s_id  
                LEFT JOIN results ON results.pe_id  = petition.pe_id 
                where student.n_year='$n_year' and student.n_group='$n_group' and results.r_term='$r_term'";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result)) { ?>
                    <tr class="text-dark" style="text-align: center;">
                        <td><?php echo $row['s_id']; ?></td>
                        <td class="name">
                            <?php echo $row['s_fna'] ?>&nbsp;<?php echo $row['s_lna']; ?>
                        </td>
                        <td><input name="r_ework" id="r_ework" onkeyup='nStr()' maxlength="2" class="form-control" placeholder="-กรุณาใส่คะแนน-" onkeypress="isInputNumber(event)" type="text" required></td>
                        <td><input name="r_ecompany" id="r_ecompany" onkeyup='nStr()' maxlength="2" class="form-control" placeholder="-กรุณาใส่คะแนน-" onkeypress="isInputNumber(event)" type="text" required></td>
                        <td><input name="r_esupervision" id="r_esupervision" value="<?php echo $row['r_esupervision'] ?>" readonly class="form-control" onkeypress="isInputNumber(event)" type="text" required></td>
                        <td>
                            <font id="show" color=""></font>
                        </td>
                        <!-- <td><input type='text' id='input1' onkeyup='nStr()'></td>
                        <td><input type='text' id='input2' onkeyup='nStr()'></td> 
                        <td><font id="show" color=""></font></td>  -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <center>
            <p><b>โปรแกรมคำนวณบวกเลข</b></p>
            Input1 :<input type='text' id='input1' onkeyup='nStr()'> <br />
            Input2 :<input type='text' id='input2' onkeyup='nStr()'><br />
            ผลลัพธ์ : <font id="show" color=""></font>
        </center>
    </body>

    </html>
<?php
} else {
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>


