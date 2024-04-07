<x-app-layout>
    @section('title', '- Consultas')
    <section class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Contenedor de la información -->
            <div class="max-w-md bg-white rounded-lg shadow-md p-6">
                <h1 class="text-3xl font-bold mb-2 text-gray-800">Centro de Capacitación Profesional</h1>
                <h2 class="text-xl font-bold mb-4 text-gray-700">Los Que Más Saben - AI PAEC</h2>
                <div class="flex flex-col">
                    <span class="text-gray-600 mb-2">Documento: <span id="spnDocumento"></span></span>
                    <span class="text-gray-600 mb-2">Otorgado: <span id="spnotorgado"></span></span>
                    <span class="text-gray-600">Nombres: <span id="spnNombres"></span></span>
                </div>
            </div>
            <!-- Formulario de consultas -->
            <div class="max-w-md">
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
                                <!-- Opciones generadas dinámicamente desde la base de datos -->
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
                            <button type="button" onclick="consultar()" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">CONSULTAR</button>
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
                        if (data.data.documento === "75235618") {
                            spnDocumento.html('<span class="certificado-text">Certificado de:</span><br>' + data.data.documento);
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
</x-app-layout>
