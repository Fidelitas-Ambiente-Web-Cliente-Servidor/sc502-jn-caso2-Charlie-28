

$(function () {
    cargarSolicitudes();

    function cargarSolicitudes() {
        $.ajax({
            url: 'index.php',
            type: 'GET',
            data: { option: 'solicitudes_json' },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                let body = $("#solicitudes-body");
                body.empty();

                if (!data || data.length === 0) {
                    body.html(`
                    <tr>
                        <td colspan="5" class="loader">No hay solicitudes pendientes</td>
                    </tr>
                `);
                    return;
                }

                $.each(data, function (index, solicitud) {
                    body.append(`
                    <tr>
                        <td>${solicitud.id}</td>
                        <td>${solicitud.taller}</td>
                        <td>${solicitud.usuario}</td>
                        <td>${solicitud.fecha}</td>
                        <td>
                            <button class="btn-nav btn-blue btn-aprobar" data-id="${solicitud.id}">Aprobar</button>
                            <button class="btn-nav btn-red btn-rechazar" data-id="${solicitud.id}">Rechazar</button>
                        </td>
                    </tr>
                `);
                });
            },
            error: function () {
                $("#solicitudes-body").html(`
                <tr>
                    <td colspan="5" class="loader">Error al cargar solicitudes</td>
                </tr>
            `);
            }
        });
    }

    $(document).on("click", ".btn-aprobar", function () {
        let idSolicitud = $(this).data("id");

        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: {
                option: 'aprobar',
                id_solicitud: idSolicitud
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $("#mensaje").text(response.message).show();
                    cargarSolicitudes();
                } else {
                    $("#mensaje").text(response.error).show();
                }
            },
            error: function () {
                $("#mensaje").text("Error al aprobar la solicitud").show();
            }
        });
    });

    $(document).on("click", ".btn-rechazar", function () {
        let idSolicitud = $(this).data("id");

        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: {
                option: 'rechazar',
                id_solicitud: idSolicitud
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $("#mensaje").text(response.message).show();
                    cargarSolicitudes();
                } else {
                    $("#mensaje").text(response.error).show();
                }
            },
            error: function () {
                $("#mensaje").text("Error al rechazar la solicitud").show();
            }
        });
    });

    $("#btnLogout").on("click", function () {
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: { option: 'logout' },
            dataType: 'json',
            success: function () {
                window.location.href = 'index.php?page=login';
            }
        });
    });
});