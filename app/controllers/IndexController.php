<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        
        if($this->request->isPost()){
            $resposta = $this->request->getPost();
            $resultado = \App\Quiz::calculaResultado($resposta);
            
            $this->view->setVar("resultado", $resultado);
            
        }
        $perguntas = \App\Quiz::getPerguntas();
        $this->view->setVar("perguntas", $perguntas);
    }

}

