<html>
<head>
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>
    body {font-size: 16pt; 
        color: #999; 
        margin: 0 auto; 
        width: 1000px;
        

    }
    h1 {font-size: 50pt ; 
        text-align: left; 
        color:rgba(0, 0, 255, 0.534);
        margin: auto auto; 
        letter-spacing: -4pt;
    }
        ul{
            font-size: 12pt;
        }
        hr{
            margin: 25px 100px ; 
            border-top: 1px dashed #ddd;
        }
        .manutitle {
            font-size: 14pt; 
            font-weight: bold;
            margin: 0px;
        }
        .content {
            margin: 10px;
        }
        .footer {
            text-align: right;
            font-size: 10pt;
            margin: 0px;
        border-bottom: solid 1px #ccc;
        color: #ccc;
        }
        th {
            background-color: #854be2;
            color: fff;
            padding: 5px 10px;
        }

        td{
            border: solid 1px #854be2;
            color: #999;
            padding: 5px 10px;
        }
        
        td.id{
            width: 20px;
            text-align: center;
        }
        
        input.del{
            margin-top: 15px;
        }

        input.add{
            margin-left:500px; 
        }


</style>
</head>
<body>
    @section('menubar')
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            @yield('footer')
        </div>
</body>
</html>