<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.user.header') <!-- Ini include header -->
</head>
<body>
    @include('layouts.user.sidebar') <!-- Ini include sidebar -->

<div class="content-wrapper">
    @yield('content') <!-- Ini buat isi konten dari tiap halaman -->
</div>

@include('layouts.user.footer') <!-- Ini include footer -->
</body>
</html>