const express = require('express');
const app = express();

app.get('/', (req, res) => {
  res.send(`
    <!DOCTYPE html>
    <html>
      <head>
        <title>Keny - Docker App</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: #0f0f0f;
            color: white;
          }
          .card {
            text-align: center;
            padding: 40px;
            border: 1px solid #333;
            border-radius: 12px;
          }
          h1 { color: #00d4ff; }
        </style>
      </head>
      <body>
        <div class="card">
          <h1>🚀 Keny Docker App</h1>
          <p>Déployée sur Azure avec Docker</p>
          <p>✅ Multi-stage build</p>
          <p>✅ Docker Hub</p>
          <p>✅ Azure App Service</p>
          <p>✅ Déployé automatiquement via CI/CD</p>
        </div>
      </body>
    </html>
  `);
});

app.listen(3000, () => {
  console.log('Serveur démarré sur le port 3000');
});