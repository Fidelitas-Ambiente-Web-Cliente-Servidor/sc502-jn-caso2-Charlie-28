<!DOCTYPE html>
<html>

<head>
    <title>Listado Talleres</title>

    <link rel="stylesheet" href="/sc502-jn-caso2-Charlie-28/public/css/style.css">
    <script src="public/js/jquery-4.0.0.min.js"></script>
</head>

<body class="container-page">

    <nav class="topbar">
        <div class="nav-left">
            <a href="index.php?page=talleres" class="btn-nav btn-blue">Talleres</a>

            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <a href="index.php?page=admin" class="btn-nav btn-dark">Gestionar Solicitudes</a>
            <?php endif; ?>
        </div>

        <div class="nav-right">
            <span class="user-label">
                <?= htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['user'] ?? 'Usuario') ?>
            </span>
            <button id="btnLogout" class="btn-nav btn-red">Cerrar sesión</button>
        </div>
    </nav>

    <main class="main-card">
        <h3>Talleres</h3>

        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Taller</th>
                        <th>Descripción</th>
                        <th>Cupo disponible</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="talleres-body">
                    <tr>
                        <td colspan="5" class="loader">Cargando talleres...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="mensaje"></div>
    </main>

    <script src="public/js/taller.js"></script>
</body>

</html>