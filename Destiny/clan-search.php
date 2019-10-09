<!DOCTYPE html>
<?php
 $apiKey = 'e1a491b9902d41389cc65267bcec0239';
 session_start();
?>
<html lang="en" class="h-100"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Seraphim Code</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sticky-footer-navbar/">

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    <!-- Custom styles for this template -->
    <link href="./Sticky Footer Navbar Template · Bootstrap_files/sticky-footer-navbar.css" rel="stylesheet">
  </head>


  <body class="d-flex flex-column h-100">
  
    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" style="color:white">Seraphim Code</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="../">Home <span class="sr-only"></span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./">Destiny <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="./clan-search.php">Clan Search <span class="sr-only"></span></a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

<!-- Main page content -->
<main role="main" class="flex-shrink-0" style="margin-top: 10%">

<div class="container center">
    <!-- Search form -->
    <div class="container">
      <form class="example">
        <h1>Search for a Clan</h1>
        <input type="text" placeholder="Search.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>

    <br><br>

    <div class="container">

    <?php

      if(isset($_GET['search'])){

        $clan_name = $_GET['search'];

        //$clan_name = str_replace(' ',"%20",$clan_name);
        //$clan_name = str_replace("'","&#39;",$clan_name);

        $clan_name = urlencode ( $clan_name ); 

        $clan_name = str_replace('+',"%20",$clan_name);

        echo '<br>';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.bungie.net/Platform/GroupV2/Name/'.$clan_name.'/1/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
       
        $json = json_decode(curl_exec($ch));
        
        //echo "<br><br>Debug<br>";
        //print_r(curl_getinfo($ch));

        if(isset($json)){

          echo '<h1>'.$json->Response->detail->name.'</h1>';
          echo '<p><i>'.$json->Response->detail->motto.'</i></p>';
          echo '<p>'.$json->Response->detail->about.'</p>';
          echo '<p>Member Count: '.$json->Response->detail->memberCount.'/'.$json->Response->detail->features->maximumMembers.'</p>';

          $member_call = curl_init();
          curl_setopt($member_call, CURLOPT_URL, 'https://www.bungie.net/Platform/GroupV2/'.$json->Response->detail->groupId.'/Members/');
          curl_setopt($member_call, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($member_call, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
         
          $member_json = json_decode(curl_exec($member_call));

          echo '<br><h2>Public Member List</h2><br><br>';

          echo '<table>';

          $results = $member_json->Response->results;

          $i = 0; 

          while($i < count($results)){

            echo '<tr>';
            echo '<td style="border-collapse: collapse; border:1pt solid black;">';

            if($results[$i]->destinyUserInfo->crossSaveOverride != 0){
              echo '<img src="https://i.imgur.com/4f3xKlT.png" style="margin-left: 0.5%; width: 6.5%; height: 8.5%;">';
            } else {

              switch($results[$i]->destinyUserInfo->membershipType){

                case 1:
                    echo '<img src="https://i.imgur.com/BevwBOg.png" style="margin-left: 1.5%; width: 6.5%; height: 6.5%;">';
                    break;
                case 2:
                    echo '<img src="https://i.imgur.com/0WIQXLq.png"  style="width: 10%; height: 18%;">';
                    break;
                case 3:
                    echo '<img src="https://i.imgur.com/PVWMEwR.png"  style="width: 10%; height: 18%;">';
                    break;
                case 4:
                    echo '<img src="https://i.imgur.com/UfnuPfw.png"  style="width: 10%; height: 21%;">';
                    break;
                case 5:
                    echo '<img src="https://i.imgur.com/1XIuoKN.png"  style="width: 15%; height: 15%;">';
                    break;
              }
            }

            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$results[$i]->destinyUserInfo->displayName;
            
            if($results[$i]->isOnline == 1){
              echo '<td style="border-collapse: collapse; border:1pt solid black;">&nbsp;&nbsp;&nbsp;[Status: Online]&nbsp;&nbsp;&nbsp;</td>';
            } else {
              echo '<td style="border-collapse: collapse; border:1pt solid black;">&nbsp;&nbsp;&nbsp;[Status: <i>Offline</i>]&nbsp;&nbsp;&nbsp;</td>';
            }

            switch($results[$i]->memberType){

              case 1:
                  echo '<td style="border-collapse: collapse; border:1pt solid black;">&nbsp;&nbsp;&nbsp;[Beginner]&nbsp;&nbsp;&nbsp;</td>';
                  break;
              case 2:
                  echo '<td style="border-collapse: collapse; border:1pt solid black;">&nbsp;&nbsp;&nbsp;[Member]&nbsp;&nbsp;&nbsp;</td>';
                  break;
              case 3:
                  echo '<td style="border-collapse: collapse; border:1pt solid black;">&nbsp;&nbsp;&nbsp;[Admin]&nbsp;&nbsp;&nbsp;</td>';
                  break;
              case 4:
                  echo '<td style="border-collapse: collapse; border:1pt solid black;">&nbsp;&nbsp;&nbsp;[Acting Founder]&nbsp;&nbsp;&nbsp;</td>';
                  break;
              case 5:
                  echo '<td style="border-collapse: collapse; border:1pt solid black;">&nbsp;&nbsp;&nbsp;[Founder]&nbsp;&nbsp;&nbsp;</td>';
                  break;
            }

            echo '</td>';
            echo '</tr>';
            $i++;
          }

          echo '</table>';

          echo '<br><br>';
          //print_r($member_json);
        } else {
          echo 'An error occured in lookup, please try again. It is possible the API could not locate anything to return and simply did not return any information';
        }

        
        
      }

    ?>

    </div>

</div>

</main>

<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">© William Hambrick 2019</span>
  </div>
</footer>
<script src="./Sticky Footer Navbar Template · Bootstrap_files/jquery-3.3.1.slim.min.js.download" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script><script src="./Sticky Footer Navbar Template · Bootstrap_files/bootstrap.bundle.min.js.download" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body></html>