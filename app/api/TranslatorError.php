<?php

namespace Api;

Class TranslatorError{
  private static $messages;
  private static function init(){
    self::$messages = [
      //Banco de dados
      1=>['Não foi possível estabelecer uma conexão com a base de dados.','Tente novamente mas tarde.'],
      //Usuário
      
      180=>['Tamanho não encontrada.','Atualize a página e tente novamente.']
    ];
  }

  public static function getTranslate($exception){
    switch (get_class($exception)) {
      case 'Exception':
        switch ($exception->getCode()) {
          case 1:
            return ['Página inexistente.','Verifique o link acessado.'];
            break;
          
          default:
            # code...
            break;
        }
        break;
      case 'PDOException':
        break;
    }
   /* switch ($code) {
      //Duplicidade de informaçao na base
      //case 1062:
      case 23000:
        $field = (str_replace('\'','',substr($message,strpos($message,'key ')+4)));
        switch($field){
          case 'user_email':return ['Já existe um registro com o email informado.','Verifique o email informado.'];
          case 'user_cpf':return ['Já existe um registro com o CPF informado.','Verifique o CPF informado.'];
          case 'contact_movel':return ['Já existe um registro com o celular informado.','Verifique o celular informado.'];
          case 'color_code':return ['Já existe uma cor com o código informado.','Verifique o código informado.'];
          case 'size_name':return ['Já existe um tamanho com o nome informado.','Verifique o nome informado.'];
          case 'size_letter':return ['Já existe um tamanho com a letra(s) informada(s).','Verifique a(s) letra(s) informada(s).'];
          default : return ['Já existe um registro com este código.' ,'Feche e abra seu navegador e tente novamente!'];
        }
        break;
      case 1045:return['Não foi possível estabelecer uma conexão com a base de dados.','Tente novamente mais tarde.'];break;
      case '42S22':return['Alguma referência com a base de dados está incorreta.','Entre em contato com o administrador do sistema.'];break;
      case 2002:return['Não foi possível estabelecer uma conexão com o servidor do banco de dados.','Tente novamente mais tarde.'];break;
      case 1049:return['Não foi possível localizar o banco de dados do sistema.','Contate o administrador do sistema.'];break;
      case 0:return['Não foi possível localizar o driver do banco de dados do sistema.','Contate o administrador do sistema.'];break;
      case 2019:return['Sistema de catecteres inválido.','Contate o administrador do sistema.'];break;
      
      default: return $message; break;
    }*/
  }
}
