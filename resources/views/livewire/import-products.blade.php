@php
    $upload = Config::get('steps.form.fileInput');
    $table = Config::get('steps.tableClasses.table');
    $thead = Config::get('steps.tableClasses.thead');
    $tbody = Config::get('steps.tableClasses.tbody');
    $stdBg = Config::get('steps.standardBgColor');
    $text = Config::get('steps.standardTextColor');
    $thead = str_replace('uppercase','',$thead);
@endphp

<div class="overflow-auto dark:{{ $stdBg }}">
    <form action="{{ route('importProducts') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-modal-steps>
            <x-slot name="title">
                Upload Excel File for Export to Products
            </x-slot>
            <x-slot name="modalContent">
                @if (session('success'))
                    <p style="color: green;">{{ session('success') }}</p>
                    <p>File Path: {{ session('file') }}</p>
                @endif
                <input type="file" class="{{ $upload }}" name="productFile">
            </x-slot>
            <x-slot name="buttonActionName">
                Upload
            </x-slot>
        </x-modal-steps>
    </form>
    <div class="overflow-auto dark:{{ $stdBg }} px-6 py-5">
        <p class="dark:{{ $text }} py-5">
            The column names and data types of the selected excel file must match the specifications below
        </p>
        <table class="{{ $table }}">
            <thead class="{{ $thead }}">
                <tr>
                    <th>product_code</th>
                    <th>name</th>
                    <th>short_description</th>
                    <th>model</th>
                    <th>type</th>
                    <th>make</th>
                    <th>version</th>
                </tr>
            </thead>
            <tbody class="{{ $tbody }}">
                <tr>
                    <td>string/text</td>
                    <td>string/text</td>
                    <td>string/text</td>
                    <td>string/text</td>
                    <td>Hardware | Software | Services | Network</td>
                    <td>string/text</td>
                    <td>string/text</td>
                </tr>
            </tbody>            
        </table>
    </div>
</div>
