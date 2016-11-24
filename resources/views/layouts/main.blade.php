{{-- Main Blade template which includes CSS and JS includes --}}
<!DOCTYPE html>
<head>
  <title>@yield('title')</title>
  <link href="/css/app.css" rel="stylesheet">
</head>
<body>
  @yield('content')
  <script type="text/JavaScript" src="/js/app.js"></script>
</body>
</html>
