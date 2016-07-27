@if (count($errors) > 0)
    <div class="alert alert-danger hidden">
        <strong>Houps !</strong> Il y a des problèmes avec vos informations.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
