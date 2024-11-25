{{-- <x-app-layout>
    @section('title', '- Consultas')
    <section class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" >
            <div class="mx-auto max-w-md bg-white rounded-lg shadow-md p-6" style="border: solid;">
                <h1 class="text-3xl font-bold mb-2 text-gray-800">Centro de Capacitación Profesional</h1>
                <h2 class="text-xl font-bold mb-4 text-gray-700">Los Que Más Saben - AI PAEC</h2>
                <div class="flex flex-col">
                    <span class="text-gray-600 mb-2">Documento: <span id="spnDocumento"></span></span>
                    <span class="text-gray-600 mb-2">Otorgado: <span id="spnotorgado"></span></span>
                    <span class="text-gray-600">Nombres: <span id="spnNombres"></span></span>
                </div>
            </div>

            <div class="max-w-md mx-auto" style="border: solid;">
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <form id="form-consultas" class="p-6">
                        <div class="mb-4">
                            <img src="../Recursos/images/logo.png" alt="logo" class="w-24 mx-auto mb-4">
                        </div>
                        <div class="mb-4" id="mensajeContainer">
                            <span id="lblmensaje" class="text-lg font-bold block text-center">Bienvenido</span>
                        </div>
                        <div class="mb-4">
                            <label for="DNI" class="block mb-1">DNI</label>
                            <input type="text" id="Dni" placeholder="DNI" name="Dni"
                                class="w-full border border-gray-300 rounded-md py-2 px-3">
                        </div>
                        <div class="mb-4">
                            <label for="Resolucion" class="block mb-1">Seleccionar la Resolución</label>
                            <select id="Resolucion" name="Resolucion"
                                class="w-full border border-gray-300 rounded-md py-2 px-3">
                                <option value="1">Seleccionar</option>
                                <option value="2">001-A2022-DUPG/CC.SS</option>
                                <option value="3">909/2021 EPG - UNT</option>
                                <option value="3">005-CONV/AUSP-EPG</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="codigo" class="block mb-1">Ingresar su Codigo</label>
                            <input type="text" id="codigo" placeholder="23-45-1245" name="codigo"
                                class="w-full border border-gray-300 rounded-md py-2 px-3">
                        </div>
                        <div class="mb-4">
                            <button type="button" onclick="consultar()"
                                class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">CONSULTAR</button>
                            <p class="text-sm text-center">DUPGCCSSCONSULTAS@GMAIL.COM</p>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p>Para verificar su documentación, digite el código en el siguiente formato,
                                Libro-Folio-Registro Ejemplo: 20B-2-57</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function consultar() {
            var formData = $('#form-consultas').serialize();

            $.ajax({
                url: "{{ route('consultas.resolucion') }}",
                type: "GET",
                data: formData,
                dataType: 'json',
                success: function(data) {
                    var spnDocumento = $('#spnDocumento');
                    var spnNombres = $('#spnNombres');
                    var mensajeContainer = $('#mensajeContainer');
                    var spnMensaje = $('#lblmensaje');

                    if (data.success) {
                        if (data.data.documento === "Capacitación" || data.data.documento === "Actualización") {
                            spnDocumento.html('<span class="certificado-text">Certificado de:</span><br>' + data
                                .data.documento);
                        } else {
                            spnDocumento.text(data.data.documento);
                        }

                        spnNombres.text(data.data.nombres);
                        mensajeContainer.css('display', 'none');
                    } else {
                        spnDocumento.text('');
                        spnNombres.text('');
                        mensajeContainer.css('display', 'block');
                        spnMensaje.text(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    var spnMensaje = $('#lblmensaje');
                    var mensajeContainer = $('#mensajeContainer');
                    mensajeContainer.css('display', 'block');
                    spnMensaje.text("Error en la solicitud. Por favor, inténtelo de nuevo.");
                }
            });
        }
    </script>
</x-app-layout> --}}
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
