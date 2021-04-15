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