<?php

class Fabrica {
    private array $listaDeCarros = [];

    public function fabricarCarro(array $carros): void {
        foreach ($carros as $carro) {
            $this->listaDeCarros[] = $carro;
        }
    }

    // Função que remove os carros pelo modelo e cor
    public function venderCarro(string $modelo, string $cor): bool {//retorna true se o modelo do carro e a cor do carro estiverem corretas ou false algum dos dois estiver errado
        foreach ($this->listaDeCarros as $i => $carro) {//faz um loop para cada carro que estiver na lista
            if ($carro->getModelo() === $modelo &&$carro->getCor() === $cor) {
                unset($this->listaDeCarros[$i]);
                $this->listaDeCarros = array_values($this->listaDeCarros);
                return true;
            }
        }
        return false;
    }

    // ler e exibir carros
    public function listarCarros(): string {
        if (empty($this->listaDeCarros)) {
            return "<p>Nenhum carro fabricado.</p>";
        }

        $saida = "<h3>Carros da Fábrica</h3>";
        foreach ($this->listaDeCarros as $carro) {
            $saida .= "<p>Modelo: {$carro->getModelo()} | Cor: {$carro->getCor()}</p>";
        }

        return $saida;
    }

    public function getListaDeCarros(): array {
        return $this->listaDeCarros;
    }
}
