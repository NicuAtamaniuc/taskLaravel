<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Generarea codului IBAN pentru încasări</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        
        <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="css/principal.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        function click1()
        {
            document.getElementById("links1").style.display="block"; 
        }
        function click2()
        {
            document.getElementById("links2").style.display="block"; 
        }
        function click5()
        {
            document.getElementById("links1").style.display="none"; 
            document.getElementById("links2").style.display="none"; 
        }
        function modIBAN()
        {
            document.getElementById("modificaIBAN").style.display="none"; 
            document.getElementById("ibNou").style.display="block"; 
        }
    </script>

    <script>

    $(document).ready(function(){
            $(document).on('change','.raion', function(){

                var id_raion=$(this).val();
                var div=$(this).parents();
                var optiune=" ";

                $.ajax({
                    type:'get',
                    url:'{!!URL::to('atribuireLocalitate')!!}',
                    data:{'id':id_raion},
                    success:function(data){
                        optiune+='<option value="0" disabled selected> -- Alege localitatea -- </option>';
                        for(var i=0;i<data.length;i++){
                            optiune+='<option value="'+data[i].kd_local+'">'+data[i].name_s+'</option>';
                        }
                    div.find('.localitate').html(" ");
                    div.find('.localitate').append(optiune);
                    }
                });
            });
        });

    </script>

    </head>
    <body style="margin-bottom: 30px;">

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('CHECK IBAN', 'CHECK IBAN') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Logare') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Înregistrare') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{$rol}}  ->  {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Deconectare') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="afisareUtilizatori" style="text-align: center; margin-top: 30px;">

            <form method="post" action="{{ route('atribuie') }}">
            @csrf
            <div>
                <label for="eco">Utilizatori</label><br>
                <select id="utilizatori" name="utilizatori" required>
                    <option value="0" disabled="true" selected="true"> -- Alege Utilizatorul -- </option>   
                    @foreach ($allUser as $user)            
                        <option value="{{$user->id}}">{{$user->name}}</option>          
                    @endforeach 
                </select>
            </div><br>

            <div>
                <select id="roluri" name="roluri" required>
                    <option value="0" disabled="true" selected="true"> -- Alege Rolul -- </option>   
                    @foreach ($roluri as $rol)            
                        <option value="{{$rol->id}}">{{$rol->rol}}</option>          
                    @endforeach 
                </select>
            </div><br>

            <button type="submit" class="btn btn-primary">Atribuie rolul</button>

            </form>

        </div>

    </body>
</html>
