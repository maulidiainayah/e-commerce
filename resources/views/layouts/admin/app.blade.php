<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.admin.header') <!-- Ini include header -->
</head>
<body>
    @include('layouts.admin.sidebar') <!-- Ini include sidebar -->

<div class="content-wrapper">
    @yield('content') <!-- Ini buat isi konten dari tiap halaman -->
</div>

@include('layouts.admin.footer') <!-- Ini include footer -->
</body>
</html>