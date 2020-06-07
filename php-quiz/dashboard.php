<?php
    include_once 'database.php';
    session_start();
    if(!(isset($_SESSION['email'])))
    {
        header("location:admin.php");
    }
    else
    {
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        include_once 'database.php';
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
	
    <title>Dashboard || PHP Quiz</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <a class="navbar-brand" href="dashboard.php?q=0">DASHBOARD</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li <?php if(@$_GET['q']==0) echo'class="nav-item active"'; ?>>
        <a class="nav-link" href="dashboard.php?q=0">Home <span class="sr-only">(current)</span></a>
      </li>
      <li <?php if(@$_GET['q']==1) echo 'class="nav-item"';?>>
        <a class="nav-link" href="dashboard.php?q=1">User</a>
      </li>
      <li <?php if(@$_GET['q']==2) echo'class="nav-item"';?>>
        <a class="nav-link" href="dashboard.php?q=2">Ranking</a>
      </li>
      <li <?php if(@$_GET['q']==4 || @$_GET['q']==5) echo'class="nav-item dropdown"';?>>
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Quiz
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="dashboard.php?q=4">Add Quiz</a>
          <a class="dropdown-item" href="dashboard.php?q=5">Remove Quiz</a>
        </div>
      </li>
      <!-- <li <?php if(@$_GET['q']==4 && @$_GET['step']==2 ) echo'class="nav-item"';?>>
        <a class="nav-link" href="dashboard.php?q=4&step=2">Add Questions</a>
      </li> -->
      <li class=" nav-item">
      <a class="nav-link"style="margin-left:6rem"; >welcome <?php echo $name;?></a>
      </li>
    </ul>
    
      <div>
   <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</button> -->
  </div>
    
  </div>
</nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(@$_GET['q']==0)
                {
                   echo '<div class="list-group">
                   <a href="dashboard.php?q=1" class="list-group-item list-group-item-action active">
                     USER
                   </a>
                   <a href="dashboard.php?q=2" class="list-group-item list-group-item-action">RANKING
                   </a>
                   <a href="dashboard.php?q=4" class="list-group-item list-group-item-action ">QUIZ|Add
                   </a>
                   <a href="dashboard.php?q=5" class="list-group-item list-group-item-action ">QUIZ|Remove
                   </a>
                 </div>';
					
                }
                ?>
                <?php
                if(@$_GET['q']==1){
                    $result=mysqli_query($connection,"SELECT * FROM user ")or die("error");
                    echo'<table class="table table-hover">
                    <tr><td>S.N</td>
                        <td>Name</td>
                        <td>College</td>
                        <td>Email</td>
                        <td>Action</td></tr>';
                        $c=1;
                        while($row=mysqli_fetch_array($result)){
                            $name=$row['name'];
                            $college=$row['college'];
                            $email=$row['email'];
                            echo '<tr><td>'.$c++.'</td><td>'.$name.'</td><td>'.$college.'</td><td>'.$email.'</td><td><button class="btn btn-outline-danger"><a href="update.php?demail='.$email.'">Delete User<i class="fas fa-trash-alt"></i></a></button></td></tr>';
                        }
                        $c=0;
                        echo '</table>';               
            
                    }
                    ?>
                    <?php

                if(@$_GET['q']== 2) 
                {
                    $rank_sql=mysqli_query($connection,"SELECT * FROM rank  ORDER BY score DESC " )or die('Error223');
                    echo  '<table class="table table-hover">
                    <tr><td>Rank</td>
                        <td>Name</td>
                        <td>Score</td>
                        </tr>';
                    $c=0;
                    while($row=mysqli_fetch_array($rank_sql) )
                    {
                        $e=$row['email'];
                        $s=$row['score'];
                        $q12=mysqli_query($connection,"SELECT * FROM user WHERE email='$e' " )or die('Error231');
                        while($row=mysqli_fetch_array($q12) )
                        {
                            $name=$row['name'];
                            $college=$row['college'];
                        }
                        $c++;
                        echo '<tr><td style="color:#99cc32"><center><b>'.$c.'</b></center></td><td><center>'.$e.'</center></td><td><center>'.$s.'</center></td>';
                    }
                    echo '</table>';
                }
                ?>
                <?php
                if(@$_GET['q']==4&& !(@$_GET['step'])){
                    echo '<div class="row mt-5">
                    <div class="col-md-6 m-auto">
                      <div class="card card-body">
                        <h1 class="text-center mb-3"><i class="fas fa-sign-in-alt"></i>Add Quiz</h1>
                       
                        <form action="update.php?q=addquiz" method="POST">';
                        echo '
                          <div class="form-group">
                            <label for="title"></label>
                            <input
                              type="text"
                              id="title"
                              name="title"
                              class="form-control"
                              placeholder="Enter Quiz Title"
                            />
                          </div>
                          <div class="form-group">
                            <label for="total"></label>
                            <input
                              type="number"
                              id="total"
                              name="total"
                              class="form-control"
                              placeholder="Enter Total Number Of Questions"
                            />
                          </div>
                          <div class="form-group">
                          <label for="correct"></label>
                          <input
                            type="number"
                            id="correct"
                            name="correct"
                            class="form-control"
                            placeholder="Enter Marks On Right Answer"
                            min="0"
                          />
                        </div>
                        <div class="form-group">
                        <label for="wrong"></label>
                        <input
                          type="number"
                          id="wrong"
                          name="wrong"
                          class="form-control"
                          placeholder="Enter Minus Marks On wrong Answer"
                          min="0"
                        />
                      </div>
                          <button name ="submit" type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                      </div>
                    </div>
                  </div>';
                }
                ?>

<?php

                if(@$_GET['q']==4 && (@$_GET['step']==2)){
                    echo '<div class="row mt-5">
                    <div class="col-md-6 m-auto">
                      <div class="card card-body">
                        <h1 class="text-center mb-3"><i class="fas fa-plus-circle"></i>Add Questions</h1>
                       
                        <form action="update.php?q=addqns&n='.@$_GET['n'].'&eid='.@$_GET['eid'].'&ch=4 " method="POST">';
                        
                        for($i=1;$i<=@$_GET['n'];$i++){
                          echo '
                          <div class="form-group">
                            <label for="title">Question number'.$i.'</label>
                            <input
                            rows="3"
                            cols="5"
                              type="text"
                              id="title"
                              name="qns'.$i.'"
                              class="form-control"
                              placeholder="Write question number '.$i.' here..."
                            />
                          </div>
                          <div class="form-group">
                            <label for="'.$i.'1"></label>
                            <input
                              type="text"
                              id="'.$i.'1"
                              name="'.$i.'1"
                              class="form-control"
                              placeholder="Enter Option a"
                            />
                          </div>
                          <div class="form-group">
                          <label for="'.$i.'2"></label>
                          <input
                            type="text"
                            id="'.$i.'2"
                            name="'.$i.'2"
                            class="form-control"
                            placeholder="Enter Option b"
                          />
                        </div>
                        <div class="form-group">
                            <label for="'.$i.'3"></label>
                            <input
                              type="text"
                              id="'.$i.'3"
                              name="'.$i.'3"
                              class="form-control"
                              placeholder="Enter Option c"
                            />
                          </div>
                          <div class="form-group">
                            <label for="'.$i.'4"></label>
                            <input
                              type="text"
                              id="'.$i.'4"
                              name="'.$i.'4"
                              class="form-control"
                              placeholder="Enter Option d"
                            />
                          </div>

                          <br />
                          <b>Correct answer</b>:<br />
                          <select id="ans'.$i.'" name="ans'.$i.'" placeholder="Choose correct answer " class="form-control input-md" >
                                    <option value="a">Select answer for question '.$i.'</option>
                                    <option value="a"> option a</option>
                                    <option value="b"> option b</option>
                                    <option value="c"> option c</option>
                                    <option value="c"> option d</option>
                                    </select>';
                               }
                        
                            echo'      
                            </ br> 
                      
                          <button name ="submit" type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                      </div>
                    </div>
                  </div>';
                }
                ?>

                <?php
                  if(@$_GET['q']=='5'){
                    $result = mysqli_query($connection,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
                    echo  '<div class="table-responsive"><table class="table table-hover">
                    <thead>
                    <tr>
                      <th scope="col">S.N</th>
                      <th scope="col">Topic</th>
                      <th scope="col">Questions</th>
                      <th scope="col">Marks</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>';
                    $c=1;
                    while($row = mysqli_fetch_array($result)) {
                        $title = $row['title'];
                        $total = $row['total'];
                        $correct = $row['correct'];
                        $eid = $row['eid'];
                        echo '<tbody>
                        <tr class="table-active">
                        <td scope="row">'.$c++.'</td>
                        <td>'.$title.'</td>
                        <td>'.$total.'</td>
                        <td>'.$total*$correct.'</td>
                        <td><a href="update.php?q=rmquiz&eid='.$eid.'"><i class="fas fa-trash-alt"></i>Remove</a></td>
                      </tr>
                      </tbody>';
                       
                    }
                    $c=0;
                    echo '</table></div>';
                  }

                ?>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>