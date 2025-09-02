@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Annexes</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                    <h5 style="color:white;">Détails de : {{ $annexe->nom }}</h5>
                    <a href="{{ route('annexe.index') }}" class="btn btn-outline-light btn-sm">Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <table class="table">
                    <tr>
                        <th>Boutiques</th>
                        <td>{{ $annexe->boutique->nom }}</td>
                    </tr>
                    <tr>
                        <th>Nom annexe :</th>
                        <td>{{ $annexe->nom }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $annexe->email }}</td>
                    </tr>
                    <tr>
                        <th>Téléphone</th>
                        <td>{{ $annexe->telephone }}</td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td>{{ $annexe->adresse }}</td>
                    </tr>
            </table>
        </div>
    </div>

@endsection
