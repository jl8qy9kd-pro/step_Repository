<center>задание 1.2.1</center><hr>

<?php
function findSimple($a, $b)
{
  for ($i = $a; $i <= $b ; $i++) // создаем массив из всех заданных чисел
    { 
      if ($i == 1) 
       {
        $i += 1;
       }
      $FullArrayAtoB[]=$i;
    }
  for ($a = 2; $a <= $b ; $a++) //создаем массив из всех Repetitive Сomposite чисел 
    { 
      for ($p = $a, $i = $a + 1; $i <= $b; $i++) 
        {  
          if ($i % $p == 0)
           {
             $ArrayСompositeNumeralRepetitive[] = $i;
           }  
        }
    }
  $ArrayСompositeNumeral = array_unique($ArrayСompositeNumeralRepetitive);
  $ArrayPrimeNumeral = array_diff ($FullArrayAtoB, $ArrayСompositeNumeral);
  return $ArrayPrimeNumeral;
}
echo '<pre>';
print_r(findSimple(1,40));
echo '</pre>';

?>
  



<center>задание 1.2.2</center><hr>






<?php
function createTrapeze($a)
{ 
  $ABCkeys = array('a','b','c'); 
  $divisionBy3 = array_chunk($a, 3);
  for ($i = 0; $i < count($divisionBy3); $i++)
    {
      $itogArrayTrapezes[] = array_combine($ABCkeys, $divisionBy3[$i]);
    }
  return $itogArrayTrapezes;
}

$createTrapeze = createTrapeze($a = [11,22,33,77,88,99,1000,1002,1533,3,7,7]); //переменная-результат function createTrapeze для отправки в дальнейшие функции
echo '<pre>';
print_r(createTrapeze($a = [11,22,33,77,88,99,1000,1002,1533,3,7,7]));
echo '</pre>';
?>





<center>задание 1.2.3</center><hr>






<?php
function squareTrapeze(&$a)
{
  foreach($a as &$keyS)
        {
          $keyS['s'] = ($keyS['a'] + $keyS['b']) * $keyS['c'] * 0.5;
        } 
  return $a;
}

$squareTrapeze = squareTrapeze($createTrapeze); //переменная-результат function squareTrapeze для отправки в дальнейшие функции
echo '<pre>';
print_r(squareTrapeze($createTrapeze)); 
echo '</pre>';
?>







<center>задание 1.2.4</center><hr>








<?php
function getSizeForLimit($a, $b)
{
  $searchKeyS = [];
  for ($i = 0; $i < count($a) ; $i++)
 	  { 
 	    if ($a[$i][s] <= $b)
 	     {
 	       $searchKeyS [] = $a[$i][s];
 	     }
  	}
  return $searchKeyS;
}

echo '<pre>';
print_r(getSizeForLimit($squareTrapeze,8167.5)); 
echo '</pre>';
?>









<center>задание 1.2.5</center><hr>











<?php
function getMin($a)
{
  $min =abs(array_sum($a));
  foreach($a as $v)
        {
          if($v < $min)
           {
             $min = $v;   
           } 
        }
  return $min;   
}

print_r(getMin($a = [14640, 1000000.24, 2100.01, 9800, 5, -6, 7, 8.7] ));
?>









<center>задание 1.2.7 1.2.8</center><hr>










<?php
abstract class BaseMath 
       { 
         function exp1($a, $b, $c)
                {
                  return $a * ($b ** $c);
                }
         function exp2($a, $b, $c)
                { 
                  return ($a / $b) ** $c;
                }               
         abstract function getValue();                 
       }

class F1 extends BaseMath
    {  
      function __construct($a=10, $b=2, $c=3)
             {
               $this->a = $a;
               $this->b = $b;
               $this->c = $c;
             } 
      public function getValue()
           {
             return (parent::exp1($a, $b, $c) + ((($this->a / $this->c) ** $this->b) % 3) ** min($this->a, $this->b, $this->c));
           }
    }
$F1 = new F1();
echo ($F1-> exp1(1, 2, 3)) . "<br>";
echo ($F1-> exp2(3, 4, 5)) . "<br>";
echo ($F1-> getValue())  . "<br>"; 
?>







  <center>задание 1.2.6</center><hr>







<?php
function printTrapeze($a)
{
  $ABC012 = array_keys($a[0]); //массив где лежат буквенные ключи со своими новыми числовыми ключами
  $rows = count($a[0]);  // количество строк
  $cols = count($a);  // кол-во столбов
  $nameSTR = array_keys($a[0]); //забор парамметров трапеций 
  echo '<table border>';
  for ($str = 0, $c = 0 - 1; $str <= $rows - 1; $str++) //строки
    { 
    	echo '<th>' . $nameSTR[$str];        	    
      for ($kol = 0, $c++; $kol <= $cols - 1; $kol++) //столбы
        {
	        if ( $c == 3 and (round($a[$kol][$ABC012[3]]) % 2) !== 0)
           {
             echo '<td style="color:white;background-color:green;">' . $a[$kol][$ABC012[$c]] . '</td>';
           }else
               {
                 echo '<td>' . $a[$kol][$ABC012[$c]] . '</td>';
               }
        }
         echo '</tr>';
    }
  echo '<th> параметры\№ трапеции  </th>';
  for ($num = 0; $num < $cols; $num++) 
    {	
      echo '<th>' . $num . '-я трапеция' . '</th>'; 
    }
}

printTrapeze($squareTrapeze);
?>
