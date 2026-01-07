<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Métricas</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }

    .dashboard {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .card {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 25px;
      border-radius: 16px;
      color: #fff;
      box-shadow: 0 6px 12px rgba(0,0,0,0.15);
      transition: transform 0.2s ease;
      background: linear-gradient(135deg, #8A05BE, #4A00E0); /* Gradiente Nubank */
    }

    .card:hover {
      transform: scale(1.05);
    }

    .icon {
      font-size: 36px;
      margin-bottom: 12px;
    }

    .info h2 {
      font-size: 32px;
      margin: 0;
    }

    .info p {
      margin: 6px 0 0;
      font-size: 18px;
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <div class="card">
      <div class="icon">👤</div>
      <div class="info">
        <h2>2</h2>
        <p>Usuários</p>
      </div>
    </div>
    <div class="card">
      <div class="icon">🏊</div>
      <div class="info">
        <h2>1</h2>
        <p>Resultados</p>
      </div>
    </div>
    <div class="card">
      <div class="icon">📅</div>
      <div class="info">
        <h2>8</h2>
        <p>Faixas Etárias</p>
      </div>
    </div>
    <div class="card">
      <div class="icon">🏋️</div>
      <div class="info">
        <h2>6</h2>
        <p>Tipos de Exercícios</p>
      </div>
    </div>
    <div class="card">
      <div class="icon">📝</div>
      <div class="info">
        <h2>17</h2>
        <p>Notas dos Exercícios</p>
      </div>
    </div>
  </div>
</body>
</html>
