<?php
try
{
  
function baseConnect()
{
  $user='root';
  $pass='root';
  $pdoConn = new PDO('mysql:host=localhost;dbname=test_samson', $user, $pass);
  return $pdoConn;
}


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
  for($i = 0; $i < count($a); $i++)
    {
      if(!array_key_exists("$b", $a[$i]))
       {
         throw new Exception("Ключ ($b) отсутствует в массиве с индексом: "."$i"."<br>");
       }
    }
  uasort($a, function ($min, $max) use ($b)
                           {
                             return ($min["$b"] - $max["$b"]);
                           }
        );
  echo "Массив отсортирован по ключу ($b) <br>";
return $a;
} 
echo "<pre>";
print_r(mySortForKey([['a'=>2,'b'=>1], ['b'=>3], ['a'=>1,'b'=>2],['a'=>1,'b'=>2],['a'=>3]], b));



function importXml($a) {
  $pdoConn = baseConnect();
  $inPutXML = $a;
for ($i = 0, $parent_id = 0, $codeCategory = 1; $i < $inPutXML->Товар->count(); $i++) 
   {
    $addProduct = $pdoConn->prepare("INSERT INTO `a_product`(`product_id`, `code`, `name`)  VALUES (NULL,?,?)");
    if ($inPutXML->Товар[$i]->attributes()->{'Код'}) 
     {
       $addProduct->execute([$inPutXML->Товар[$i]->attributes()->{'Код'}, $inPutXML->Товар[$i]->attributes()->{'Название'}]);
     }else 
         {
           $addProduct->execute([NULL, $inPutXML->Товар[$i]->attributes()->{'Название'}]);
         }
    $product_id = $pdoConn->lastInsertId();
    $addPrice = $pdoConn->prepare("INSERT INTO `a_price`(`product_id`, `type`, `price`) VALUES ($product_id,?,?)");
    foreach($inPutXML->Товар[$i]->Цена as $price) 
          {
            $addPrice->execute([$price['Тип'], $price]);
          }
    $addProperties = $pdoConn->prepare("INSERT INTO `a_property`(`product_id`, `name`, `property`)  VALUES ($product_id,?,?)");
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
    $addCategories = $pdoConn->prepare("INSERT INTO `a_category`(`id_category`, `code`, `name`, `parent_id`) VALUES  (NULL,?,?,?)");
    $combiConnect = $pdoConn->prepare("INSERT INTO `combiconnect`(`product_id`, `id_category`) VALUES (?, ?)");
    foreach ($inPutXML->Товар[$i]->Разделы->Раздел as $category_name) 
          {
            $query_category = $pdoConn->query("SELECT * FROM a_category WHERE name LIKE '$category_name'");
            $category = $query_category->fetch(PDO::FETCH_ASSOC);
            if ($category['name'] == $category_name)
             {
               $parent_id = $category['id_category'];
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




function exportXml($a, $b) {
  $pdoConn = baseConnect();
  $domDoc = new domDocument("1.0", "utf-8");
  $domDoc->formatOutput=true;
  $element = $domDoc->createElement('Товары');
  $domDoc->appendChild($element);

  $selectCategoryB = $pdoConn->query("SELECT * FROM a_category WHERE code = $b");
  $category = $selectCategoryB->fetch(PDO::FETCH_ASSOC);

  $selectProductCombiconnect = $pdoConn->query("SELECT * FROM combiconnect WHERE id_category  = $category[id_category]");
  while ($product_category = $selectProductCombiconnect->fetch(PDO::FETCH_ASSOC))
  {
    $selectProduct = $pdoConn->query("SELECT * FROM a_product WHERE product_id = $product_category[product_id]");
    $product = $selectProduct->fetch(PDO::FETCH_ASSOC);
    $formProductTag = $domDoc->createElement('Товар');
    $formProductTag->setAttribute('Код', $product['code']);
    $formProductTag->setAttribute('Название', $product['name']);

    $selectPrice = $pdoConn->query("SELECT * FROM a_price WHERE product_id = $product[product_id]");
    while ($price = $selectPrice->fetch(PDO::FETCH_ASSOC))
    {
      $price_tag = $domDoc->createElement('Цена', $price['price']);
      $price_tag->setAttribute('Тип', $price['type']);
      $formProductTag->appendChild($price_tag);
    }
    $formPropertiesTag = $domDoc->createElement('Свойства');
    $selectProperty = $pdoConn->query("SELECT * FROM a_property WHERE product_id = $product[product_id]");
    while ($property = $selectProperty->fetch(PDO::FETCH_ASSOC))
    {
      $property_tag = $domDoc->createElement($property['name'], $property['property']);
      $formPropertiesTag->appendChild($property_tag);
      $formProductTag->appendChild($formPropertiesTag);
    }
    $catalogs_tag = $domDoc->createElement('Разделы');
    $catalog_tag = $domDoc->createElement('Раздел', $category['name']);
    $catalogs_tag->appendChild($catalog_tag);
    $formProductTag->appendChild($catalogs_tag);
    $element ->appendChild($formProductTag);
  }
  $domDoc->save($a);
}

//exportXml('C:\Users\Gomynkyl\Desktop\git\outPutXML.xml',1);

  
}catch(Exception $e)
{
  echo $e -> getMessage();
}
