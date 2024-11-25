<x-app-layout>
    @section('title', '- Consultas')
    <section class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 border">
            <h1 class="text-3xl font-bold mb-2 text-gray-800">Centro de Capacitación Profesional</h1>
            <h2 class="text-xl font-bold mb-4 text-gray-700">Los Que Más Saben - AI PAEC</h2>

            <form id="form-consultas" class="p-6">
                <div class="mb-4">
                    <label for="Dni" class="block mb-1 text-gray-700">Ingrese su DNI</label>
                    <input type="text" id="Dni" placeholder="DNI" name="Dni"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <button type="button" onclick="consultar()"
                        class="w-auto bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">CONSULTAR</button>
                </div>
                <p class="text-sm text-center text-gray-600">DUPGCCSSCONSULTAS@GMAIL.COM</p>
            </form>
            

            <!-- Resultados de la Consulta -->
            <div class="mt-8 hidden" id="resultadosContainer">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Datos del Usuario</h2>

                <!-- Tabla de Datos Personales -->
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full bg-white border-collapse table-auto shadow-md">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b text-left bg-gray-100">DNI</th>
                                <th class="px-4 py-2 border-b text-left bg-gray-100">Nombres</th>
                                <th class="px-4 py-2 border-b text-left bg-gray-100">Apellidos</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDatosPersonales">
                            <!-- Los datos se agregarán aquí por AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Tabla de Datos del Certificado -->
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Datos del Certificado</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border-collapse table-auto shadow-md">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b text-left bg-gray-100">Curso</th>
                                <th class="px-4 py-2 border-b text-left bg-gray-100">Resolución</th>
                                <th class="px-4 py-2 border-b text-left bg-gray-100">Código</th>
                                <th class="px-4 py-2 border-b text-left bg-gray-100">Certificado</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDatosCertificado">
                            <!-- Los datos del certificado se agregarán aquí por AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function consultar() {
            var dni = $('#Dni').val();

            // Validar que se haya ingresado un DNI
            if (!dni) {
                alert("Por favor, ingrese su DNI.");
                return;
            }

            $.ajax({
                url: "{{ route('certificados.BuscarCertificado') }}", // Cambia la ruta a la de tu consulta por DNI
                type: "GET",
                data: {
                    dni: dni
                },
                dataType: 'json',

                success: function(data) {
                    // Mostrar el contenedor de resultados
                    $('#resultadosContainer').show();

                    // Limpiar tablas antes de agregar nuevos datos
                    $('#tablaDatosPersonales').empty();
                    $('#tablaDatosCertificado').empty();

                    if (data.success) {
                        // Tabla de Datos Personales
                        var tablaDatosPersonales = $('#tablaDatosPersonales');
                        tablaDatosPersonales.append(`
                            <tr>
                                <td class="px-4 py-2 border-b">${data.data.dni}</td>
                                <td class="px-4 py-2 border-b">${data.data.nombres}</td>
                                <td class="px-4 py-2 border-b">${data.data.apellidos}</td>
                            </tr>
                        `);

                        // Tabla de Datos del Certificado
                        var tablaDatosCertificado = $('#tablaDatosCertificado');
                        tablaDatosCertificado.append(`
                            <tr>
                                <td class="px-4 py-2 border-b">${data.data.curso}</td>
                                <td class="px-4 py-2 border-b">${data.data.resolucion}</td>
                                <td class="px-4 py-2 border-b">${data.data.codigo}</td>
                                <td class="px-4 py-2 border-b">
                                    <a href="${data.data.documento}" download target="_blank"
                                        class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Descargar</a>
                                </td>
                            </tr>
                        `);
                    } else {
                        alert(data.message); // Mostrar mensaje de error si no se encuentra el DNI
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error en la solicitud. Por favor, inténtelo de nuevo.");
                }
            });
        }
    </script>
</x-app-layout>
