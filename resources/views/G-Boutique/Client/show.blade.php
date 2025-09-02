@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Client</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Détails du client : {{ $client->nom }}</h5>
                <a href="{{ route('client.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i> Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <table class="table">
                    <tr>
                    <tr>
                        <th>Prénom :</th>
                        <td>{{ $client->prenom }}</td>
                    </tr>
                    <tr>
                        <th>Nom :</th>
                        <td>{{ $client->nom }}</td>
                    </tr>
                    <tr>
                        <th>Email :</th>
                        <td>{{ $client->email }}</td>
                    </tr>
                    <tr>
                        <th>Téléphone :</th>
                        <td>{{ $client->telephone }}</td>
                    </tr>
                    <tr>
                        <th>Adresse :</th>
                        <td>{{ $client->adresse }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endsection
