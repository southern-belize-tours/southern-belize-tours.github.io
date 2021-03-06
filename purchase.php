<?php
if(isset($_POST['email'])){
  require_once('php-mailer/PHPMailerAutoload.php');
  $mail = new PHPMailer();
  $mail->isSMTP();
  $mail->SMTPAuth=true;
  $mail->SMTPSecure = 'ssl';
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = '465'; //Can also be 587
  $mail->Username = 'SouthernBelizeTours@gmail.com'; //change this later
  $mail->Password = 'eaglei`1pwcs!!';
  $mail->SetFrom('no-reply@southern-belize-tours.com');
  $mail->Subject = 'Booking Confirmed! Do Not Reply!';

  $tourOptions = array(
    array('nimLi','Nim Li Punit Mayan ruins'),
    array('spiceFarm','Spice Farm tropical botanical gardens'),
    array('jungleTube','South Staan Creek jungle river tubing'),
    array('waterfallSightseeing','Waterfall sightseeing'),
    array('lubaantun','Lubaantun Mayan Ruins'),
    array('inlandBlueHole','Inland Blue Hole'),
    array('blueHoleFlyover','Great Blue Hole flyover'),
    array('southwaterSnorkelHalf','Southwater Caye snorkeling (full day)'),
    array('southwaterSnorkelFull','Southwater Caye snorkeling (half day)'),
    array('southWaterFishing','Southwater Caye fishing'),
    array('atmCave','ATM Cave adventure'),
    array('caveTubing','Cave Tubing'),
    array('twinCities','Twin Cities Mayan ruins'),
    array('ziplining','Jungle Ziplining'),
    array('zoo','Belize Zoo')
  );

  $checkedTours = "Your party of ".$_POST['partySize'] . " has booked the following tours: <div style='margin-top: 10px;margin-bottom: 10px;'>";
  foreach($tourOptions as $tour){
    if(!empty($_POST[$tour[0]]))
    {
      $checkedTours = $checkedTours . '<div style="margin-left:15px;margin-top: 3px;margin-bottom: 3px;font-size:18;color: rgb(23,123,211);">' . $tour[1] . '</div>';
    }
  }
  $checkedTours = $checkedTours . '</div>';
  $location="";
  if(empty($_POST['hotelAddress']) || $_POST['hotelAddress']=='')
  {
    $location="Placencia Docks. Please try to take the earliest possible ferry from Harvest Caye, the Norweigan Cruise Line drop off point, as the ferries often meet capacity.";
  }
  else $location = $_POST['hotelAddress'];

  $tourDeposit = strval((float)(floatval($_POST['totalUSD'])/10));
  $remainderCost = strval(floatval($_POST['totalUSD'])-floatval($tourDeposit));
  $remainderBZE = strval(floatval($remainderCost*2));

  $messageBody =
               '<div style="background-color:#1d3d75;display:inline-block;text-align:center;width:100%;padding-top:10px;padding-bottom:5px;">'
               .'<img src="https://southern-belize-tours.com/images/companyLogo4.png" width=110px height=110px>'
               .'</div>'
               .'<div style="background-color:#fafafa;padding:15px;line-height:25px;">'
               .'<div style="font-size:18px;color:black;">' .$_POST['first_name'].' ' .$_POST['last_name'] .',<br>'
               . 'Congrats on your booking on '.$_POST['month'] .'/'.$_POST['day'].'/20' .$_POST['year'] . '! We are very excited to show you the wonders of Belize! <br>'
               .$checkedTours
               . 'The total cost for your bookings is $' .$_POST['totalUSD'] . '.<br>'
               .'You have payed a nonrefundable tour deposit of $' . $tourDeposit
               .' through Paypal. The remainder of $' .$remainderCost . ' USD or $'.$remainderBZE
               .' Belizian Dollars is to be payed to your tour guide in cash.'
               .'<br> Before your tour, you can expect our guides to contact you at your email '.$_POST['email'].' covering logistics.'
               .'<br> We will be picking you up from '
               .$location
               .'<br> If you have any questions about your booking please contact us at placencia.action.tours@outlook.com'
               . '</div>'
               . '</div>';

  $mail->Body = $messageBody;
  $mail->isHTML();
  $mail->AddAddress('placencia.action.tours@outlook.com');    //Add addresses for all necessary people eg julian and whoever confirmed it
  //$mail->AddAddress('ianfeekes@gmail.com');
  $mail->AddAddress($_POST['email']);       //This line should be for the user address
  $mail->Send();

  header('Location: thankYou.html');
  exit;

  /*$mail->SMTPDebug = 2;
  if(!$mail->Send()){
    echo 'message was not send.';
  }
  else echo 'message sent successfully.';*/
}

//This is a debugging line. Delete it for release.
//$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};

 ?>
