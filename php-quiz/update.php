<?php
require_once('database.php');
session_start();
$email =$_SESSION['email'];

  if(@$_GET['demail']) 
  {
    $email=@$_GET['demail'];
    $r1 = mysqli_query($connection,"DELETE FROM rank WHERE email='$email' ") or die('Error');
    $r2 = mysqli_query($connection,"DELETE FROM history WHERE email='$email' ") or die('Error');
    $result = mysqli_query($connection,"DELETE FROM user WHERE email='$email' ") or die('Error');
    header("location:dashboard.php?q=1");
  }


if(isset($_POST['submit'])){
if(@$_GET['q']=='addquiz')

    {
        $title = $_POST['title'];
        $title= ucwords(strtolower($title));
        $total = $_POST['total'];
        $correct = $_POST['correct'];
        $wrong = $_POST['wrong'];
        $id=uniqid();
        $q3=mysqli_query($connection,"INSERT INTO quiz VALUES  ('$id','$title' , '$correct' , '$wrong','$total', NOW())");
        header("location:dashboard.php?q=4&step=2&eid=$id&n=$total");
      }
    }
  

    
    if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) 
  {
    $eid=@$_GET['eid'];
    $sn=@$_GET['n'];
    $total=@$_GET['t'];
    $ans=$_POST['ans'];
    $qid=@$_GET['qid'];
    $q=mysqli_query($connection,"SELECT * FROM answer WHERE qid='$qid' " );
    while($row=mysqli_fetch_array($q) )
    {  $ansid=$row['ansid']; }
    if($ans == $ansid)
    {
      $q=mysqli_query($connection,"SELECT * FROM quiz WHERE eid='$eid' " );
      while($row=mysqli_fetch_array($q) )
      {
        $correct=$row['correct'];
      }
      if($sn == 1)
      {
        $q=mysqli_query($connection,"INSERT INTO history VALUES('$email','$eid' ,'0','0','0','0',NOW())")or die('Error');
      }
      $q=mysqli_query($connection,"SELECT * FROM history WHERE eid='$eid' AND email='$email' ")or die('Error115');
      while($row=mysqli_fetch_array($q) )
      {
        $s=$row['score'];
        $c=$row['correct'];
      }
      $correct++;
      $s=$s+$c;
      $q=mysqli_query($connection,"UPDATE `history` SET `score`=$s,`level`=$sn,`correct`=$correct, date= NOW()  WHERE  email = '$email' AND eid = '$eid'")or die('Error124');
    } 
    else
    {
      $q=mysqli_query($connection,"SELECT * FROM quiz WHERE eid='$eid' " )or die('Error129');
      while($row=mysqli_fetch_array($q) )
      {
        $wrong=$row['wrong'];
      }
      if($sn == 1)
      {
        $q=mysqli_query($connection,"INSERT INTO history VALUES('$email','$eid' ,'0','0','0','0',NOW() )")or die('Error137');
      }
      $q=mysqli_query($connection,"SELECT * FROM history WHERE eid='$eid' AND email='$email' " )or die('Error139');
      while($row=mysqli_fetch_array($q) )
      {
        $s=$row['score'];
        $w=$row['wrong'];
      }
      $w++;
      $s=$s-$wrong;
      $q=mysqli_query($connection,"UPDATE `history` SET `score`=$s,`level`=$sn,`wrong`=$w, date=NOW() WHERE  email = '$email' AND eid = '$eid'")or die('Error147');
    }
    if($sn != $total)
    {
      $sn++;
      header("location:welcome.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total")or die('Error152');
    }
    else if( $_SESSION['key']!='')
    {
      $q=mysqli_query($connection,"SELECT score FROM history WHERE eid='$eid' AND email='$email'" )or die('Error156');
      while($row=mysqli_fetch_array($q) )
      {
        $s=$row['score'];
      }
      $q=mysqli_query($connection,"SELECT * FROM rank WHERE email='$email'" )or die('Error161');
      $rowcount=mysqli_num_rows($q);
      if($rowcount == 0)
      {
        $q2=mysqli_query($connection,"INSERT INTO rank VALUES('$email','$s',NOW())")or die('Error165');
      }
      else
      {
        while($row=mysqli_fetch_array($q) )
        {
          $sun=$row['score'];
        }
        $sun=$s+$sun;
        $q=mysqli_query($connection,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'")or die('Error174');
      }
      header("location:welcome.php?q=result&eid=$eid");
    }
    else
    {
      header("location:welcome.php?q=result&eid=$eid");
    }
  }

  if(@$_GET['q']== 'quizre' && @$_GET['step']== 25 ) 
  {
    $eid=@$_GET['eid'];
    $n=@$_GET['n'];
    $t=@$_GET['t'];
    $q=mysqli_query($connection,"SELECT score FROM history WHERE eid='$eid' AND email='$email'" )or die('Error156');
    while($row=mysqli_fetch_array($q) )
    {
      $s=$row['score'];
    }
    $q=mysqli_query($connection,"DELETE FROM `history` WHERE eid='$eid' AND email='$email' " )or die('Error184');
    $q=mysqli_query($connection,"SELECT * FROM rank WHERE email='$email'" )or die('Error161');
    while($row=mysqli_fetch_array($q) )
    {
      $sun=$row['score'];
    }
    $sun=$sun-$s;
    $q=mysqli_query($connection,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'")or die('Error174');
    header("location:welcome.php?q=quiz&step=2&eid=$eid&n=1&t=$t");
  }
  ?>
  <!--add question--->
  <?php
if(isset($_POST['submit'])){
  if(@$_GET['q']=='addqns'){
    $n=@$_GET['n'];
    $eid=@$_GET['eid'];
    $ch=@$_GET['ch'];
    for($i=1;$i<=$n;$i++)
    {
      $qid=uniqid();
      $qns=$_POST['qns'.$i];
      $q3=mysqli_query($connection,"INSERT INTO questions VALUES  ('$eid','$qid','$qns' , '$ch' , '$i')");
        $oaid=uniqid();
        $obid=uniqid();
        $ocid=uniqid();
        $odid=uniqid();
        $a=$_POST[$i.'1'];
        $b=$_POST[$i.'2'];
        $c=$_POST[$i.'3'];
        $d=$_POST[$i.'4'];
        $qa=mysqli_query($connection,"INSERT INTO options VALUES  ('$qid','$a','$oaid')") or die('Error61');
        $qb=mysqli_query($connection,"INSERT INTO options VALUES  ('$qid','$b','$obid')") or die('Error62');
        $qc=mysqli_query($connection,"INSERT INTO options VALUES  ('$qid','$c','$ocid')") or die('Error63');
        $qd=mysqli_query($connection,"INSERT INTO options VALUES  ('$qid','$d','$odid')") or die('Error64');
        $e=$_POST['ans'.$i];
        switch($e)
        {
          case 'a' : $ansid = $oaid;
                      break;
          case 'b' : $ansid = $obid;
                    break;
          case 'c' : $ansid = $ocid;
                      break;
          case 'd' : $ansid = $odid;
                      break;
          default:$ansid=$oaid;
        }
        $qans=mysqli_query($connection,"INSERT INTO answer VALUES ('$qid','$ansid')");
    }
    header('location:dashboard.php?q=0');
  }
}


?>