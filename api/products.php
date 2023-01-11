<?php
/**
 * @Product endpoints
 * @author Armando Rojas <armando.develop@gmail.com>
 * @github: https://github.com/dev-armando
 */

$db = require('Database.php');

$code = $_REQUEST['code'] ?? '0'; 

$sql = "SELECT 
    p.code, 
    p.name ,
    p.pricesell as price ,
    ROUND(p.pricesell  * t2.rate  , 2 ) as price_tax  , 
    ROUND((p.pricesell )  +  (p.pricesell  * t2.rate) , 2)  as price_with_tax,
    p.priceusdsale  as priceusd  ,
    ROUND(p.priceusdsale  * t2.rate  , 2 ) as priceusd_tax, 
    ROUND((p.priceusdsale )  +  (p.priceusdsale  * t2.rate) , 2)  as priceusd_withtax
    FROM 
        products as p 
    JOIN taxcategories  t ON   p.taxcat = t.id 
    JOIN taxes t2 on t2.category  = t.id
    WHERE code = :code  limit 1";


$products = $db->execute($sql  , [ 'code' => $code  ] );
$product = count($products) > 0 ? $products[0] : []; 

echo json_encode(['product' => $product]);

?>