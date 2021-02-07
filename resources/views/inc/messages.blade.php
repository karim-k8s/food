@if(count($errors)>0)
    @foreach($errors->all() as $error)
        <div class="ui negative message">
            <i class="close icon"></i>
            <div class="header">
               {{$error}}
            </div>
        </div>
    @endforeach
@endif

@if(isset($error))
    <div class="ui negative message">
        <i class="close icon"></i>
        <div class="header">
           {{$error}}
        </div>
    </div>
@endif

@if(isset($success))
    <div class="ui success message">
        <i class="close icon"></i>
        <div class="header">
           {{$success}}
        </div>
    </div>
@endif


@if(session('success'))
    <div class="ui success message">
        <i class="close icon"></i>
        <div class="header">
           {{session('success')}}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="ui negative message">
        <i class="close icon"></i>
        <div class="header">
           {{session('error')}}
        </div>
    </div>
@endif