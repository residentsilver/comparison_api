<html>
<head>
        <!-- BootStrap読み込み -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
        </script>
        <!-- BootStrap -->
        
    <title>@yield('title')</title>

    <style>
      body {
            margin: 0 auto; 
            width: 1300px;
        }

        header{
            height: 80px;
        }
      /* 
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
            } */
    
    div.contents_all{
        display: flex;
        width: 1200px;
        flex-wrap:wrap ;
        justify-content: space-around;

    }
    
    div.content{
        width: 350px;
        margin: 10px;   
    }
    
    </style>
</head>
<body>
    <header>
        <!-- ナビ -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="/top">Comparison Tools</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- justify-content-endに変更すると、ナビ右寄せ --}}
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="/top">Top</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/guest">利用者管理</a>
                    </li>

                    <!-- ドロップダウンタイプ -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            予約管理
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/reservation/index">予約一覧</a>
                        </div>
                    </li>
                    <!-- ドロップダウンタイプここまで -->

                    <li class="nav-item">
                        <a class="nav-link" href="/masters">部屋管理</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/rooms">部屋種別</a>
                    </li>

                </ul>
            </div>
        </nav>
        <!-- ナビここまで -->
    </header>
    @section('menubar')
    @yield('content')
    <div class="footer">
        @yield('footer')
    </div>
</body>
</html>