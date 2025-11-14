<?php

class Usuarios{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $tipo; // 'aluno' ou 'professor'

    public function __construct($id, $nome, $email, $senha, $tipo){
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->tipo = $tipo;
    }

    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function getTipo(){
        return $this->tipo;
    }
}