<?php
require 'database.php';
session_start();
if(!isset($_SESSION['email'])){
    header("location:login.php");
}else {
    $name =$_SESSION['name'];
    $email=$_SESSION['email'];
    require 'database.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/4/journal/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <title>Welcome | Php Quiz</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Quiz</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor03">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active" <?php if(@$_GET['q']==1) echo 'class="active"';?>>
        <a class="nav-link" href="welcome.php?q=1"><i class="fas fa-home"></i>&nbsp;Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item" <?php if(@$_GET['q']==2) echo 'class="active"';?>>
        <a class="nav-link" href="welcome.php?q=2"><i class="fas fa-history"></i>&nbsp;History</a>
      </li>
      <li class="nav-item" <?php if(@$_GET['q']==3) echo 'class="active"';?>>
        <a class="nav-link" href="welcome.php?q=3"><i class="fas fa-chart-bar"></i>&nbsp;Ranking</a>
      </li>
     
    </ul>
   <div>
   <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</button> -->
  </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <?php if(@$_GET['q']==1){
            $result=mysqli_query($connection,"SELECT * FROM quiz ORDER BY date DESC")or die("error");
            echo '<table class="table table-hover">
            <tr><td>S.N</td>
                <td>Title</td>
                <td>Total Question</td>
                <td>Marks</td>
                <td>Action</td>
            ';
            $c=1;
            while($row=mysqli_fetch_array($result)){
                $title=$row['title'];
                $total=$row['total'];
                $correct=$row['correct'];
                $eid=$row['eid'];
                $s12=mysqli_query($connection,"SELECT score FROM history WHERE eid='$eid' AND email='$email'")or die('error');
                $rowCount=mysqli_num_rows($s12);
                if($rowCount==0){
                    echo '<tr><td>'.$c++.
                         '</td><td>'.$title.
                         '</td><td>'.$total.
                         '</td><td>'.$correct*$total.
                         '</td><td><a href="welcome.php?q=quiz&step=2&eid='.$eid.'&n=1&t='.$total.'" class="btn btn-success" ><b>Start</b></a></td></tr>';
                                                
                }else {
                    echo '<tr><td>'.$c++.
                    '</td><td>'.$title.
                    '</td><td>'.$total.
                    '</td><td>'.$correct*$total.
                    '</td><td><a href ="update.php?q=quizre&step=25&eid='.$eid.'&n=1&t='.$total.'"class="btn btn-warning">Restart</a></td></tr>';
                    }
            }
            $c=0;
            echo '</table>';
        }
        ?>
<?php
                    if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) 
                    {
                        $eid=@$_GET['eid'];
                        $sn=@$_GET['n'];
                        $total=@$_GET['t'];
                        $qid=@$_GET['qid'];
                        $optionid=@$_GET['optionid'];
                        $q=mysqli_query($connection,"SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' " );
                        echo '<div class="card card-body" style="margin:5%">';
                        while($row=mysqli_fetch_array($q) )
                        {
                            $qns=$row['qns'];
                            $qid=$row['qid'];
                            echo '<b>Question &nbsp;'.$sn.'&nbsp;::<br /><br />'.$qns.'</b><br /><br />';
                        }
                        $q=mysqli_query($connection,"SELECT * FROM options WHERE qid='$qid' " );
                        echo '<form action="update.php?q=quiz&step=2&eid='.$eid.'&n='.$sn.'&t='.$total.'&qid='.$qid.'" method="POST"  class="form-horizontal">
                        <br />';

                        while($row=mysqli_fetch_array($q) )
                        {
                            $option=$row['option'];
                            echo'<input type="radio" name="ans" value="'.$optionid.'">&nbsp;'.$option.'<br /><br />';
                            $optionid=$row['optionid'];
                        }
                        echo'<br /><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;Submit</button></form></div>';
                    }
?>
<?php
        
         if(@$_GET['q']=='result' && $_GET['eid']){
          $eid =@$_GET['eid'];
          $query = mysqli_query($connection,"SELECT * FROM history WHERE eid ='$eid' AND email='$email'") or die('error');
          echo '<div class="row mt-5"
                <h1>Result</h1>
                <table class="table table-hover>';
                  while($row=mysqli_fetch_array($query)){
                    $score = $row['score'];
                    $wrong= $row['wrong'];
                    $correct =$row['correct'];
                    $level =$row['level'];
                    echo '<tr><td>Total Questions</td><td>'.$level.'</td></tr>
                    <tr><td>right Answer&nbsp;</td><td>'.$correct.'</td></tr> 
                    <tr><td>Wrong Answer&nbsp;</td><td>'.$wrong.'</td></tr>
                    <tr style="color:#66CCFF"><td>Score&nbsp;</td><td>'.$score.'</td></tr>';
          }
          $query =mysqli_query($connection,"SELECT * FROM rank WHERE email ='$email'") or die('error123');
          while($row =mysqli_fetch_array($query)){
            $score =$row['score'];
            echo '<tr><td>Overall Score</td>
                  <td>'.$score.'</td></tr>';
          }
          echo '</table></div>';
        }
        ?>
         <?php if(@$_GET['q']==2){
           $q=mysqli_query($connection,"SELECT * FROM history WHERE email='$email' ORDER BY date DESC " )or die('Error197');
           echo  '
           <table class="table table-hover" >
           <tr><td>S.N.</td>
           <td>Quiz</td>
           <td>Question Solved</td>
           <td>Correct</td>
           <td>Wrong</td>
           <td>Score</td></tr>';
           $c=0;
           while($row=mysqli_fetch_array($q) )
           {
           $eid=$row['eid'];
           $score=$row['score'];
           $wrong=$row['wrong'];
           $correct=$row['correct'];
           $level=$row['level'];
           $q23=mysqli_query($connection,"SELECT title FROM quiz WHERE  eid='$eid' " )or die('Error208');

           while($row=mysqli_fetch_array($q23) )
           {  $title=$row['title'];  }
           $c++;
           echo '<tr><td>'.$c.'</td>
                <td>'.$title.'</td>
                <td>'.$level.'</td>
                <td>'.$correct.'</td>
                <td>'.$wrong.'</td>
                <td>'.$score.'</td></tr>';
           }
           echo'</table>';
          }
          
          if(@$_GET['q']== 3) 
                    {
                        $q=mysqli_query($connection,"SELECT * FROM rank ORDER BY score DESC " )or die('Error223');
                        echo  '
                        <table class="table table-hover" >
                        <tr><td>Rank</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Score</td></tr>';
                        $c=0;

                        while($row=mysqli_fetch_array($q) )
                        {
                            $e=$row['email'];
                            $s=$row['score'];
                            $q12=mysqli_query($connection,"SELECT * FROM user WHERE email='$e' " )or die('Error231');
                            while($row=mysqli_fetch_array($q12) )
                            {
                                $name=$row['name'];
                            }
                            $c++;
                            echo '<tr><td>'.$c.'</td>
                            <td>'.$name.'</td><td>'.$e.'</td><td>'.$s.'</td></tr>';
                        }
                        echo '</table>';
                    }
        ?>

        </div>
    </div>
</div>






   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> 

</body>
</html>