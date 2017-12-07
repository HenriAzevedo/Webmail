<?php

namespace Api;
use Exception;

Class FormValidator{
	private $action = null;
	private $form = array();
	public function __construct($model){ $this->form['model']	=	ucfirst(get_class($model)); }
	public function setAction($action){ $this->action = $action; }
	public function addField($field,array $test){
		if(empty($this->action)) throw new Exception('FormValidator not set action.', 1);
		if(empty($this->form[$this->form['model']][$this->action][$field]))	$this->form[$this->form['model']][$this->action][$field] = $test;
		return $this;
	}
	public function getFormValidator(){return $this->form;}
}

Class Validator{
	private static $validators = array();
	public static function ModelExists($model){return class_exists('Model\\'.$model); }
	public static function ControllerExists($controller){ return class_exists('Controller\\'.$controller); }
	public static function add($model,$return){ self::$validators[get_class($model)] = $return($FormValidator = new FormValidator($model)); }

	public static function execute($data){
		try{
			if(!is_array($data)) throw new Exception('Informações em formato incorreto.',11);
			if(!array_key_exists('data', $data)) throw new Exception('Informações cruciais não foram recebidas.',11);
			if(json_decode($data['data'])===null)	throw new Exception('O servidor recebeu as informações em formato json.',11);
			if(!empty($_GET) && !array_key_exists('class', $_GET)) throw new Exception('O servidor não recebeu o ID do formulário.',11);
			if(!self::ModelExists(ucfirst($_GET['class']))) throw new Exception('ID do formaluário não reconhecido.',11);

			$data = json_decode($data['data']);
			$class = 'Model\\'.ucfirst($_GET['class']);
			$model = new $class();

			if(empty($data[0]->value)) throw new Exception('O servidor não conseguiu identificar a finalidade deste formulário.',11);
			if(!array_key_exists($data[0]->value, self::$validators[get_class($model)])) throw new Exception('Não existe regras para validar este formulário.',11);

			$tests = (count(self::$validators[get_class($model)][$data[0]->value]));
			$testeds = 0;
			foreach (self::$validators[ucfirst(get_class($model))][$data[0]->value] as $key => $value) {
				for ($i=0; $i < count($data); $i++) {
					if($data[$i]->name===$key){
						$testeds++;
						foreach ($value as $subkey => $subvalue) {
							switch ($subkey) {
								case 'index':
									if($data[$subvalue]->name!==$key) throw new Exception('O registro \''.$key.'\' está em uma posição incorreta.',11);
									break;
								case 'type':
									if(array_key_exists('required', $value)){
										if($value['required'] or strlen($data[$i]->value)!==0){
											switch ($subvalue) {
												case 'date':
													$date = explode('/', $data[$i]->value);
													if(!checkdate($date[1],$date[0],$date[2]))
														throw new Exception('Data inválida.',10);
													break;
											}
										}
									}
									break;
								case 'maxlength':
									if(array_key_exists('required', $value)){
										if($value['required'] or strlen($data[$i]->value)!==0){
											if(strlen($data[$i]->value)>(int)$subvalue)
												//throw new Exception('|'.$key.'|O campo \''.$key.'\' ultrapassou o limite de caracteres permitidos.');
												throw new Exception($key.' ultrapassou o limite de caracteres permitidos.',10);
										}
									}
									break;
								case 'minlength':
									if(array_key_exists('required', $value)){
										if($value['required'] or strlen($data[$i]->value)!==0){
											if(strlen($data[$i]->value)<(int)$subvalue)
												//throw new Exception('|'.$key.'|O campo \''.$key.'\' não atingiu a minimos de caracteres necessários.');
												throw new Exception($key.' não atingiu a minimos de caracteres necessários.',10);
										}
									}
									break;
								case 'regex':
									if(array_key_exists('required', $value)){
										if($value['required'] or strlen($data[$i]->value)!==0){
											if(!@preg_match($subvalue,$data[$i]->value))
												//throw new Exception('|'.$key.'|O campo \''.$key.'\' está inválido.');
												throw new Exception($key.' inválido(a).',10);
										}
									}
									break;
								case 'equals':
									$equals = false;
									for ($e=0; $e < count($data); $e++) {
										if($data[$e]->name===$subvalue){
											$equals=true;
											if(array_key_exists('required', $value)){
												if($value['required'] or strlen($data[$i]->value)!==0){
													if($data[$i]->value!==$data[$e]->value)
														//throw new Exception('|'.$key.'|O campo \''.$key.'\' está diferente do campo \''.$subvalue.'\'.');
														throw new Exception($key.' está diferente do solicitado.',10);
												}
											}
										}
									}
									if(!$equals)
										throw new Exception('O servidor não encontrou a informação \''.$subvalue.'\' para ser comparada a \''.$key.'\'.',10);
									break;
							}
						}
					}
				}
			}
			if($tests!==$testeds)
				throw new Exception('Alguma informação necessária não pode ser validada.',11);
			return true;
		}catch(Exception $er){
			throw $er;
		}
	}
}
