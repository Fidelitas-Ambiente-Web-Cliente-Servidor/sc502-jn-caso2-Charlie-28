<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Solicitudes pendientes</title>

    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/admin.js"></script>
    <link rel="stylesheet" href="/sc502-jn-caso2-Charlie-28/public/css/style.css">
</head>

<body class="container-page">
    <nav class="topbar">
        <div class="nav-left">
            <a href="index.php?page=talleres" class="btn-nav btn-blue">Talleres</a>
            <a href="index.php?page=admin" class="btn-nav btn-dark">Gestionar Solicitudes</a>
        </div>

        <div class="nav-right">
            <span class="user-label">
                Admin: <?= htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['user'] ?? 'Administrador') ?>
            </span>
            <button id="btnLogout" class="btn-nav btn-red">Cerrar sesión</button>
        </div>
    </nav>

    <main class="main-card">
        <h2>Solicitudes pendientes de aprobación</h2>

        <div class="table-container">
            <table id="tabla-solicitudes" class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Taller</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="solicitudes-body">
                    <tr>
                        <td colspan="5" class="loader">Cargando solicitudes...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="mensaje"></div>
    </main>
</body>

</html>