<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resultados_usuarios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notas_exercicios_model');
    }

    function listar_resultados()
    {
        $dados = $this->db
            ->select('
        u.id AS usuario_id,
        u.nome,
        u.sexo,
        CONCAT(f.idade_inicial, "-", f.idade_final) AS faixa_etaria,
        f.nome_grupo,
        re.id AS exercicio_id,
        re.nome_exercicio,
        re.tipo_exercicio,
        eu.contagem_exercicio,
        COALESCE(ne.valor_nota, 0) AS valor_nota,
        COALESCE(ne.meta_exercicio, nmin.meta_exercicio) AS meta_exercicio
    ')
            ->from('resultados_usuarios r')
            ->join('usuarios u', 'u.id = r.usuario_id')
            ->join('faixas_etarias f', 'f.id = r.faixa_id')
            ->join('registro_exercicios re', 're.id = r.registro_exercicio_id')
            ->join('exercicios_usuarios eu', 'eu.id = r.exercicio_usuario_id')
            // join padrão
            ->join('notas_exercicios ne', 'ne.id = r.nota_ex_id', 'left')
            // subquery que pega a menor nota possível da combinação correspondente
            ->join('(
        SELECT registro_exercicio_id, faixa_id, sexo, MIN(valor_nota) AS valor_nota,meta_exercicio
        FROM notas_exercicios
        GROUP BY registro_exercicio_id, faixa_id, sexo
    ) AS nmin',
                'nmin.registro_exercicio_id = re.id 
         AND nmin.faixa_id = f.id 
         AND nmin.sexo = u.sexo',
                'left'
            )
            ->order_by('u.id, re.id')
            ->get()
            ->result_array();


        return agrupar_resultados_exercicios_por_usuarios($dados);
    }

    function inserir_notas_resultados($dados)
    {

        $nem = $this->Notas_exercicios_model;
        $exercicios = $nem->exercicio_atingiram_meta($dados);

        if (!$exercicios)
            return;
        else {
            //se atingir ou não a meta
            $id_valor_nota = $nem->obter_id_valor_nota($dados['valor_nota'], $dados['registro_exercicio_id']);
            foreach ($exercicios as $key => $dados_array) {
                if ($dados['valor_nota'] > $dados_array['valor_nota']) {
                    $this->db->where('id', $dados_array['id'])->update('resultados_usuarios', ['nota_ex_id' => $id_valor_nota]);
                } else {
                    return;
                }
            }
            return;
        }
    }



    function inserir_resultados_usuarios($dados, $exercicio_usuario_id)
    {
        $notasModel = $this->Notas_exercicios_model;
        $usuariosModel = $this->Usuarios_model;
        $idadesModel = $this->Idades_model;

        // 🧮 1. Obter a maior nota possível para o exercício
        $resultado = $notasModel->dados_maior_nota_exercicio($dados);
        $nova_nota = $resultado['valor_nota'];

        // Montar estrutura base do registro
        $registro = [
            'nota_ex_id' => $resultado['nota_ex_id'] ?? null,
            'usuario_id' => $dados['usuario_id'],
            'exercicio_usuario_id' => $exercicio_usuario_id,
            'registro_exercicio_id' => $dados['registro_exercicio_id']
        ];

        //  2. Determinar a faixa etária do usuário
        $usuario = $usuariosModel->buscar($dados['usuario_id']);
        $registro['faixa_id'] = $idadesModel->get_id_by_faixa($usuario['data_nascimento']);

        //  3. Verificar se já existe um registro com os mesmos critérios
        $existe = $this->db
            ->where('usuario_id', $registro['usuario_id'])
            ->where('faixa_id', $registro['faixa_id'])
            ->where('registro_exercicio_id', $registro['registro_exercicio_id'])
            ->get('resultados_usuarios')
            ->row_array();

        // Caso exista, buscar o valor da nota associada
        $nota_existente = null;
        if ($existe && !empty($existe['nota_ex_id'])) {
            $nota_existente = $this->db
                ->select('valor_nota')
                ->get_where('notas_exercicios', ['id' => $existe['nota_ex_id']])
                ->row_array()['valor_nota'] ?? null;
        }

        //  4. Tomar decisão: INSERT, UPDATE ou ignorar
        if ($existe) {
            if ($nota_existente != $nova_nota) {
                // Caso 1 — Atualiza o registro existente com nova nota
                $this->db->where('id', $existe['id'])
                    ->update('resultados_usuarios', ['nota_ex_id' => $registro['nota_ex_id']]);

                log_message('debug', 'UPDATE executado: valor_nota alterado');
            } else {
                // Caso 2 — Mesmos dados, nenhuma ação
                log_message('debug', 'Nenhuma ação: nota idêntica');
            }
        } else {
            // Caso 3 — Nenhum registro existente, inserir novo
            $this->db->insert('resultados_usuarios', $registro);
            log_message('debug', 'INSERT executado: novo registro adicionado');
        }
    }


}
?>