<?php

declare(strict_types=1);

class voiture
{
    private string $name = "";
    private float $model_number = 0;
    private int $wheel_amount = 0;
    private string $color = "";

    public function Vroom()
    {
        echo ($this->name);
    }

    public function __construct($name, $model_number, $wheel_amount, $color)
    {
        $this->name = $name;
        $this->model_number = $model_number;
        $this->wheel_amount = $wheel_amount;
        $this->color = $color;
    }
}

$tesla = new voiture("Lapin", 77, 6, "rouge");
var_dump($tesla);
