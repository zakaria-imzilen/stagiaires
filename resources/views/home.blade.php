<!doctype html>
<html lang="en">

<head>
    <title>Home | Stagiaires</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>

    {{-- Alerts --}}
    @if (isset($_GET['added']))
        @if ($_GET['added'] === 'y')
            <div class="alert alert-success" role="alert">
                The internee is added successfuly
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                The internee is not added
            </div>
        @endif
    @endif

    @if (isset($_GET['deletedAll']))
        @if ($_GET['deletedAll'] === 'y')
            <div class="alert alert-success" role="alert">
                All internees are deleted successfuly
            </div>
        @endif
    @endif

    @if (isset($_GET['edited']))
        @if ($_GET['edited'] === 'y')
            <div class="alert alert-success" role="alert">
                Internee edited successfuly
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                Edit went wrong, retry later
            </div>
        @endif
    @endif

    @if (isset($_GET['deleted']))
        @if ($_GET['deleted'] === 'y')
            <div class="alert alert-success" role="alert">
                Internee deleted successfuly
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                Internee couldn't get deleted, retry again later!
            </div>
        @endif
    @endif


    <h1 class="text-success font-weight-bold text-center my-3">Internees Management</h1>

    <div class="container-fluid">

        {{-- Navbar --}}
        <nav class="container my-5 navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <a class="navbar-brand text-dark mr-5" href="#">Zakaria Imzilen</a>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link btn-primary rounded-pill px-4" aria-current="page"
                                href="/home">Home</a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link btn text-dark" data-bs-toggle="modal"
                                data-bs-target="#addModal">Add
                                an internee</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link btn text-danger" data-bs-toggle="modal"
                                data-bs-target="#deletedAllModal">Delete All</a>
                        </li>
                    </ul>
                    <form class="d-flex ml-auto" role="search" action="/internee/search" method="POST">
                        @csrf
                        <input class="form-control me-2" type="search" placeholder="Enter the Name" aria-label="Search"
                            name="search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($result))
                    @if ($result === 'NotFound')
                        <h5 class="font-weight-bold text-center my-5">NOT FOUND</h5>
                    @elseif (count($result) > 0)
                        @foreach ($result as $stagiaire)
                            <tr>
                                <td scope="row">{{ $stagiaire['id'] }}</td>
                                <td>{{ $stagiaire['firstName'] }}</td>
                                <td>{{ $stagiaire['lastName'] }}</td>
                                <td>{{ $stagiaire['age'] }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal">Edit</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target={{ '#deleteModal' . $stagiaire['id'] }}>Delete</button>
                                </td>

                                {{-- Modal: edit --}}
                                <div class="modal fade container" id="editModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <form action={{ '/internee/edit/' }} method="POST" class="modal-dialog">
                                        @csrf
                                        {{-- {{ csrf_field() }} --}}
                                        {{-- {{ method_field('put') }} --}}
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fs-5" id="exampleModalLabel">Edit the internee
                                                </h5>
                                                <button type="button" class="btn-close btn" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    x
                                                </button>
                                            </div>
                                            <div class="modol-body p-3">
                                                <input type="hidden" name="id" value={{ $stagiaire['id'] }}>
                                                <div class="form-group">
                                                    <label for="firstName">New First Name</label>
                                                    <input type="text" class="form-control" name="firstName"
                                                        aria-describedby="helpId" value={{ $stagiaire['firstName'] }}>
                                                </div>
                                                <div class="form-group">
                                                    <label for="lastName">New Last Name</label>
                                                    <input type="text" class="form-control" name="lastName"
                                                        aria-describedby="helpId" value={{ $stagiaire['lastName'] }}>
                                                </div>
                                                <div class="form-group">
                                                    <label for="age">New Age</label>
                                                    <input type="text" class="form-control" name="age"
                                                        aria-describedby="helpId" value={{ $stagiaire['age'] }}>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- Modal: delete --}}
                                <div class="modal fade container" id={{ 'deleteModal' . $stagiaire['id'] }}
                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fs-5" id="exampleModalLabel">Delete
                                                    {{ $stagiaire['firstName'] }}
                                                </h5>
                                                <button type="button" class="btn-close btn" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    x
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-danger"
                                                    href={{ '/internee/delete/' . $stagiaire['id'] }}
                                                    role="button">DELETE</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    @endif
                @else
                    @foreach ($allStagiaires as $stagiaire)
                        <tr>
                            <td scope="row">{{ $stagiaire['id'] }}</td>
                            <td>{{ $stagiaire['firstName'] }}</td>
                            <td>{{ $stagiaire['lastName'] }}</td>
                            <td>{{ $stagiaire['age'] }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target={{ '#editModal' . $stagiaire['id'] }}>Edit</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target={{ '#deleteModal' . $stagiaire['id'] }}>Delete</button>
                            </td>

                            {{-- Modal: edit --}}
                            <div class="modal fade container" id={{ 'editModal' . $stagiaire['id'] }} tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <form action={{ '/internee/edit/' }} method="POST" class="modal-dialog">
                                    @csrf
                                    {{-- {{ method_field('put') }} --}}
                                    {{-- {{ csrf_field() }} --}}
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fs-5" id="exampleModalLabel">Edit the internee
                                            </h5>
                                            <button type="button" class="btn-close btn" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                x
                                            </button>
                                        </div>
                                        <div class="modol-body p-3">
                                            <input type="hidden" name="id" value={{ $stagiaire['id'] }}>
                                            <div class="form-group">
                                                <label for="firstName">New First Name</label>
                                                <input type="text" class="form-control" name="firstName"
                                                    aria-describedby="helpId" value={{ $stagiaire['firstName'] }}>
                                            </div>
                                            <div class="form-group">
                                                <label for="lastName">New Last Name</label>
                                                <input type="text" class="form-control" name="lastName"
                                                    aria-describedby="helpId" value={{ $stagiaire['lastName'] }}>
                                            </div>
                                            <div class="form-group">
                                                <label for="age">New Age</label>
                                                <input type="text" class="form-control" name="age"
                                                    aria-describedby="helpId" value={{ $stagiaire['age'] }}>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Modal: delete --}}
                            <div class="modal fade container" id={{ 'deleteModal' . $stagiaire['id'] }}
                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fs-5" id="exampleModalLabel">Delete
                                                {{ $stagiaire['firstName'] }}
                                            </h5>
                                            <button type="button" class="btn-close btn" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                x
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn btn-danger"
                                                href={{ '/internee/delete/' . $stagiaire['id'] }}
                                                role="button">DELETE</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    {{-- Modals --}}
    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/internee/add" method="post" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add an internee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <form action="/internee/add" method="post">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" required class="form-control" name="firstName" id="firstName"
                                aria-describedby="helpId">
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" required class="form-control" name="lastName" id="lastName"
                                aria-describedby="helpId">
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" required class="form-control" name="age" id="age"
                                aria-describedby="helpId">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deletedAllModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Sure you want to delete all internees ?
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <a href="/internee/deleteAll" class="btn btn-danger" tabindex="-1" role="button"
                        aria-disabled="true">Yes, Delete them all !</a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js"
        integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous">
    </script>
</body>

</html>
