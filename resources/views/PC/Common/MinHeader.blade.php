<html>
<head>
    <title>饭团扑</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    @include('PC.Common.HtmlHead')
</head>

<body>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

