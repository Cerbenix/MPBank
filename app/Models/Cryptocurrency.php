<?php declare(strict_types=1);

namespace App\Models;

class Cryptocurrency
{
    private int $id;
    private string $name;
    private string $symbol;
    private float $percentChangeHour;
    private float $percentChangeDay;
    private float $percentChangeWeek;
    private float $price;

    public function __construct(
        int $id,
        string $name,
        string $symbol,
        float $percentChangeHour,
        float $percentChangeDay,
        float $percentChangeWeek,
        float $price
    )
    {

        $this->id = $id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->percentChangeHour = $percentChangeHour;
        $this->percentChangeDay = $percentChangeDay;
        $this->percentChangeWeek = $percentChangeWeek;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPercentChangeHour(): float
    {
        return $this->percentChangeHour;
    }

    public function getPercentChangeDay(): float
    {
        return $this->percentChangeDay;
    }

    public function getPercentChangeWeek(): float
    {
        return $this->percentChangeWeek;
    }
}
