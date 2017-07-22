<?php
class Common_AmountTool{
	/**
	 *数字金额转换成中文大写金额的函数
	 *String Int  $num  要转换的小写数字或小写字符串
	 *return 大写字母
	 *小数位为两位
	 **/
	public static function get_amount($num){
		$c1 = "零壹贰叁肆伍陆柒捌玖";
		$c2 = "分角元拾佰仟万拾佰仟亿";

		//owt客户采购单PO291702040003,采购金额4613.400,精度转换后变为了461339.9999999999,导致异常,bug修复,by max 2017-2-4 21:22:58
		//wy客户PO11704010006，金额588.8 intval($num * 100)之后变为58879，bug，加上strval()方法后正常,by sheen 2017-04-04
		//$num = intval(strval($num * 100));
		
		//update by Tom 2017-4-12
		$num = sprintf("%0.2f", $num);
		$num = round($num * 100);
		
		if (strlen($num) > 10) {
			return "数据太长，没有这么大的钱吧，检查下";
		}
		$i = 0;
		$c = "";
		while (1) {
			if ($i == 0) {
				$n = substr($num, strlen($num)-1, 1);
			} else {
				$n = $num % 10;
			}
			$p1 = substr($c1, 3 * $n, 3);
			$p2 = substr($c2, 3 * $i, 3);
			if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
				$c = $p1 . $p2 . $c;
			} else {
				$c = $p1 . $c;
			}
			$i = $i + 1;
			$num = $num / 10;
			$num = (int)$num;
			if ($num == 0) {
				break;
			}
		}
		$j = 0;
		$slen = strlen($c);
		while ($j < $slen) {
			$m = substr($c, $j, 6);
			if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
				$left = substr($c, 0, $j);
				$right = substr($c, $j + 3);
				$c = $left . $right;
				$j = $j-3;
				$slen = $slen-3;
			}
			$j = $j + 3;
		}

		if (substr($c, strlen($c)-3, 3) == '零') {
			$c = substr($c, 0, strlen($c)-3);
		}
		if (empty($c)) {
			return "零元整";
		}else{
			return $c . "整";
		}
	}
}
