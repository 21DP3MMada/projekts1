<x-app-layout>
    <style>
        .btn-kkas {
            background-color: black;
            border: white;
            color: white;
            padding: 10px;
            border-radius: 20px;
            margin-top: 20px;
        }
    </style>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 " style="display: flex; margin-bottom: 10px;">
        <a style=" font-size: 14px; font-family: sans-serif; text-transform: uppercase; font-weight: 800;" class="btn-kkas" href="{{'/bookpage'}}">View All Books</a>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 " style="display: flex; margin-bottom: 10px;">
        <a style=" font-size: 14px; font-family: sans-serif; text-transform: uppercase; font-weight: 800;" class="btn-kkas" href="{{'/favorites'}}">View Favorites</a>
    </div>


</x-app-layout>
