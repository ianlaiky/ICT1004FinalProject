<html>



<head>


    <script
        src="http://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0 auto;
            max-width: 800px;
            padding: 0 20px;
        }

        .textcont {
            border: 2px solid #dedede;
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }

        .darker {
            border-color: #ccc;
            background-color: #ddd;
        }

        .textcont::after {
            content: "";
            clear: both;
            display: table;
        }

        .textcont img {
            float: left;
            max-width: 60px;
            width: 100%;
            margin-right: 20px;
            border-radius: 50%;
        }

        .textcont img.right {
            float: right;
            margin-left: 20px;
            margin-right:0;
        }

        .move-right {
            float: right;
            color: #aaa;
        }

        .move-left {
            float: left;
            color: #999;
        }
        .currentCount{
            visibility: hidden;
        }
    </style>

    <script>

function callback(){
    console.log("test");
    ajaxcall();
    setTimeout(callback, 3000);
}
callback();

function ajaxcall(){
    $.get( "<?php echo dirname($_SERVER['PHP_SELF']);?>/getMessages.php", function( data ) {

        console.log( "Load was performed." );
        console.log(data.length);
        console.log(data);
        console.log(document.getElementById("currentCount").textContent);

        var currentCount = document.getElementById("currentCount").textContent;
        document.getElementById("currentCount").textContent = data.length;

        for (var i = currentCount; i < data.length; i++) {

            if(data[i].msgDirection=="from"){
                var new_row = document.createElement('div');
                new_row.className = "textcont";

                var new_p = document.createElement('p');
                var newContent = document.createTextNode(data[i].message_content);
                new_p.appendChild(newContent);
                new_row.appendChild(new_p);

                var userdat = document.createElement('span');
                var userdatcont = document.createTextNode("Seller");
                userdat.className = "move-left";
                userdat.appendChild(userdatcont);
                new_row.appendChild(userdat);


                var currmsg = document.getElementById("msgarea");
                currmsg.appendChild(new_row);

            }else{
                var new_row = document.createElement('div');
                new_row.className = "textcont darker";

                var new_p = document.createElement('p');
                var newContent = document.createTextNode(data[i].message_content);
                new_p.appendChild(newContent);
                new_row.appendChild(new_p);

                var userdat = document.createElement('span');
                var userdatcont = document.createTextNode("You");
                userdat.className = "move-right";
                userdat.appendChild(userdatcont);
                new_row.appendChild(userdat);

                var currmsg = document.getElementById("msgarea");
                currmsg.appendChild(new_row);


            }
        }





    });

}

    </script>
</head>

<body>

<!--do not remove this; very important-->
<div id="msgarea">
<div class="currentCount" id="currentCount">0</div>

</div>


</body>

</html>