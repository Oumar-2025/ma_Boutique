{{-- @extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Client</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Détails de la caisse : {{ $caisse->source }}</h5>
                <a href="{{ route('client.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i> Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <table class="table">
                    <tr>
                    <tr>
                        <th>Type :</th>
                        <td>{{ $caisse->type }}</td>
                    </tr>
                    <tr>
                        <th>Source :</th>
                        <td>{{ $caisse->source }}</td>
                    </tr>
                    <tr>
                        <th>Description :</th>
                        <td>{{ $caisse->description }}</td>
                    </tr>
                    <tr>
                        <th>Montant :</th>
                        <td>{{ number_format($caisse->montant, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    <tr>
                        <th> :</th>
                        <td>{{ $client->adresse }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endsection --}}
