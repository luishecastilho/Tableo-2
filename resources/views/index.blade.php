<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tableo 2</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script defer>
            $(document).ready(function() {
                $('#loading').hide();

                $('#getQuotesButton').click(async function() {
                    $('#quotesList').hide();
                    $('#loading').show();

                    await $.ajax({
                        url: "{{ route('quotes') }}",
                        type: 'GET',
                        success: function(response) {
                            $('#quotesList').show();
                            $html = '';
                            response.forEach(function(quote) {
                                $html += '<li class="mb-2">' + quote + '</li>';
                            });
                            $('#quotesList').html($html);
                        },
                        error: function() {
                            alert('Error retrieving quotes');
                        }
                    });

                    $('#loading').hide();
                });
            });
        </script>
    </head>
    <body class="bg-gray-900 text-white font-sans antialiased leading-normal tracking-normal">

        <div class="min-h-screen flex flex-col justify-center items-center">
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-xl">
                <h1 class="text-2xl font-bold mb-4 text-center">Kanye West - Quotes</h1>

                <button id="getQuotesButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 w-full">
                    Get Quotes
                </button>

                <div id="loading" class="flex justify-center items-center">
                    <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-white"></div>
                </div>
                <div id="quotesList" class="bg-gray-700 p-4 rounded mb-4 hidden">
                    <!-- the quotes will be injected here -->
                </div>
            </div>
        </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>
