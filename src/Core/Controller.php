<?php

namespace App\Core;

class Controller{

	public function model($model)
	{
		require_once '../Models/' . $model . '.php';
		return new $model;
	}
}