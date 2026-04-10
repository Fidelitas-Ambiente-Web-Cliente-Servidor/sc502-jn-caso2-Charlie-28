<!DOCTYPE html>
<html>

<head>

    <title>Registro</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="/sc502-jn-caso2-Charlie-28/public/css/style.css">

    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/register.js"></script>
</head>

<body class="container-page">

    <div class="auth-container">
        <div class="auth-card">

            <h2 class="mb-3">Registro</h2>

            <form id="formRegister" class="d-flex flex-column gap-2">

                <input
                    class="form-control"
                    name="nombre"
                    id="nombre"
                    placeholder="Nombre">

                <input
                    class="form-control"
                    name="username"
                    id="username"
                    placeholder="Usuario">

                <input
                    type="password"
                    class="form-control"
                    name="password"
                    id="password"
                    placeholder="Contraseña">

                <button type="submit" class="btn-nav btn-blue">
                    Registrarse
                </button>

                <a href="index.php?page=login" class="btn-nav btn-dark text-center">
                    Iniciar sesión
                </a>

            </form>

            <div id="mensaje" class="mt-3"></div>

        </div>
    </div>

</body>

</html>