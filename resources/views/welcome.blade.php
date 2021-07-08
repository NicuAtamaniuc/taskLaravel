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
            document.getElementById("links2").style.display="none";
            document.getElementById("links4").style.display="none";  
            document.getElementById("links1").style.display="block"; 
        }
        function click2()
        {
            document.getElementById("links1").style.display="none";
            document.getElementById("links4").style.display="none"; 
            document.getElementById("links2").style.display="block"; 
        }
        function click4()
        {
            document.getElementById("links1").style.display="none"; 
            document.getElementById("links2").style.display="none"; 
            document.getElementById("links4").style.display="block"; 
        }
        function click5()
        {
            document.getElementById("links1").style.display="none"; 
            document.getElementById("links2").style.display="none"; 
            document.getElementById("links4").style.display="none";
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
                            optiune+='<option value="'+data[i].kd_local+'">'+data[i].kd_local+' - '+data[i].name_s+'</option>';
                        }
                    div.find('.localitate').html(" ");
                    div.find('.localitate').append(optiune);
                    }
                });
            });

            $(document).on('change','.anul', function(){

            var anul=$(this).val();
            var div=$(this).parents();
            var optiune=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('EcoAtribuire')!!}',
                data:{'anul':anul},
                success:function(data){
                    optiune+='<option value="0" disabled selected> -- Alege Eco -- </option>';
                    for(var i=0;i<data.length;i++){
                        optiune+='<option value="'+data[i].kd_eco+'">'+data[i].kd_eco+' - '+data[i].label_md+'</option>';
                    }
                div.find('.eco').html(" ");
                div.find('.eco').append(optiune);
                }
            });
            });

            $(document).on('change','.anul2', function(){

            var anul=$(this).val();
            var div=$(this).parents();
            var optiune=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('EcoAtribuire')!!}',
                data:{'anul':anul},
                success:function(data){
                    optiune+='<option value="0" disabled selected> -- Alege Eco -- </option>';
                    for(var i=0;i<data.length;i++){
                        optiune+='<option value="'+data[i].kd_eco+'">'+data[i].kd_eco+' - '+data[i].label_md+'</option>';
                    }
                div.find('.eco2').html(" ");
                div.find('.eco2').append(optiune);
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

        @if($message = Session::get('adaugat'))
            <div class="col-12 alert alert-succes alert-block" style="text-align: center; margin-left: auto; margin-right: auto; display: block; padding: 10px;">
                <!-- <button type="button" class="close" data-dismiss="alert">x</button> -->
                <strong>{{ __('Inregistrarea a fost adaugata cu succes!') }}</strong>
            </div>
	    @endif

        @if($message = Session::get('sters'))
            <div class="col-12 alert alert-succes alert-block" style="text-align: center; margin-left: auto; margin-right: auto; display: block; padding: 10px;">
                <!-- <button type="button" class="close" data-dismiss="alert">x</button> -->
                <strong>{{ __('Datele au fost sterse!') }}</strong>
            </div>
	    @endif

        @if($message = Session::get('actualizat'))
            <div class="col-12 alert alert-succes alert-block" style="text-align: center; margin-left: auto; margin-right: auto; display: block; padding: 10px;">
                <!-- <button type="button" class="close" data-dismiss="alert">x</button> -->
                <strong>{{ __('Datele au fost actualizate!') }}</strong>
            </div>
	    @endif

        @if($message = Session::get('setat'))
            <div class="col-12 alert alert-succes alert-block" style="text-align: center; margin-left: auto; margin-right: auto; display: block; padding: 10px;">
                <!-- <button type="button" class="close" data-dismiss="alert">x</button> -->
                <strong>{{ __('Rolul a fost atribuit!') }}</strong>
            </div>
	    @endif

        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                @guest
                    <p style="font-size: 50px; text-align: center;">Ministerul Finanțelor</p><br>
                    <img src="flag.jpg" alt="flag" style="max-width: 70%; margin-left: auto; margin-right: auto; display: block;">
                @endguest
                @auth
                    @if($rol == 'admin')
                    <div id="crud" class="col-12">
                        <button type="button" onclick="click1()" class="btn btn-primary">C</button>
                        <button type="button" onclick="click2()" class="btn btn-primary">R & U</button>
                        <button type="button" onclick="click4()" class="btn btn-primary">D</button><br><br>
                        <a href="{{route('atribuieRol')}}"><button type="button" class="btn btn-primary">Atribuie Roluri</button></a><br><br>
                        <button type="button" onclick="click5()" class="btn btn-primary">Închide</button>
                    </div>
                </div>

                <div class="links1" id="links1" style="display: none;">
                    <form method="post" action="{{ route('adauga') }}">
                        @csrf
                        <div class="form-group">
                            <label for="anul">Anul</label>
                                <select class="form-control" id="anul" name="anul">
                                    <option>2021</option>
                                    <option>2020</option>
                                    <option>2019</option>
                                    <option>2018</option>
                                    <option>2017</option>
                                    <option>2016</option>
                                </select>                        
                        </div>
                        <div class="form-group" style="width: 400px;">
                            <label for="eco">Codul Eco</label>
                            <select class="form-control" id="eco" name="eco">
                                @foreach ($eco as $ec)            
                                    <option style="width: 100px;" value="{{$ec->kd_eco}}">{{$ec->kd_eco}} - {{$ec->label_md}}</option>          
                                @endforeach 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="raion">Raionul</label>
                            <select class="raion form-control" onChange="raion()" id="raion" name="raion" required>
                                <option value="0" disabled="true" selected="true"> -- Alege Raionul -- </option>   
                                @foreach ($raioane as $raion)            
                                    <option value="{{$raion->id}}">{{$raion->id}} - {{$raion->denumire_raion}}</option>          
                                @endforeach 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="localitate">Localitatea</label>
                                <select class="localitate form-control" id="localitate" name="localitate" required>
                                    <option value="0" disabled="true" selected="true"> -- Alege localitatea -- </option>   
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="iban">IBAN</label>
                            <input style="width: 35px;" type="text" readonly value="MD">
                            <input style="width: 350px;" type="text" required id="iban" name="iban" oninput="if(value.length>22)value=value.slice(0,22); this.value = this.value.toUpperCase();">
                        </div>
                        <button type="submit" class="btn btn-primary">Adaugă</button>
                    </form>
                </div>

                <div class="links2" id="links2" style="display: none;">
                    <form method="post" action="{{ route('read') }}">
                        @csrf
                        <div class="form-group">
                            <label for="anul">Alege anul</label>
                                <select class="anul form-control" id="anul" name="anul" onChange="an()">
                                    <option value="0" disabled="true" selected="true"> -- Alege anul -- </option>   
                                    @foreach ($ani as $an)            
                                        <option value="{{$an->anul}}">{{$an->anul}}</option>          
                                    @endforeach 
                                </select>                        
                        </div>
                        <div class="form-group" style="width: 400px;">
                            <label for="eco">Codul Eco</label>
                            <select class="eco form-control" id="eco" name="eco">
                                <option value="0" disabled="true" selected="true"> -- Alege Eco -- </option>   
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="raion">Raionul</label>
                            <select class="raion form-control" onChange="raion()" id="raion" name="raion" required>
                                <option value="0" disabled="true" selected="true"> -- Alege Raionul -- </option>   
                                @foreach ($raioane as $raion)            
                                    <option value="{{$raion->id}}">{{$raion->id}} - {{$raion->denumire_raion}}</option>          
                                @endforeach 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="localitate">Localitatea</label>
                                <select class="localitate form-control" id="localitate" name="localitate" required>
                                    <option value="0" disabled="true" selected="true"> -- Alege localitatea -- </option>   
                                </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Afișează</button>
                    </form>
                </div>

                <div class="links4" id="links4" style="display: none;">
                    <form method="post" action="{{ route('sterge') }}">
                        @csrf
                        <div class="form-group">
                            <label for="anul">Alege anul</label>
                                <select class="anul2 form-control" id="anul2" name="anul2">
                                    <option value="0" disabled="true" selected="true"> -- Alege anul -- </option>   
                                    @foreach ($ani as $an)            
                                        <option value="{{$an->anul}}">{{$an->anul}}</option>          
                                    @endforeach 
                                </select>                        
                        </div>
                        <div class="form-group" style="width: 400px;">
                            <label for="eco">Codul Eco</label>
                            <select class="eco2 form-control" id="eco2" name="eco2">
                                <option value="0" disabled="true" selected="true"> -- Alege Eco -- </option>   
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="raion">Raionul</label>
                            <select class="raion form-control" onChange="raion()" id="raion" name="raion" required>
                                <option value="0" disabled="true" selected="true"> -- Alege Raionul -- </option>   
                                @foreach ($raioane as $raion)            
                                    <option value="{{$raion->id}}">{{$raion->id}} - {{$raion->denumire_raion}}</option>          
                                @endforeach 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="localitate">Localitatea</label>
                                <select class="localitate form-control" id="localitate" name="localitate" required>
                                    <option value="0" disabled="true" selected="true"> -- Alege localitatea -- </option>   
                                </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Șterge</button>
                    </form>
                </div>

                @elseif($rol == 'operator_raion')

                <div class="operator_raion" id="operator_raion">
                    <form method="post" action="{{ route('operator_raion') }}">
                        @csrf
                        <div class="form-group">
                            <label for="anul">Alege anul</label>
                                <select class="anul form-control" id="anul" name="anul" onChange="an()">
                                    <option value="0" disabled="true" selected="true"> -- Alege anul -- </option>   
                                    @foreach ($ani as $an)            
                                        <option value="{{$an->anul}}">{{$an->anul}}</option>          
                                    @endforeach 
                                </select>                        
                        </div>
                        <div class="form-group" style="width: 400px;">
                            <label for="eco">Codul Eco</label>
                            <select class="eco form-control" id="eco" name="eco">
                                <option value="0" disabled="true" selected="true"> -- Alege Eco -- </option>   
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="raion">Raionul</label>
                            <select class="raion form-control" onChange="raion()" id="raion" name="raion" required>
                                <option value="0" disabled="true" selected="true"> -- Alege Raionul -- </option>   
                                @foreach ($raioane as $raion)
                                    @if($raion->id == Auth::user()->raion)            
                                    <option value="{{$raion->id}}">{{$raion->id}} - {{$raion->denumire_raion}}</option>  
                                    @endif        
                                @endforeach 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="localitate">Localitatea</label>
                                <select class="localitate form-control" id="localitate" name="localitate" required>
                                    <option value="0" disabled="true" selected="true"> -- Alege localitatea -- </option>   
                                </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Afișează</button>
                    </form>
                </div>

                @elseif($rol == 'operator')

                <div class="operator" id="operator">
                <form method="post" action="{{ route('simplu_operator') }}">
                        @csrf
                        <div class="form-group">
                            <label for="anul">Alege anul</label>
                                <select class="anul form-control" id="anul" name="anul" onChange="an()">
                                    <option value="0" disabled="true" selected="true"> -- Alege anul -- </option>   
                                    @foreach ($ani as $an)            
                                        <option value="{{$an->anul}}">{{$an->anul}}</option>          
                                    @endforeach 
                                </select>                        
                        </div>
                        <div class="form-group" style="width: 400px;">
                            <label for="eco">Codul Eco</label>
                            <select class="eco form-control" id="eco" name="eco">
                                <option value="0" disabled="true" selected="true"> -- Alege Eco -- </option>   
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="raion">Raionul</label>
                            <select class="raion form-control" onChange="raion()" id="raion" name="raion" required>
                                <option value="0" disabled="true" selected="true"> -- Alege Raionul -- </option>   
                                @foreach ($raioane as $raion)            
                                    <option value="{{$raion->id}}">{{$raion->id}} - {{$raion->denumire_raion}}</option>          
                                @endforeach 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="localitate">Localitatea</label>
                                <select class="localitate form-control" id="localitate" name="localitate" required>
                                    <option value="0" disabled="true" selected="true"> -- Alege localitatea -- </option>   
                                </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Afișează</button>
                    </form>
                </div>
                @endif
                @endauth
            </div>
        </div>

    </body>
</html>
