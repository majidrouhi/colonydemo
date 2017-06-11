<?php
	class Classification
	{
		public static function knn($sample, $dataset)
		{
			foreach($dataset as $k => $arr)
			{
				$f = 0;

				foreach($arr as $key => $value) $f += ($value - $sample[$key]) ** 2;

				$s[$k] = sqrt($f);
			}

			return $s;
		}
	}
?>