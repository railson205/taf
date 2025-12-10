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
        <?php foreach ($resultados['registro_exercicios'] as $key => $r) {
          $this->load->view('templates/avaliacao_modal', ['id' => "avaliacao_modal$key", 'exercicios' => $r['exercicios'], 'registro' => $r,'isDashboard'=>true]);
        } ?>

            <table class="table table-striped table-hover table-bordered datatable" style="width: 100%;">
              <thead>
                <tr>
                  <th class="text-center border-end border-top border-dark">#</th>
                  <th class="text-center border-end border-top border-dark">Nome</th>
                  <th class="text-center border-end border-top border-dark">Sexo</th>
                  <th class="text-center border-end border-top border-dark">Faixa Etária
                  </th>
                  <th class="text-center border-end border-top border-dark">Grupo
                    da<br>Faixa
                    Etária</th>
                  <th class="text-center border-end border-top border-dark">Exercícios</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($resultados)): ?>
                  <?php foreach ($resultados['registro_exercicios'] as $key => $r): ?>


                    <!-- LINHA PAI -->
                    <tr>
                      <td class="text-center"><?= $key + 1 ?> </td>
                      <td class="text-center"><?= $r['nome'] ?? '-' ?></td>

                      <td class="text-center">
                        <?= $r['sexo'] ?? '-' ?>
                        <?php if ($r['sexo'] == "Masculino"): ?>
                          <i class="fa-solid fa-mars bg-info p-2 rounded text-white"></i>
                        <?php elseif ($r['sexo'] == 'Feminino'): ?>
                          <i class="fa-solid fa-venus bg-danger p-2 rounded text-white"></i>
                        <?php endif; ?>
                      </td>

                      <td class="text-center"><?= $r['faixa_etaria'] ?? '-' ?></td>
                      <td class="text-center"><?= $r['grupo_faixa'] ?? '-' ?></td>

                      <!-- BOTÃO DO ACCORDION -->
                      <td class="text-center">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                          data-bs-target="#avaliacao_modal<?= $key ?>">
                          Detalhes
                        </button>

                      </td>
                    </tr>


                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6">Nenhum exercício encontrado.</td>
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
  <script>
        $(document).ready(function () {
            $('.datatable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 5,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json"
                },
                columnDefs: [
                    { orderable: false, targets: -1 } // Ações não ordena
                ]
            });
        });
    </script>
</section>