<?php
namespace App;

class Quiz {
    
    public static $_arrRespostas = [
        "a" => 0,
        "b" => 0,
        "c" => 0,
        "d" => 0,
        "e" => 0,
    ];
    
    public static $_perguntas = [
        1 => [
            "pergunta" => "De manhã, você:",
            "alternativas" => [
                "a" => "Acorda cedo e come frutas cortadas metodicamente", 
                "b" => "Sai da cama com o despertador e se prepara para a batalha da semana.", 
                "c" => "Só consegue lembrar do seu nome depois do café." ,
                "d" => "Levanta e faz café pra todos da casa.",
                "e" => "Passa o café e conserta um erro no HTML." 
            ],
        ],
        2 => [
            "pergunta" => "Indo para o trabalho você encontra uma senhora idosa caída na rua.",
            "alternativas" => [
                "a" => "Ela vai atrapalhar seu horário. Oculte o corpo.", 
                "b" => "Levanta a senhora e jura protegê-la com sua vida.", 
                "c" => "Ajuda-a, mas questiona sua real identidade.", 
                "d" => "Oferece para caminharem juntos até um destino em comum." ,
                "e" => "Testa se ela roda bem no Firefox. Não roda." 
            ],
        ],
        3 => [
            "pergunta" => "Chega no prédio e o elevador está cheio.",
            "alternativas" => [
                "a" => "Convence parte das pessoas a esperarem o próximo.", 
                "b" => "Ignora as pessoas no elevador e entra de qualquer forma.", 
                "c" => "Você questiona a realidade, as coisas e tudo mais. Sobe de escada.", 
                "d" => "Com uma leve intimidação passivo-agressiva, encontra um lugar no elevador.",
                "e" => "Cria um app que mostra a lotação do elevador. Vende o app e fica milionário." 
            ],
        ],
        4 => [
            "pergunta" => "Você chega no trabalho e as convenções sociais te obrigam a puxar assunto.",
            "alternativas" => [
                "a" => "Fala sobre a política, eleições, como tudo é um absurdo.", 
                "b" => "Larga uma frase polêmica e vê uma pequena guerra se formar.",
                "c" => "Puxa um assunto e te lembram que já foi discutido semana passada.", 
                "d" => "Sugere que os colegas trabalhem na ideia de um novo projeto.", 
                "e" => "Desabafa sobre como odeia PHP. Todo mundo na sala adora PHP."
            ],
        ],
        5 => [
            "pergunta" => "A pauta pegou o dia todo, mas você está indo para casa.",
            "alternativas" => [
                "a" => "Vou chamar aqui o meu Uber.",
                "b" => "Pegarei o bus junto com o resto do povo.",
                "c" => "No ponto de ônibus mais uma vez, espero não errar a linha de novo.",
                "d" => "Vou de carro, mas ofereço uma carona para os colegas.",
                "e" => "Acho que descobri uma forma de fazer aquela senhora rodar no Firefox." 
            ],
        ],
    ];
    
    public static $_respostas = [
        "a" => [
            "serie" => "Você é House of Cards: Ataca o problema com método e faz de tudo para resolver a situação",
            "path" => "imagens/houseofcards.jpg"
        ],
        "b" => [
            "serie" => "Você é Game of Thrones: Não tem muita delicadeza nas ações, mas resolve o problema de forma prática.",
            "path" => "imagens/gameofthrones.jpg"
        ],
        "c" => [
            "serie" => "Você é Lost: Faz as coisas sem ter total certeza se é o caminho certo ou se faz sentido, mas no final dá tudo certo.",
            "path" => "imagens/lost.jpg"
        ],
        "d" => [
            "serie" => "Você é Breaking Bad: Pra fazer acontecer você toma a liderança, mas sempre contando com seus parceiros.",
            "path" => "imagens/breakingbad.jpg"
        ],
        "e" => [
            "serie" => "Você é Silicon Valley: Vive a tecnologia o tempo todo e faz disso um mantra para cada situação no dia. ",
            "path" => "imagens/siliconvalley.jpg"
        ]
    ];
    
    public static function getPerguntas(){
        
        $perguntas = self::$_perguntas;
        $auxiliar = [];
        
        foreach ($perguntas as $key => $pergunta) {
            $auxiliar[$key]["pergunta"] = $pergunta["pergunta"];
            $auxiliar[$key]["alternativas"] = self::getAlternativasRandomicas($pergunta["alternativas"]);
        }
        
        return $auxiliar;
    }
    public static function getAlternativasRandomicas($alternativas){
        
        $auxiliar = [];
        while (count($auxiliar) < 5) {
           // pega por random uma posição qualquer do array de alternativas
           $alternRand = array_rand($alternativas);
           // verifica se ela não existe no array - senão existe insere no auxiliar com a posição e valor da alternativa
           if(!array_key_exists($alternRand, $auxiliar)){
               $auxiliar[$alternRand] = $alternativas[$alternRand];
           }
        }
        
        return $auxiliar;
        
    }
    
    public static function calculaResultado($resposta){
        // faz a contagem das respostas
        foreach ($resposta as $value) {
            self::$_arrRespostas[$value] += 1;
        }
        
        // cria um array unico com o valor do maior votado
        $maiorEscolhida = ["maior" => max(self::$_arrRespostas)];
        
        // unico modo q consegui foi por eliminação, não vejo outra forma
        // então vou eliminando os q forem menor que o valor maximo encontrado, os q forem iguais eu deixo pra aplicar o criterio de desempate
        self::criterioDesempate($maiorEscolhida);
        
        // se for maior q 1 significa q teve empate no critério das escolhas, logo vai calcular a prioridade
        if(count(self::$_arrRespostas) > 1){
            // vai fazer o calculo por grau de prioridade
            $serie = self::calculoPrioridade($resposta);
        }else{
            // vai pegar a serie que foi escolhida
            $serie = self::getResultado();
        }
        
        return ["serie" => $serie];
    }
    
    
    public static function criterioDesempate($maiorEscolhida){
        // aplica o criterio retirando as menores restando somente as que tiverem valores iguais (empatadas)
        foreach (self::$_arrRespostas as $key => $value) {
            if ($maiorEscolhida["maior"] > $value){
                unset(self::$_arrRespostas[$key]);
            }
        }
    }
    
    public static function calculoPrioridade($resposta){
        // setando os os valores de alternativas para 1 -> para multiplicação
        foreach (self::$_arrRespostas as $key => $v) {
            self::$_arrRespostas[$key] = 1;
        }
        
        // faz a leitura nas respostas uma por uma
        foreach ($resposta as $pergunta => $res) {
            // ex: se existir a resposta A e essa resposta for uma chave de $_arrRespostas, significa q A foi uma das que deu empate, logo devo multiplicar o valor
            // de A pelo grau de importancia, guardando o resultado em $_arrRepostas novamente.
            if(array_key_exists($res, self::$_arrRespostas)){
                $grauImportancia = (int)str_replace('pergunta', '', $pergunta);
                self::$_arrRespostas[$res] *= $grauImportancia;
            }
        }
        
        // feito isso basta pegar o resultado da maior multiplicação
        return self::getResultado();
    }
    
    public static function getResultado(){
        // encontra a posição da pergunta q teve mais alternativas iguais
        $posicao = array_search(max(self::$_arrRespostas), self::$_arrRespostas);
        // pega do array de respostas a mensagem padrão
        $serie = self::$_respostas[$posicao];
        
        return $serie;
    }
    
}