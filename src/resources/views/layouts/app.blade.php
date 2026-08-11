<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

<meta charset="utf-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">


<title>
SGDV
</title>


@vite([
'resources/css/app.css',
'resources/css/sgdv-theme.css',
'resources/js/app.js'
])


</head>


<body>


<div class="page">


<x-layout.sidebar />


<div class="page-wrapper">


<x-layout.navbar />



<div class="page-body">


@if(session('success'))

<div class="container-xl mt-3">

<div class="alert alert-success alert-dismissible"
role="alert">


{{ session('success') }}


<button type="button"
class="btn-close"
data-bs-dismiss="alert">
</button>


</div>

</div>

@endif



@if(session('error'))

<div class="container-xl mt-3">

<div class="alert alert-danger alert-dismissible"
role="alert">


{{ session('error') }}


<button type="button"
class="btn-close"
data-bs-dismiss="alert">
</button>


</div>

</div>

@endif



{{ $slot }}



</div>


</div>


</div>


</body>

</html>
