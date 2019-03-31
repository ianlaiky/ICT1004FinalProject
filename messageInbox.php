<html>
<?php
/**
 * Created by PhpStorm.
 * User: Ian
 * Date: 24/3/2019
 * Time: 3:19 PM
 */
session_start();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>FastTrade</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    <link href="css/messageinbox.css" rel="stylesheet">
    <script
            src="http://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script>
        // do not comment this
        function gettest(id) {

            location.href = location.origin + location.pathname + '?pid=' + id;
        }


        function callback() {
            console.log("test");
            ajaxcall();
            setTimeout(callback, 3000);
        }

        callback();

        function ajaxcall() {


            $.get("<?php echo dirname($_SERVER['PHP_SELF']);?>/getMessages.php?productid=" +<?php echo $_GET['pid']?>, function (data) {

                console.log("Load was performed.");
                console.log(data.length);
                console.log(data);
                console.log(document.getElementById("currentCount").textContent);

                if (document.getElementById("sendingto").textContent == "") {
                    document.getElementById("sendingto").textContent = data[data.length - 2];

                }
                if (document.getElementById("sendpid").textContent == "") {
                    document.getElementById("sendpid").textContent = data[data.length - 1];

                }


                // keep current text count; if current count is same as server, dont update
                var currentCount = document.getElementById("currentCount").textContent;
                document.getElementById("currentCount").textContent = data.length - 2;


                // i = current count, if new data, only start from the current count
                for (var i = currentCount; i < data.length - 2; i++) {

                    if (data[i].msgDirection == "from") {

                        var new_roww = document.createElement('div');
                        new_roww.className = "incoming_msg";


                        var new_received_msg_ = document.createElement('div');
                        new_received_msg_.className = "received_msg";

                        new_roww.appendChild(new_received_msg_);

                        var new_received_withd_msg_ = document.createElement('div');
                        new_received_withd_msg_.className = "received_withd_msg";
                        new_received_msg_.appendChild(new_received_withd_msg_);


                        var new_pa = document.createElement('p');
                        var newContentt = document.createTextNode(data[i].message_content);
                        new_pa.appendChild(newContentt);
                        new_received_withd_msg_.appendChild(new_pa);

                        var currmsg = document.getElementById("msg_history");
                        currmsg.appendChild(new_roww);


                    } else {

                        var new_rowww = document.createElement('div');
                        new_rowww.className = "outgoing_msg";


                        var new_sent_msg = document.createElement('div');
                        new_sent_msg.className = "sent_msg";

                        new_rowww.appendChild(new_sent_msg);


                        var new_par = document.createElement('p');
                        var newContentt = document.createTextNode(data[i].message_content);
                        new_par.appendChild(newContentt);
                        new_sent_msg.appendChild(new_par);

                        var currmsgs = document.getElementById("msg_history");
                        currmsgs.appendChild(new_rowww);


                    }
                }


            });

        }


    </script>

    <style>
        .currentCount {
            visibility: hidden;
        }

        #sendingto {
            visibility: hidden;
        }

        #sendpid {
            visibility: hidden;
        }
    </style>

</head>


<header>
    <?php include 'header.inc.php';
    require_once('config.php');
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

    if (mysqli_connect_errno()) {
        die(mysqli_connect_error());
    }
    ?>
</header>

