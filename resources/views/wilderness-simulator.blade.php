<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <title>Test</title>
    <link rel="stylesheet" href="{{ asset('css/grid.css') }}">
    <meta name="_token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <strong>Wilderness Simulator</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <p>Step: <span id="step-counter"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class='grid'>
                            <div class='grid-square' id="a0"></div>
                            <div class='grid-square' id="a1"></div>
                            <div class='grid-square' id="a2"></div>
                            <div class='grid-square' id="a3"></div>
                            <div class='grid-square' id="a4"></div>
                            <div class='grid-square' id="a5"></div>
                            <div class='grid-square' id="a6"></div>
                            <div class='grid-square' id="a7"></div>
                            <div class='grid-square' id="a8"></div>
                            <div class='grid-square' id="a9"></div>

                            <div class='grid-square' id="b0"></div>
                            <div class='grid-square' id="b1"></div>
                            <div class='grid-square' id="b2"></div>
                            <div class='grid-square' id="b3"></div>
                            <div class='grid-square' id="b4"></div>
                            <div class='grid-square' id="b5"></div>
                            <div class='grid-square' id="b6"></div>
                            <div class='grid-square' id="b7"></div>
                            <div class='grid-square' id="b8"></div>
                            <div class='grid-square' id="b9"></div>

                            <div class='grid-square' id="c0"></div>
                            <div class='grid-square' id="c1"></div>
                            <div class='grid-square' id="c2"></div>
                            <div class='grid-square' id="c3"></div>
                            <div class='grid-square' id="c4"></div>
                            <div class='grid-square' id="c5"></div>
                            <div class='grid-square' id="c6"></div>
                            <div class='grid-square' id="c7"></div>
                            <div class='grid-square' id="c8"></div>
                            <div class='grid-square' id="c9"></div>

                            <div class='grid-square' id="d0"></div>
                            <div class='grid-square' id="d1"></div>
                            <div class='grid-square' id="d2"></div>
                            <div class='grid-square' id="d3"></div>
                            <div class='grid-square' id="d4"></div>
                            <div class='grid-square' id="d5"></div>
                            <div class='grid-square' id="d6"></div>
                            <div class='grid-square' id="d7"></div>
                            <div class='grid-square' id="d8"></div>
                            <div class='grid-square' id="d9"></div>

                            <div class='grid-square' id="e0"></div>
                            <div class='grid-square' id="e1"></div>
                            <div class='grid-square' id="e2"></div>
                            <div class='grid-square' id="e3"></div>
                            <div class='grid-square' id="e4"></div>
                            <div class='grid-square' id="e5"></div>
                            <div class='grid-square' id="e6"></div>
                            <div class='grid-square' id="e7"></div>
                            <div class='grid-square' id="e8"></div>
                            <div class='grid-square' id="e9"></div>

                            <div class='grid-square' id="f0"></div>
                            <div class='grid-square' id="f1"></div>
                            <div class='grid-square' id="f2"></div>
                            <div class='grid-square' id="f3"></div>
                            <div class='grid-square' id="f4"></div>
                            <div class='grid-square' id="f5"></div>
                            <div class='grid-square' id="f6"></div>
                            <div class='grid-square' id="f7"></div>
                            <div class='grid-square' id="f8"></div>
                            <div class='grid-square' id="f9"></div>

                            <div class='grid-square' id="g0"></div>
                            <div class='grid-square' id="g1"></div>
                            <div class='grid-square' id="g2"></div>
                            <div class='grid-square' id="g3"></div>
                            <div class='grid-square' id="g4"></div>
                            <div class='grid-square' id="g5"></div>
                            <div class='grid-square' id="g6"></div>
                            <div class='grid-square' id="g7"></div>
                            <div class='grid-square' id="g8"></div>
                            <div class='grid-square' id="g9"></div>

                            <div class='grid-square' id="h0"></div>
                            <div class='grid-square' id="h1"></div>
                            <div class='grid-square' id="h2"></div>
                            <div class='grid-square' id="h3"></div>
                            <div class='grid-square' id="h4"></div>
                            <div class='grid-square' id="h5"></div>
                            <div class='grid-square' id="h6"></div>
                            <div class='grid-square' id="h7"></div>
                            <div class='grid-square' id="h8"></div>
                            <div class='grid-square' id="h9"></div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="row">
                            <button type="button" class="btn btn-success" id="button-start">Start</button>
                        </div>
                        <div class="mt-2 row">
                            <button type="button" class="btn btn-danger" id="button-stop">Stop</button>
                        </div>
                        <div class="mt-2 row">
                            <button type="button" class="btn btn-primary" id="button-step">Step</button>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <strong>Sessioni salvate</strong>
                            </div>
                            <ul id="saved-session-list" class="list-group list-group-flush">
                                @foreach ($savedSessions as $savedSession)
                                    <li class="list-group-item"><a class="savedSession" href="javascript:void(0)"
                                            id="{{ $savedSession->session_name }}">{{ $savedSession->session_name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <strong>Factorial Calculator</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-2">
                        <p>Insert a number</p>
                    </div>
                    <div class="col-lg-2">
                        <input type="number" id="numeric-input" min="1">
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-primary" id="calculate">Calculate</button>
                    </div>
                    <div class="col-lg-7">
                        <p id="result"></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>

<script src="{{ asset('js/wilderness-simulator.js') }}"></script>
<script src="{{ asset('js/factorial.js') }}"></script>

</html>
