<html>
<head>
    <title>@yield('title')</title>

    <style>
      body {
            margin: 0 auto; 
            width: 1300px;
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
    @section('menubar')
    @yield('content')
    <div class="footer">
        @yield('footer')
    </div>
</body>
</html>