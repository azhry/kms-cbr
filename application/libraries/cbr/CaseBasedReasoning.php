<?php 

class CaseBasedReasoning
{
	private $attributes;
	private $matrix;
	private $distances;
	private $data;

	public function __construct($attributes)
	{
		$this->attributes 	= $attributes;
		$this->matrix 		= [];
		$this->distances	= [];
	}

	public function fit($data, $excludedKeys = [])
	{
		$this->matrix 	= [];
		$this->data 	= $data;
		foreach ($data as $record)
		{
			$row = [];
			$attributeIds = array_column($record->gejala->toArray(), 'id_gejala');
			foreach ($this->attributes as $attributes)
			{
				if (in_array($attributes->id_gejala, $attributeIds))
				{
					$row []= $record->gejala[array_search($attributes->id_gejala, $attributeIds)]
								->gejala
								->representasi;
				}
				else
				{
					$row []= 0;
				}
			}
			$this->matrix []= $row;
		}

		return $this->matrix;
	}

	public function fit2($data, $excludedKeys = [])
	{
		$this->matrix 	= [];
		$this->data 	= $data;
		$numAttr = 0;
		foreach ($data as $record)
		{
			$attributeIds = array_column($record->gejala->toArray(), 'id_gejala');
			$num = count($attributeIds);
			if ($num > $numAttr)
			{
				$numAttr = $num;
			}
		}

		foreach ($data as $record)
		{
			$row = [];
			$attributeIds = array_column($record->gejala->toArray(), 'id_gejala');
			for ($i = 0; $i < $numAttr; $i++)
			{
				if (isset($record->gejala[$i]))
				{
					$row []= $record->gejala[$i]
								->gejala
								->representasi;
				}
				else
				{
					$row []= 0;
				}
			}

			$this->matrix []= $row;
		}

		return $this->matrix;
	}

	public function rank($problem)
	{
		$this->distances = [];
		$data = $this->data->toArray();
		foreach ($this->matrix as $i => $row)
		{
			$data[$i]['distance'] = $this->distance($row, $problem);
			$this->distances []= $data[$i]['distance'];
		}

		array_multisort($this->distances, SORT_ASC, $data);
		return $data;
	}

	private function distance($x, $y)
	{
		$sum = 0;
		if (count($x) > count($y))
		{
			foreach ($y as $i => $val)
			{
				$sum += ($val - $x[$i]) ** 2;
			}
		}
		else
		{
			foreach ($x as $i => $val)
			{
				$sum += ($val - $y[$i]) ** 2;
			}
		}
		
		return sqrt((float)$sum);
	}
}