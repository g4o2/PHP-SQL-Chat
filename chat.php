<?php
session_start();
require_once "pdo.php";
date_default_timezone_set('UTC');

if (!isset($_SESSION["email"])) {
  echo "PLEASE LOGIN";
  echo "<br />";
  echo "Redirecting in 3 seconds";
  header("refresh:3;url=index.php");
  die();
}

$stmt = $pdo->query(
  "SELECT * FROM chatlog"
);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['logout'])) {
  header("Location: logout.php");
  return;
}

if (isset($_POST['message'])) {
  $stmta = $pdo->prepare(
    'INSERT INTO chatlog
  (message, message_date, account)
  VALUES (:msg, :msgd, :acc)'
  );

  $stmta->execute(
    array(
      ':msg' => $_POST['message'],
      ':msgd' => date(DATE_RFC2822),
      ':acc' => $_SESSION['name']
    )
  );
  $stmt = $pdo->query(
    "SELECT * FROM chatlog"
  );
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<html>
<title>g4o2 chat</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="./style.css">
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Alumni+Sans+Pinstripe&family=Montserrat:wght@300&family=Orbitron&family=Work+Sans:wght@300&display=swap');

  body {
    font-family: Arial, Helvetica, sans-serif;
    background-color: #121212;
    color: #ffffff;
    opacity: 87%;
    overflow-x: hidden;
  }

  #chatcontent {
    padding-left: 16px;
    border-radius: 8px;
    height: 45vh;
    overflow: auto;
    margin-left: 5px;
    border-radius: 10px;
    padding: 10px 0px 0px 30px;
    background-color: rgba(0, 0, 0, 0.6);
  }


  #chatcontent::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #353935
      /*#F5F5F5*/
    ;
  }

  #chatcontent::-webkit-scrollbar {
    width: 10px;
    background-color: #F5F5F5;
  }

  #chatcontent::-webkit-scrollbar-thumb {
    background-color: #F90;
    background-image: -webkit-linear-gradient(45deg,
        rgba(255, 255, 255, .2) 25%,
        transparent 25%,
        transparent 50%,
        rgba(255, 255, 255, .2) 50%,
        rgba(255, 255, 255, .2) 75%,
        transparent 75%,
        transparent)
  }


  ::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #353935
      /*#F5F5F5*/
    ;
  }

  ::-webkit-scrollbar {
    width: 10px;
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar-thumb {
    background-color: #F90;
    background-image: -webkit-linear-gradient(45deg,
        rgba(255, 255, 255, .2) 25%,
        transparent 25%,
        transparent 50%,
        rgba(255, 255, 255, .2) 50%,
        rgba(255, 255, 255, .2) 75%,
        transparent 75%,
        transparent)
  }

  .profile-image {
    float: left;
    height: 45px;
    width: 45px;
    border-radius: 100px;
  }

  .account {
    cursor: pointer;
    font-size: 15px;
    font-family: monospace, sans-serif;
  }

  .stats {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    color: orange;
    margin-left: 50px;
  }

  .msg {
    margin-top: -5px;
    font-size: 15px;
    font-weight: 100;
    color: white;
    margin-left: 50px;
  }

  #message-input {
    height: 36px;
    font-size: 14px;
    width: 70%;
    margin-left: 2px;
    padding-left: 12px;
    border-radius: 5px;
    border: none;
    background-color: #d1d1d1;
    transition: all .2s ease-in-out;
  }

  #message-input:focus {
    outline: none !important;
    border: 3px solid #ffa500;
    box-shadow: 0 0 0px #719ECE
  }

  #page-header {
    margin-top: -1.7%;
    margin-left: 0.3%;
  }

  h1 {
    font-family: 'Orbitron', arial;
    color: orange;
    font-size: 8vw;
    text-transform: uppercase;
    user-select: none;
  }

  #guide {
    height: 20vh;
    margin-top: -7.3%;
    margin-bottom: 1.5%;
    border-radius: 10px;
    padding: 20px 0px 20px 30px;
    background-color: rgba(0, 0, 0, 0.6);
  }

  ::placeholder {
    padding-left: 0px;
  }

  :-ms-input-placeholder {
    padding-left: 0px;
  }

  #form {
    margin-top: 1.3%;
    left: 0;
    bottom: 0;
    width: 100%;
    text-align: center;
  }

  #submit {
    background-color: rgb(1, 1, 120);
  }

  #submit:hover {
    background-color: transparent;
  }

  #logout {
    background-color: rgb(107, 0, 0);
  }

  #logout:hover {
    background-color: transparent;
  }

  .button {
    height: 35px;
    font-size: 14px;
    width: 13%;
    border: none;
    cursor: pointer;
    border-radius: 3px;
    padding: 8px;
    color: orange;
    background-color: #343434;
    transition: all .2s ease-in-out;
  }

  .button:hover {
    background-color: #121212;
    transition: all .2s ease-in-out;
    color: #ffa500;
  }

  .spinner {
    margin-left: 20%;
    margin-right: 20%;
    margin-top: 7vh;
    width: 10vw;
  }


  .rainbow_text_animated {
    background: linear-gradient(to right, #6666ff, #0099ff, #00ff00, #ff3399, #6666ff);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    animation: rainbow_animation 6s ease-in-out infinite;
    background-size: 400% 100%;
  }

  @keyframes rainbow_animation {

    0%,
    100% {
      background-position: 0 0;
    }

    50% {
      background-position: 100% 0;
    }
  }

  .not-allowed {
    cursor: not-allowed;
  }

  .progress {
    cursor: progress;
  }



  @import url('https://fonts.googleapis.com/css2?family=Alumni+Sans+Pinstripe&family=Montserrat:wght@300&family=Orbitron&family=Work+Sans:wght@300&display=swap');

  .container {
    margin-left: 40px;
    margin-top: 20px;
  }

  #profile {
    position: fixed;
    right: 10px;
    top: 10px;
    background-color: rgba(0, 0, 0, .5);
    padding: 40px;
    text-align: center;
    transition: opacity .3s ease-in;
  }


  #close-btn {
    background-color: transparent;
    color: #ffa500;
  }

  #close-btn-two {
    background-color: transparent;
    color: #ffa500;
  }

  #close-btn:hover {
    background-color: transparent !important;
    transition: all .1s ease-in !important;
    cursor: pointer;
    color: #fff;
  }

  #close-btn-two:hover {
    background-color: transparent !important;
    transition: all .1s ease-in !important;
    cursor: pointer;
    color: #fff;
  }

  .btn {
    font-family: Arial, Helvetica, sans-serif;
    text-decoration: none;
    color: #ffa500;
    background-color: rgba(41, 41, 41, 1);
    padding: 8px;
    border: none;
    font-size: 14px;
    cursor: pointer;
    transition: all .15s ease-in;
  }

  .btn:hover {
    color: #fff;
  }

  .btn:active {
    background-color: transparent;
  }
