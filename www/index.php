<?php
 include "../includes/database.php"; // Database !!
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles/styles.css">
        <link rel="stylesheet" href="../styles/fontawesome/css/all.css">
    </head>
        <header><div class="div-header-time"><img src="../styles/cocolime.png">POS</div>
        <div class="div-header-time" class="div-header-time"><h2 id=time class="time"></h2><div>
    </header>

         <!-- Navigation -->
        <nav>
            <a onclick="openSales()"><i class="fas fa-shopping-cart"></i> &nbsp Sales</a>
            <a onclick="openTransactions()"><i class="fas fa-history"></i> &nbsp Transactions</a>
            <a><i class="fas fa-sign-out-alt"></i> &nbsp Logout</a>
        </nav>

         <!-- Order List -->
         <div class="div-order" id="div-order">
            <div class="div-order-left">
                <h1 style="float: left;width: 25%;color:rgb(63, 63, 63)"><i class="fas fa-cart-plus"></i> Orders</h1>
                <button onclick="openModal()" class='button-submit'><i class="fas fa-share"></i>&nbsp <b>Add Orders</b> </button>
                <button onclick="emptyOrders()" class='button-cancel'><b>Cancel Orders</b> </button>
                <br>
                <br>
                <table>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                    <tbody id='orders'>
                    </tbody>
                </table>
                <br>
            </div>
            <div class="div-total">
                <h2 id='total'><i class='fas fa-tag'></i>&nbspTotal Cost: &nbsp ₱</h2>
            </div>
            <div class="div-order-right">
                <h1 style="color:rgb(63, 63, 63)"><i class="fas fa-utensils"></i> Menu</h1>
                <br>
                <hr>
                <br>
                <i class="fas fa-search"></i>&nbsp<input name="search" id="search" type="text" placeholder="Search" class="search" oninput="search()">
                <br>
                <div id="result"></div>
                <br>
                <?php
                $sql = "SELECT * FROM tbl_products WHERE 1"; // Get Data !!
                $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                        echo "<div class='menu-food'>";
                        echo $row['product_name'];
                        $row = json_encode($row);
                        echo "<button class='button-add' onclick='add($row)'><i class='fas fa-plus'></i></button>"; // Pass Data to JSON object
                        echo "</div>";
                        }
                    }
                    else
                    {
                    echo "no data";
                    }
                ?>
            </div>
            <!-- The Modal -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <h2>Are you sure to send orders?</h2>
                    <br>
                    <hr>
                    <br>
                    <button onclick="sendOrders()" class="button-send-orders"><b>yes</b></button>
                    <br>
                    <button onclick="closeModal()" class="button-send-cancel"><b>no</b></button>
                    <br>
                </div>
            </div>
        </div>
        <!-- Transactions -->
        <div id="div-transactions" class="div-transactions">
            <div class="div-trans-top">
                <h1 style="color:rgb(63, 63, 63)"><i class="fas fa-clipboard-list"></i>&nbspTransactions
                &nbsp
                <button onclick="sortDesc()" class="button-desc">desc<br><i class="fas fa-sort-down"></i>
                </button>
                &nbsp
                <button onclick="sortAsc()" class = "button-asc">asc<br><i class="fas fa-sort-up"></i></button>
                &nbsp
                <button onclick="refresh()" class = "button-refresh">refresh<br><i class="fas fa-sync-alt"></i></button></h1>
            </div>
            <div class="div-asc-desc">
                <br>
                <br>
                <div id="trans-desc" class="div-desc">
                <?php
                    $sql_trans = "SELECT tbl_transactions.trans_id, tbl_orders.customer_id, tbl_orders.order_status, tbl_transactions.trans_date_time, tbl_transactions.trans_time FROM tbl_transactions INNER JOIN tbl_orders ON tbl_transactions.trans_id = tbl_orders.trans_id GROUP BY tbl_transactions.trans_date_time DESC";
                    $result_trans = mysqli_query($conn, $sql_trans);
                    if(mysqli_num_rows($result_trans) > 0){
                        while($row_trans = mysqli_fetch_assoc($result_trans)){
                            echo '<div style="float:left;padding:25px;width:95%;background: #f8f5f1;margin:5px;border-radius:15px">';
                            echo '<h3> Transaction No:';
                            echo $row_trans['trans_id'];
                            echo '</h3>';
                            echo '<hr>';
                            echo '<br>';
                            echo $row_trans['trans_date_time'];
                            echo '<br>';
                            echo '<br>';
                            echo $row_trans['trans_time'];
                            echo '<br>';
                            echo '<br>';
                            echo $row_trans['order_status'];
                            echo "</div>";
                        }
                    }
                    else
                    {
                    echo "no data";
                    }
                ?>
                </div>
                <div id="trans-asc" class="div-asc">   
                <?php
                    $sql_trans_asc = "SELECT tbl_transactions.trans_id, tbl_orders.customer_id, tbl_orders.order_status, tbl_transactions.trans_date_time, tbl_transactions.trans_time FROM tbl_transactions INNER JOIN tbl_orders ON tbl_transactions.trans_id = tbl_orders.trans_id GROUP BY tbl_transactions.trans_date_time ASC";
                    $result_trans_asc = mysqli_query($conn, $sql_trans_asc);
                    if(mysqli_num_rows($result_trans_asc) > 0){
                        while($row_trans_asc = mysqli_fetch_assoc($result_trans_asc)){
                            echo '<div style="float:left;padding:25px;width:95%;background: #f8f5f1;margin:5px;border-radius:15px">';
                            echo '<h3> Transaction No:';
                            echo $row_trans_asc['trans_id'];
                            echo '</h3>';
                            echo '<hr>';
                            echo '<br>';
                            echo $row_trans_asc['trans_date_time'];
                            echo '<br>';
                            echo '<br>';
                            echo $row_trans_asc['trans_time'];
                            echo '<br>';
                            echo '<br>';
                            echo $row_trans_asc['order_status'];
                            echo "</div>";
                        }
                    }
                    else
                    {
                    echo "no data";
                    }
                ?>
                </div>
            </div>
        </div>

         <!-- Script -->
        <script src='../js/jquery-3.4.1.min.js'></script>
        <script>
            var orders = []; // Store each Food item to Array
            var data; // The Data passed from PHP
            var res; // The Group By Results
            var time; // Time
            var modal = document.getElementById("myModal"); // Modal ID
            $( document ).ready(function() {
                openSales();
                formatAMPM(new Date); // Time
            });
            function openSales(){ // Open Div Order , Close Trans
                $('#div-order').show(); 
                $('#div-transactions').hide();
            }
            function openTransactions(){ // Open Div Trans , Close Order
                $('#div-order').hide();
                $('#div-transactions').show(); 
            }
            function add(data){ // Pass Food item to orders[]
                data = data;
                orders.push(data); // Push data to orders[]
                parseProducts(orders); // Parse all numbers to Integers
                var result = orders // Group Data
                    .map((item, i, array) => {
                    const defaultValue = {
                    product_id: item.product_id,
                    product_name: item.product_name,
                    product_quantity: 0,
                    product_price: 0
                    }
                    const finalValue = array
                    .filter(other => other.product_name === item.product_name) // We filter the same items
                    .reduce((accum, currentVal) => { // We reduce them into a single entry
                        accum.product_quantity += currentVal.product_quantity;
                        accum.product_price += currentVal.product_price;
                        return accum;
                    }, defaultValue);

                    return finalValue;
                })
                .filter((item, thisIndex, array) => { // Now our new array has duplicates, lets remove them
                    const index = array.findIndex((otherItem, otherIndex) => otherItem.product_name === item.product_name && otherIndex !== thisIndex && otherIndex > thisIndex);

                    return index === -1
                })
                showAll(result);
                res = result;
            } 
            function parseProducts(array){ // Parse all numbers
                for(var i=0; i<array.length;i++){
                    array[i].product_id = parseInt(array[i].product_id);
                    array[i].product_price = parseInt(array[i].product_price);
                    array[i].product_quantity = parseInt(array[i].product_quantity);
                }
                return(array);
            }
            function sendOrders(){ // Send Orders[] to PHP array
                closeModal();
                $.ajax({
                    url: "orders.php", // Send AJAX to orders.php
                    method: "POST",
                    data: { orders : JSON.stringify( res ), time : JSON.stringify(time) },
                    success: function(res){
                    console.log(res)
                    }
                });
                var empty_orders = []; // EMPTY The ARRAY orders
                orders = empty_orders;  
                showAll(result);
                alert('Orders: \n Orders Pending!');
            }
            function search(){ // Search LIKE % * The word User enters * %
                var search = document.getElementById("search").value;
                $.ajax({
                    url: "search.php",
                    method: "POST",
                    data: { search : JSON.stringify( search ) },
                    success: function(res){
                    $('#result').html(res);
                    }
                });                
            }
            function emptyOrders(){ // EMPTY The ARRAY orders
                var empty_orders = []; 
                orders = empty_orders;
                var total = 0;
                var str_html='';
                showAll(orders);
            }
            function showAll(array){ // Display Array
                var total = 0;
                var str_html='';
                for(var i=0;i<array.length; i++){ 
                    str_html+='<tr>';
                    str_html+='<td> '+array[i].product_name+'</td>';
                    str_html+='<td>'+array[i].product_quantity+'</td>';
                    str_html+='<td>'+array[i].product_price+'</td>';
                    str_html+='<td><button onclick="popOrder('+array[i].product_id+','+array[i].product_quantity+')" class="button-delete"><i class="fas fa-trash"></i></button></td>';
                    str_html+='</tr>';
                    total = total + parseInt(array[i].product_price);
                }
                $('#orders').html(str_html);
                $('#total').html("<i class='fas fa-tag'></i>&nbspTotal Cost: &nbsp ₱"+ total);
            }
            function popOrder(id){ // Pop Orders
                for (var i = 0; i <= orders.length; i++){
                    var index = orders.findIndex(function(o){
                    return o.product_id === id;
                    })
                    if (index !== -1) i = 0, orders.splice(index, 1);
                    }
                popResults(id);
                showAll(res)
            }
            function popResults(id){ // Pop Results
                for (var i = 0; i <= res.length; i++){
                    var index = res.findIndex(function(o){
                    return o.product_id === id;
                    })
                    if (index !== -1) i = 0, res.splice(index, 1); 
                   
                }
            }
            function sortDesc(){ // Show transation descendng div
                   $('#trans-desc').show();
                   $('#trans-asc').hide();
            }
            function sortAsc(){ // Show transation ascendng div
                   $('#trans-desc').hide();
                   $('#trans-asc').show();
            }
            function openModal() {  // Get the modal
                if(orders.length === 0)
                {
                    alert('Orders: \n No Orders!'); // Validate if empty
                }
                else{
                    modal.style.display = "block";
                } 
            }
            function closeModal() { // Close Modal
                modal.style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == modal) {
                  modal.style.display = "none";
                }
            }
            function formatAMPM(date) { // Time
                var hours = date.getHours();
                var minutes = date.getMinutes();
                var ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0'+minutes : minutes;
                var strTime = hours + ':' + minutes + ' ' + ampm;
                // return strTime;
                time = strTime;
                document.getElementById('time').innerHTML='<i class="fas fa-clock"></i> '+time;
                displayC();
            }
            function displayC(){ // Update Time
                var refresh = 1000;
                myTime = setTimeout('formatAMPM(new Date)', refresh);
            }
            function refresh(){
                location.reload();
            }
        </script>
</html>