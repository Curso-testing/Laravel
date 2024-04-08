@extends('base')

@section('body')
    @if ($isLockedDown)
        @include('main._lockDownAlert') {{-- Asume que has convertido también el archivo _lockDownAlert.html.twig a Blade --}}
    @endif
    <div class="container volcano mt-4" style="flex-grow: 1;">
        <h1 class="mt-5">Dinotopia Status</h1>
        <div class="dino-stats-container mt-2 p-3">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Genus</th>
                    <th>Size</th>
                    <th>Enclosure</th>
                    <th>Accepting Visitors</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($dinos as $dino)
                    <tr>
                        <td>{{ $dino->name }}</td>
                        <td>{{ $dino->genus }}</td>
                        <td>{{ $dino->sizeDescription() }}</td>
                        <td>{{ $dino->enclosure }}</td>
                        <td>{{ $dino->isAcceptingVisitors() ? 'Yes' : 'No' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="https://github.com/SymfonyCasts/dino-park" target="_blank" class="mb-3 me-2 mb-md-0 text-decoration-none lh-1 text-light">
                    <p><i>GenLab Secret Dino Repository</i></p>
                </a>
            </div>

            <div class="col-md-4 d-flex justify-content-center align-items-center">
                <a href="https://symfonycasts.com/" class="mb-3 me-2 mb-md-0 text-light text-decoration-none lh-1">
                    <p>With ❤️ from the gals and guys at SymfonyCasts</p>
                </a>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-light" href="https://github.com/SymfonyCasts"><i class="fab fa-github"></i></a></li>
                <li class="ms-3"><a class="text-light" href="https://twitter.com/symfonycasts"><i class="fab fa-twitter"></i></a></li>
                <li class="ms-3"><a class="text-light" href="https://www.facebook.com/SymfonyCasts/"><i class="fab fa-facebook"></i></a></li>
            </ul>
        </footer>
    </div>
@endsection
