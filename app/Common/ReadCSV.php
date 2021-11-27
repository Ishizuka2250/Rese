<?php

namespace App\Common;

use SplFileObject;

class ReadCSV
{
	public static function import_csv($targetFile)
	{
		if (file_exists($targetFile)) {
			$file = new SplFileObject($targetFile);
			$file->setFlags(
				SplFileObject::READ_CSV |
				SplFileObject::READ_AHEAD |
				SplFileObject::SKIP_EMPTY |
				SplFileObject::DROP_NEW_LINE
			);
		} else {
			return array();
		}
		
		$columnName = array();
		$lineCount = 0;
		$result = array();

		foreach ($file as $line)
		{
			$i = 0;
			$addLine = array();
			foreach ($line as $item)
			{
				if ($lineCount == 0) {
					array_push($columnName,$item);
				} else {
					$addLine += [$columnName[$i] => $item];
				}
				$i++;
			}
			if ($lineCount > 0) {
				array_push($result, $addLine);
			}
			$lineCount++;
		}
		return $result;
	}
}
