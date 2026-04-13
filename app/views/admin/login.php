<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Login — Le Mascotte</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>body{font-family:'Nunito',sans-serif;}</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-orange-50 flex items-center justify-center p-4">

<div class="w-full max-w-md">
  <!-- Logo -->
  <div class="text-center mb-8">
    <div class="w-16 h-16 bg-[#FF6B35] rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-lg">🐾</div>
    <h1 class="text-2xl font-black text-gray-900">Le Mascotte</h1>
    <p class="text-sm text-gray-500 font-semibold">Panel de Administración</p>
  </div>

  <!-- Card -->
  <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Iniciar sesión</h2>

    <?php if (!empty($_SESSION['admin_error'])): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 flex items-center gap-2 text-sm font-semibold">
      <i class="fas fa-exclamation-circle text-red-500"></i>
      <?= htmlspecialchars($_SESSION['admin_error']) ?>
    </div>
    <?php unset($_SESSION['admin_error']); endif; ?>

    <form method="POST" action="<?= APP_URL ?>/admin/login" class="space-y-5">
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-1.5">Email</label>
        <div class="relative">
          <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
          <input type="email" name="email" required autofocus placeholder="admin@lemascotte.com"
                 class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 text-sm transition-all">
        </div>
      </div>
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-1.5">Contraseña</label>
        <div class="relative">
          <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
          <input type="password" name="password" required placeholder="••••••••"
                 class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 text-sm transition-all">
        </div>
      </div>
      <button type="submit"
              class="w-full bg-[#FF6B35] text-white py-3.5 rounded-xl font-bold text-sm hover:bg-[#E5521C] transition-colors shadow-md hover:shadow-lg">
        <i class="fas fa-sign-in-alt mr-2"></i>Entrar al panel
      </button>
    </form>

    <p class="text-center text-xs text-gray-400 mt-5">
      <a href="<?= APP_URL ?>/inicio" class="text-orange-500 font-bold hover:underline">← Volver al sitio</a>
    </p>
  </div>

  <p class="text-center text-xs text-gray-400 mt-5">
    Credenciales por defecto: <strong>admin@lemascotte.com</strong> / <strong>admin123</strong>
  </p>
</div>
</body>
</html>
