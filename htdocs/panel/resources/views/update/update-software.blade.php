@extends('layouts.blank')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-2"></div>
            <div class="col-md-8">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="mar-ver pad-btm text-center mb-3">
                            <h1 class="h3">StackFood Software Update</h1>
                                <p style="font-weight: bold;">
                                    Downloaded From <a href="https://gambiato.co" target="_blank" class="text-info">Gambiato Forums</a>
                                </p>
                        </div>
                        <form method="POST" action="{{route('update-system')}}">
                            @csrf
                            <div class="form-group">
                                <label for="purchase_code">Codecanyon Username</label>
                                <input type="text" class="form-control" id="username" value="GambitSteel"
                                       name="username" readonly>
                            </div>

                            <div class="form-group">
                                <label for="purchase_code">Purchase Code</label>
                                <input type="text" class="form-control" id="purchase_key"
                                       value="Gambiato-Forums" name="purchase_key" readonly>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-info">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
@endsection
