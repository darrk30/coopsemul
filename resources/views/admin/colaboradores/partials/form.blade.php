<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('name', 'Nombres', ['class' => 'form-label']) !!}
            {!! Form::text('name', $user->name ?? null, ['class' => 'form-control', 'required']) !!}
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('apellidos', 'Apellidos', ['class' => 'form-label']) !!}
            {!! Form::text('apellidos', $user->profile->apellidos ?? null, ['class' => 'form-control', 'required']) !!}
            @error('apellidos')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="{{ isset($user) ? 'col-md-6' : 'col-md-4' }}">
        <div class="form-group">
            {!! Form::label('DNI', 'DNI', ['class' => 'form-label']) !!}
            {!! Form::text('DNI', $user->profile->DNI ?? null, ['class' => 'form-control', 'required']) !!}
            @error('DNI')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="{{ isset($user) ? 'col-md-6' : 'col-md-4' }}">
        <div class="form-group">
            {!! Form::label('email', 'Email', ['class' => 'form-label']) !!}
            {!! Form::email('email', $user->email ?? null, [
                'class' => 'form-control',
                'required',
                'autocomplete' => 'current-email',
            ]) !!}
            @error('email')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
    @if (!isset($user))
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('password', 'Contraseña', ['class' => 'form-label']) !!}
                {!! Form::password('password', ['class' => 'form-control', 'required', 'autocomplete' => 'current-password']) !!}
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
    @else
    
        <div class="col-md-4" id="password_field" style="{{ old('activate_password') ? 'display:block;' : 'display:none;' }}">
            <div class="form-group">
                {!! Form::label('password', 'Contraseña', ['class' => 'form-label']) !!}
                {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'current-password']) !!}
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const activatePasswordCheckbox = document.getElementById('activate_password');
                const passwordField = document.getElementById('password_field');

                activatePasswordCheckbox.addEventListener('change', function() {
                    passwordField.style.display = this.checked ? 'block' : 'none';
                });
            });
        </script>
    @endif

</div>


<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('biografia', 'Bibliografía', ['class' => 'form-label']) !!}
            {!! Form::textarea('biografia', $user->profile->biografia ?? null, ['class' => 'form-control', 'rows' => 2]) !!}
            @error('biografia')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('especialidad', 'Especialidad', ['class' => 'form-label']) !!}
            {!! Form::text('especialidad', $user->profile->especialidad ?? null, ['class' => 'form-control']) !!}
            @error('especialidad')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('role', 'Rol') !!}
            @foreach ($roles as $role)
                <div class="custom-control custom-switch">
                    {!! Form::checkbox('roles[]', $role->id, null, [
                        'class' => 'custom-control-input ',
                        'id' => 'role_' . $role->id,
                    ]) !!}
                    <label class="custom-control-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('status', 'Estado') !!}
            {!! Form::select('status', ['1' => 'Activo', '0' => 'No activo'], $user->profile->status ?? null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione una opción',
            ]) !!}
            @error('status')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
