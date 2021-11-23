<?php

namespace App\Common;

class ReadCSV
{
	public static function import_csv($targetFile)
	{
		if (file_exists($targetFile)) {
			$fileHandle = fopen($targetFile, 'r');
		} else {
			return array();
		}
		
		$columnName = array();
		$count = 0;
		$result = array();

		while($data = fgetcsv($fileHandle))
		{
			if ($count == 0) {
				$columnName = $data;
			} else {
				$line = array();
				for ($i = 0; $i < count($columnName); $i++)
				{
					$line += [$columnName[$i] => $data[$i]];
				}
				array_push($result, $line);
			}
			$count++;
		}
		fclose($fileHandle);
		return $result;
	}
}
