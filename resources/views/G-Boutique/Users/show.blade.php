@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Utilisateurs</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Détails sur : {{ $user->name }}</h5>
                <a href="{{ route('users.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i>
                    Liste</a>
            </div>
            <div class="card-body px-4 py-3">
        <table class="table">
            <tr>
                <th>Nom complet :</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email :</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Role :</th>
                <td>{{ $user->role }}</td>
            </tr>
        </table>
    </div>
    </div>
@endsection