</style>
</head>

<body>
  <section id="page-header">
    <h1>g4o2&nbsp;chat</h1>
    <section style="overflow: auto;" id="guide">
      <p>Press <kbd>Enter</kbd> to submit message</p>
      <p>Press <kbd>/</kbd> to select <kbd>Esc</kbd> to deselect</p>
      <p>Users can now upload profile pictures via the edit account button on the <a style='color: #ADD8E6' href="./index.php">index</a> page</p>
    </section>
  </section>
  <section>
    <div class="progress" id="chatcontent">
      <!--<img class="spinner" src="spinner.gif" alt="Loading..." />-->
      <?php
      require_once "pdo.php";
      function loadChat($pdo)
      {
        $stmt = $pdo->query(
          "SELECT * FROM chatlog"
        );
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($rows) > 0) {
          echo "<p style='text-align:center;color: #ffa500;'>This is the start of all messages</p>";
          foreach ($rows as $row) {
            $pfpsrc = './default-pfp.png';
            $user = "<a href='./profile.php?user={$row['account']}' class='account rainbow_text_animated'>" . $row['account'] . "</a>";

            $stmta = $pdo->prepare("SELECT pfp FROM account WHERE name=?");
            $stmta->execute([$row['account']]);
            $pfptemp = $stmta->fetchAll(PDO::FETCH_ASSOC);

            foreach ($pfptemp as $test) {
              if ($test['pfp'] != null) {
                $pfpsrc = $test['pfp'];
              }
            }
            $pfp = "<img class='profile-image' src='$pfpsrc'>";


            $message = htmlentities($row['message']);
            if (isset($_COOKIE['timezone'])) {

              //might break the chat 
              $timezone_offset_minutes = $_COOKIE['timezone'];
              $time = new DateTime($row["message_date"]);
              $minutes_to_add = ($timezone_offset_minutes);
              $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
              $stamp = $time->format('D, d M Y H:i:s');
              // here ^

            } else {
              $stamp = $row["message_date"];
            }
            $info = "<p class='stats'>{$user} ({$stamp})</p>";
            $msg = "<p class='msg'>{$message}</p>";
            echo $pfp;
            echo "<div style='margin-left: 10px;margin-top: 18px;'>{$info}{$msg}</div>";
          }
        }
      };
      loadChat($pdo);
      ?>
    </div>
    <form id='form' autocomplete="off" method="post" action="chat.php">
      <div>
        <!--<input pattern=".{1,}" required title="3 characters minimum" id='message-input' type="text" name="message" size="60" placeholder="Enter message and submit" />-->
        <input id='message-input' type="text" name="message" size="60" style="width: 55vw;" placeholder="Enter message and submit" />
        <input class='button not-allowed' id="submit" type="submit" value="Chat" />
        <input class='button' id='logout' type="submit" name="logout" value="Logout" />
      </div>
    </form>
  </section>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js">
  </script>
  <script type="text/javascript">
    let input = document.getElementById('message-input');
    input.focus();
    input.select();
    let pageBody = document.getElementsByTagName('body')[0];

    $("#submit").prop("disabled", true);
    $(input).keyup(function() {
      if (!$(input).val().replace(/\s/g, '').length) {
        $("#submit").prop("disabled", true);
        $('#submit').addClass("not-allowed")
      } else {
        $("#submit").prop("disabled", false);
        $('#submit').removeClass("not-allowed");
      }
    });
    window.addEventListener("keydown", event => {
      if ((event.keyCode == 191)) {
        if (input === document.activeElement) {
          return;
        } else {
          input.focus();
          input.select();
          event.preventDefault();
        }
      }
      if ((event.keyCode == 27)) {
        if (input === document.activeElement) {
          document.activeElement.blur();
          window.focus();
          event.preventDefault();
        }
      }
    });
    $(document).ready(function() {
      setTimeout(
        function() {
          $("#chatcontent").removeClass("progress");
        }, 1000);
      console.log('%c What are you doing in the console?', 'background: #222; color: #ff0000');
      console.log('%c Dont try anything sus', 'background: #222; color: #fff');
      console.log(`

          `)

    })

    function chatScroll() {
      let chat = document.getElementById('chatcontent')
      chat.scrollTop = chat.scrollHeight;
    }
    chatScroll()

    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }

    var timezone_offset_minutes = new Date().getTimezoneOffset();
    timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;

    document.cookie = "timezone=" + timezone_offset_minutes;

    let inverval = window.setInterval(function() {
      $.ajax({
        url: "messages.php",
        success: function(data) {
          document.getElementById("chatcontent").innerHTML = data
        }
      });
      let chat = document.getElementById("chatcontent")
      if (chat.scrollTop >= (chat.scrollHeight - chat.offsetHeight) - 100) {
        //console.log("bottom")
        chatScroll()
      }
    }, 1000)
    /*
    jQuery(
        function($) {
          $('#chatcontent').bind('scroll', function() {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
              alert('end reached');
            }
            let chat = document.getElementById("chatcontent")
            if (chat.scrollTop >= (chat.scrollHeight - chat.offsetHeight) - 100) {
              console.log("bottom")
              chatScroll()
            }
        })
      }
    )*/
  </script>



  <?php
  if (isset($_SESSION['email'])) {
    $pfpsrc = './default-pfp.png';

    $stmta = $pdo->prepare("SELECT * FROM account WHERE user_id=?");
    $stmta->execute([$_SESSION['user_id']]);
    $pfptemp = $stmta->fetchAll(PDO::FETCH_ASSOC);

    foreach ($pfptemp as $test) {
      if ($test['pfp'] != null) {
        $pfpsrc = $test['pfp'];
      }
      $_SESSION['name'] = $test['name'];
      $_SESSION['email'] = $test['email'];
    }
    $pfp = "<img class='profile-image' style='border-radius: 100px;height: 60px;width:60px;'' src='$pfpsrc'>";
    $main = "<p style='margin-top: 20px;font-size: 20px;font-family: monospace;'>{$_SESSION['name']}</p><p style='font-family: monospace;'>{$_SESSION['email']}</p>";
    $actions = '<a style="color: #ADD8E6;" href="edit-account.php">Edit Account</a> | <a href="logout.php">Logout</a>';
    echo "<div style='border-radius: 12px;' id='profile'><button id='close-btn' onclick='closeProfile()' style='border:none;position:absolute;top:0;left:0;font-size: 18px;padding:5px 12px 5px 12px;'>&times;</button>{$pfp}{$main}{$actions}</div>";
    echo "<button id='close-btn-two' onclick='openProfile()' style='border:none;position:absolute;top:10px;right:10px;font-size: 18px;padding:5px 12px 5px 12px;opacity: 0;'>&#9776;</button>";
  }
  ?>
  <script>
    function closeProfile() {
      document.getElementById("profile").style.opacity = '0';
      document.getElementById("close-btn").style.opacity = '0';
      document.getElementById("close-btn-two").style.opacity = '1';
    }

    function openProfile() {
      document.getElementById("profile").style.opacity = '1';
      document.getElementById("close-btn").style.opacity = '1';
      document.getElementById("close-btn-two").style.opacity = '0';
    }
  </script>
</body>