@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <div class="container">
        @if (session('error'))
            <div id="alerta" class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ session('error') }}</strong>
            </div>
        @endif
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card border-left-primary shadow h-100 py-2" style="border-left: 5px solid #007bff; border-radius: 0 20px 20px 0;">
            {!! Form::model($question, [
                'route' => ['admin.questions.update', $question],
                'autocomplete' => 'off',
                'files' => true,
                'method' => 'PUT',
            ]) !!}
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="text-center">
                    <h4 class="mt-2">EDITAR PREGUNTA</h4>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <div class="form-outline" style="width: 4rem;">
                        {!! Form::number('puntaje', floor($question->puntaje), [
                            'min' => 1,
                            'id' => 'puntos',
                            'class' => 'form-control',  
                            'required'                          
                        ]) !!}
                    </div>
                    <span class="ml-2">puntos</span>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    {!! Form::textarea('pregunta', null, [
                        'id' => 'editor',
                        'class' => 'form-control form-control-lg',
                        'placeholder' => 'Ingrese la pregunta',
                        'required'
                    ]) !!}
                </div>
                <div class="form-group" id="alternatives-container">
                    @foreach ($question->options as  $alternative)
                        <div class="alternative-item" >
                            <div class="option-container">
                                <input type="radio" name="correct[]" value="{{ $alternative->id }}" {{ $alternative->correct_option ? 'checked' : '' }} required>
                                <input type="input" name="options[][{{$alternative->id}}]" value="{{ $alternative->option }}" class="form-control" placeholder="Ingrese la alternativa" required> 
                                <div style="position: relative;">
                                    <i class="far fa-image" style="position: absolute; margin-top: 13px; margin-left: 12.5px; font-size: 1.5rem;"></i>
                                    <button class="icon-button" type="button">
                                        <input type="file" accept="image/*" name="fileOptions[{{$alternative->id}}]" class="file-input">
                                    </button>
                                    <i class="fas fa-times" style="position: absolute; margin-top: 13px; margin-left: 17px; font-size: 1.5rem;"></i>
                                    <button class="icon-button-delete btn-remove-option" type="button"
                                        onclick="deleteOption('{{ route('questions.options.destroy', ['option' => $alternative->id]) }}', this)"></button>
                                </div>
                            </div>
                            @if ($alternative->image)
                                <div class="image-container">
                                    <img class="image-preview" src="{{ Storage::disk('s3')->url($alternative->image->url) }}" style="display: block;">
                                    <a class="icon-delete icon-show"
                                        onclick="deleteImage('{{ route('questions.options.image.destroy', ['option' => $alternative->id]) }}', this)"
                                        type="button">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            @else
                                <div class="image-container">
                                    <img class="image-preview" style="display: none;">
                                    <a class="icon-delete" type="button">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-outline-primary" id="add-option" type="button">Agregar Opción</button>
                <br>
            </div>
            <div class="card-footer" style="margin-bottom: -8px; border-end-end-radius: 20px">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')
    <style>
        .input-group-text {
            display: flex;
            align-items: center;
        }

        .image-preview {
            margin-top: 10px;
            max-width: 150px;
            height: auto;
            display: none;
            margin-left: 20px;
        }

        .alternative-item {
            margin-bottom: 10px;
        }

        .option-container {
            display: flex;
            align-items: center;
            gap: 2px;
            margin-bottom: 10px;
        }

        .option-container input[type="radio"] {
            margin-right: 5px;
        }

        .option-container .form-control {
            height: 45px;
            flex: 1;
        }

        .icon-button,
        .icon-button-delete {
            background: none;
            border: none;
            cursor: pointer;
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .icon-button,
        .icon-button-delete i {
            font-size: 1.5rem;
            margin: 0;
        }

        .icon-button:hover {
            background-color: rgba(146, 146, 146, 0.329);
        }

        .icon-button-delete:hover {
            background-color: rgba(146, 146, 146, 0.329);
        }

        .icon-button input[type="file"] {
            display: none;
        }

        .image-container {
            position: relative;
            width: 10rem;
        }

        .image-container img {
            max-width: 100%;
            display: block;
        }

        .icon-delete,
        .icon-show {
            position: absolute;
            top: 0;
            right: -16px;
            font-size: 1.5rem;
            color: red;
            cursor: pointer;
        }

        .icon-delete {
            display: none;
        }

        .icon-show {
            display: block;
        }
    </style>
@stop

@section('js')
    <script>
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return new Promise((resolve, reject) => {
                    const data = new FormData();
                    this.loader.file.then(file => {
                        data.append('upload', file);

                        fetch('{{ route('upload.image') }}', {
                                method: 'POST',
                                body: data,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                resolve({
                                    default: data.url
                                });
                                imageUrls.push(data.url);
                            })
                            .catch(error => {
                                reject(error);
                            });
                    });
                });
            }

        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        let imageUrls = [];

        ClassicEditor
            .create(document.querySelector('#editor'), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
            })
            .then(editor => {
                window.editor = editor;

                editor.model.document.on('change:data', () => {
                    const content = editor.getData();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(content, 'text/html');
                    const currentImages = Array.from(doc.querySelectorAll('img')).map(img => img.getAttribute(
                        'src'));

                    const imagesToDelete = imageUrls.filter(url => !currentImages.includes(url));
                    imagesToDelete.forEach(url => {
                        const xhr = new XMLHttpRequest();
                        xhr.open('DELETE', '{{ route('delete.image') }}', true);
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                        xhr.setRequestHeader('Content-Type', 'application/json');
                        xhr.send(JSON.stringify({
                            url: url
                        }));
                    });

                    imageUrls = currentImages;
                });
            })
            .catch(error => {
                console.error(error);
            });

        document.addEventListener('DOMContentLoaded', function () {
            const alternativesContainer = document.getElementById('alternatives-container');
            const addOptionButton = document.getElementById('add-option');
            let optionIndex = -1;

            addOptionButton.addEventListener('click', function () {
                const alternativeItem = document.createElement('div');
                alternativeItem.className = 'alternative-item';
                alternativeItem.dataset.id = optionIndex;

                alternativeItem.innerHTML = `
                    <div class="option-container">
                    <input type="radio" name="correct[]" value="${optionIndex}" required>
                    <input type="text" class="form-control" name="alternatives[][${optionIndex}]" placeholder="Ingrese la alternativa" required>
                    <div style="position: relative;">
                        <i class="far fa-image" style="position: absolute; margin-top: 13px; margin-left: 12.5px; font-size: 1.5rem;"></i>
                        <button class="icon-button" type="button">
                            <input type="file" accept="image/*" name="file[${optionIndex}]" class="file-input">
                        </button>
                        <i class="fas fa-times" style="position: absolute; margin-top: 13px; margin-left: 17px; font-size: 1.5rem;"></i>
                        <button class="icon-button-delete btn-remove-option" type="button"></button>
                    </div>
                    </div>
                    <div class="image-container">
                        <img class="image-preview" style="display: none;">
                        <a class="icon-delete" type="button">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                `;

                alternativesContainer.appendChild(alternativeItem);
                optionIndex--;
            });

            alternativesContainer.addEventListener('click', function (event) {
                if (event.target.classList.contains('btn-remove-option')) {
                    event.target.closest('.alternative-item').remove();
                } else if (event.target.classList.contains('icon-button')) {
                    const input = event.target.querySelector('.file-input');
                    input.click();
                } else if (event.target.closest('.icon-delete')) {
                    const alternativeItem = event.target.closest('.alternative-item');
                    alternativeItem.querySelector('.image-preview').src = '';
                    alternativeItem.querySelector('.image-preview').style.display = 'none';
                    alternativeItem.querySelector('.icon-delete').style.display = 'none';

                    alternativeItem.querySelector('.file-input').value = '';
                }
            });

            alternativesContainer.addEventListener('change', function (event) {
                const input = event.target;
                if (input.type === 'file' && input.files.length > 0) {
                    const file = input.files[0];
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const alternativeItem = input.closest('.alternative-item');
                        const imagePreview = alternativeItem.querySelector('.image-preview');
                        const iconDelete = alternativeItem.querySelector('.icon-delete');
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                        iconDelete.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        function deleteImage(url, element) {
            const imageContainer = $(element).closest('.image-container');
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    imageContainer.remove();
                },
                error: function (xhr) {
                    alert('Error al eliminar la imagen.');
                }
            });
        }

        function deleteOption(url, element) {
            const optionContainer = $(element).closest('.alternative-item');
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    optionContainer.remove();
                },
                error: function (xhr) {
                    alert('Error al eliminar la opción.');
                }
            });
        }
    </script>
@stop