<body>
<div id="sendingto"></div>
<div id="sendpid"></div>
<div class="currentCount" id="currentCount">0</div>
<div class="container">

    <div class="messaging">
        <div class="inbox_msg">
            <div class="inbox_people">
                <div class="headind_srch">
                    <div class="recent_heading">
                        <h4>Messages</h4>
                    </div>

                </div>
                <div class="inbox_chat">

                    <?php

                    require_once('config.php');
                    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

                    if (mysqli_connect_errno()) {
                        die(mysqli_connect_error());
                    }


                    // run this if new chat with new product

                    if (isset($_GET['redirect'])) {
                        if ($_GET['redirect'] == "true") {


                            $existingchat = 0;

                            $sqlFindexistingChat = "select * from users_message where (fk_custUserId = '" . $_SESSION['user_id'] . "' or fk_sellerUserId = '" . $_SESSION['user_id'] . "') and fk_productid = " . $_GET['pid'];

                            if ($resultexistingChat = mysqli_query($connection, $sqlFindexistingChat)) {
                                while ($rowexistingChat = mysqli_fetch_assoc($resultexistingChat)) {
                                    if ($rowexistingChat > 0) {


                                        $existingchat = 1;
                                    }
                                }

                                $sqlgetnewp = "select * from product where product_id='" . $_GET['pid'] . "'";
                                if ($resultexistingChat = mysqli_query($connection, $sqlgetnewp)) {
                                    while ($rowexistingChat = mysqli_fetch_assoc($resultexistingChat)) {
                                        $sqlgetseller = "select * from users where user_id='" . $rowexistingChat['userid'] . "'";
                                        $getseller = "";
                                        $getsellerid = "";
                                        $imggger=null;
                                        if ($resultgetseller = mysqli_query($connection, $sqlgetseller)) {
                                            while ($rowgetseller = mysqli_fetch_assoc($resultgetseller)) {
                                                $getseller = $rowgetseller['name'];
                                                $getsellerid = $rowgetseller['user_id'];

                                                if (!empty($rowgetseller['profile_picture'])) {
                                                $imggger = "data:image/png;base64," . base64_encode($rowgetseller['profile_picture']);
                                                } else {
                                                    $imggger = "img/user.png";
                                                }

                                            }
                                        }

                                        if ($existingchat == 0) {

                                            echo "<div onclick=\"gettest(" . $_GET['pid'] . ")\" class=\"chat_list active_chat\">";
                                            echo "<div class=\"chat_people\">";
                                            echo "<div class=\"chat_ib row\">";
                                            echo "<div class='col-md-4 '>";
                                            echo "<img class='rounded-circle' height=\"60px\" width=\"60px\" src=\"$imggger\">";
                                            echo "</div>";
                                            echo "<div class='col-md-8'>";
                                            echo "<h5>Product name: " . $rowexistingChat['title'] . "</h5>";
                                            echo "<h6>Seller: " . $getseller . "</h6>";
                                            echo "</div>";
                                            echo " </div> </div> </div>";

                                        }


                                        ?>

                                        <script>

                                            document.getElementById("sendingto").textContent = "<?php echo $getsellerid?>";


                                        </script>


                                        <?php
                                    }


                                }
                            }


                        }
                    }


                    $sql = "SELECT DISTINCT fk_productid,fk_custUserId FROM users_message where fk_custUserId = '" . $_SESSION['user_id'] . "' or fk_sellerUserId = '" . $_SESSION['user_id'] . "'";
                    $buyername = "";

                    if ($result = mysqli_query($connection, $sql)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($_SESSION['user_id'] != $row['fk_custUserId']) {


                                $sqlgetname = "select * from users where user_id ='" . $row['fk_custUserId'] . "'";


                                if ($resultgetname = mysqli_query($connection, $sqlgetname)) {
                                    while ($rowgetname = mysqli_fetch_assoc($resultgetname)) {

                                        $buyername = $rowgetname['name'];

                                    }
                                }

                            }
                            $pidd = $row['fk_productid'];

                            $sql1 = "select * from product where product_id='" . $pidd . "'";

                            if ($result1 = mysqli_query($connection, $sql1)) {
                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                    $ptitle = $row1['title'];
                                    $puserid = $row1['userid'];
                                    $sellername = "";

                                    $sql3 = "select * from users where user_id='" . $puserid . "'";

                                    $imggg = null;
                                    if ($result3 = mysqli_query($connection, $sql3)) {
                                        while ($row3 = mysqli_fetch_assoc($result3)) {
                                            $sellername = $row3['name'];
                                            if (!empty($row3['profile_picture'])) {


                                                $imggg = "data:image/png;base64," . base64_encode($row3['profile_picture']);
                                            } else {
                                                $imggg = "img/user.png";
                                            }

                                        }
                                    }


                                    $displayseller = "";
                                    if ($puserid == $_SESSION['user_id']) {
                                        $displayseller = "Buyer: " . $buyername;
                                    } else {
                                        $displayseller = "Seller: " . $sellername;
                                    }

                                    if($pidd==$_GET['pid']){
                                        echo "<div onclick=\"gettest(" . $pidd . ")\" class=\"chat_list active_chat\">";
                                    }else{
                                        echo "<div onclick=\"gettest(" . $pidd . ")\" class=\"chat_list\">";

                                    }





                                    echo "<div class=\"chat_people\">";
                                    echo "<div class=\"chat_ib row\">";
//                                    echo "<img style=\"float: right;border-radius: 50%;\" height=\"60px\" width=\"60px\" src=\"data:image/png;base64,/>";
                                    echo "<div class='col-md-4 '>";
                                    echo "<img class='rounded-circle' height=\"60px\" width=\"60px\" src=\"$imggg\">";
                                    echo "</div>";
                                    echo "<div class='col-md-8'>";
                                    echo "<h5>Product name: " . $ptitle . "</h5>";
                                    echo "<h6>" . $displayseller . "</h6>";
                                    echo "</div>";
                                    echo "</div></div></div>";

                                }

                            }

                        }
                    }

                    ?>
                    <!--                    <img class='col-md-4' style="border-radius: 50%;" height="60px" width="60px" src="data:image/png;base64, base64_encode($imggg)">-->


                    <!--                    <button onclick="gettest()">sdfds</button>-->


                    <!--                    <div class="chat_list active_chat">-->
                    <!--                        <div class="chat_people">-->
                    <!--                            <div class="chat_img"><img src="https://ptetutorials.com/images/user-profile.png"-->
                    <!--                                                       alt="sunil"></div>-->
                    <!--                            <div class="chat_ib">-->
                    <!--                                <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>-->
                    <!--                                <p>Test, which is a new approach to have all solutions-->
                    <!--                                    astrology under one roof.</p>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->


                </div>
            </div>
            <div class="mesgs">
                <div id="msg_history" class="msg_history">


                    <!---->
                    <!--                    <div class="incoming_msg">-->
                    <!--                        <div class="incoming_msg_img"></div>-->
                    <!--                        <div class="received_msg">-->
                    <!--                            <div class="received_withd_msg">-->
                    <!--                                <p>Test which is a new approach to have all-->
                    <!--                                    solutions</p>-->
                    <!--                                <span class="time_date"> 11:01 AM    |    June 9</span></div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="outgoing_msg">-->
                    <!--                        <div class="sent_msg">-->
                    <!--                            <p>Test which is a new approach to have all-->
                    <!--                                solutions</p>-->
                    <!--                            <span class="time_date"> 11:01 AM    |    June 9</span></div>-->
                    <!--                    </div>-->
                    <!--                    <div class="incoming_msg">-->
                    <!--                        <div class="incoming_msg_img"><img src="https://ptetutorials.com/images/user-profile.png"-->
                    <!--                                                           alt="sunil"></div>-->
                    <!--                        <div class="received_msg">-->
                    <!--                            <div class="received_withd_msg">-->
                    <!--                                <p>Test, which is a new approach to have</p>-->
                    <!--                                <span class="time_date"> 11:01 AM    |    Yesterday</span></div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="outgoing_msg">-->
                    <!--                        <div class="sent_msg">-->
                    <!--                            <p>Apollo University, Delhi, India Test</p>-->
                    <!--                            <span class="time_date"> 11:01 AM    |    Today</span></div>-->
                    <!--                    </div>-->
                    <!--                    <div class="incoming_msg">-->
                    <!--                        <div class="incoming_msg_img"><img src="https://ptetutorials.com/images/user-profile.png"-->
                    <!--                                                           alt="sunil"></div>-->
                    <!--                        <div class="received_msg">-->
                    <!--                            <div class="received_withd_msg">-->
                    <!--                                <p>We work directly with our designers and suppliers,-->
                    <!--                                    and sell direct to you, which means quality, exclusive-->
                    <!--                                    products, at a price anyone can afford.</p>-->
                    <!--                                <span class="time_date"> 11:01 AM    |    Today</span></div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>

                <script>

                    function handle(e) {

                        var key = e.keyCode || e.which;
                        if (key === 13) {

                            var msg = document.getElementById("write_msg").value;
                            // console.log(msg);

                            var rusr = document.getElementById("sendingto").textContent;
                            var sendpid = document.getElementById("sendpid").textContent;

                            $.get("<?php echo dirname($_SERVER['PHP_SELF']);?>/setMessage.php?rUsr=" + rusr + "&pid=" + sendpid + "&msg=" + msg, function (ret) {
                                console.log(ret);
                            })

                            document.getElementById("write_msg").value = "";
                        }
                    }
                </script>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input onkeypress="handle(event)" id="write_msg" type="text" class="write_msg"
                               placeholder="Type a message"/>

                    </div>
                </div>


            </div>
        </div>
    </div>


    <!--        <p class="text-center top_spac"> Design by <a target="_blank" href="#">Sunil Rajput</a></p>-->

</div>
</div>

</body>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<?php include 'footer.inc.php' ?>
</html>


</html>