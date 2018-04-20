/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    
    $("#formQuiz").submit(function(){
        if($('input[type="radio"]:checked').length < 5){
            alert('Responda todas as perguntas.');
            return false;
        }
    });
});
