@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Boutiques</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Détails de la boutique : {{ $boutique->nom }}</h5>
                <a href="{{ route('boutique.index') }}" class="btn btn-outline-light btn-sm">Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <table class="table">
                    <tr>
                    <tr>
                        <td><img src="{{ asset($boutique->logo) }}" alt="{{ $boutique->nom }}" class="img-fluid"
                                style="max-width: 200px;"></td>
                    </tr>
                    <tr>
                        <th>Nom :</th>
                        <td>{{ $boutique->nom }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $boutique->email }}</td>
                    </tr>
                    <tr>
                        <th>Téléphone</th>
                        <td>{{ $boutique->telephone }}</td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td>{{ $boutique->adresse }}</td>
                    </tr>
                    <tr>
                        <th>Type de boutiques</th>
                        <td>{{ $boutique->type_boutique }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endsection
