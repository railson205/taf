<section class="content">
  <div class="container-fluid">

    <div class="row mt-4 mw-50 mh-50">
      <?php $this->load->view('templates/small_box', ['color' => 'bg-info', 'value' => count($usuarios), 'title' => 'Usuários', 'icon' => 'fa-solid fa-user']) ?>
      <?php $this->load->view('templates/small_box', ['color' => 'bg-success', 'value' => count($faixas_etarias), 'title' => 'Faixas Etárias', 'icon' => 'fa-solid fa-calendar']) ?>
      <?php $this->load->view('templates/small_box', ['color' => 'bg-warning', 'value' => count($exercicios), 'title' => 'Tipos de Exercícios', 'icon' => 'fa-solid fa-dumbbell']) ?>
      <?php $this->load->view('templates/small_box', ['color' => 'bg-danger', 'value' => count($notas), 'title' => 'Notas dos Exercícios', 'icon' => 'fa-solid fa-file-pen']) ?>
      <?php $qtdResultados = 0;
      foreach ($resultados['registro_exercicios'] as $registro) {
        $qtdResultados += count($registro['exercicios']);
      }
      $this->load->view('templates/small_box', ['color' => 'bg-info', 'value' => $qtdResultados, 'title' => 'Resultados', 'icon' => 'fa-solid fa-person-swimming'])
        ?>

    </div>
    <!-- Parâmetros iniciais-->
    <?php
    $ex_unic = $resultados['exercicios_unicos_usuarios'];

    ?>
    <!--Tabela dos resultados-->
    <div class="row mt-4">
      <div class="col-md-12">
        <h5>Resultados</h5>
        <div class="card">
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th rowspan="2" class="text-center border-end border-top border-dark">#</th>
                  <th rowspan="2" class="text-center border-end border-top border-dark">Nome</th>
                  <th rowspan="2" class="text-center border-end border-top border-dark">Sexo</th>
                  <th rowspan="2" class="text-center border-end border-top border-dark">Faixa Etária
                  </th>
                  <th rowspan="2" class="text-center border-end border-top border-dark">Grupo
                    da<br>Faixa
                    Etária</th>
                  <th rowspan="2" class="text-center border-end border-top border-dark">Nota Média
                  </th>
                  <?php foreach ($ex_unic as $exercicio): ?>
                    <th colspan="3" class="text-center border-end border-dark bg-secondary text-white">
                      <?= htmlspecialchars($exercicio) ?>
                    </th>
                  <?php endforeach; ?>
                </tr>
                <tr>

                  <?php foreach ($ex_unic as $exercicio): ?>
                    <th class="text-center border-end border-dark">Modo de Contagem</th>
                    <th class="text-center border-end border-dark">Índice</th>
                    <th class="text-center border-end border-dark">Nota</th>
                  <?php endforeach; ?>

                </tr>
              </thead>
              <tbody>
                <?php
                if (!empty($resultados)):
                  foreach ($resultados['registro_exercicios'] as $key => $r):

                    // Mapeia os exercícios do usuário para facilitar acesso pelo nome
                    $notaTotal = 0;
                    $qtdNotas = 0;
                    $map_exercicios = [];
                    foreach ($r['exercicios'] as $ex) {
                      $notaTotal += (float) $ex['valor_nota'];
                      $qtdNotas += 1;
                      $map_exercicios[$ex['nome_exercicio']] = $ex;
                    }

                    ?>
                    <tr>
                      <td class="text-center"><?= $key + 1 ?></td>
                      <td class="text-center"><?= $r['nome'] ?? '-' ?></td>
                      <td class="text-center"><?= $r['sexo'] ?? '-' ?></td>
                      <td class="text-center"><?= $r['faixa_etaria'] ?? '-' ?></td>
                      <td class="text-center"><?= $r['grupo_faixa'] ?? '-' ?></td>
                      <td class="text-center"><?= $notaTotal/$qtdNotas?></td>

                      <?php


                      foreach ($ex_unic as $exercicio):
                        $ex = $map_exercicios[$exercicio] ?? null;
                        ?>
                        <td class="text-center"><?= $ex['modo_contagem'] ?? '-' ?></td>
                        <td class="text-center">
                          <?= $ex['modo_contagem'] == 'Tempo' ? segundos_para_tempo($ex['indice']) : $ex['indice'] ?? '-' ?>
                        </td>
                        <td class="text-center"><?= $ex['valor_nota'] ?? '-' ?></td>
                      <?php endforeach; ?>

                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5">Nenhum exercício realizado encontrado.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!--Tabela -->
    </div>
  </div>
</section>