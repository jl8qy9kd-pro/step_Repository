<?php
function convertString($a, $b)
{
  if(strlen($b) !== 1) 
   {
     $positionFirstSubstring = strpos($a, $b) + 1; //создаем точку отсчета для сохранения от инветации первого вхождения подстроки $b
     $positionSecondSubstring = strpos($a, $b, $positionFirstSubstring);//поиск позиции второго вхождения подстроки $b
     return substr_replace("$a", strrev($b), $positionSecondSubstring, strlen($b));
   }else 
       {
         echo 'Один символ подстроки $b не с чем инвертировать';
       } 
} 
//print_r(convertString('aKW K W ukwKWKW','KW'));

function mySortForKey($a, $b)
{
  uasort($a, function ($min, $max) use ($b)
            {
             return ($min["$b"] - $max["$b"]);
            }      
        );
for($i = 0; $i < count($a); $i++) 
  { 
    try
      {
        if(!array_key_exists("$b", $a[$i])) 
         {
           throw new Exception("Ключ ($b) отсутствует в массиве с индексом: "."$i"."<br>");
         } 
      }catch(Exception $e)
           {
             echo $e -> getMessage();
           }
  }
  echo "Массив отсортирован по ключу ($b) <br>";
return $a;
} 
echo "<pre>";
//print_r(mySortForKey([['a'=>2,'b'=>1], ['a'=>5], ['b'=>3], ['a'=>6], ['a'=>1,'b'=>2], ['a'=>8]], b));


function importXml($a) {
$user='root';
$pass='root';
$pdoConn = new PDO('mysql:host=localhost;dbname=test_samson', $user, $pass);

$inPutXML= $a;
  
for ($i = 0, $parent_id = 0, $codeCategory = 1; $i < $inPutXML->Товар->count(); $i++) 
   {
    $addProduct = $pdoConn->prepare("INSERT INTO `a_product`(`ид_продукта`, `код_продукта`, `название`)  VALUES (NULL,?,?)");
    if ($inPutXML->Товар[$i]->attributes()->{'Код'}) 
     {
       $addProduct->execute([$inPutXML->Товар[$i]->attributes()->{'Код'}, $inPutXML->Товар[$i]->attributes()->{'Название'}]);
     }else 
         {
           $insert_product->execute([NULL, $inPutXML->Товар[$i]->attributes()->{'Название'}]);
         }
    $product_id = $pdoConn->lastInsertId();
    $addPrice = $pdoConn->prepare("INSERT INTO `a_price`(`ид_продукта`, `тип`, `цена`) VALUES ($product_id,?,?)");
    foreach($inPutXML->Товар[$i]->Цена as $price) 
          {
            $addPrice->execute([$price['Тип'], $price]); 
          }
    $addProperties = $pdoConn->prepare("INSERT INTO `a_property`(`ид_продукта`, `название`, `свойство`)  VALUES ($product_id,?,?)");
    foreach($inPutXML->Товар[$i]->Свойства as $properties)
          {  
            foreach($properties as $property => $value) 
                  {
                  if($inPutXML->Товар[$i]->Свойства) 
                   {
                 $addProperties->execute([$property, $value]);
               }
              }
          }
    $addCategories = $pdoConn->prepare("INSERT INTO `a_category`(`ид_категории`, `код_категории`, `название`, `ид_родителя`) VALUES  (NULL,?,?,?)");
    $combiConnect = $pdoConn->prepare("INSERT INTO `combiconnect`(`ид_продукта`, `ид_категории`) VALUES (?, ?)");
    foreach ($inPutXML->Товар[$i]->Разделы->Раздел as $category_name) 
          {
            $query_category = $pdoConn->query("SELECT * FROM a_category WHERE название LIKE '$category_name'");
            $category = $query_category->fetch(PDO::FETCH_ASSOC);
            if ($category['название'] == $category_name) 
             {
               $parent_id = $category['ид_категории'];
               $combiConnect->execute([$product_id, $parent_id]);   
             }else 
                 {
             $addCategories->execute([$codeCategory, $category_name, $parent_id]);
             $parent_id = $pdoConn->lastInsertId();
             $combiConnect->execute([$product_id, $pdoConn->lastInsertId()]);
             $codeCategory++;
         }  
      }
   }
}

//importXml(simplexml_load_file('C:\Users\Gomynkyl\Desktop\git\InPutXML.xml'));