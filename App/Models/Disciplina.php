<?php

class Disciplinas{
    private $id;
    private $nome;
    private $carga_horaria;
    private $professor_id;

    public function __construct($id, $nome, $carga_horaria, $professor_id){
        $this->id = $id;
        $this->nome = $nome;
        $this->carga_horaria = $carga_horaria;
        $this->professor_id = $professor_id;
    }

    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getCargaHoraria(){
        return $this->carga_horaria;
    }

    public function getProfessorId(){
        return $this->professor_id;
    }
}