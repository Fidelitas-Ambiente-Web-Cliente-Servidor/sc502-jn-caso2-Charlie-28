$(function () {
    cargarTalleres();

    function cargarTalleres() {
        $.ajax({
            url: 'index.php',
            type: 'GET',
            data: { option: 'talleres_json' },
            dataType: 'json',
            success: function (data) {
                let body = $("#talleres-body");
                body.empty();

                if (!data || data.length === 0) {
                    body.html(`
                        <tr>
                            <td colspan="5">No hay talleres disponibles</td>
                        </tr>
                    `);
                    return;
                }

                $.each(data, function (index, taller) {
                    body.append(`
                        <tr>
                            <td>${taller.id}</td>
                            <td>${taller.nombre}</td>
                            <td>${taller.descripcion}</td>
                            <td>${taller.cupo_disponible}</td>
                            <td>
                                <button class="btn-nav btn-blue btn-solicitar" data-id="${taller.id}">
                                    Solicitar
                                </button>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function () {
                $("#talleres-body").html(`
                    <tr>
                        <td colspan="5">Error al cargar talleres</td>
                    </tr>
                `);
            }
        });
    }

    $(document).on("click", ".btn-solicitar", function () {
        let tallerId = $(this).data("id");

        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: {
                option: 'solicitar',
                taller_id: tallerId
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $("#mensaje").text(response.message).show();
                    cargarTalleres();
                } else {
                    $("#mensaje").text(response.error).show();
                }
            },
            error: function () {
                $("#mensaje").text("Error al enviar la solicitud").show();
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