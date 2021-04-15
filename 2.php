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