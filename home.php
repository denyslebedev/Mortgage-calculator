<?php
require 'config.php';
$connect = new PDO("mysql:host=$server;dbname=$database_name", $database_user, $database_passwd);
session_start();

	/*** Important do not change ***/
	if(!isset($_SESSION['db_login'])){
		header("Location: index.php");
		exit();
	}
	/*** Important END ,,,***/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marafon</title>
    <link rel="stylesheet" href="./style/papa.css">
<?php 
$text_en_home="Home";
$text_en_mortcalc="Mortgage calculator"; 
$text_en_ouradr="Our address"; 
$text_en_send="Send an email"; 
?>
 <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <style type="text/css">
    body{padding-top:20px;background-color:#f9f9f9;}
  </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="js/jquery-1.11.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>



  <script>
$('form').submit(function(e){
  <?php
//AAAAAAAAAAAAAAAAAAAAAAAAAAAA
if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['id']) && isset($_POST['pre']) && isset($_POST['prepre'])&& isset($_POST['current']) ){
 
    $id = $_SESSION['db_login']['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pre = $_POST['pre'];
    $prepre = $_POST['prepre'];
    $current = $_POST['current'];
   $query = " UPDATE users  
   SET password = :password, email = :email, prepre = :prepre, pre = :pre, current = :current
   WHERE id = :id ";
   $statement = $connect->prepare($query);
   $statement->execute(
   array(
    'email' => $email,
    'password'  => $password,
    'prepre' => $prepre,
    'pre' => $pre,
    'current' => $current,
    'id' => $id
   )
  );
}
?>


}
</script>

</head>
<body>
    <header class="container header">
        <div>
            <a href="">
                <img src="new/Logo.png" alt="">
            </a>
        </div>
        <nav>
            <ul>
                
                <li class="nav-li">
                    <a class="nav-link" href="">
                    <?php echo $text_en_home;?>
                    </a>
                </li>
                <li class="nav-li">
                    <a class="nav-link" href="index.php">
                        <?php echo $text_en_mortcalc;?>
                    </a>
                </li>
                <li class="nav-li">
                    <a class="nav-link" href="">
                    <?php echo $text_en_ouradr;?>
                    </a>
                </li>
                <li class="nav-li">
                    <a class="nav-link" href="">
                    <?php echo $text_en_send;?>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <section class="app">
        <div class="container">
            <h6 class="app-pretitle">
                Bank app 1
            </h6>
            <h1 class="app-title">
                Why stay hungry when 
                you can create own bank 
            </h1>
            <p class="app-text">
                Order in exchange for your 3 minutes
            </p>
            <div>
                <button class="button"><?php echo $text_en_mortcalc;?></button>
                
            </div>
        </div>
    </section>
    <section class="container">
        <div class="mobile1">
        <h1 class="main-title">Welcome, <?php echo $_SESSION['db_login']['firstname']." ".$_SESSION['db_login']['lastname']; ?></h1>
        </div>
    </section>

  <div class="container">
  
   <div align="right">
    <a href="index.php">Logout</a>
   </div>
   
   <?php
   if($_SESSION['db_login']['type'] !="master")
   {
     $id = $_SESSION['db_login']['id'];
    // создание строки запроса
    $query ="SELECT * FROM users WHERE id = '$id'";
    // выполняем запрос
     $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $count = $statement->rowCount();
    //если в запросе более нуля строк
   foreach($result as $row){

       // $row = mysqli_fetch_row($result); // получаем первую строку
        $email = $row["email"];
        $password = $row["password"];
        $prepre = $row["prepre"];
        $pre = $row["pre"];
        $current = $row["current"];
        if(empty($current)) { $current=1; $flag_cur=1; }


    echo " <section class='container'>
            <div class='mobile'>
        
        <div>
        
        <h2>Main settings</h2>
            <form method='POST'>
            <input type='hidden' name='id' value='$id' />
            <p>Enter email:<br> 
            <input type='text' name='email' value='$email' /></p>
            <p>Enter password: <br> 
            <input type='password' name='password' value='$password' /></p>
            
            <h2>Financial settings</h2>
            <p>Initial loan (USD): <br> 
            <input type='text' name='prepre' value='$prepre' /></p>
            <p>Down payment (USD): <br> 
            <input type='text' name='pre' value='$pre' /></p>
            <p>Bank is selected $current: <br>
            <select name='current' id='current'>";


            $query = " SELECT id, bank_name, interest_rate, max_loan, min_pay, loan_term FROM banks";
            $statement = $connect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $count = $statement->rowCount();
            foreach($result as $row)
            {
            echo '<option value='.$row["id"].''; if($current==$row["id"]) echo ' selected';
            echo '>'.$row["bank_name"].'</option>';
            }
            
           echo " </select> </p>";
     ?>
          <div style="margin-top:10px" class="form-group">
          <div class="col-sm-12 controls">
          <input type="hidden" name="type" value="login">
          <button type="submit" id="btn-login" class="btn btn-success">Calculate  </button>
          </div>
          </div>
          </form>
          <br><br>
            </div> 
            
            <?php
           $query = " SELECT bank_name, interest_rate, max_loan, min_pay, loan_term FROM banks WHERE id='$current'";
           $statement = $connect->prepare($query);
           $statement->execute();
           $result1 = $statement->fetchAll();
           $count = $statement->rowCount();
             $init_paym=$prepre;
             $down_paym = $pre;
             $start_payment=$init_paym-$down_paym;
             foreach($result1 as $row1)
            {
            ?>
            
           <div>
           <p> Bank name: <?php echo $row1["bank_name"]; ?> </p>
           <p> Interest rate: <?php echo $row1["interest_rate"]; ?>% </p>
           <p> Maximum loan: <?php echo $row1["max_loan"]; ?> USD </p>
           <p> Minimum down payment: <?php echo $row1["min_pay"]; ?>% </p>
           <p> Loan term: <?php echo $row1["loan_term"]; ?> months </p>
           <table style="margin:10px; padding:10px" table-bordered border="1" width=600>
            <tr>
            <th style="text-align:center">No. month for paying</th>
            <th style="text-align:center">Monthly mortgage payment</th>
            <th style="text-align:center">Remaining payment</th>
            </tr>
            <?php
            $percent_1=round(((float)$row1["interest_rate"]/12.0),10)/100; 
            $p_pow=round(pow((1+$percent_1),$row1["loan_term"]),6);

            $top_res=$start_payment*($percent_1)*$p_pow;
            $bot_res=$p_pow-1;
            //echo $row1["loan_term"].'!!!!'.$top_res.'='.$bot_res.'=--'.$percent_1.'-'.$p_pow;
            $month_payment=round(($top_res/$bot_res),2);
            if($flag_cur!=1)
        {
            for($i1=1; $i1<=$row1["loan_term"]; $i1++)
            {
                        
            echo '<tr><td style="text-align:center">'.$i1.'</td>
            <td style="text-align:center">'.$month_payment.'</td>
            <td style="text-align:center">'. $start_payment.'</td></tr>';
            $start_payment=round(($start_payment-$month_payment),2); 
            if($start_payment<0) 
                        { $start_payment=0;  
            echo '<tr><td style="text-align:center">'.($i1+1).'</td>
            <td style="text-align:center">'.$month_payment.'</td>
            <td style="text-align:center">0</td></tr>';
                        $i1=$row1["loan_term"]+1;
                        }
            }
        }

            ?>
            
            
            
            
            
            </table>
            </div>
            <?php } ?>
        </div>

<?php
    }
 }
   else
   {
   ?>

   <div class="panel panel-default">
    <div id="user_login_status" class="panel-body">
      <?php
        $output = '';
  $query = "
  SELECT email, firstname, lastname, pre, prepre ,current, type FROM users";

  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $count = $statement->rowCount();
  $output .= '
  <div class="table-responsive">
   <table class="table table-bordered table-striped">
    <tr>
     <th>No.</th>
     <th>Email ID</th>
     <th>Bank ID</th>
    </tr>
  ';
  $i = 0;
  foreach($result as $row)
  {
   $i = $i + 1;
   if ($row["current"]== 0  && $row["type"] !="master"){
   $output .= '
   <tr> 
    <td>'.$i.'</td>
    <td>'.$row["firstname"].' '.$row["lastname"].'</td>
    <td style="background-color:red;">'.$row["pre"].' '.$row["prepre"].' '.$row["current"].'</td>
   </tr>
   ';
   }
   else{
   $output .= '
   <tr> 
    <td>'.$i.'</td>
    <td>'.$row["firstname"].' '.$row["lastname"].'</td>
    <td>'.$row["pre"].' '.$row["prepre"].' '.$row["current"].'</td>
   </tr>
   ';
  }}
  $output .= '</table></div>';
  echo $output;
      ?>
    </div>
   </div>
   <?php
   }
   ?>
  </div>
  <section class="bot">
        <div class="container">
            <h1 class="bot-pretitle">
                Order now.
            </h1>
            <h6 class="bot-title">
                Available on your favorite store. Start your premium experience now
            </h6>
            <div>
                <button class="button1">Playstore</button>
                <button class="button1">App store</button>
            </div>
        </div>
    </section>
    <footer class="container header">
      <div>
          <a href="">
              <img src="./new/Logo.png" alt="">
          </a>
      </div>
      <p>
          Was created by WE 2022
      </p>
    </footer>
</body>
</html>