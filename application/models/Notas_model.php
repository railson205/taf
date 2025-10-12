<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notas_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        // Carrega o outro model
        $this->load->model('Idade_model');
    }

    public function listar_notas(){
        $dados= $this->db->get('notas')->result_array();
        foreach ($dados as $value => $row) {
            $row['faixa']=$this->Idade_model->get_faixa_by_id($row['faixa_id']);
            $row['corrida_2400m'] = segundos_para_tempo($row['corrida_2400m']);
            $row['natacao_100m'] = segundos_para_tempo($row['natacao_100m']);
            $dados[$value] = $row;
        }
        return $dados;
    }

    public function inserir_notas($dados){
        return $this->db->insert('notas',$dados);
    }

    public function att_notas() {
        //Help:Insere um novo usuário na tabela 'usuarios' com os dados fornecidos
        return ;
    }

    public function mocar_tabela($dados){
        $this->db->insert_batch('notas',$dados);
    }

    public function deletar_tabela(){
        $sql='DROP TABLE notas';
        return $this->db->query($sql);
    }

    public function criar_tabela(){
        $sql='CREATE TABLE notas(id INT PRIMARY KEY AUTO_INCREMENT, faixa_id INT, sexo VARCHAR(10), nota FLOAT,corrida_2400m FLOAT,flexao_abdominal_supra FLOAT,flexao_barra_fixa FLOAT,natacao_100m FLOAT,flexao_braco_solo FLOAT,natacao_12min FLOAT,FOREIGN KEY (faixa_id) REFERENCES faixas_etarias(id))';
        return $this->db->query($sql);
    }

}
?>