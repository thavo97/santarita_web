
<?php
    $servername = "localhost";
    $username = "root";
    $password = "123Abejas";
    $dbname = "santarita";
    $table = "products";

    $action = $_POST['action'];
    //create connection
    $conn = new mysqli($servername,$username,$password,$dbname);
    //check connection
    if($conn->connect_error){
        die("connection failed". $conn->$connect_eror);
        return;
    }

    // to get all products
    if("GET_ALL_PRODUCTS" == $action){
        $products_data = array();
        $sql = "select code, name, cost, price, units from $table order by name limit 0,50";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $products_data[]= $row;
            }
            echo json_encode($products_data);
        }else{
            echo("error get all products");
        }
        $conn->close();
        return;
    }
    // get pages products
    if ("GET_PAGE_PRODUCTS" == $action) {
        $number_page = $_POST['number_page'];
        $products_pages = array();
        $start= ($number_page)*50;
        $end =  ($number_page+1)*50;
        $sql = "select code, name, cost, price,units from $table order by name limit $start,$end";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $products_pages[]= $row;
            }
            echo json_encode($products_pages);
        }else{
            echo("error get all products");
        }
        $conn->close();
        return;
    }
    //get search products
    if("GET_SEARCH_PRODUCTS" == $action){
        $character = $_POST['character'];
        $products_search = array();
        $sql = "select code, name, cost, price, units from $table where name like '%$character%' order by name";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $products_search[]= $row;
            }
            echo json_encode($products_search);
        }else{
            echo("error get all products");
        }
        $conn->close();
        return;
    }
    //update price cost and units
    if("UPDATE_PRICE" == $action){
        $code_product = $_POST['code_product'];
        $price_product = $_POST['price_product'];
        $cost_product = $_POST['cost_product'];
        $unit_product = $_POST['unit_product'];

        $sql = "update $table SET 
        price = '$price_product',  
        cost = '$cost_product', 
        units = (select units+$unit_product from products where code='$code_product') 
        WHERE code ='$code_product'";
        if($conn->query($sql)===TRUE){
                echo("success");
        }else{
            echo("error update price product");
        }
        $conn->close();
        return;
    }


?>