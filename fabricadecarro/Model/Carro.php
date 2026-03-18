<?php

final class Carro {
    private string $modelo;
    private string $cor;

    public function setModelo(string $modelo): void {
        $this->modelo = $modelo;
    }

    public function getModelo(): string {
        return $this->modelo;
    }

    public function setCor(string $cor): void {
        $this->cor = $cor;
    }

    public function getCor(): string {
        return $this->cor;
    }
}
