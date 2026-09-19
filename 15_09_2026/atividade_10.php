<?php

class ConversorTemperatura {
    
    public function celsiusParaFahrenheit(float $celsius): float
    {
        return ($celsius * 1.8) + 32;
    }

    public function fahrenheitParaCelsius(float $fahrenheit): float
    {
        return ($fahrenheit - 32) / 1.8;
    }
}