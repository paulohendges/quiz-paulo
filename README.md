# quiz-paulo
Quiz de testes para processo seletivo

CONFIGURAÇÕES:
WampServer
PHP: 5.6
Phalcon Framework: versão 3.2.3 https://phalconphp.com/pt/
JQuery: 3.2.1
CSS: Biblioteca Material Google Design CSS
Para instalação do phalcon:
https://olddocs.phalconphp.com/en/3.0.0/reference/install.html


Desenvolvido em: 19/04/2018 -> 20/04/2018

Este quiz traz uma solução para avaliação de perfis relacionando séries de filme às pessoas de acordo com as suas respostas.

O quiz possuí 5 questões, cada questão com 5 alternativas: A, B, C, D e E.
Casa alternativa se refere à uma série de TV.
As 5 questões são ordenadas por prioridade, da menor para a maior.

Lógica de solução:
Existem dois caminhos para a solução..
O primeiro é quando a alternativa mais escolhida vence.
O segundo é quando há empate entre as alternativas.
Faz-se então o calculo de multiplicação do número de vezes que a alternativa é escolhida pelo grau de prioridade da questão.
Ex:

Escolhidas alternativas B duas vezes / questão 1 e 2
Escolhidas alternativas E duas vezes / questão 3 e 4
Faz-se então o calculo de multiplicação de prioridade da questão, logo:
1x2 = 2
3x4 = 12 < questão de maior prioridade letra E é a serie correspondente ao perfil da pessoa.

