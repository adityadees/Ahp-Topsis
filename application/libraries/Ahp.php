<?php
error_reporting(~E_NOTICE);
class Ahp{

	function get_row_total($matrix){
		$arr = array();
		foreach($matrix as $row){
			foreach($row as $key => $col){
				$arr[$key] += $col;
			}
		}
		return $arr;
	}

	function normalize($matrix, $row_total){
		$arr = array();
		foreach($matrix as $key => $val){
			foreach($val as $k => $v){
				$arr[$key][$k] = round($v / $row_total[$k],9);
			}
		}
		return $arr;
	}

	function get_priority($normal){
		$arr = array();
		foreach($normal as $key => $val){
			$arr[$key] = round(array_sum($val) / count($val),6);
		}
		return $arr;
	}   



	function get_jumlah_normalisasi($normal){
		$arr = array();
		foreach($normal as $key => $val){
			$arr[$key] = array_sum($val);
		}
		return $arr;
	}   



	function get_cm($matrix, $priority){
		$arr = array();
		foreach($matrix as $row){
			foreach($row as $key => $col){
				$arr[$key] += $col * $priority[$key];
			}
		}
		return $arr;
	}

	function get_consistency($cm){
		$arr = array();

		$sum = array_sum($cm);
		$count = count($cm); 
		$arr['ci'] = round(($sum - $count) / ($count - 1),6);

		$nRI = array (
			1=>0,
			2=>0,
			3=>0.58,
			4=>0.9,
			5=>1.12,
			6=>1.24,
			7=>1.32,
			8=>1.41,
			9=>1.46,
			10=>1.49,
			11=>1.51,
			12=>1.48,
			13=>1.56,
			14=>1.57,
			15=>1.59
		);
		$arr['ri'] = $nRI[count($cm)];
		$arr['cr'] = round($arr['ci'] / $arr['ri'],5);
		$arr['consistency'] =  $arr['cr']<=0.1 ? 'consistent' : 'inconsistent';

		return $arr;
	}
}