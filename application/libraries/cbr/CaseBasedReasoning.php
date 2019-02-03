<?php 

class CaseBasedReasoning
{
	private $ci;
	private $attributes;
	private $matrix;
	private $distances;
	private $data;

	public function __construct($attributes)
	{
		$this->ci =& get_instance();
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
			$attributeIds = array_column((array)$record->gejala, 'id_gejala');
			foreach ($this->attributes as $attributes)
			{
				if (in_array($attributes->id_gejala, $attributeIds))
				{
					$row []= $record->gejala[array_search($attributes->id_gejala, $attributeIds)]->representasi;
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
		foreach ($this->matrix as $row)
		{
			$this->distances []= $this->distance($row, $problem);
		}

		$data = $this->data;
		array_multisort($this->distances, SORT_ASC, $data);
		return $data;
	}

	private function distance($x, $y)
	{
		if (count($x) !== count($y))
		{
			throw new InvalidArgumentException('Size of given arrays does not match');
		}

		$sum = 0;
		foreach ($x as $i => $val)
		{
			$sum += ($val - $y[$i]) ** 2;
		}

		return sqrt((float)$sum);
	}
}